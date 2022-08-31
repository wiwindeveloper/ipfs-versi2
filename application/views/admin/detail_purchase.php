<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">Bonus Global Detail</h1>

    <?= $this->session->flashdata('message'); ?>
    <?php 
        $explodeDate = explode('-', $date);
        $year = $explodeDate[0];

        $query_total = $controller->omsetGlobalPerMonth($date);
        $omset_fil = $query_total['total_fil'] + ($query_total['total_mtm'] / 4) + ($query_total['total_zenx'] / 12); 
        
        if($fm4 != 0)
        {
            $bonus_fm4  = ((($omset_fil * 2)/100)*4)/$fm4;
        }
        else
        {
            $bonus_fm4 = 0;
        }
        
        if($fm5 != 0)
        {
            $bonus_fm5  = ((($omset_fil * 1)/100)*4)/$fm5;
        }
        else
        {
            $bonus_fm5 = 0;
        }
        
        if($fm6 != 0)
        {
            $bonus_fm6  = ((($omset_fil * 0.5)/100)*4)/$fm6;
        }
        else
        {
            $bonus_fm6 = 0;
        }
        
        if($fm7 != 0)
        {
            $bonus_fm7  = ((($omset_fil * 0.4)/100)*4)/$fm7;
        }
        else
        {
            $bonus_fm7 = 0;
        }
        
        if($fm8 != 0)
        {
            $bonus_fm8  = ((($omset_fil * 0.3)/100)*4)/$fm8;

        }
        else
        {
            $bonus_fm8 = 0;
        }
        
        if($fm9 != 0)
        {
            $bonus_fm9  = ((($omset_fil * 0.2)/100)*4)/$fm9;
        }
        else
        {
            $bonus_fm9 = 0;
        }

        if($fm10 != 0)
        {
            $bonus_fm10 = ((($omset_fil * 0.1)/100)*4)/$fm10;
        }
        else
        {
            $bonus_fm10 = 0;
        }
    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Total Level <?= $monthName." ".$year; ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-nowrap tb-global-detail" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-right head">Total omset:</th>
                            <th class="text-right head"><?= $query_total['total_box'] . ' BOX'; ?></th>
                            <th class="text-right head"><?= ($omset_fil) . ' FIL'; ?></th>
                            <th class="text-right head"><?= ($omset_fil * 4) . ' MTM'; ?></th>
                        </tr>
                        <tr>
                            <th colspan="5"></th>
                        </tr>
                        <tr>
                            <th class="subhead">Level:</th>
                            <th class="head">FM 4 <span class="float-right">2%</span></th>
                            <th class="head">FM 5 <span class="float-right">1%</span></th>
                            <th class="head">FM 6 <span class="float-right">0,5%</span></th>
                            <th class="head">FM 7 <span class="float-right">0,4%</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="subhead">Amount:</th>
                            <td>
                                <a href="<?= base_url('admin/detailLevelPerMonth/FM4/').$date;?>">
                                    <?= $fm4 ?? 0; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/detailLevelPerMonth/FM5/').$date;?>">
                                    <?= $fm5 ?? 0; ?></td>
                                </a>
                            <td>
                                <a href="<?= base_url('admin/detailLevelPerMonth/FM6/').$date;?>">
                                    <?= $fm6 ?? 0; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/detailLevelPerMonth/FM7/').$date;?>">
                                    <?= $fm7 ?? 0; ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th class="subhead">Bonus:</th>
                            <td><?= !empty($bonus_fm4) ? $bonus_fm4." MTM" : '0'; ?></td>
                            <td><?= !empty($bonus_fm5) ? $bonus_fm5. " MTM" : '0'; ?></td>
                            <td><?= !empty($bonus_fm6) ? $bonus_fm6. " MTM" : '0'; ?></td>
                            <td><?= !empty($bonus_fm7) ? $bonus_fm7. " MTM" : '0'; ?></td>
                        </tr>
                        <tr>
                            <th colspan="5"></th>
                        </tr>
                        <tr>
                            <th class="subhead">Level:</th>
                            <th class="head">FM 8 <span class="float-right">0,3%</span></th>
                            <th class="head">FM 9 <span class="float-right">0,2%</span></th>
                            <th class="head">FM 10 <span class="float-right">0,1%</span></th>
                        </tr>
                        <tr>
                            <th class="subhead">Amount:</th>
                            <td>
                                <a href="<?= base_url('admin/detailLevelPerMonth/FM8/').$date;?>">
                                    <?= $fm8 ?? 0; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/detailLevelPerMonth/FM9/').$date;?>">
                                    <?= $fm9 ?? 0; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/detailLevelPerMonth/FM10/').$date;?>">
                                    <?= $fm10 ?? 0; ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th class="subhead">Bonus:</th>
                            <td><?= !empty($bonus_fm8) ? $bonus_fm8. " MTM" : '0'; ?></td>
                            <td><?= !empty($bonus_fm9) ? $bonus_fm9. " MTM" : '0'; ?></td>
                            <td><?= !empty($bonus_fm10) ? $bonus_fm10." MTM" : '0'; ?></td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Purchase <?= $monthName." ".$year; ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Package</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_purchase as $row) : ?>
                            <tr>
                                <td><?= date('Y-m-d', $row->update_date); ?></td>
                                <td><?= $row->username; ?></td>
                                <td><?= $row->name; ?></td>
                                <td>
                                    <?php
                                    if ($row->fill != 0) {
                                        echo $row->fill . " FIL";
                                    } elseif ($row->mtm != 0) {
                                        echo $row->mtm . " MTM";
                                    } elseif ($row->zenx != 0) {
                                        echo $row->zenx . " ZENX";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->