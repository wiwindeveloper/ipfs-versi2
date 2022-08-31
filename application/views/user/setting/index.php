<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('setting'); ?></h1>
    <?= $this->session->flashdata('message'); ?>

    <!-- content -->
    <div class="row mt-5">
        <div class="col-md-8 mx-auto">
            <a href="<?= base_url('user/changePassword'); ?>" class="btn btn-bonus btn-block"><?= $this->lang->line('change_password') ?></a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-8 mx-auto">
            <a href="<?= base_url('user/changeEmail'); ?>" class="btn btn-bonus btn-block"><?= $this->lang->line('change_email') ?></a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-8 mx-auto">
            <a href="<?= base_url('user/google_otp') ?>" class="btn btn-bonus btn-block">Google OTP</a>
        </div>
    </div>
    <!-- /.content -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->