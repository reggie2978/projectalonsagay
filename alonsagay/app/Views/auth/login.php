<?= $this->extend('layouts/login_base') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-color: #1a3a52;
        --secondary-color: #2c5f7f;
        --accent-color: #d4af37;
        --text-dark: #2c3e50;
        --text-light: #5a6c7d;
        --border-light: #e0e6ed;
        --shadow-sm: 0 2px 8px rgba(26, 58, 82, 0.08);
        --shadow-md: 0 4px 16px rgba(26, 58, 82, 0.12);
        --shadow-lg: 0 8px 24px rgba(26, 58, 82, 0.16);
    }

    .login-title {
        font-family: 'Merriweather', Georgia, serif;
        font-weight: 700;
        color: var(--primary-color);
        font-size: 2rem;
        text-align: center;
        padding: 2rem 0;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .login-title::before {
        content: '🎓';
        font-size: 2.5rem;
    }

    .login-title::after {
        content: '';
        position: absolute;
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--accent-color), transparent);
        border-radius: 2px;
    }

    .login-container {
        max-width: 450px;
        margin: 0 auto;
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-card {
        border: none;
        border-radius: 16px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        background: #fff;
    }

    .login-card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        padding: 1.5rem;
        border-bottom: 3px solid var(--accent-color);
        position: relative;
    }

    .login-card-header::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.4;
    }

    .login-card-title {
        font-family: 'Merriweather', Georgia, serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: #fff;
        margin: 0;
        text-align: center;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .login-card-title::before {
        content: '\f023';
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        color: var(--accent-color);
        font-size: 1.5rem;
    }

    .login-card-body {
        padding: 2.5rem 2rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control {
        border: 2px solid var(--border-light);
        border-radius: 10px 0 0 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background-color: #fafbfc;
    }

    .form-control:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 0.2rem rgba(44, 95, 127, 0.15);
        background-color: #fff;
    }

    .input-group {
        box-shadow: var(--shadow-sm);
        border-radius: 10px;
        overflow: hidden;
    }

    .input-group-text {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border: 2px solid var(--secondary-color);
        border-left: none;
        border-radius: 0 10px 10px 0;
        padding: 0.75rem 1.25rem;
        color: #fff;
        font-size: 1.1rem;
    }

    .btn-login {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border: none;
        border-radius: 10px;
        padding: 0.85rem 2rem;
        font-weight: 600;
        font-size: 1.05rem;
        color: #fff;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }

    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
    }

    .btn-login:hover::before {
        left: 100%;
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        color: var(--secondary-color);
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .back-link::before {
        content: '\f060';
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        transition: transform 0.3s ease;
    }

    .back-link:hover {
        color: var(--primary-color);
        gap: 0.75rem;
    }

    .back-link:hover::before {
        transform: translateX(-4px);
    }

    /* Alert Styling */
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.25rem;
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

    /* Responsive Design */
    @media (max-width: 576px) {
        .login-title {
            font-size: 1.5rem;
            padding: 1.5rem 1rem;
        }

        .login-title::before {
            font-size: 2rem;
        }

        .login-card-body {
            padding: 2rem 1.5rem;
        }

        .login-card-title {
            font-size: 1.5rem;
        }
    }

    /* Subtle Animation for Form Elements */
    .mb-3 {
        animation: slideIn 0.4s ease-out;
        animation-fill-mode: both;
    }

    .mb-3:nth-child(2) {
        animation-delay: 0.1s;
    }

    .mb-3:nth-child(3) {
        animation-delay: 0.2s;
    }

    .mb-3:nth-child(4) {
        animation-delay: 0.3s;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>

<h2 class="login-title"><?= env('system_name') ?></h2>

<div class="login-container col-lg-5 col-md-6 col-sm-10 col-xs-12">
    <div class="card login-card">
        <div class="card-header login-card-header">
            <div class="login-card-title">Administrator Login</div>
        </div>
        <div class="card-body login-card-body">
            <div class="container-fluid">
                <form action="<?= base_url('login') ?>" method="POST">
                    <?php if($session->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= $session->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if($session->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= $session->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   autofocus 
                                   placeholder="administrator@example.com" 
                                   value="<?= !empty($data->getPost('email')) ? $data->getPost('email') : '' ?>" 
                                   required="required">
                            <div class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter your password" 
                                   required="required">
                            <div class="input-group-text">
                                <i class="fa fa-key"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-login">
                            <i class="fa fa-sign-in-alt me-2"></i>
                            Sign In
                        </button>
                    </div>
                    
                    <div class="text-center">
                        <a href="<?= base_url('/Vacancy') ?>" class="back-link">
                            Back to Site
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>