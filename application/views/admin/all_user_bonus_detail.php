<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb text-white mb-4">
        All User Bonus Detail
    </h1>


    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3 tableFixHead" style="overflow-x:auto;">
                <table class="table table-bordered" id="tabledetail" cellspacing="4" cellpadding="4">
                    <thead>
                        <tr class="head">
                            <th rowspan="2" class="align-middle text-center date">Code User</th>
                            <th rowspan="2" class="align-middle text-center id">ID</th>
                            <th rowspan="2" class="align-middle text-center">Package</th>
                            <th rowspan="2" class="align-middle text-center">Daily Airdrop ZENX</th>
                            <th rowspan="2" class="align-middle text-center">Daily Mining FIL</th>
                            <th rowspan="2" class="align-middle text-center">Daily Airdrop MTM</th>
                            <th colspan="2" class="align-middle text-center">Sponsor</th>
                            <th colspan="2" class="align-middle text-center">Sponsor Matching</th>
                            <th colspan="3" class="align-middle text-center">Recommended Mining</th>
                            <th rowspan="2" class="align-middle text-center">Mining Generasi</th>
                            <th rowspan="2" class="align-middle text-center">Pairing</th>
                            <th rowspan="2" class="align-middle text-center">Pairing Matching</th>
                            <th rowspan="2" class="align-middle text-center">Global</th>
                            <th rowspan="2" class="align-middle text-center">Basecamp</th>
                        </tr>
                        <tr class="subhead">
                            <th>FIL</th>
                            <th>MTM</th>
                            <th>FIL</th>
                            <th>MTM</th>
                            <th>Team A</th>
                            <th>Team B</th>
                            <th>Team C</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($bonus as $row) : ?>
                            <tr>
                                <td class="date"><?= $row->id; ?></td>
                                <td class="id"><a style="color:#858796;" href="<?= base_url('admin/detailUserBonus/' . $row->id) ?>"><?= $row->username; ?></a></td>
                                <td><?= $row->name == null ? '0' : $row->name; ?> BOX</td>
                                <td><?= 0; ?></td>
                                <td><?= empty($row->mining_fil) ? 0 : number_format($row->mining_fil, 10)." FIL"; ?> </td>
                                <td><?= empty($row->airdrop_mtm) ? 0 : number_format($row->airdrop_mtm, 10). " MTM"; ?> </td>
                                <td><?= empty($row->sponsorfil) ? 0 : number_format($row->sponsorfil, 10). " FIL"; ?> </td>
                                <td><?= empty($row->sponsormtm) ? 0 : number_format($row->sponsormtm, 10). " MTM"; ?> </td>
                                <td><?= empty($row->sponmatchingfil) ? 0 : number_format($row->sponmatchingfil, 10). " FIL"; ?> </td>
                                <td><?= empty($row->sponmatchingmtm) ? 0 : number_format($row->sponmatchingmtm, 10). " MTM"; ?> </td>
                                <td><?= empty($row->minmatchingA) ? 0 : number_format($row->minmatchingA, 10). " FIL"; ?> </td>
                                <td><?= empty($row->minmatchingB) ? 0 : number_format($row->minmatchingB, 10). " FIL"; ?> </td>
                                <td><?= empty($row->minmatchingC) ? 0 : number_format($row->minmatchingC, 10). " FIL"; ?> </td>
                                <td><?= empty($row->minpairing) ? 0 : number_format($row->minpairing, 10). " FIL"; ?> </td>
                                <td><?= empty($row->pairingmatch) ? 0 : number_format($row->pairingmatch, 10). " MTM"; ?> </td>
                                <td><?= empty($row->binarymatch) ? 0 : number_format($row->binarymatch, 10). " MTM"; ?></td>
                                <td><?= empty($row->bonusglobal) ? 0 : number_format($row->bonusglobal, 10). " MTM"; ?></td>
                                <td><?= empty($row->basecampmtm) ? 0 : number_format($row->basecampmtm, 10). " MTM"; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->