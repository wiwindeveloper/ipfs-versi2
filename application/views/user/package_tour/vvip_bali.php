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
                <p class="font-italic text-center mb-0 text-uppercase" style="color:#44c2cb; font-size:40px; font-weight:800; margin-top:-75px;   text-shadow: 4px 3px 10px black;"><?= $this->lang->line('vip_tour_intinerary'); ?></p>
                <p class="text-center text-white mb-1 text-uppercase" style="font-size:24px; font-weight:800;">VIP <?= $this->lang->line('vvip_bali_title'); ?> + NYEPI</p>
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
                            <th rowspan="9" class="text-center"><?= $this->lang->line('day'); ?> 2 JIMBARAN TOUR</th>
                            <td class="text-center">09.30</td>
                            <td>ULUWATU TOUR</td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">12.00</td>
                            <td><?= $this->lang->line('restaurant'); ?></td>
                            <td><?= $this->lang->line('lunch'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">13.00</td>
                            <td><?= $this->lang->line('single_fin'); ?></td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">14.00</td>
                            <td>PADANG-PADANG BEACH</td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">15.30</td>
                            <td><?= $this->lang->line('join_ogoh_festival'); ?></td>
                            <td><?= $this->lang->line('festival'); ?></td>
                        </tr>
                        <tr>
                            <td rowspan="3" class="text-center">16.00</td>
                            <td>OGOH-OGOH FESTIVAL</td>
                            <td rowspan="3"><?= $this->lang->line('free_time'); ?></td>
                        </tr>
                        <tr>
                            <td><?= $this->lang->line('dinner'); ?> INDONESIA</td>
                        </tr>
                        <tr>
                            <td><?= $this->lang->line('seafood_dinner'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">21.00</td>
                            <td><?= $this->lang->line('hotel'); ?></td>
                            <td><?= $this->lang->line('rest'); ?></td>
                        </tr>
                        <tr>
                            <th class="text-center"><?= $this->lang->line('day'); ?> 3</th>
                            <td></td>
                            <td><?= $this->lang->line('all_activities_hotel'); ?></td>
                            <td>NYEPI DAY</td>
                        </tr>
                        <tr>
                            <th rowspan="4" class="text-center">DAY 4 KUTA TOUR</th>
                            <td class="text-center">12.00</td>
                            <td><?= $this->lang->line('restaurant'); ?></td>
                            <td><?= $this->lang->line('lunch'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">13.30</td>
                            <td>KUTA CITY TOUR</td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">16.00</td>
                            <td>SEMINYAK TOUR</td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">17.30</td>
                            <td><?= $this->lang->line('hotel'); ?></td>
                            <td><?= $this->lang->line('hip_hop_performance'); ?></td>
                        </tr>
                        <tr>
                            <th rowspan="8" class="text-center"><?= $this->lang->line('day'); ?> 5</th>
                            <td class="text-center">09.00</td>
                            <td>UBUD MONKEY FOREST</td>
                            <td><?= $this->lang->line('tour'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">12.00</td>
                            <td><?= $this->lang->line('restaurant'); ?></td>
                            <td><?= $this->lang->line('lunch'); ?></td>
                        </tr>
                        <tr>
                            <td rowspan="3" class="text-center">13.20</td>
                            <td>UBUD PALACE</td>
                            <td rowspan="3"><?= $this->lang->line('free_tour'); ?></td>
                        </tr>
                        <tr>
                            <td>SARASWATI TEMPLE</td>
                        </tr>
                        <tr>
                            <td>UBUD MARKET</td>
                        </tr>
                        <tr>
                            <td class="text-center">15.30</td>
                            <td><?= $this->lang->line('hotel'); ?></td>
                            <td><?= $this->lang->line('check_out'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">18.30</td>
                            <td><?= $this->lang->line('hotel'); ?></td>
                            <td>ZPOP & <?= $this->lang->line('dinner'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">22.00</td>
                            <td>NGURAH RAI AIRPORT</td>
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