<?= $this->extend('layouts/vacancy_base') ?>
<?= $this->section('content') ?>

<div class="container my-4">
    <div class="row">

        <!-- DASHBOARD CARDS -->
        <div class="col-md-10 mx-auto">
            <h3 class="mb-3 text-center">My Dashboard</h3>

            <div class="row text-center">

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm p-3">
                        <h5>Pending</h5>
                        <h2 class="text-warning"><?= esc($pending ?? 0) ?></h2>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm p-3">
                        <h5>Accepted</h5>
                        <h2 class="text-success"><?= esc($accepted ?? 0) ?></h2>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm p-3">
                        <h5>Rejected</h5>
                        <h2 class="text-danger"><?= esc($rejected ?? 0) ?></h2>
                    </div>
                </div>

            </div>
        </div>

        <!-- CHART -->
        <div class="col-md-10 mx-auto mt-4">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0">Application Status Overview</h4>
                </div>
                <div class="card-body">
                    <canvas id="applicationChart" height="90"></canvas>
                </div>
            </div>
        </div>

        <!-- USER CONTROLS -->
        <div class="col-md-10 mx-auto mt-4">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0">💼</h4>
                </div>
                <div class="card-body">

                    <a href="<?= base_url('Applicant/applications') ?>" class="btn btn-primary">My Applications</a>
                    <a href="<?= base_url('Applicant/logout') ?>" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('applicationChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Pending', 'Accepted', 'Rejected'],
        datasets: [{
            label: 'Applications',
            data: [
                <?= esc($pending ?? 0) ?>,
                <?= esc($accepted ?? 0) ?>,
                <?= esc($rejected ?? 0) ?>
            ],
            backgroundColor: ['#f4c542', '#28a745', '#dc3545'],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

<?= $this->endSection() ?>
