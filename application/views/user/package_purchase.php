<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('package_purchase');?></h1>
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
                <div class="link-package active"><?= $this->lang->line('mining_fil');?></div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 my-2">
            <a class="text-white text-decoration-none" href="<?= base_url('user/packageTour'); ?>">
                <div class="link-package"><?= $this->lang->line('tour');?></div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 my-2">
            <a class="text-white text-decoration-none" href="#">
                <div class="link-package"><?= $this->lang->line('marketplace');?></div>
            </a>
        </div>
    </div>
    <div class="row text-center">
        <?php foreach ($package_filecoin as $row_filecoin) { ?>
            <div class="col-lg-4 col-md-6 col-sm-12 my-2">
                <div class="card shadow h-100 bg-trans bd-none">
                    <div class="card-body">
                        <!-- <img src="<?= base_url('assets/img/') . $row_filecoin->img; ?>" class="img-fluid"> -->
                        <div class="mining-package" style="background-image:url(<?= base_url('assets/img/') . $row_filecoin->img; ?>);">
                            <p class="p-mining-1 font-wight-bold text-white"><?= $row_filecoin->daysmining; ?><span class="span-mining-1 text-white"> <?= $this->lang->line('days_of_mining');?></span></p>
                            <p class="p-mining-2 font-wight-bold text-white" style="margin-top:-25px"><?= $row_filecoin->daysmining / 2; ?><span class="span-mining-2 text-white"> <?= $this->lang->line('days_free_cost');?></span></p>
                            <p class="p-mining-3 font-wight-bold text-white" style="margin-top:-25px"><?= $row_filecoin->daysmining / 2; ?><span class="span-mining-3 text-white"> <?= $this->lang->line('days_paid_cost');?></span></p>
                            <p class="p-mining-4 font-italic text-white mt-4 mb-0"><?= $this->lang->line('start_after');?> :</p>
                            <p class="p-mining-5 font-italic text-white mb-0"><?= $row_filecoin->startafter; ?> <?= $this->lang->line('days_for_fil');?></p>
                            <p class="p-mining-6 font-italic text-white" style="margin-top:-7px">7 <?= $this->lang->line('days_for_mtm');?></p>
                            <p class="p-mining-7 font-italic text-white mb-0" style="margin-top: -8px;">
                                <?= $this->lang->line('hashrate');?> : <span class="span-mining-7"><?= $row_filecoin->hashrate; ?> GiB</span>
                                <?= $row_filecoin->tib != 0 ? '/' . $row_filecoin->tib . 'TiB' : ''; ?>
                            </p>
                        </div>
                        <div class="my-3 mx-auto buy-package">
                            <a href="<?= base_url() . 'user/fil/' . $row_filecoin->id; ?>" class="btn btn-bonus btn-block"><?= $this->lang->line('buy');?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>


    <!-- /.content -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->