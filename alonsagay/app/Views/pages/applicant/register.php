<?= $this->extend('layouts/vacancy_base') ?>
<?= $this->section('content') ?>

<?php helper('form'); ?>

<div class="container my-5">
    <div class="col-md-6 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-3">Applicant Registration</h3>

                <?php if(isset($validation)): ?>
                    <div class="alert alert-danger">
                        <?= $validation->listErrors() ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('Applicant/register') ?>">
                    <?= csrf_field() ?>

                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= set_value('email') ?>" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirm" class="form-control" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-success">Create Account</button>
                        <a href="<?= base_url('Applicant/login') ?>" class="btn btn-link">Already have an account? Login</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
