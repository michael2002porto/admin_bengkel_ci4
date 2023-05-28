<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">List of Branch Offices</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/branch_office_add') ?>" class="btn btn btn-primary bg-gradient border rounded-0"><i class="far fa-plus-square"></i> Add Branch Office</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-stripped table-bordered">
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">Office Name</th>
                    <th class="p-1 text-center">Location</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach($branch_offices as $row): ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $i + (($page * $perPage) - $perPage +1) ?></th>
                            <td class="px-2 py-1 align-middle"><?= $row['office_name'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['location'] ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('Main/branch_office_edit/'.$row['id']) ?>" class="mx-2 text-decoration-none text-primary"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url('Main/branch_office_delete/'.$row['id']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete <?= $row['office_name'] ?> from list?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                    <?php if(count($branch_offices) <= 0): ?>
                        <tr>
                            <td class="p-1 text-center" colspan="4">No result found</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
            <div>
                <?= $pager->makeLinks($page, $perPage, $total, 'custom_view') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>