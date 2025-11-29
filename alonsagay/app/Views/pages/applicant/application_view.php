<?= $this->extend('layouts/vacancy_base') ?>
<?= $this->section('content') ?>

<div class="container my-4">
    <div class="col-md-8 mx-auto">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-0">Application Details</h4>
            </div>
            <div class="card-body">
                <p><b>Vacancy ID:</b> <?= esc($application['vacancy_id']) ?></p>
                <p><b>Name:</b> <?= esc($application['first_name']) ?> <?= esc($application['middle_name']) ?> <?= esc($application['last_name']) ?></p>
                <p><b>Email:</b> <?= esc($application['email']) ?></p>
                <p><b>Contact:</b> <?= esc($application['contact']) ?></p>
                <p><b>Address:</b> <?= esc($application['address']) ?></p>
                <p><b>Applied at:</b> <?= date('M d, Y h:i A', strtotime($application['created_at'])) ?></p>

                <p><b>Status:</b>
                    <?php
                    if (isset($application['status'])) {
                        if ($application['status'] == 1) echo '<span class="badge bg-success">Accepted</span>';
                        elseif ($application['status'] == 2) echo '<span class="badge bg-danger">Rejected</span>';
                        else echo '<span class="badge bg-secondary">Pending</span>';
                    } else {
                        echo '<span class="badge bg-secondary">Pending</span>';
                    }
                    ?>
                </p>

                <a href="<?= base_url('Applicant/applications') ?>" class="btn btn-light">Back to Applications</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
