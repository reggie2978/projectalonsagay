<?php

namespace App\Controllers;
use App\Models\Auth;
use App\Models\Departments;
use App\Models\Vacancies;
use App\Models\Applicants;
use App\Models\SystemSettingModel;
use App\Models\NetworkLogModel;

class Main extends BaseController
{   
    protected $request;
    protected $session;
    protected $db;
    protected $auth_model;
    protected $department_model;
    protected $vacancy_model;
    protected $applicant_model;
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

    // ✅ Define $data property properly (avoid dynamic property warning)
    $this->data = [
        'session' => $this->session,
        'request' => $this->request,
    ];
}


    /** ✅ GET IP */
    public static function getLocalIpAddress()
{
    $session = session();

    // Prefer client IP stored via JavaScript (if set)
    $ip = $session->get('client_ip');

    // Fallback to PHP-detected IP
    if (empty($ip)) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    }

    // Normalize IPv6 localhost (::1) → IPv4
    if ($ip === '::1') {
        $ip = '127.0.0.1';
    }

    // ✅ Try deeper detection via system commands
    if ($ip === '127.0.0.1' || $ip === 'Unknown') {
        // Windows method
        @exec('ipconfig', $output);
        if (!empty($output)) {
            foreach ($output as $line) {
                // Match any active IPv4 (Ethernet, Wi-Fi, etc.)
                if (preg_match('/IPv4 Address[.\s]*:\s*([0-9\.]+)/i', $line, $matches)) {
                    $ip = $matches[1];
                    break;
                }
            }
        }

        // Linux/macOS method
        if ($ip === '127.0.0.1' || $ip === 'Unknown') {
            @exec("hostname -I", $linuxOutput);
            if (!empty($linuxOutput[0])) {
                $ipList = explode(' ', trim($linuxOutput[0]));
                $ip = $ipList[0] ?? '127.0.0.1';
            }
        }
    }

    return $ip;
}

   

    /** ✅ SAVE NETWORK LOG */
       /** ✅ Save log with updated IP + MAC logic */
   /** ✅ Save log with updated IP + MAC logic */
/**
 * ✅ Unified saveLog() with accurate IP + MAC detection (client + server hybrid + ARP lookup)
 */
private function saveLog(string $action)
{
    $userId = session()->get('login_id');
    if (!$userId) return;

    $ip  = session()->get('client_ip') ?? $this->request->getIPAddress();
    $mac = session()->get('client_mac') ?? 'N/A';

    // ✅ Enhanced MAC detection using ARP lookup
    if ($mac === 'N/A' || $mac === 'Unknown') {
        if (stripos(PHP_OS, 'WIN') === 0) {
            $output = @shell_exec("arp -a $ip");
        } else {
            $output = @shell_exec("arp -n $ip");
        }

        if ($output && preg_match('/([0-9a-f]{2}[:-]){5}[0-9a-f]{2}/i', $output, $matches)) {
            $mac = $matches[0];
        }
    }

    $this->db->table('network_logs')->insert([
        'user_id'     => $userId,
        'action'      => $action,
        'ip_address'  => $ip,
        'mac_address' => strtoupper(trim($mac)),
        'created_at'  => date('Y-m-d H:i:s')
    ]);
}


public function testSession()
{
    $data = [
        'session_mac' => $this->session->get('client_mac'),
        'has_mac' => $this->session->has('client_mac'),
        'all_session' => $this->session->get()
    ];
    
    return $this->response->setJSON($data);
}

    public function index()
    {
        $this->data['page_title'] = "Home";
        $this->data['departments'] = $this->department_model->countAll();
        $this->data['vacancies'] = $this->vacancy_model->countAll();
        $this->data['applicants'] = $this->applicant_model->countAll();
        return view('pages/home', $this->data);
    }

    // USERS
    public function users()
    {
        $this->data['page_title'] = "Users";
        $this->data['page'] = !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] = 10;
        $this->data['total'] = $this->auth_model->where("id != '{$this->session->login_id}'")->countAllResults();
        $this->data['users'] = $this->auth_model->where("id != '{$this->session->login_id}'")->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['users']) ? count($this->data['users']) : 0;
        $this->data['pager'] = $this->auth_model->pager;
        return view('pages/users/list', $this->data);
    }

    public function user_add()
    {
        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());
            if ($password !== $cpassword) {
                $this->session->setFlashdata('error', "Password does not match.");
            } else {
                $udata = [];
                $udata['name'] = $name;
                $udata['email'] = $email;
                if (!empty($password))
                    $udata['password'] = password_hash($password, PASSWORD_DEFAULT);
                $checkMail = $this->auth_model->where('email', $email)->countAllResults();
                if ($checkMail > 0) {
                    $this->session->setFlashdata('error', "User Email Already Taken.");
                } else {
                    $save = $this->auth_model->save($udata);
                    if ($save) {

                        $this->saveLog("Added User: $email");

                        $this->session->setFlashdata('main_success', "User has been added successfully.");
                        return redirect()->to('Main/users');
                    } else {
                        $this->session->setFlashdata('error', "Failed to add user.");
                    }
                }
            }
        }

        $this->data['page_title'] = "Add User";
        return view('pages/users/add', $this->data);
    }

    public function user_edit($id = '')
    {
        if (empty($id))
            return redirect()->to('Main/users');

        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());
            if ($password !== $cpassword) {
                $this->session->setFlashdata('error', "Password does not match.");
            } else {
                $udata = [];
                $udata['name'] = $name;
                $udata['email'] = $email;
                if (!empty($password))
                    $udata['password'] = password_hash($password, PASSWORD_DEFAULT);
                $checkMail = $this->auth_model->where('email', $email)->where('id!=', $id)->countAllResults();
                if ($checkMail > 0) {
                    $this->session->setFlashdata('error', "User Email Already Taken.");
                } else {
                    $update = $this->auth_model->where('id', $id)->set($udata)->update();
                    if ($update) {

                        $this->saveLog("Updated User ID: $id");

                        $this->session->setFlashdata('success', "User updated successfully.");
                        return redirect()->to('Main/user_edit/' . $id);
                    } else {
                        $this->session->setFlashdata('error', "User update failed.");
                    }
                }
            }
        }

        $this->data['page_title'] = "Edit User";
        $this->data['user'] = $this->auth_model->where("id ='{$id}'")->first();
        return view('pages/users/edit', $this->data);
    }

    public function user_delete($id = '')
    {
        if (empty($id)) {
            $this->session->setFlashdata('main_error', "User deletion failed: Unknown ID.");
            return redirect()->to('Main/users');
        }
        $delete = $this->auth_model->where('id', $id)->delete();
        if ($delete) {

            $this->saveLog("Deleted User ID: $id");

            $this->session->setFlashdata('main_success', "User deleted successfully.");
        } else {
            $this->session->setFlashdata('main_error', "User deletion failed.");
        }
        return redirect()->to('Main/users');
    }

    // DEPARTMENTS
    public function departments()
    {
        $this->data['page_title'] = "Departments";
        $this->data['page'] = !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] = 10;
        $this->data['total'] = $this->department_model->countAllResults();
        $this->data['departments'] = $this->department_model->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['departments']) ? count($this->data['departments']) : 0;
        $this->data['pager'] = $this->department_model->pager;
        return view('pages/departments/list', $this->data);
    }

    public function department_add()
    {
        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());
            $udata = [];
            $udata['name'] = htmlspecialchars($this->db->escapeString($name));
            $udata['description'] = htmlspecialchars($this->db->escapeString($description));
            $checkCode = $this->department_model->where('name', $name)->countAllResults();
            if ($checkCode) {
                $this->session->setFlashdata('error', "Department Already Exists.");
            } else {
                $save = $this->department_model->save($udata);
                if ($save) {

                    $this->saveLog("Added Department: $name");

                    $this->session->setFlashdata('main_success', "Department added successfully.");
                    return redirect()->to('Main/departments/');
                } else {
                    $this->session->setFlashdata('error', "Failed to add department.");
                }
            }
        }

        $this->data['page_title'] = "Add Department";
        return view('pages/departments/add', $this->data);
    }

    public function department_edit($id = '')
    {
        if (empty($id))
            return redirect()->to('Main/departments');

        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());
            $udata = [];
            $udata['name'] = htmlspecialchars($this->db->escapeString($name));
            $udata['description'] = htmlspecialchars($this->db->escapeString($description));
            $checkCode = $this->department_model->where('name', $name)->where("id!= '{$id}'")->countAllResults();
            if ($checkCode) {
                $this->session->setFlashdata('error', "Department Already Exists.");
            } else {
                $update = $this->department_model->where('id', $id)->set($udata)->update();
                if ($update) {

                    $this->saveLog("Updated Department ID: $id");

                    $this->session->setFlashdata('success', "Department updated successfully.");
                    return redirect()->to('Main/department_edit/' . $id);
                } else {
                    $this->session->setFlashdata('error', "Department update failed.");
                }
            }
        }

        $this->data['page_title'] = "Edit Department";
        $this->data['department'] = $this->department_model->where("id ='{$id}'")->first();
        return view('pages/departments/edit', $this->data);
    }

    public function department_delete($id = '')
    {
        if (empty($id)) {
            $this->session->setFlashdata('main_error', "Department deletion failed: Unknown ID.");
            return redirect()->to('Main/departments');
        }
        $delete = $this->department_model->where('id', $id)->delete();
        if ($delete) {

            $this->saveLog("Deleted Department ID: $id");

            $this->session->setFlashdata('main_success', "Department deleted successfully.");
        } else {
            $this->session->setFlashdata('main_error', "Department deletion failed.");
        }
        return redirect()->to('Main/departments');
    }

    // VACANCIES
    public function vacancies()
    {
        $this->data['page_title'] = "Vacancies";
        $this->data['page'] = !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] = 10;

        if (!empty($this->request->getVar('search'))) {
            $search = $this->request->getVar('search');
            $this->vacancy_model->like('vacancies.position', $search)
                                ->orLike('vacancies.description', $search);
        }

        $this->data['total'] = $this->vacancy_model->countAllResults(false);

        $this->data['vacancies'] = $this->vacancy_model
            ->select("vacancies.*, departments.name as department, 
            (vacancies.slot - COALESCE((SELECT COUNT(id) FROM applicants WHERE vacancy_id = vacancies.id AND status = 1), 0)) as available")
            ->join("departments", "vacancies.department_id = departments.id", "inner")
            ->paginate($this->data['perPage']);

        $this->data['total_res'] = is_array($this->data['vacancies']) ? count($this->data['vacancies']) : 0;
        $this->data['pager'] = $this->vacancy_model->pager;
        return view('pages/vacancies/list', $this->data);
    }

    public function vacancy_add()
    {
        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());
            $udata = [
                'department_id' => htmlspecialchars($this->db->escapeString($department_id)),
                'position' => htmlspecialchars($this->db->escapeString($position)),
                'description' => htmlspecialchars($this->db->escapeString($description)),
                'slot' => $this->db->escapeString($slot),
                'salary_from' => $this->db->escapeString($salary_from),
                'salary_to' => $this->db->escapeString($salary_to),
                'status' => $this->db->escapeString($status)
            ];
            $save = $this->vacancy_model->save($udata);
            if ($save) {

                $this->saveLog("Added Vacancy: $position");

                $this->session->setFlashdata('main_success', "Vacancy added successfully.");
                return redirect()->to('Main/vacancies/');
            } else {
                $this->session->setFlashdata('error', "Failed to add vacancy.");
            }
        }

        $this->data['page_title'] = "Add Vacancy";
        $this->data['departments'] = $this->department_model->findAll();
        return view('pages/vacancies/add', $this->data);
    }

    public function vacancy_edit($id = '')
    {
        if (empty($id))
            return redirect()->to('Main/vacancies');

        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());
            $udata = [
                'department_id' => htmlspecialchars($this->db->escapeString($department_id)),
                'position' => htmlspecialchars($this->db->escapeString($position)),
                'description' => htmlspecialchars($this->db->escapeString($description)),
                'slot' => $this->db->escapeString($slot),
                'salary_from' => $this->db->escapeString($salary_from),
                'salary_to' => $this->db->escapeString($salary_to),
                'status' => $this->db->escapeString($status)
            ];
            $update = $this->vacancy_model->where('id', $id)->set($udata)->update();
            if ($update) {

                $this->saveLog("Updated Vacancy ID: $id");

                $this->session->setFlashdata('success', "Vacancy updated successfully.");
                return redirect()->to('Main/vacancy_edit/' . $id);
            } else {
                $this->session->setFlashdata('error', "Failed to update vacancy.");
            }
        }

        $this->data['page_title'] = "Edit Vacancy";
        $this->data['vacancy'] = $this->vacancy_model->where("id ='{$id}'")->first();
        $this->data['departments'] = $this->department_model->findAll();
        return view('pages/vacancies/edit', $this->data);
    }

    public function vacancy_delete($id = '')
    {
        if (empty($id)) {
            $this->session->setFlashdata('main_error', "Vacancy deletion failed: Unknown ID.");
            return redirect()->to('Main/vacancies');
        }
        $delete = $this->vacancy_model->where('id', $id)->delete();
        if ($delete) {

            $this->saveLog("Deleted Vacancy ID: $id");

            $this->session->setFlashdata('main_success', "Vacancy deleted successfully.");
        } else {
            $this->session->setFlashdata('main_error', "Vacancy deletion failed.");
        }
        return redirect()->to('Main/vacancies');
    }

    // APPLICANTS
    public function applicants()
{
    $this->data['page_title'] = "Applicants";
    $this->data['page'] = !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
    $this->data['perPage'] = 10;
    $this->data['total'] = $this->applicant_model->countAllResults();

    $this->data['applicants'] = $this->applicant_model
        ->select("applicants.*, 
            CONCAT(applicants.last_name,', ',applicants.first_name,' ',COALESCE(CONCAT(' ', applicants.middle_name), '')) as name,
            vacancies.position, 
            departments.name as department")
            
        // 🔥 FIX — Use LEFT JOIN so applicant still appears even if vacancy/department was deleted
        ->join("vacancies", "applicants.vacancy_id = vacancies.id", "left")
        ->join("departments", "vacancies.department_id = departments.id", "left")

        ->paginate($this->data['perPage']);

    $this->data['total_res'] = is_array($this->data['applicants']) ? count($this->data['applicants']) : 0;
    $this->data['pager'] = $this->applicant_model->pager;

    return view('pages/applicants/list', $this->data);
}

public function applicant_view($id = "")
{
    if (empty($id)) {
        $this->session->setFlashdata('main_error', "Unknown ID.");
        return redirect()->to('Main/applicants');
    }

    $this->data['applicant'] = $this->applicant_model
        ->select("applicants.*, 
            CONCAT(applicants.last_name,', ',applicants.first_name,' ',COALESCE(CONCAT(' ', applicants.middle_name), '')) as name,
            vacancies.position, 
            departments.name as department")
        
        // 🔥 Apply same fix here
        ->join("vacancies", "applicants.vacancy_id = vacancies.id", "left")
        ->join("departments", "vacancies.department_id = departments.id", "left")

        ->where('applicants.id', $id)
        ->first();

    if (!isset($this->data['applicant']['id'])) {
        $this->session->setFlashdata('main_error', "Unknown ID.");
        return redirect()->to('Main/applicants');
    }

    $this->data['page_title'] = $this->data['applicant']['name'];
    return view('pages/applicants/view', $this->data);
}

    public function applicant_hired($id = '')
    {
        if (empty($id)) {
            $this->session->setFlashdata('main_error', "Unknown ID.");
            return redirect()->to('Main/applicants');
        }
        $update = $this->applicant_model->where('id', $id)->set('status', 1)->update();
        if ($update) {

            $this->saveLog("Marked Applicant ID $id as Hired");

            $this->session->setFlashdata('main_success', "Applicant marked as Hired.");
        } else {
            $this->session->setFlashdata('main_error', "Failed to mark as Hired.");
        }
        return redirect()->to('Main/applicant_view/' . $id);
    }

    public function applicant_nothired($id = '')
    {
        if (empty($id)) {
            $this->session->setFlashdata('main_error', "Unknown ID.");
            return redirect()->to('Main/applicants');
        }
        $update = $this->applicant_model->where('id', $id)->set('status', 2)->update();
        if ($update) {

            $this->saveLog("Marked Applicant ID $id as Not Hired");

            $this->session->setFlashdata('main_success', "Applicant marked as Not Hired.");
        } else {
            $this->session->setFlashdata('main_error', "Failed to mark as Not Hired.");
        }
        return redirect()->to('Main/applicant_view/' . $id);
    }

    public function applicant_delete($id = '')
    {
        if (empty($id)) {
            $this->session->setFlashdata('main_error', "Applicant deletion failed: Unknown ID.");
            return redirect()->to('Main/applicants');
        }
        $delete = $this->applicant_model->where('id', $id)->delete();
        if ($delete) {

            $this->saveLog("Deleted Applicant ID: $id");

            $this->session->setFlashdata('main_success', "Applicant deleted successfully.");
        } else {
            $this->session->setFlashdata('main_error', "Applicant deletion failed.");
        }
        return redirect()->to('Main/applicants');
    }

    private function getUserIP()
{
    return $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
}



public function network_logs()
{
    $logModel = new \App\Models\NetworkLogModel();

    $data['page_title'] = "Network Logs";
    $data['logs'] = $logModel
        ->select('network_logs.*, users.name as user_name') 
        ->join('users', 'users.id = network_logs.user_id', 'left')
        ->orderBy('network_logs.id', 'DESC')
        ->findAll();

    return view('network_logs', $data);
}

 private function getMacAddress()
{
    // ✅ 1. Prefer MAC stored in session (set via JS from client)
    $macAddress = $this->session->get('client_mac');
    if (!empty($macAddress)) {
        return strtoupper(trim($macAddress));
    }

    // ✅ 2. Try to detect from headers (optional fallback)
    if (isset($_SERVER['HTTP_X_CLIENT_MAC'])) {
        return strtoupper(trim($_SERVER['HTTP_X_CLIENT_MAC']));
    }

    // ✅ 3. Fallback to server MAC (for local/dev environments)
    if (function_exists('exec')) {
        @exec("getmac", $output);
        if (!empty($output[0])) {
            $mac = strtok($output[0], ' ');
            if ($mac) return strtoupper(trim($mac));
        }

        @exec("ipconfig /all", $output);
        foreach ($output as $line) {
            if (preg_match("/([0-9A-F]{2}[:-]){5}[0-9A-F]{2}/i", $line, $matches)) {
                return strtoupper($matches[0]);
            }
        }

        @exec("cat /sys/class/net/*/address 2>/dev/null", $output);
        if (!empty($output[0])) {
            return strtoupper(trim($output[0]));
        }
    }

    // ✅ 4. If all else fails
    return 'UNKNOWN';
}

public function saveClientMac()
{
    $data = json_decode($this->request->getBody(), true);
    if (!$data) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
    }

    $mac = $data['mac'] ?? 'Unknown';
    $ip  = $data['ip'] ?? $this->request->getIPAddress();

    // ✅ Save to session for later use
    session()->set('client_mac', $mac);
    session()->set('client_ip', $ip);

    return $this->response->setJSON([
        'status' => 'success',
        'ip' => $ip,
        'mac' => $mac
    ]);
}




public function clearNetworkLogs()
{
    try {
        // ✅ Optional: Check if user is logged in
        if (!$this->session->get('login_id')) {
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to perform this action.');
        }

        // ✅ Clear all logs
        $this->db->table('network_logs')->truncate();

        // ✅ Record action (if you use saveLog)
        if (method_exists($this, 'saveLog')) {
            $this->saveLog('Cleared all network logs');
        }

        // ✅ Set success message
        $this->session->setFlashdata('success', '✅ All network logs have been cleared successfully.');
    } catch (\Throwable $e) {
        // ✅ Handle any failure
        $this->session->setFlashdata('error', '⚠️ Failed to clear logs: ' . $e->getMessage());
    }

    // ✅ Redirect back to the proper route (case-sensitive)
    return redirect()->to(base_url('NetworkLogs'));
}
public function NetworkLogs()
{
    $logs = $this->db->table('network_logs')
        ->select('network_logs.*, users.name AS user_name')
        ->join('users', 'users.id = network_logs.user_id', 'left')
        ->orderBy('network_logs.id', 'DESC')
        ->get()
        ->getResultArray();

    $data = [
        'logs' => $logs
    ];

    return view('network_logs', $data); // ✅ correct path
}




    
}