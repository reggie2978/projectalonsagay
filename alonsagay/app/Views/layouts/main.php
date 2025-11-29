<?php 
use App\Models\SystemSettingModel;
$session = session();
$sysModel = new SystemSettingModel();
$system = $sysModel->first();
$maintenance = $system['maintenance_mode'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?= isset($page_title) ? $page_title.' | ' : "" ?>Company Recruitment Management System</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" crossorigin="anonymous"/>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <style>
        :root {
            --primary-color: #1a3a52;
            --secondary-color: #2c5f7f;
            --accent-color: #d4af37;
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

        body { 
            background-color: var(--bg-light);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            font-size: 15px;
            letter-spacing: -0.01em;
        }

        /* Academic Header Bar */
        .academic-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 0.75rem 0;
            box-shadow: var(--shadow-md);
            border-bottom: 3px solid var(--accent-color);
        }

        .navbar { 
            background: transparent;
            box-shadow: none;
            padding: 0.5rem 0;
        }

        .navbar-brand { 
            font-family: 'Merriweather', Georgia, serif;
            font-weight: 700;
            color: #fff !important;
            font-size: 1.35rem;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-brand::before {
            content: '🎓';
            font-size: 1.5rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .nav-link:hover {
            color: #fff !important;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }

        .nav-link.active {
            color: #fff !important;
            background-color: rgba(255, 255, 255, 0.15);
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Professional User Menu */
        #user-topnav-menu { 
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(10px);
        }

        #user-topnav-menu:hover {
            background: #fff;
            border-color: var(--accent-color);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .badge {
            font-weight: 600;
            padding: 0.35em 0.65em;
            border-radius: 6px;
            font-size: 0.7rem;
            letter-spacing: 0.03em;
        }

        /* Dropdown Menu Styling */
        .dropdown-menu {
            border: 1px solid var(--border-light);
            border-radius: 10px;
            box-shadow: var(--shadow-lg);
            padding: 0.5rem;
            min-width: 240px;
            margin-top: 0.5rem !important;
        }

        .dropdown-item {
            padding: 0.7rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-item:hover {
            background-color: var(--bg-light);
            color: var(--secondary-color);
            transform: translateX(4px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: var(--border-light);
        }

        /* Main Content Area */
        .container {
            max-width: 1320px;
        }

        .page-wrapper { 
            background: #fff;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
            min-height: calc(100vh - 250px);
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
            border-left: 4px solid;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border-left-color: #dc2626;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border-left-color: #16a34a;
        }

        /* Professional Footer */
        footer {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: rgba(255, 255, 255, 0.9);
            padding: 2rem 0;
            margin-top: 3rem;
            font-size: 0.9rem;
            font-weight: 500;
            border-top: 3px solid var(--accent-color);
            box-shadow: 0 -4px 16px rgba(26, 58, 82, 0.1);
        }

        footer::before {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: var(--accent-color);
            margin: 0 auto 1rem;
            border-radius: 2px;
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .navbar-brand {
                font-size: 1.1rem;
            }

            .nav-link {
                margin: 0.25rem 0;
            }

            .page-wrapper {
                padding: 1.5rem;
            }

            #user-topnav-menu {
                margin-top: 1rem;
                width: 100%;
            }
        }

        /* Loading State */
        .page-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-color), var(--secondary-color), var(--accent-color));
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
            opacity: 0;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--secondary-color);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }
    </style>

    <?= $this->renderSection('custom_css') ?>
</head>
<body>
    <div class="academic-header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="<?= base_url('Main') ?>">Company Recruitment Management System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <ul class="navbar-nav me-auto ms-lg-4">
                        <li class="nav-item"><a class="nav-link <?= isset($page_title) && $page_title == 'Home' ? 'active' : '' ?>" href="<?= base_url('Main') ?>"><i class="fa fa-home me-1"></i> Home</a></li>
                        <li class="nav-item"><a class="nav-link <?= isset($page_title) && $page_title == 'Departments' ? 'active' : '' ?>" href="<?= base_url('Main/departments') ?>"><i class="fa fa-building me-1"></i> Departments</a></li>
                        <li class="nav-item"><a class="nav-link <?= isset($page_title) && $page_title == 'Vacancies' ? 'active' : '' ?>" href="<?= base_url('Main/vacancies') ?>"><i class="fa fa-briefcase me-1"></i> Vacancies</a></li>
                        <li class="nav-item"><a class="nav-link <?= isset($page_title) && $page_title == 'Applicants' ? 'active' : '' ?>" href="<?= base_url('Main/applicants') ?>"><i class="fa fa-users me-1"></i> Applicants</a></li>
                        <li class="nav-item"><a class="nav-link <?= isset($page_title) && $page_title == 'Users' ? 'active' : '' ?>" href="<?= base_url('Main/users') ?>"><i class="fa fa-user-shield me-1"></i> Users</a></li>
                    </ul>

                    <div class="dropdown">
                        <button id="user-topnav-menu" data-bs-toggle="dropdown" class="border-0">
                            <i class="fa fa-user-circle me-2" style="color: var(--secondary-color);"></i>
                            <?= esc($session->get('login_name')) ?>

                            <?php if (intval($maintenance) === 1): ?>
                                <span class="badge bg-danger ms-2">MAINTENANCE ON</span>
                            <?php endif; ?>

                            <i class="fa fa-angle-down ms-1" style="color: var(--text-light);"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?= base_url('SystemSetting/toggleMaintenance') ?>">
                                    <i class="fa fa-power-off" style="color: <?= (intval($maintenance) === 1) ? '#dc2626' : '#16a34a' ?>;"></i>
                                    <?= (intval($maintenance) === 1) ? 'Disable Maintenance Mode' : 'Enable Maintenance Mode' ?>
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <a class="dropdown-item" href="<?= base_url('update_user') ?>">
                                    <i class="fa fa-cog" style="color: var(--text-light);"></i>
                                    Update User
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="<?= base_url('Main/network_logs') ?>">
                                    <i class="fa fa-network-wired" style="color: var(--text-light);"></i>
                                    Network Logs
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                    <i class="fa fa-sign-out-alt" style="color: #dc2626;"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="container" style="padding-top:2rem; padding-bottom:2rem;">
        <?php if ($session->getFlashdata('main_error')): ?>
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle me-2"></i>
                <?= $session->getFlashdata('main_error') ?>
            </div>
        <?php endif; ?>
        <?php if ($session->getFlashdata('main_success')): ?>
            <div class="alert alert-success">
                <i class="fa fa-check-circle me-2"></i>
                <?= $session->getFlashdata('main_success') ?>
            </div>
        <?php endif; ?>

        <div class="page-wrapper">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <footer class="text-center">
        <div class="container">
            <p class="mb-1">© <?= date('Y') ?> Company Recruitment Management System</p>
            <p class="mb-0" style="font-size: 0.85rem; opacity: 0.8;">Professional Human Resource Management Solution</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- ✅ CLIENT IP + MAC CAPTURE SCRIPT -->
    <script>
$(document).ready(function() {
    $.getJSON("https://api.ipify.org?format=json", function(data) {
        const ip = data.ip || "Unknown";

        // Build unique device signature
        const deviceData = [
            navigator.userAgent,
            navigator.language,
            screen.width + "x" + screen.height,
            ip
        ].join("|");

        // Generate pseudo MAC hash
        let hash = 0;
        for (let i = 0; i < deviceData.length; i++) {
            const chr = deviceData.charCodeAt(i);
            hash = ((hash << 5) - hash) + chr;
            hash |= 0;
        }

        // Create pseudo-MAC format (consistent for each device/browser)
        const pseudoMac = "PC-" + Math.abs(hash).toString(16).padStart(12, "0").slice(0, 12);

        console.log("🖥 Detected Client IP:", ip, "Pseudo-MAC:", pseudoMac);

        // Send to backend via AJAX
        $.ajax({
            url: "<?= base_url('Main/saveClientMac') ?>",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify({ mac: pseudoMac, ip: ip }),
            success: (res) => console.log("✅ Sent client MAC/IP:", res),
            error: (err) => console.error("❌ Failed to send MAC/IP:", err)
        });
    });
});
    </script>

    <?= $this->renderSection('custom_js') ?>
</body>
</html>