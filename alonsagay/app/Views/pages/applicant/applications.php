<?= $this->extend('layouts/vacancy_base') ?>
<?= $this->section('content') ?>

<div class="container my-4">
    <h3 class="mb-3">My Applications</h3>

    <?php if(empty($applications)): ?>
        <div class="alert alert-info">You have not applied to any vacancies yet.</div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach($applications as $a): ?>
                <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                   href="<?= base_url('Applicant/application/'.$a['id']) ?>">
                    <div>
                        <div class="fw-bold"><?= esc($a['first_name']) ?> <?= esc($a['last_name']) ?></div>
                        <small class="text-muted">Email: <?= esc($a['email']) ?> • Applied: <?= date('M d, Y h:i A', strtotime($a['created_at'])) ?></small>
                    </div>
                    <div>
                        <?php
                            $statusText = 'Pending';
                            if (isset($a['status'])) {
                                if ($a['status'] == 1) $statusText = '<span class="badge bg-success">Accepted</span>';
                                elseif ($a['status'] == 2) $statusText = '<span class="badge bg-danger">Rejected</span>';
                                else $statusText = '<span class="badge bg-secondary">Pending</span>';
                            } else {
                                $statusText = '<span class="badge bg-secondary">Pending</span>';
                            }
                        ?>
                        <?= $statusText ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
