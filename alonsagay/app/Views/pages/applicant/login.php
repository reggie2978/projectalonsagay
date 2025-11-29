<?= $this->extend('layouts/vacancy_base') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <div class="col-md-5 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-3">Applicant Login</h3>

                <!-- Flash messages -->
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <!-- Validation errors -->
                <?php if (isset($validation)): ?>
                    <div class="alert alert-danger">
                        <?= $validation->listErrors() ?>
                    </div>
                <?php endif; ?>

                <!-- LOGIN FORM -->
                <form method="post" action="<?= base_url('Applicant/loginAuth') ?>">
                    <?= csrf_field() ?>

                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control" 
                            value="<?= set_value('email') ?>" 
                            required
                        >
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            class="form-control" 
                            required
                        >
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-primary">Login</button>
                        <a href="<?= base_url('Applicant/register') ?>" class="btn btn-link">
                            Create account
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
