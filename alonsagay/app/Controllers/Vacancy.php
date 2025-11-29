<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Auth;
use App\Models\Vacancies;
use App\Models\Applicants;
use App\Models\Departments;
use App\Models\NetworkLogModel;

class Vacancy extends BaseController
{
    protected $request;
    protected $session;
    protected $db;
    protected $auth_model;
    protected $department_model;
    protected $vacancy_model;
    protected $applicant_model;
    protected $logModel;
    protected $data = [];

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->db = db_connect();

        $this->auth_model = new Auth();
        $this->department_model = new Departments();
        $this->vacancy_model = new Vacancies();
        $this->applicant_model = new Applicants();
        $this->logModel = new NetworkLogModel();

        // ✅ Proper data setup (no dynamic property)
        $this->data = [
            'session' => $this->session,
            'request' => $this->request,
        ];
    }

    /** ✅ Save log using updated IP + MAC logic with ARP detection */
    private function saveLog($action)
    {
        $userID = $this->session->get('login_id') ?? null;

        // Get IP address
        $ip = $this->request->getIPAddress();
        $mac = 'N/A';

        // Try to detect MAC address using ARP (works only in LAN or local dev)
        if (stripos(PHP_OS, 'WIN') === 0) {
            $output = shell_exec("arp -a $ip");
        } else {
            $output = shell_exec("arp -n $ip");
        }

        if ($output && preg_match('/([0-9a-f]{2}[:-]){5}[0-9a-f]{2}/i', $output, $matches)) {
            $mac = $matches[0];
        }

        // Save to network_logs
        $this->db->table('network_logs')->insert([
            'user_id'     => $userID,
            'action'      => $action,
            'ip_address'  => $ip,
            'mac_address' => $mac,
        ]);
    }

    /** ✅ Get Client IP (same logic as NetworkLogs) */
    public static function getLocalIpAddress()
    {
        $session = session();

        // Prefer IP stored from JavaScript (client-side detection)
        $ip = $session->get('client_ip');

        // Fallback to PHP-detected IP
        if (empty($ip)) {
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        }

        // Convert IPv6 localhost (::1) → IPv4
        if ($ip === '::1') {
            $ip = '127.0.0.1';
        }

        return $ip;
    }

    /** ✅ Get MAC Address (same logic as NetworkLogs) */
    private static function getMacAddress()
    {
        $mac = 'Unknown';

        // Try using getmac (Windows)
        @exec("getmac", $output);
        if (!empty($output)) {
            foreach ($output as $line) {
                if (preg_match('/([0-9A-Fa-f]{2}[:-]){5}[0-9A-Fa-f]{2}/', $line, $matches)) {
                    $mac = $matches[0];
                    break;
                }
            }
        }

        // Fallback using ipconfig /all
        if ($mac === 'Unknown') {
            @exec("ipconfig /all", $output);
            foreach ($output as $line) {
                if (preg_match('/([0-9A-Fa-f]{2}[:-]){5}[0-9A-Fa-f]{2}/', $line, $matches)) {
                    $mac = $matches[0];
                    break;
                }
            }
        }

        return $mac;
    }

    /** ✅ Homepage (Vacancy List) */
    public function index()
    {
        $this->data['page_title'] = "Home";
        $this->data['page'] = $this->request->getVar('page') ?? 1;
        $this->data['perPage'] = 5;

        $this->data['total'] = $this->vacancy_model
            ->where('status', 1)
            ->orderBy('abs(unix_timestamp(created_at)) DESC')
            ->countAllResults();

        $this->data['vacancies'] = $this->vacancy_model
            ->select("vacancies.*, departments.name as department, 
                      (vacancies.slot - COALESCE((SELECT COUNT(id) FROM applicants WHERE vacancy_id = vacancies.id AND status = 1), 0)) AS available")
            ->where('vacancies.status', 1)
            ->join('departments', "vacancies.department_id = departments.id", "inner")
            ->orderBy('abs(unix_timestamp(vacancies.created_at)) DESC')
            ->paginate($this->data['perPage']);

        $this->data['total_res'] = is_array($this->data['vacancies']) ? count($this->data['vacancies']) : 0;
        $this->data['pager'] = $this->vacancy_model->pager;

        return view('pages/public/home', $this->data);
    }

    /** ✅ View specific vacancy and handle applicant submission */
    public function view($id = '')
    {
        if (empty($id))
            return redirect()->to('Vacancy/PagenotFound');

        // ✅ Log every time a vacancy is viewed
        $this->saveLog("Viewed Vacancy ID: {$id}");

        // ✅ Handle applicant submission
        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());

           $udata = [
    'vacancy_id' => $this->db->escapeString($vacancy_id),
    'first_name' => htmlspecialchars($this->db->escapeString($first_name)),
    'middle_name' => htmlspecialchars($this->db->escapeString($middle_name)),
    'last_name' => htmlspecialchars($this->db->escapeString($last_name)),
    'email' => htmlspecialchars($this->db->escapeString($email)),
    'contact' => htmlspecialchars($this->db->escapeString($contact)),
    'address' => htmlspecialchars($this->db->escapeString($address)),
];

// attach logged-in applicant user id if present
if ($this->session->get('applicant_id')) {
    $udata['user_id'] = intval($this->session->get('applicant_id'));
}


            $save = $this->applicant_model->save($udata);

            if ($save) {
                // ✅ Log applicant submission with IP & MAC
                $this->saveLog("New applicant submitted for Vacancy ID: {$id}");

                $this->session->setFlashdata('main_success', "Your application has been submitted successfully.");
                return redirect()->to('Vacancy/view/' . $id);
            } else {
                $this->session->setFlashdata('error', "Application failed to submit.");
            }
        }

        // ✅ Fetch vacancy details
        $vacancy = $this->vacancy_model
            ->select("vacancies.*, departments.name AS department, 
                      (vacancies.slot - COALESCE((SELECT COUNT(id) FROM applicants WHERE vacancy_id = vacancies.id AND status = 1), 0)) AS available")
            ->where("vacancies.id", $id)
            ->join('departments', "vacancies.department_id = departments.id", "inner")
            ->first();

        if (!isset($vacancy['id']))
            return redirect()->to('Vacancy/PagenotFound');

        $this->data['page_title'] = $vacancy['position'];
        $this->data['vacancy'] = $vacancy;

        return view('pages/public/vacancy', $this->data);
    }

    /** ✅ 404 Page */
    public function PagenotFound()
    {
        $this->data['page_title'] = "Page Not Found";
        return view('pages/public/page_not_found', $this->data);
    }
}