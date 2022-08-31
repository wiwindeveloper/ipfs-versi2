<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('package_purchase'); ?></h1>
    <?= $this->session->flashdata('message'); ?>

    <!-- content -->
    <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="filecoin-tab" data-toggle="tab" href="#filecoin" role="tab" aria-controls="filecoin" aria-selected="true">
                                Filecoin Mining
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="mtm-tab" data-toggle="tab" href="#mtm" role="tab" aria-controls="mtm" aria-selected="false">
                                MTM Coin Mining
                            </a>
                        </li>
                    </ul> -->
    <!-- <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="filecoin" role="tabpanel" aria-labelledby="filecoin-tab">
                            <div class="row">
                                <?php foreach ($package_filecoin as $row_filecoin) { ?>
                                <div class="col-xl-4 col-md-12 my-3">
                                    <div class="card border-left-info shadow h-100 py-2 purchase">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="mb-3">
                                                    <h2><?= $row_filecoin->name; ?></h2>
                                                </div>
                                                <div class="mb-3">
                                                    <img src="<?= base_url('assets/img/filecoin-img.png'); ?>" alt="gambar" width="100">
                                                </div>
                                                <div class="mb-3">
                                                    <a href="<?= base_url() . 'user/fil/' . $row_filecoin->id; ?>" class="btn btn-primary btn-block"><?= $row_filecoin->fil; ?> FIL</a>
                                                    <a href="#" class="btn btn-primary btn-block"><?= $row_filecoin->usdt; ?> USDT</a>
                                                    <a href="#" class="btn btn-primary btn-block"><?= $row_filecoin->mtm; ?> MTM/+100 Day</a>
                                                </div>
                                                <div class="mb-3">
                                                    <p><?= $row_filecoin->daysmining; ?> Days of Mining</p>
                                                    <p>Start After <?= $row_filecoin->startafter; ?> Days</p>
                                                    <p>Hashrate : <?= $row_filecoin->hashrate; ?> Gib</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="mtm" role="tabpanel" aria-labelledby="mtm-tab">
                            <div class="row">

                                <?php foreach ($package_mtmcoin as $row_mtmcoin) { ?>
                                <div class="col-xl-4 col-md-12 my-3">
                                    <div class="card border-left-info shadow h-100 py-2 purchase">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="mb-3">
                                                    <h2><?= $row_mtmcoin->name; ?></h2>
                                                </div>
                                                <div class="mb-3">
                                                    <img src="<?= base_url('assets/img/mtmcoin-img.png'); ?>" alt="gambar" width="100">
                                                </div>
                                                <div class="mb-3">
                                                    <a href="<?= base_url() . 'user/fil/' . $row_mtmcoin->id; ?>" class="btn btn-primary btn-block"><?= $row_mtmcoin->fil; ?> FIL</a>
                                                    <a href="#" class="btn btn-primary btn-block"><?= $row_mtmcoin->usdt; ?> USDT</a>
                                                    <a href="#" class="btn btn-primary btn-block"><?= $row_mtmcoin->mtm; ?> MTM/+100 Day</a>
                                                </div>
                                                <div class="mb-3">
                                                    <p><?= $row_mtmcoin->daysmining; ?> Days of Mining</p>
                                                    <p>Start After <?= $row_mtmcoin->startafter; ?> Days</p>
                                                    <p>Hashrate : <?= $row_mtmcoin->hashrate; ?> Gib</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div> -->

    <!-- new design -->
    <div class="row text-center navlink-package text-uppercase">
        <div class="col-lg-4 col-md-4 my-2">
            <a class="text-white text-decoration-none" href="<?= base_url('user/package'); ?>">
                <div class="link-package"><?= $this->lang->line('mining_fil'); ?></div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 my-2">
            <a class="text-white text-decoration-none" href="<?= base_url('user/packageTour'); ?>">
                <div class="link-package active"><?= $this->lang->line('tour'); ?></div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 my-2">
            <a class="text-white text-decoration-none" href="#">
                <div class="link-package"><?= $this->lang->line('marketplace'); ?></div>
            </a>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-md-4 my-3">
            <div class="card shadow py-2 bg-trans bd-none">
                <div class="card-body tour-body mx-auto" style="width: fit-content;">
                    <div class="tour-package p-5" style="background-image:url(<?= base_url('assets/img/icon_tour-01.png') ?>);">
                        <p class="p-tour-1 text-white mb-0 text-uppercase"><?= $this->lang->line('tour'); ?>*</p>
                        <p class="p-tour-2 text-white mb-0"><?= $this->lang->line('vip_korea_title'); ?></p>
                        <p class="p-tour-3 text-white mb-0"><?= $this->lang->line('vip_bali_title'); ?></p>
                        <p class="p-tour-4 text-white mb-0"><?= $this->lang->line('hotel'); ?> (*4)</p>
                        <p class="p-tour-5 text-white mb-0"><?= $this->lang->line('tour_traveling'); ?> (7 <?= $this->lang->line('place'); ?>)</p>
                        <p class="p-tour-6 text-white mb-0"><?= $this->lang->line('food_kuliner'); ?></p>
                    </div>
                    <div class="my-3 mx-auto">
                        <a href="<?= base_url('user/packageKoreaVIP'); ?>" class="btn-tour btn btn-bonus btn-block font-italic"><?= $this->lang->line('tour_korea'); ?></a>
                        <a href="<?= base_url('user/packageBaliVIP'); ?>" class="btn-tour btn btn-bonus btn-block font-italic"><?= $this->lang->line('tour_bali'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 my-3">
            <div class="card shadow py-2 bg-trans bd-none">
                <div class="card-body tour-body mx-auto" style="width: fit-content;">
                    <div class="tour-package p-5" style="background-image:url(<?= base_url('assets/img/icon_tour-02.png') ?>);">
                        <p class="p-tour-1 text-white mb-0 text-uppercase"><?= $this->lang->line('tour'); ?>*</p>
                        <p class="p-tour-2 text-white mb-0"><?= $this->lang->line('vvip_korea_title'); ?></p>
                        <p class="p-tour-3 text-white mb-0"><?= $this->lang->line('vvip_bali_title'); ?></p>
                        <p class="p-tour-4 text-white mb-0"><?= $this->lang->line('hotel'); ?> (*5)</p>
                        <p class="p-tour-5 text-white mb-0"><?= $this->lang->line('tour_traveling'); ?> (9 <?= $this->lang->line('place'); ?>)</p>
                        <p class="p-tour-6 text-white mb-0"><?= $this->lang->line('food_kuliner'); ?></p>
                    </div>
                    <div class="my-3 mx-auto">
                        <a href="<?= base_url('user/packageKoreaVVIP'); ?>" class="btn-tour btn btn-bonus btn-block font-italic"><?= $this->lang->line('tour_korea'); ?> + <?= $this->lang->line('check_up'); ?></a>
                        <a href="<?= base_url('user/packageBaliVvIP'); ?>" class="btn-tour btn btn-bonus btn-block font-italic"><?= $this->lang->line('tour_bali'); ?> + NYEPI</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 my-3">
            <div class="card shadow py-2 bg-trans bd-none">
                <div class="card-body tour-body mx-auto" style="width: fit-content;">
                    <div class="tour-package p-5" style="background-image:url(<?= base_url('assets/img/icon_tour-03.png') ?>);">
                        <p class="p-tour-1 text-white mb-0 text-uppercase"><?= $this->lang->line('tour'); ?>*</p>
                        <p class="p-tour-2 text-white mb-0"><?= $this->lang->line('gold_korea_title'); ?></p>
                        <p class="p-tour-3 text-white mb-0"><?= $this->lang->line('gold_bali_title'); ?></p>
                        <p class="p-tour-4 text-white mb-0"><?= $this->lang->line('hotel'); ?> (*6)</p>
                        <p class="p-tour-5 text-white mb-0"><?= $this->lang->line('tour_traveling'); ?> (11 <?= $this->lang->line('place'); ?>)</p>
                        <p class="p-tour-6 text-white mb-0"><?= $this->lang->line('food_kuliner'); ?>(6 <?= $this->lang->line('place'); ?>)</p>
                    </div>
                    <div class="my-3 mx-auto">
                        <a href="<?= base_url('user/packageKoreaGoldVVIP'); ?>" class="btn-tour btn btn-bonus btn-block font-italic"><?= $this->lang->line('tour_korea'); ?> + <?= $this->lang->line('medical'); ?>/<?= $this->lang->line('surgery'); ?></a>
                        <a href="<?= base_url('user/packageBaliGoldVVIP'); ?>" class="btn-tour btn btn-bonus btn-block font-italic"><?= $this->lang->line('tour_bali'); ?> + NYEPI</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h3 class="text-center text-white">*<?= $this->lang->line('tour_package_note'); ?></h3>


    <!-- /.content -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->