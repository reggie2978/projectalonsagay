<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title.' | ' : "" ?><?= env('system_name') ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css" crossorigin="anonymous" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" crossorigin="anonymous"></script>

    <style>
        :root {
            --primary-color: #1a3a52;
            --secondary-color: #2c5f7f;
            --accent-color: #d4af37;
            --info-color: #3b82f6;
            --warning-color: #f59e0b;
            --danger-color: #dc2626;
            --text-dark: #2c3e50;
            --text-light: #5a6c7d;
            --border-light: #e0e6ed;
            --bg-light: #f8f9fc;
            --shadow-sm: 0 2px 8px rgba(26, 58, 82, 0.08);
            --shadow-md: 0 4px 16px rgba(26, 58, 82, 0.12);
            --shadow-lg: 0 8px 24px rgba(26, 58, 82, 0.16);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            letter-spacing: -0.01em;
        }

        body {
            background: linear-gradient(135deg, #f8f9fc 0%, #e8edf5 100%);
            min-height: 100vh;
        }

        /* Academic Navbar Styling */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
            box-shadow: var(--shadow-lg);
            border-bottom: 3px solid var(--accent-color);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-family: 'Merriweather', Georgia, serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff !important;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.02);
        }

        .navbar-brand::before {
            content: '🎓';
            font-size: 1.75rem;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.3);
            padding: 0.5rem 0.75rem;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.2);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1.25rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff !important;
            transform: translateY(-2px);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff !important;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        /* Professional Button Styling */
        .btn {
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.6);
            color: #fff;
            background: transparent;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: #fff;
            color: #fff;
        }

        .btn-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-color: #3b82f6;
            color: #fff !important;
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-color: #2563eb;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-color) 0%, #b8941f 100%);
            border-color: var(--accent-color);
            color: var(--text-dark) !important;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #b8941f 0%, #9a7a1a 100%);
            border-color: #b8941f;
        }

        .btn-outline-info {
            border-color: #3b82f6;
            color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
        }

        .btn-outline-info:hover {
            background: #3b82f6;
            border-color: #3b82f6;
            color: #fff;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border-color: #dc2626;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            border-color: #b91c1c;
        }

        button#user-topnav-menu {
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 0.6rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            color: var(--text-dark);
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(10px);
        }

        button#user-topnav-menu:hover {
            background: #fff;
            border-color: var(--accent-color);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        /* Container Styling */
        .container {
            max-width: 1320px;
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
            border-left: 4px solid;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert::before {
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 1.25rem;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border-left-color: #dc2626;
        }

        .alert-danger::before {
            content: '\f06a';
            color: #dc2626;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border-left-color: #16a34a;
        }

        .alert-success::before {
            content: '\f058';
            color: #16a34a;
        }

        /* Print Styles */
        @media print {
            .col-lg-6, .col-md-6 {
                width: 50%;
            }
            .lh-1 {
                line-height: 1em;
            }
            .navbar, .btn, .alert {
                display: none !important;
            }
        }

        /* Text Utilities */
        .truncate-5 {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
        }

        /* Responsive Design */
        @media (max-width: 767px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            .navbar-brand::before {
                font-size: 1.5rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
                width: 100%;
                margin-bottom: 0.5rem;
                justify-content: center;
            }

            .d-flex.align-items-center {
                flex-direction: column;
                width: 100%;
                gap: 0.5rem;
            }

            .container.py-4 {
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }
        }

        /* Smooth Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container > * {
            animation: fadeIn 0.5s ease-out;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--secondary-color);
            border-radius: 6px;
            border: 2px solid var(--bg-light);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }

        /* Select2 Custom Styling */
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 8px;
            border: 2px solid var(--border-light);
            min-height: 42px;
        }

        .select2-container--bootstrap-5 .select2-selection:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(44, 95, 127, 0.25);
        }
    </style>

    <?= $this->renderSection('custom_css') ?>
</head>

<body>

<?php $session = \Config\Services::session(); ?>  <!-- ✅ FIX ADDED -->

<nav class="navbar navbar-expand-md navbar-dark">
    <div class="container">

        <a class="navbar-brand" href="<?= base_url() ?>"><?= env('short_name') ?></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= isset($page_title) && $page_title == 'Home' ? 'active' : '' ?>" 
                       href="<?= base_url() ?>">
                        <i class="fa fa-home me-1"></i> Home
                    </a>
                </li>
            </ul>

            <!-- AUTH BUTTONS -->
            <div class="d-flex align-items-center">

                <?php if(!$session->get('applicant_id')): ?>
                    <a href="<?= base_url('Auth/') ?>" class="btn btn-outline-light me-2">
                        <i class="fa fa-user-shield"></i>
                        <span>Admin Login</span>
                    </a>
                <?php endif; ?>

                <?php if(!$session->get('applicant_id')): ?>

                    <!-- NOT LOGGED IN -->
                    <a href="<?= base_url('Applicant/login') ?>" class="btn btn-info me-2">
                        <i class="fa fa-sign-in-alt"></i>
                        <span>Applicant Login</span>
                    </a>

                    <a href="<?= base_url('Applicant/register') ?>" class="btn btn-warning">
                        <i class="fa fa-user-plus"></i>
                        <span>Register</span>
                    </a>

                <?php else: ?>

                    <!-- LOGGED IN -->
                    <a href="<?= base_url('Applicant/profile') ?>" class="btn btn-outline-info me-2">
                        <i class="fa fa-user"></i>
                        <span>My Profile</span>
                    </a>

                    <a href="<?= base_url('Applicant/logout') ?>" class="btn btn-danger">
                        <i class="fa fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>

                <?php endif; ?>

            </div>

        </div>
    </div>
</nav>

<div class="container py-4">

    <?php if($session->getFlashdata('main_error')): ?>
        <div class="alert alert-danger">
            <?= $session->getFlashdata('main_error') ?>
        </div>
    <?php endif; ?>

    <?php if($session->getFlashdata('main_success')): ?>
        <div class="alert alert-success">
            <?= $session->getFlashdata('main_success') ?>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<?= $this->renderSection('custom_js') ?>

</body>
</html>