<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">Network</h1>
    <div class="v-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group input-group-joined">
            <span class="input-group-text">
                <img src="<?= base_url('assets/img/icon-03.png'); ?>" alt="icon" width="20px">
            </span>
            <input class="form-control border-0 small" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" id="myInputMobile">
        </div>
    </div>

    <?= $this->session->flashdata('message'); ?>

    <div class="col-md-12 col-sm-12 mt-5" id="">
        <div class="tree zoom dragscroll" style="width: auto; height:90vh;">
            <?= $network; ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->