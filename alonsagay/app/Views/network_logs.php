<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="m-0">
            <i class="fa fa-network-wired me-2"></i> Network Logs
        </h5>

        <!-- ✅ Clear Logs Button -->
        <form action="<?= base_url('NetworkLogs/clear') ?>" method="post"
              onsubmit="return confirm('Are you sure you want to clear all logs? This action cannot be undone.');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fa fa-trash-alt me-1"></i> Clear Logs
            </button>
        </form>
    </div>

    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>IP Address</th>
                    <th>MAC Address</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= esc($log['id']) ?></td>
                            <td><?= esc($log['user_name'] ?? 'System') ?></td>
                            <td><?= esc($log['action']) ?></td>
                            <td><?= esc($log['ip_address']) ?></td>
                            <td><?= esc($log['mac_address']) ?></td>
                            <td><?= esc($log['created_at']) ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No network logs yet.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
