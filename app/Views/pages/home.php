<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-body">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <h1 class="fw-bold">Welcome, <?= $session->get('login_name') ?>!</h1>
            </div>
            <div class="col-auto">
                <button class="btn-lg" onclick="downloadPDFWithBrowserPrint()">Print</button>
            </div>
        </div>
    </div>
</div>
<br>
<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Produk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_produk ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cog fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Jumlah Transaksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_transaksi ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wrench fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Jumlah User</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_user ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-person-booth fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Jumlah Cabang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_cabang ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-building fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card rounded-0">
    <div class="card-body">
        <div class="d-grid gap-2 col-6 mx-auto">
            <a class="btn btn-success fw-bold" type="button" href="<?= base_url('Main/shopping') ?>">Let's Go Shopping!</a>
        </div>
    </div>
</div>

<script>
    function downloadPDFWithBrowserPrint() {
        window.print();
    }
</script>
<?= $this->endSection() ?>