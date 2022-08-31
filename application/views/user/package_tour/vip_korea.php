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

    <div class="bg-custom mt-5">
        <div class="row">
            <div class="col-md-12 p-5 mx-auto justify-content-center text-justify">
                <p class="font-italic text-center mb-0" style="color:#44c2cb; font-size:40px; font-weight:800; margin-top:-75px;   text-shadow: 4px 3px 10px black;"><?= $this->lang->line('package_vip_korea_title'); ?></p>
                <p class="text-center text-white mb-1" style="font-size:24px; font-weight:800;"><?= $this->lang->line('package_vip_korea_title_sub'); ?></p>
                <table border="1" cellpadding="4" class="tb-tour font-italic mx-auto w-100 text-uppercase">
                    <thead>
                        <tr>
                            <th class="text-center"><?= $this->lang->line('date'); ?></th>
                            <th class="text-center"><?= $this->lang->line('time'); ?></th>
                            <th class="text-center"><?= $this->lang->line('destination'); ?></th>
                            <th class="text-center"><?= $this->lang->line('activity'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th rowspan="2"></th>
                            <td class="text-center">01.00</td>
                            <td><?= $this->lang->line('indonesia_to_korea'); ?></td>
                            <td><?= $this->lang->line('check_in_take_of'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">09.40</td>
                            <td><a href="<?= base_url('user/incheonAirport'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/incheon-airport.jpg'); ?>" data-title="<?= $this->lang->line('incheon_airport'); ?>" data-text="<?= $this->lang->line('data_text_incheon_airport'); ?>"><?= $this->lang->line('korea_incheon_airport'); ?></a></td>
                            <td><?= $this->lang->line('arrive_at_incheon_airport'); ?></td>
                        </tr>
                        <tr>
                            <th rowspan="3" class="text-center"><?= $this->lang->line('day'); ?> 1</th>
                            <td class="text-center">10.00</td>
                            <td><a href="<?= base_url('user/seoulCity'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/seoul.jpg'); ?>" data-title="<?= $this->lang->line('seoul_city'); ?>" data-text="<?= $this->lang->line('data_text_seoul_city'); ?>"><?= $this->lang->line('seoul_city'); ?></a></td>
                            <td><?= $this->lang->line('have_lunch'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">13.00</td>
                            <td><a href="<?= base_url('user/gyeongbokPalace'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/gyeongbok-palace.jpg'); ?>" data-title="<?= $this->lang->line('geongbok_palace'); ?>" data-text="<?= $this->lang->line('data_text_geongbok_palace'); ?>"><?= $this->lang->line('geongbok_palace'); ?></a></td>
                            <td><?= $this->lang->line('seoul_city_tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">18.00</td>
                            <td><?= $this->lang->line('hotel'); ?> (*4)</td>
                            <td><?= $this->lang->line('dinner'); ?></td>
                        </tr>
                        <tr>
                            <th rowspan="3" class="text-center"><?= $this->lang->line('day'); ?> 2</th>
                            <td class="text-center">10.00</td>
                            <td><?= $this->lang->line('hotel'); ?> (*4)</td>
                            <td><?= $this->lang->line('breakfast'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">13.00</td>
                            <td><a href="<?= base_url('user/insadong'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/insadong.jpg'); ?>" data-title="<?= $this->lang->line('insa_dong'); ?>" data-text="<?= $this->lang->line('data_text_insa_dong'); ?>"><?= $this->lang->line('insa_dash_dong'); ?></a></td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">18.00</td>
                            <td><a href="<?= base_url('user/namsanTower'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/namsan-tower.jpg'); ?>" data-title="<?= $this->lang->line('namsan_tower'); ?>" data-text="<?= $this->lang->line('data_text_namsan_tower'); ?>"><?= $this->lang->line('namsan_tower'); ?></a></td>
                            <td><?= $this->lang->line('tour_dinner'); ?> </td>
                        </tr>
                        <tr>
                            <th rowspan="3" class="text-center"><?= $this->lang->line('day'); ?> 3</th>
                            <td class="text-center">10.00</td>
                            <td><?= $this->lang->line('hotel'); ?> (*4)</td>
                            <td><?= $this->lang->line('breakfast'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">13.00</td>
                            <td><a href="<?= base_url('user/lotteTower'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/lotte-tower.jpg'); ?>" data-title="<?= $this->lang->line('lotte_tower'); ?>" data-text="<?= $this->lang->line('data_text_lotte_tower'); ?>"><?= $this->lang->line('lotte_tower'); ?></a></td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">18.00</td>
                            <td><a href="<?= base_url('user/observatoriumLotteTower'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/observatorium.jpg'); ?>" data-title="<?= $this->lang->line('observatorium_lotte_tower'); ?>" data-text="<?= $this->lang->line('data_text_observatorium_lotte_tower'); ?>"><?= $this->lang->line('observatorium_lotte_tower'); ?></a></td>
                            <td><?= $this->lang->line('tour_dinner'); ?></td>
                        </tr>
                        <tr>
                            <th rowspan="3" class="text-center"><?= $this->lang->line('day'); ?> 4</th>
                            <td class="text-center">10.00</td>
                            <td><?= $this->lang->line('hotel'); ?> (*4)</td>
                            <td><?= $this->lang->line('breakfast'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">13.00</td>
                            <td><?= $this->lang->line('hospital_korea'); ?></td>
                            <td><?= $this->lang->line('tour_checkup'); ?> / <?= $this->lang->line('medical'); ?> / <?= $this->lang->line('plastic_surgery'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">18.00</td>
                            <td><?= $this->lang->line('korea_indonesia'); ?></td>
                            <td><?= $this->lang->line('check_in_take_of'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="my-4 mx-auto w-50">
        <a href="<?= base_url() . 'user/tour/1' ?>" class="btn btn-bonus btn-block font-italic"><?= $this->lang->line('buy'); ?></a>
    </div>

    <!-- /.content -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<div class="card-priview">
    <img src="" class="card-img-top">
    <div class="card-body">
        <h5 class="card-title"></h5>
        <p class="card-text"></p>
    </div>
</div>