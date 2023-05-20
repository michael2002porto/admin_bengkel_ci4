<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Add New Product</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/products') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('Main/product_add') ?>" method="POST" enctype="multipart/form-data">
                <?php if ($session->getFlashdata('error')) : ?>
                    <div class="alert alert-danger rounded-0">
                        <?= $session->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <?php if ($session->getFlashdata('success')) : ?>
                    <div class="alert alert-success rounded-0">
                        <?= $session->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="code" class="control-label">Code</label>
                    <input type="text" class="form-control rounded-0" id="code" name="code" autofocus placeholder="Code" value="<?= !empty($request->getPost('code')) ? $request->getPost('code') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="name" class="control-label">Name</label>
                    <input type="text" class="form-control rounded-0" id="name" name="name" placeholder="Product 101" value="<?= !empty($request->getPost('name')) ? $request->getPost('name') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="description" class="control-label">Description</label>
                    <textarea rows="3" class="form-control rounded-0" id="description" name="description"><?= !empty($request->getPost('description')) ? $request->getPost('description') : '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="control-label">Price</label>
                    <input type="number" step="any" class="form-control rounded-0 text-end" id="price" name="price" value="<?= !empty($request->getPost('price')) ? $request->getPost('price') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="image" class="control-label">Image</label>
                    <div class="row">
                        <div class="col-2">
                            <img id="blah" src="https://bit.ly/3ubuq5o" class="img-fluid" alt="your image" />
                        </div>
                        <div class="col-10">
                            <input class="form-control" type="file" id="image" name="image" accept="image/*" required onchange="readURL(this);">
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-1">
                    <button class="btn rounded-0 btn-primary bg-gradient">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>