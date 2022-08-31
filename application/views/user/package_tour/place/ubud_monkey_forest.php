<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('package_purchase'); ?></h1>
    <?= $this->session->flashdata('message'); ?>

    <!-- new design -->
    <div class="row text-center navlink-package">
        <div class="col-lg-4 col-md-4 my-2">
            <a class="text-white text-decoration-none" href="<?= base_url('user/package'); ?>">
                <div class="link-package text-uppercase"><?= $this->lang->line('mining_fil'); ?></div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 my-2">
            <a class="text-white text-decoration-none" href="<?= base_url('user/packageTour'); ?>">
                <div class="link-package active text-uppercase"><?= $this->lang->line('tour'); ?></div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 my-2">
            <a class="text-white text-decoration-none" href="#">
                <div class="link-package text-uppercase"><?= $this->lang->line('marketplace'); ?></div>
            </a>
        </div>
    </div>

    <div class="bg-custom mt-5">
        <div class="row">
            <div class="col-md-12 p-5 text-white mx-auto justify-content-center text-justify">
                <img src="<?= base_url('assets/photo/tour/ubud-monkey-forest.jpg'); ?>" alt="Ubud Monkey Forest" class="mb-4 img-placetour">
                <h2 class="font-italic font-weight-bold text-uppercase">UBUD MONKEY FOREST</h2>
                <p><?= $this->lang->line('ubud_monkey_paragraph1'); ?></p>
                <p><?= $this->lang->line('ubud_monkey_paragraph2'); ?></p>
                <p><?= $this->lang->line('ubud_monkey_paragraph3'); ?></p>
                <p><?= $this->lang->line('ubud_monkey_paragraph4'); ?></p>
            </div>
        </div>
    </div>
    <div class="my-4 mx-auto w-50">
        <a onclick="window.history.back()" class="btn btn-cancel btn-block text-uppercase"><?= $this->lang->line('back'); ?></a>
    </div>



    <!-- /.content -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->