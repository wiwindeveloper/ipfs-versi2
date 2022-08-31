<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb text-white mb-4">Iklan Home</h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Banner Atas</h6>
        </div>
        <?php echo form_open("admin/iklanHome", array('enctype' => 'multipart/form-data')); ?>
        <div class="input-group" style="padding:1.25rem">
            <div class="custom-file input-group-prepend">
                <input type="file" class="custom-file-input image-name" name="image" id="image" onchange="previewImg()">
                <label class="custom-file-label" for="image">Choose file</label>
            </div>
            <div class="input-group-append">
                <input class="btn btn-secondary" type="submit" name="submit_1"></input>
            </div>
        </div>
        <?php echo form_close() ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($banner1 as $row) : ?>
                            <tr>
                                <td style="width:100px"><?= $i++; ?></td>
                                <td><img src="<?= base_url('assets/photo/banner/' . $row->image) ?>" alt="image" width="300px" /></td>
                                <td style="width:100px">
                                    <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#delete_modal<?= $row->id ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Banner Samping</h6>
        </div>
        <?php echo form_open("admin/iklanHome", array('enctype' => 'multipart/form-data')); ?>
        <div class="input-group" style="padding:1.25rem">
            <div class="custom-file input-group-prepend">
                <input type="file" class="custom-file-input image-name" name="image" id="image" onchange="previewImg()">
                <label class="custom-file-label" for="image">Choose file</label>
            </div>
            <div class="input-group-append">
                <input class="btn btn-secondary" type="submit" name="submit_2"></input>
            </div>
        </div>
        <?php echo form_close() ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($banner2 as $row) : ?>
                            <tr>
                                <td style="width:100px"><?= $i++; ?></td>
                                <td><img src="<?= base_url('assets/photo/banner/' . $row->image) ?>" alt="image" height="200px" /></td>
                                <td style="width:100px">
                                    <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#delete_modal<?= $row->id ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Konformasi Hapus  -->
<?php
foreach ($banner1 as $row) {
?>
    <div class="modal fade" id="delete_modal<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Image</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="<?php echo base_url('admin/deleteIklanHome') ?>">
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus iklan <b><?php echo $row->image; ?></b>?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_banner" value="<?php echo $row->id; ?>">
                        <input type="hidden" name="image" value="<?php echo $row->image; ?>">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        <button class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<?php
foreach ($banner2 as $row) {
?>
    <div class="modal fade" id="delete_modal<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Image</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="<?php echo base_url('admin/deleteIklanHome') ?>">
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus iklan <b><?php echo $row->image; ?></b>?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_banner" value="<?php echo $row->id; ?>">
                        <input type="hidden" name="image" value="<?php echo $row->image; ?>">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        <button class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>