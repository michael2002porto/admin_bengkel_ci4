<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Add New Branch Office</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/branch_offices') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('Main/branch_office_add/') ?>" method="POST">
                <?php if($session->getFlashdata('error')): ?>
                    <div class="alert alert-danger rounded-0">
                        <?= $session->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <?php if($session->getFlashdata('success')): ?>
                    <div class="alert alert-success rounded-0">
                        <?= $session->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="office_name" class="control-label">Office Name</label>
                    <div class="input-group rounded-0">
                        <input type="text" class="form-control rounded-0" id="office_name" name="office_name" autofocus placeholder="PT ..." value="<?= !empty($request->getPost('office_name')) ? $request->getPost('office_name') : '' ?>" required="required">
                        <div class="input-group-text bg-light bg-gradient rounded-0"><i class="fa fa-building"></i></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="location" class="control-label">Location</label>
                    <div class="input-group rounded-0">
                        <input type="text" class="form-control rounded-0" id="location" name="location" placeholder="Jakarta" value="<?= !empty($request->getPost('location')) ? $request->getPost('location') : '' ?>" required="required">
                        <div class="input-group-text bg-light bg-gradient rounded-0"><i class="fa fa-location-dot"></i></div>
                    </div>
                </div>
                <div class="d-grid gap-1">
                    <button class="btn rounded-0 btn-primary bg-gradient">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>