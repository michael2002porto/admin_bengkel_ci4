<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-body">
        <h1 class="fw-bold">Welcome, <?= $session->get('login_name') ?>!</h1>
    </div>
</div>
<br>
<div class="card rounded-0">
    <div class="card-body">
        <div class="d-grid gap-2 col-6 mx-auto">
            <a class="btn btn-success fw-bold" type="button" href="<?= base_url('Main/shopping') ?>">Let's Go Shopping!</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>