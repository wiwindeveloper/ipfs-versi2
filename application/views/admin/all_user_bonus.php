<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb text-white mb-4">
        All User Bonus
    </h1>


    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <div class="row">
                <div class="col-lg-6">
                    <h5>Total Bonus</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="border p-4 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered" style="width:max-content" cellspacing="4" cellpadding="4">
                            <tr>
                                <th class="align-middle text-center">Package</th>
                                <th class="align-middle text-center">Total Airdrop ZENX</th>
                                <th class="align-middle text-center">Total Mining FIL</th>
                                <th class="align-middle text-center">Total Airdrop MTM</th>
                                <th colspan="2" class="align-middle text-center">Total Sponsor</th>
                                <th colspan="2" class="align-middle text-center">Total Sponsor Matching</th>
                                <th colspan="3" class="align-middle text-center">Total Recommended Mining</th>
                                <th class="align-middle text-center">Total Mining Generasi</th>
                                <th class="align-middle text-center">Total Pairing</th>
                                <th class="align-middle text-center">Total Pairing Matching</th>
                                <th class="align-middle text-center">Total Global</th>
                                <th class="align-middle text-center">Total Basecamp</th>
                            </tr>
                            <tr>
                                <td><?= $total['name'] == null ? '0' : $total['name']; ?> BOX</td>
                                <td><?= number_format(0, 10); ?> ZENX</td>
                                <td><?= number_format($total['mining_fil'], 10); ?> FIL</td>
                                <td><?= number_format($total['airdrop_mtm'], 10); ?> MTM</td>
                                <td><?= number_format($total['sponsorfil'], 10); ?> FIL</td>
                                <td><?= number_format($total['sponsormtm'], 10); ?> MTM</td>
                                <td><?= number_format($total['sponmatchingfil'], 10); ?> FIL</td>
                                <td><?= number_format($total['sponmatchingmtm'], 10); ?> MTM</td>
                                <td><?= number_format($total['minmatchingA'], 10); ?> FIL (Team A)</td>
                                <td><?= number_format($total['minmatchingB'], 10); ?> FIL (Team B)</td>
                                <td><?= number_format($total['minmatchingC'], 10); ?> FIL (Team C)</td>
                                <td><?= number_format($total['minpairing'], 10); ?> FIL</td>
                                <td><?= number_format($total['pairingmatch'], 10); ?> MTM</td>
                                <td><?= number_format($total['binarymatch'], 10); ?> MTM</td>
                                <td><?= number_format($total['bonusglobal'], 10); ?> MTM</td>
                                <td><?= number_format($total['basecampmtm'], 10); ?> MTM</td>
                            </tr>
                        </table>
                </div>
            </div>  
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <div class="row">
                <div class="col-lg-6">
                    <h5>Bonus by Month</h5>
                    Date: <input type="text" id="datepicker" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="border p-4 mb-4">
                <div class="table-responsive mt-3 tableFixHead" id="showBonus">
                    <table class="table table-bordered" cellspacing="4" cellpadding="4">
                        <thead>
                            <tr class="head">
                                <th class="align-middle text-center date" rowspan="2">Date</th>
                                <th class="align-middle text-center" rowspan="2">Airdrop ZENX</th>
                                <th class="align-middle text-center" rowspan="2">Mining FIL</th>
                                <th class="align-middle text-center" rowspan="2">Airdrop MTM</th>
                                <th colspan="2" class="align-middle text-center">Sponsor</th>
                                <th colspan="2" class="align-middle text-center">Sponsor Matching</th>
                                <th colspan="3" class="align-middle text-center">Recommended Mining</th>
                                <th class="align-middle text-center" rowspan="2">Mining Generasi</th>
                                <th class="align-middle text-center" rowspan="2">Pairing</th>
                                <th class="align-middle text-center" rowspan="2">Pairing Matching</th>
                                <th class="align-middle text-center" rowspan="2">Global</th>
                                <th class="align-middle text-center" rowspan="2">Basecamp</th>
                            </tr>
                            <tr class="subhead">
                                <th>Filecoin</th>
                                <th>MTM</th>
                                <th>Filecoin</th>
                                <th>MTM</th>
                                <th>TEAM A</th>
                                <th>TEAM B</th>
                                <th>TEAM C</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                $total_miningfil = 0;
                                $total_airdrop_mtm = 0;
                                $total_sponsor_fil = 0;
                                $total_sponsor_mtm = 0;
                                $total_sponsor_matching_fil = 0;
                                $total_sponsor_matching_mtm = 0;
                                $total_recomm_mining_a = 0;
                                $total_recomm_mining_b = 0;
                                $total_recomm_mining_c = 0;
                                $total_mining_generation = 0;
                                $total_pairing = 0;
                                $total_pairing_match = 0;
                                $total_global = 0;
                                $total_basecamp = 0;

                                foreach ($date as $dt) 
                                {
                                    $showDate           = $dt->format("Y-m-d");
                                    $minningfil         = $adminClass->totalMiningFil($showDate);
                                    $airdrop_mtm        = $adminClass->totalAirdropMtm($showDate);
                                    $sponsor            = $adminClass->totalSponsor($showDate);
                                    $sponsor_matching   = $adminClass->totalSponsorMatching($showDate);
                                    $recomm_mining_a    = $adminClass->totalRecommendedMining($showDate, 'A');
                                    $recomm_mining_b    = $adminClass->totalRecommendedMining($showDate, 'B');
                                    $recomm_mining_c    = $adminClass->totalRecommendedMining($showDate, 'C');
                                    $mining_generation  = $adminClass->totalMiningGeneration($showDate);
                                    $pairing            = $adminClass->totalPairing($showDate);
                                    $pairing_match      = $adminClass->totalPairingMatching($showDate);
                                    $global             = $adminClass->totalGlobalBonus($showDate);
                                    $basecamp           = $adminClass->totalBasecampBonus($showDate);
                            ?>
                            <tr>
                                <td class="date">
                                    <a href="<?= base_url('admin/allUserBonus/').$showDate; ?>">
                                        <?= $showDate; ?>
                                    </a>
                                </td>
                                <td>0</td>
                                <td><?= empty($minningfil) ? 0 : number_format($minningfil, 10)." FIL"; ?></td>
                                <td><?= empty($airdrop_mtm) ? 0 : number_format($airdrop_mtm, 10)." MTM"; ?></td>
                                <?php
                                foreach($sponsor as $row_spon)
                                {
                                    ?>
                                        <td><?= empty($row_spon->filecoin) ? 0 : number_format($row_spon->filecoin, 10)." FIL"; ?></td>
                                        <td><?= empty($row_spon->mtm) ? 0 : number_format($row_spon->mtm, 10)." MTM";?></td>
                                    <?php
                                }
                                ?>
                                <?php
                                foreach($sponsor_matching as $row_sponmatch)
                                {
                                    ?>
                                        <td><?= empty($row_sponmatch->filecoin) ? 0 : number_format($row_sponmatch->filecoin, 10)." FIL"; ?></td>
                                        <td><?= empty($row_sponmatch->mtm) ? 0 : number_format($row_sponmatch->mtm, 10)." MTM"; ?></td>
                                    <?php
                                }
                                ?>
                                <td><?= empty($recomm_mining_a) ? 0 : number_format($recomm_mining_a, 10)." FIL";?></td>
                                <td><?= empty($recomm_mining_b) ? 0 : number_format($recomm_mining_b, 10)." FIL";?></td>
                                <td><?= empty($recomm_mining_c) ? 0 : number_format($recomm_mining_c, 10)." FIL";?></td>
                                <td><?= empty($mining_generation) ? 0 : number_format($mining_generation, 10) ." MTM";?></td>
                                <td><?= empty($pairing) ? 0 : number_format($pairing, 10)." MTM";?></td>
                                <td><?= empty($pairing_match) ? 0 : number_format($pairing_match, 10)." MTM";?></td>
                                <td><?= empty($global) ? 0 : number_format($global, 10)." MTM";?></td>
                                <td><?= empty($basecamp) ? 0 : number_format($basecamp, 10)." MTM";?></td>
                            </tr>
                            <?php
                                    $total_miningfil = $total_miningfil + $minningfil;
                                    $total_airdrop_mtm = $total_airdrop_mtm + $airdrop_mtm;
                                    $total_sponsor_fil = $total_sponsor_fil + $row_spon->filecoin;
                                    $total_sponsor_mtm = $total_sponsor_mtm + $row_spon->mtm;
                                    $total_sponsor_matching_fil = $row_sponmatch->filecoin + $total_sponsor_matching_fil;
                                    $total_sponsor_matching_mtm = $total_sponsor_matching_mtm + $row_sponmatch->mtm;
                                    $total_recomm_mining_a = $total_recomm_mining_a + $recomm_mining_a;
                                    $total_recomm_mining_b = $total_recomm_mining_b + $recomm_mining_b;
                                    $total_recomm_mining_c = $total_recomm_mining_c + $recomm_mining_c;
                                    $total_mining_generation = $total_mining_generation + $mining_generation;
                                    $total_pairing = $total_pairing + $pairing;
                                    $total_pairing_match = $total_pairing_match + $pairing_match;
                                    $total_global = $total_global + $global;
                                    $total_basecamp = $total_basecamp + $basecamp;
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="total">Total</th>
                                <th>0</th>
                                <th><?= $total_miningfil == 0 ? '0'  : number_format($total_miningfil, 10)." FIL"; ?></th>
                                <th><?= $total_airdrop_mtm == 0 ? '0' : number_format($total_airdrop_mtm, 10)." MTM"; ?></th>
                                <th><?= $total_sponsor_fil == 0 ? '0' : number_format($total_sponsor_fil, 10)." FIL"; ?></th>
                                <th><?= $total_sponsor_mtm == 0 ? '0' : number_format($total_sponsor_mtm, 10)." MTM"; ?></th>
                                <th><?= $total_sponsor_matching_fil == 0 ? '0' : number_format($total_sponsor_matching_fil, 10)." FIL"; ?></th>
                                <th><?= $total_sponsor_matching_mtm == 0 ? '0' : number_format($total_sponsor_matching_mtm, 10)." MTM"; ?></th>
                                <th><?= $total_recomm_mining_a == 0 ? '0' : number_format($total_recomm_mining_a, 10)." FIL"; ?></th>
                                <th><?= $total_recomm_mining_b == 0 ? '0' : number_format($total_recomm_mining_b, 10)." FIL"; ?></th>
                                <th><?= $total_recomm_mining_c == 0 ? '0' : number_format($total_recomm_mining_c, 10)." FIL"; ?></th>
                                <th><?= $total_mining_generation == 0 ? '0' : number_format($total_mining_generation, 10)." MTM"; ?></th>
                                <th><?= $total_pairing == 0 ? '0' : number_format($total_pairing, 10)." MTM"; ?></th>
                                <th><?= $total_pairing_match == 0 ? '0' : number_format($total_pairing_match, 10)." MTM"; ?></th>
                                <th><?= $total_global == 0 ? '0' : number_format($total_global, 10)." MTM"; ?></th>
                                <th><?= $total_basecamp == 0 ? '0' : number_format($total_basecamp, 10)." MTM"; ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->