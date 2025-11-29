<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Site Under Maintenance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body { background: #f8f9fa; }
        .center { min-height: 100vh; display:flex; align-items:center; justify-content:center; }
    </style>
</head>
<body>
    <div class="container center">
        <div class="text-center">
            <h1 class="display-4 text-danger"><i class="fa fa-tools"></i> Site Under Maintenance</h1>
            <p class="lead">We are performing scheduled maintenance. We'll be back soon.</p>
            <a href="<?= base_url('/') ?>" class="btn btn-dark">Go to Home</a>
        </div>
    </div>
</body>
</html>
