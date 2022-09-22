<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase">
    <?= $this->lang->line('marketing_plan');?>
    </h1>

    <div class="bg-custom p-5 mb-4">
        <div class="row">
            <div class="col-md-10 mx-auto justify-content-center text-justify">
                <div class="marketing-plan mt-4 text-white" style="font-size: 17px;">
                    <table border="1" cellpadding="4" cellspacing="4" width="100%">
                        <tr class="text-center">
                            <th><?= $this->lang->line('level');?></th>
                            <th><?= $this->lang->line('requirements');?></th>
                        </tr>
                        <tr>
                            <td class="text-center">FM</td>
                            <td><?= $this->lang->line('td_fm');?></td>
                        </tr>
                        <tr>
                            <td class="text-center">FM1</td>
                            <td><?= $this->lang->line('td_fm1'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">FM2</td>
                            <td><?= $this->lang->line('td_fm2'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">FM3</td>
                            <td><?= $this->lang->line('td_fm3'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">FM4</td>
                            <td><?= $this->lang->line('td_fm4'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">FM5</td>
                            <td><?= $this->lang->line('td_fm5'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">FM6</td>
                            <td><?= $this->lang->line('td_fm6'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">FM7</td>
                            <td><?= $this->lang->line('td_fm7'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">FM8</td>
                            <td><?= $this->lang->line('td_fm8'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">FM9</td>
                            <td><?= $this->lang->line('td_fm9'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">FM10</td>
                            <td><?= $this->lang->line('td_fm10'); ?></td>
                        </tr>
                    </table>
                </div>
                <div class=" marketing-plan mt-4" style="font-size: 17px;">
                    <h2 class="title-text"><?= $this->lang->line('sponsor_bonus'); ?></h2>
                    <p class="p-mplan"><?= $this->lang->line('bonus_sponsor_1'); ?></p>
                    <p class="space-height p-mplan"><?= $this->lang->line('bonus_calculation_as_follows'); ?></p>
                    <ul style="margin-left:0 !important;">
                        <li class="li-mplan">1,3,9 <?= $this->lang->line('box'); ?> = 5 % ( 2.5 % USDT & 2.5 KRP )</li>
                        <li class="li-mplan">15,30,60 <?= $this->lang->line('box'); ?> = 6 % ( 3 % USDT & 3 % KRP )</li>
                        <li class="li-mplan">120,300,540 <?= $this->lang->line('box'); ?> = 7 % ( 3.5 % USDT & 3.5 % KRP )</li>
                    </ul>
                    <div class="image-bonus-marketingplan my-4">
                        <img class="bonus_sponsor" src="<?= base_url('assets/img/' . $this->lang->line('img_bonus_sponsor')); ?>">
                    </div>
                    <p class="p-mplan"><?= $this->lang->line('bonus_sponsor_6'); ?></p>
                </div>
                <div class="marketing-plan mt-5" style="font-size: 17px;">
                    <h2 class="title-text"><?= $this->lang->line('sponsor_matching_title'); ?></h2>
                    <p class="p-mplan"><?= $this->lang->line('sponsor_matching_1'); ?></p>
                    <div class="image-bonus-marketingplan my-4">
                        <img src="<?= base_url('assets/img/' . $this->lang->line('img_sponsor_matching')); ?>">
                    </div>
                    <p class="p-mplan"><?= $this->lang->line('sponsor_matching_2'); ?></p>
                    <p class="space-height p-mplan"><?= $this->lang->line('bonus_calculation_as_follows'); ?></p>
                    <ul style="margin-left:0 !important;">
                        <li class="li-mplan">1,3,9 <?= $this->lang->line('box'); ?> = 50 % ( 25 % USDT & 25 % KRP )</li>
                        <li class="li-mplan">15,30,60 <?= $this->lang->line('box'); ?> = 35 % ( 17.5 % USDT & 17.5 % KRP )</li>
                        <li class="li-mplan">120,300,540 <?= $this->lang->line('box'); ?> = 20 % ( 10 % USDT & 10 % KRP )</li>
                    </ul>
                </div>
                <div class="marketing-plan mt-5" style="font-size: 17px;">
                    <h2 class="title-text"><?= $this->lang->line('recommended_mining_title'); ?></h2>
                    <p class="p-mplan"><?= $this->lang->line('recommended_mining_1'); ?></p>
                    <p class="space-height p-mplan"><?= $this->lang->line('bonus_calculation_as_follows'); ?></p>
                    <ul style="margin-left:0 !important;">
                        <li class="li-mplan">1, 2, 3 <?= $this->lang->line('direct_sponsors'); ?> = A (3%)</li>
                        <li class="li-mplan">4, 5, 6 <?= $this->lang->line('direct_sponsors'); ?> = B (4%)</li>
                        <li class="li-mplan">7, <?= $this->lang->line('until_next_direct_sponsors'); ?> = C (5%)</li>
                    </ul>
                    <div class="image-bonus-marketingplan my-4">
                        <img src="<?= base_url('assets/img/' . $this->lang->line('img_recommended_mining')); ?>">
                    </div>
                    <p class="p-mplan"><?= $this->lang->line('recommended_mining_6'); ?></p>
                </div>
                <div class="marketing-plan mt-5" style="font-size: 17px;">
                    <h2 class="title-text"><?= $this->lang->line('mining_generasi_title'); ?></h2>
                    <p class="p-mplan"><?= $this->lang->line('mining_generasi_1'); ?></p>
                    <p class="space-height p-mplan"><?= $this->lang->line('bonus_calculation_as_follows'); ?></p>
                    <ul id="list-triple" style="margin-left:0 !important;">
                        <li class="li-mplan">G2 = 20% (FM)</li>
                        <li class="li-mplan">G3 = 15% (FM1)</li>
                        <li class="li-mplan">G4 = 10% (FM2)</li>
                        <li class="li-mplan">G5 = 5% (FM2)</li>
                        <li class="li-mplan">G6 = 5% (FM3)</li>
                        <li class="li-mplan">G7 = 10% (FM3)</li>
                        <li class="li-mplan">G8 = 15% (FM4)</li>
                        <li class="li-mplan">G9 = 20% (FM4)</li>
                        <li class="li-mplan">G10 = 20% (FM5)</li>
                        <li class="li-mplan">G11 = 15% (FM5)</li>
                        <li class="li-mplan">G12 = 10% (FM6)</li>
                        <li class="li-mplan">G13-15 = 5% (FM7)</li>
                        <li class="li-mplan">G16-20 = 3% (FM8)</li>
                        <li class="li-mplan">G21-30 = 2% (FM9)</li>
                        <li class="li-mplan">G31-50 = 1% (FM10)</li>
                    </ul>
                    <div class="image-bonus-marketingplan my-5 ">
                        <img src="<?= base_url('assets/img/' . $this->lang->line('img_mining_generasi')); ?>">
                    </div>
                    <p class="p-mplan"><?= $this->lang->line('mining_generasi_3'); ?></p>
                </div>
                <div class="marketing-plan mt-5" style="font-size: 17px;">
                    <h2 class="title-text"><?= $this->lang->line('pairing_mining_title'); ?></h2>
                    <p class="p-mplan"><?= $this->lang->line('pairing_mining_1'); ?></p>
                    <p class="space-height p-mplan"><?= $this->lang->line('pairing_mining_2'); ?></p>
                    <ul>
                        <li class="li-mplan">4:4 = 1 <?= $this->lang->line('set_box'); ?> (0,5 USDT)</li>
                        <li class="li-mplan">8:8 = 2 <?= $this->lang->line('set_boxes'); ?> (0,5 + 05 USDT)</li>
                    </ul>
                    <p class="space-height p-mplan"><?= $this->lang->line('pairing_mining_6'); ?></p>
                    <ul>
                        <li class="li-mplan">FM = 2 Set / 1 USDT</li>
                        <li class="li-mplan">FM1 = 6 set / 3 USDT</li>
                        <li class="li-mplan">FM2 = 10 set / 5 USDT</li>
                        <li class="li-mplan">FM3 = 14 set / 7 USDT</li>
                        <li class="li-mplan">FM4 = 20 set / 10 USDT</li>
                        <li class="li-mplan">FM5 = 30 set / 15 USDT</li>
                        <li class="li-mplan">FM6 = 40 set / 20 USDT</li>
                        <li class="li-mplan">FM7 = 50 set / 25 USDT</li>
                        <li class="li-mplan">FM8 = 100 set / 50 USDT</li>
                        <li class="li-mplan">FM9 = 140 set / 70 USDT</li>
                        <li class="li-mplan">FM10 = 200 set / 100 USDT</li>
                    </ul>
                    <div class="image-bonus-marketingplan my-4">
                        <img src="<?= base_url('assets/img/' . $this->lang->line('img_pairing_mining')); ?>">
                    </div>
                    <p class="p-mplan"><?= $this->lang->line('pairing_mining_5'); ?></p>
                </div>
                <div class="marketing-plan mt-5" style="font-size: 17px;">
                    <h2 class="title-text"><?= $this->lang->line('pairing_matching_title'); ?></h2>
                    <p class="p-mplan"><?= $this->lang->line('pairing_matching_1'); ?></p>
                    <p class="space-height p-mplan"><?= $this->lang->line('pairing_matching_2'); ?></p>
                    <ul id="list-triple" style="margin-left:0 !important;">
                        <li class="li-mplan">G2 = 20% (FM)</li>
                        <li class="li-mplan">G3 = 15% (FM1)</li>
                        <li class="li-mplan">G4 = 10% (FM2)</li>
                        <li class="li-mplan">G5 = 5% (FM2)</li>
                        <li class="li-mplan">G6 = 5% (FM3)</li>
                        <li class="li-mplan">G7 = 10% (FM3)</li>
                        <li class="li-mplan">G8 = 15% (FM4)</li>
                        <li class="li-mplan">G9 = 20% (FM4)</li>
                        <li class="li-mplan">G10 = 20% (FM5)</li>
                        <li class="li-mplan">G11 = 15% (FM5)</li>
                        <li class="li-mplan">G12 = 10% (FM6)</li>
                        <li class="li-mplan">G13-15 = 5% (FM7)</li>
                        <li class="li-mplan">G16-20 = 3% (FM8)</li>
                        <li class="li-mplan">G21-30 = 2% (FM9)</li>
                        <li class="li-mplan">G31-50 = 1% (FM10)</li>
                    </ul>
                    <div class="image-bonus-marketingplan my-5">
                        <img src="<?= base_url('assets/img/' . $this->lang->line('img_pairing_matching')); ?>">
                    </div>
                    <p class="p-mplan"><?= $this->lang->line('pairing_matching_3'); ?></p>
                </div>
                <div class="marketing-plan mt-5" style="font-size: 17px;">
                    <h2 class="title-text"><?= $this->lang->line('bonus_global_title'); ?></h2>
                    <p class="p-mplan"><?= $this->lang->line('bonus_global_1'); ?></p>
                    <p class="space-height p-mplan"><?= $this->lang->line('bonus_global_2'); ?></p>
                    <ul style="margin-left:0 !important;">
                        <li class="li-mplan">FM4 = 2%</li>
                        <li class="li-mplan">FM5 = 1%</li>
                        <li class="li-mplan">FM6 = 0.5%</li>
                        <li class="li-mplan">FM7 = 0.4%</li>
                        <li class="li-mplan">FM8 = 0.3%</li>
                        <li class="li-mplan">FM9 = 0.2%</li>
                        <li class="li-mplan">FM10 = 0.1%</li>
                    </ul>
                    <div class="image-bonus-marketingplan my-4 mx-auto">
                        <img src="<?= base_url('assets/img/' . $this->lang->line('img_bonus_global')); ?>">
                    </div>
                    <p class="p-mplan"><?= $this->lang->line('bonus_global_3'); ?></p>
                </div>
                <div class="marketing-plan my-5" style="font-size: 17px;">
                    <h2 class="title-text"><?= $this->lang->line('bonus_basecamp_title'); ?></h2>
                    <p class="p-mplan"><?= $this->lang->line('bonus_basecamp_1'); ?></p>
                    <p class="space-height p-mplan"><?= $this->lang->line('bonus_calculation_as_follows'); ?></p>
                    <ul>
                        <li class="li-mplan">FM 5 = 2% BS <?= $this->lang->line('reward'); ?> USDT</li>
                        <li class="li-mplan">FM 6 = 2.5% BS <?= $this->lang->line('reward'); ?> USDT</li>
                        <li class="li-mplan">FM 7 = 3% BS <?= $this->lang->line('reward'); ?> USDT</li>
                        <li class="li-mplan">FM 8 = 3.5% BS <?= $this->lang->line('reward'); ?> USDT</li>
                    </ul>
                    <div class="image-bonus-marketingplan my-4">
                        <img src="<?= base_url('assets/img/' . $this->lang->line('img_bonus_basecamp')); ?>">
                    </div>
                    <p class="p-mplan"><?= $this->lang->line('bonus_basecamp_3'); ?></p>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->