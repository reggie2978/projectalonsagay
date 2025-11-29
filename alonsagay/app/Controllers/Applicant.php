<?php

namespace App\Controllers;

use App\Models\ApplicantUserModel;
use App\Models\Applicants; // <-- CORRECT MODEL

class Applicant extends BaseController
{
    protected $session;
    protected $applicantUserModel;
    protected $applicationsModel;

    public function __construct()
    {
        helper(['form']);
        $this->session = session();

        $this->applicantUserModel = new ApplicantUserModel();
        $this->applicationsModel  = new Applicants(); // <-- FIXED
    }

    // -----------------------
    // SHOW LOGIN FORM
    // -----------------------
    public function login()
    {
        return view('pages/applicant/login');
    }

    // -----------------------
    // LOGIN AUTH PROCESS
    // -----------------------
    public function loginAuth()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->applicantUserModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email not found.');
        }

        if (!password_verify($password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Incorrect password.');
        }

        // Save session
        $this->session->set([
            'applicant_id' => $user['id'],
            'applicant_name' => $user['first_name'] . ' ' . $user['last_name'],
            'is_applicant_logged_in' => true
        ]);

        return redirect()->to(base_url('Applicant/profile'));
    }

    // -----------------------
    // SHOW REGISTRATION FORM
    // -----------------------
    public function register()
{
    if ($this->request->getMethod() === 'post') {

        $validation = \Config\Services::validation();

        // Only email + password + confirm password
        $validation->setRules([
            'email'             => 'required|valid_email|is_unique[applicant_users.email]',
            'password'          => 'required|min_length[6]',
            'password_confirm'  => 'matches[password]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('pages/applicant/register', ['validation' => $validation]);
        }

        // Save user with only email + password
        $this->applicantUserModel->save([
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to(base_url('Applicant/login'))
            ->with('success', 'Registration successful! You may now login.');
    }

    return view('pages/applicant/register');
}


    // -----------------------
    // PROFILE PAGE
    // -----------------------
   public function profile()
{
    if (!$this->session->get('is_applicant_logged_in')) {
        return redirect()->to(base_url('Applicant/login'));
    }

    $applicantId = $this->session->get('applicant_id');

    // Get user info
    $data['user'] = $this->applicantUserModel->find($applicantId);

   // Count total applications
$data['totalApplications'] = $this->applicationsModel
    ->where('user_id', $applicantId)
    ->countAllResults();

// Pending = 0
$data['pending'] = $this->applicationsModel
    ->where('user_id', $applicantId)
    ->where('status', 0)
    ->countAllResults();

// Accepted = 1
$data['accepted'] = $this->applicationsModel
    ->where('user_id', $applicantId)
    ->where('status', 1)
    ->countAllResults();

// Rejected = 2
$data['rejected'] = $this->applicationsModel
    ->where('user_id', $applicantId)
    ->where('status', 2)
    ->countAllResults();


    return view('pages/applicant/profile', $data);
}


    // ============================
    // MY APPLICATIONS LIST
    // ============================
    public function applications()
    {
        if (!$this->session->get('is_applicant_logged_in')) {
            return redirect()->to(base_url('Applicant/login'));
        }

        $applicantId = $this->session->get('applicant_id');

        // Load all applications associated with this applicant user
        $applications = $this->applicationsModel
            ->where('user_id', $applicantId)
            ->findAll();

        return view('pages/applicant/applications', [
            'applications' => $applications
        ]);
    }

    // ============================
    // VIEW SPECIFIC APPLICATION
    // ============================
    public function application_view($id)
    {
        if (!$this->session->get('is_applicant_logged_in')) {
            return redirect()->to(base_url('Applicant/login'));
        }

        $application = $this->applicationsModel->find($id);

        if (!$application) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Application not found");
        }

        return view('pages/applicant/application_view', [
            'application' => $application
        ]);
    }

    // -----------------------
    // LOGOUT
    // -----------------------
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('Applicant/login'));
    }
}
