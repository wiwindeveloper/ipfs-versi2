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
            <div class="col-md-12 p-5 mx-auto justify-content-center text-justify">
                <p class="font-italic text-center mb-0" style="color:#44c2cb; font-size:40px; font-weight:800; margin-top:-75px;   text-shadow: 4px 3px 10px black;"><?= $this->lang->line('vip_tour_intinerary'); ?></p>
                <p class="text-center text-white mb-1" style="font-size:24px; font-weight:800;"><?= $this->lang->line('sub_vip_tour_intinerary'); ?></p>
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
                            <th rowspan="2" class="text-center"><?= $this->lang->line('day'); ?> 1</th>
                            <td rowspan="2"></td>
                            <td rowspan="2"><?= $this->lang->line('korea_to_bali'); ?></td>
                            <td><?= $this->lang->line('airport_pickup'); ?></td>
                        </tr>
                        <tr>
                            <td><?= $this->lang->line('hotel_checkin'); ?></td>
                        </tr>
                        <tr>
                            <th rowspan="6" class="text-center"><?= $this->lang->line('day'); ?> 2 JIMBARAN TOUR</th>
                            <td class="text-center">10.00</td>
                            <td><a href="<?= base_url('user/gwk'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/gwk.jpg'); ?>" data-title="GWK PARK" data-text="<?= $this->lang->line('data_text_gwk_park'); ?>">GWK PARK</a></td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">12.00</td>
                            <td><?= $this->lang->line('restaurant'); ?></td>
                            <td><?= $this->lang->line('lunch'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">13.30</td>
                            <td><a href="<?= base_url('user/padangpadangBeach'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/padang-padang_beach.jpg'); ?>" data-title="PADANG-PADANG BEACH" data-text="<?= $this->lang->line('data_text_padang_padang_beach'); ?>">PADANG-PADANG BEACH</a></td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">15.15</td>
                            <td><a href="<?= base_url('user/singleFin'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/single-fin.jpg'); ?>" data-title="<?= $this->lang->line('single_fin'); ?>" data-text="<?= $this->lang->line('data_text_single_fin'); ?>"><?= $this->lang->line('single_fin'); ?></a></td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">16.30</td>
                            <td>ULUWATU TOUR</td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">16.30</td>
                            <td><?= $this->lang->line('hotel_drop'); ?></td>
                            <td><?= $this->lang->line('dinner'); ?></td>
                        </tr>
                        <tr>
                            <th rowspan="8" class="text-center"><?= $this->lang->line('day'); ?> 3 UBUD TOUR</th>
                            <td class="text-center">09.00</td>
                            <td><a href="<?= base_url('user/ubudMonkeyForest'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/ubud-monkey-forest.jpg'); ?>" data-title="UBUD MONKEY FOREST" data-text="<?= $this->lang->line('data_text_ubud_monkey_forest'); ?>">UBUD MONKEY FOREST</a></td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">12.00</td>
                            <td><?= $this->lang->line('restaurant'); ?></td>
                            <td><?= $this->lang->line('lunch'); ?> UBUD</td>
                        </tr>
                        <tr>
                            <td rowspan="3" class="text-center">13.20</td>
                            <td><a href="<?= base_url('user/ubudPalace'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/ubud-palace.jpg'); ?>" data-title="UBUD PALACE" data-text="<?= $this->lang->line('data_text_ubud_palace'); ?>">UBUD PALACE</a></td>
                            <td rowspan="3"><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td><a href="<?= base_url('user/saraswatiTemple'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/incheon-airport.jpg'); ?>" data-title="SARASWATI TEMPLE" data-text="<?= $this->lang->line('data_text_saraswati_temple'); ?>">SARASWATI TEMPLE</a></td>
                        </tr>
                        <tr>
                            <td><a href="<?= base_url('user/ubudMarket'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/ubud-art-market.jpg'); ?>" data-title="UBUD MARKET" data-text="<?= $this->lang->line('data_text_ubud_market'); ?>">UBUD MARKET</a></td>
                        </tr>
                        <tr>
                            <td class="text-center">15.30</td>
                            <td><a href="<?= base_url('user/tegalalangRiceTerrace'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/tegalalang-rice.jpg'); ?>" data-title="TEGALALANG RICE TERRACE" data-text="<?= $this->lang->line('data_text_tegalalang_rice_terace'); ?>">TEGALALANG RICE TERRACE</a></td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">16.30</td>
                            <td><a href="<?= base_url('user/tegenunganWaterfall'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/incheon-airport.jpg'); ?>" data-title="TEGENUNGAN WATERFALL" data-text="<?= $this->lang->line('data_text_tegenung_waterfall'); ?>">TEGENUNGAN WATERFALL</a></td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">19.00</td>
                            <td><?= $this->lang->line('hotel_drop'); ?></td>
                            <td><?= $this->lang->line('dinner'); ?></td>
                        </tr>
                        <tr>
                            <th rowspan="6" class="text-center"><?= $this->lang->line('day'); ?> 4 SEMINYAK TOUR</th>
                            <td class="text-center">12.30</td>
                            <td><?= $this->lang->line('restaurant'); ?></td>
                            <td><?= $this->lang->line('lunch'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">14.00</td>
                            <td><a href="<?= base_url('user/bajraSandhi'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/incheon-airport.jpg'); ?>" data-title="BAJRA SANDHI" data-text="<?= $this->lang->line('data_text_bajra_sandhi'); ?>">BAJRA SANDHI</a></td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">15.30</td>
                            <td><a href="<?= base_url('user/kutaCity'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/incheon-airport.jpg'); ?>" data-title="KUTA CITY TOUR" data-text="">KUTA CITY TOUR</a></td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">18.00</td>
                            <td><?= $this->lang->line('restaurant'); ?></td>
                            <td><?= $this->lang->line('dinner'); ?></td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="text-center">19.00</td>
                            <td>SEMINYAK TOUR</td>
                            <td><?= $this->lang->line('massage'); ?></td>
                        </tr>
                        <tr>
                            <td><a href="<?= base_url('user/ngurahRaiAirport'); ?>" onmouseover=" showLinkPreview()" onmouseleave="hideLinkPreview()" class="link-with-preview text-dark pt-2" data-image="<?= base_url('assets/photo/tour/incheon-airport.jpg'); ?>" data-title="NGURAH RAI AIRPORT" data-text="<?= $this->lang->line('data_text_ngurah_rai_airport'); ?>">NGURAH RAI AIRPORT</a></td>
                            <td><?= $this->lang->line('check_out'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="my-4 mx-auto w-50">
        <a href="<?= base_url() . 'user/tour/4' ?>" class="btn btn-bonus btn-block font-italic"><?= $this->lang->line('buy'); ?></a>
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