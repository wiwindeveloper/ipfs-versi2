<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase">MTM <?= $this->lang->line('bonus_balance');?></h1>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 wallet">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 my-auto">
                            <img class="img-balance" src="<?= base_url('assets/img/mtm_logo.png') ?>" alt="img" width="100px">
                        </div>
                        <div class="col-9 text-right">
                            <div class="text-balance font-weight-bold text-white text-uppercase mb-1 ">
                                MTM <?= $this->lang->line('bonus_balance');?>
                            </div>
                            <h2 class="amount-balance"><?= number_format($balance, 10); ?></h2>
                            <div class="dollar-balance h5 mb-0 text-tb-head font-w-8">
                                <i class="fas fa-dollar-sign"></i> <?= $market_price['mtm'] * $balance ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12 mb-4">
            <a href="<?= base_url('user/transfer_bonus_mtm'); ?>" class="btn btn-info btn-block">
            <?= $this->lang->line('trf_to_general');?>
            </a>
        </div>

        <div class="col-xl-12 col-md-12 mb-4 wallet">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-center font-weight-bold text-white mb-5">
                            <?= $this->lang->line('history');?>
                            </div>
                            <div class="h5 mb-0 text-gray-800 ">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-white" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?= $this->lang->line('date');?></th>
                                                <th><?= $this->lang->line('description');?></th>
                                                <th><?= $this->lang->line('amount');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($bonus_list as $row_list) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                    <td>
                                                        <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('recommended');?></span> -
                                                        MTM <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                    </td>
                                                    <td><?= number_format($row_list->mtm, 10); ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                            <?php foreach ($bonus_sm_list as $row_list) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                    <td>
                                                        <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('recommended_matching');?></span> -
                                                        MTM <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                    </td>
                                                    <td><?= number_format($row_list->mtm, 10); ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                            <?php foreach ($bonus_pairingmatch_list as $row_list) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                    <td>
                                                        <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('pairing');?></span> -
                                                        MTM <?= $this->lang->line('income_from');?> <?= $row_list->set_amount / 4; ?> set
                                                    </td>
                                                    <td><?= number_format($row_list->mtm, 10); ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                            <?php foreach ($bonus_binary_list as $row_list) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                    <td>
                                                        <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('pairing_matching');?></span> -
                                                        MTM <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                    </td>
                                                    <td><?= number_format($row_list->mtm, 10); ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                            <?php foreach ($bonus_global_list as $row_list) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                    <td>
                                                        <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('global');?></span> -
                                                        MTM <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                    </td>
                                                    <td><?= number_format($row_list->mtm, 10); ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                            <?php foreach ($transfer_list as $trf_list) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $trf_list->datecreate); ?></td>
                                                    <td><?= $this->lang->line('trf_to_general');?></td>
                                                    <td>-<?= number_format($trf_list->amount, 10); ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                            <?php foreach ($bonus_basecamp_list as $row_list) : ?>
                                                <?php if ($row_list->mtm != 0) : ?>
                                                    <tr>
                                                        <td><?= date('Y/m/d H:i', $row_list->update_date); ?></td>
                                                        <td>
                                                            <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('basecamp');?></span> -
                                                            MTM <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                        </td>
                                                        <td><?= number_format($row_list->mtm, 10); ?></td>
                                                    </tr>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2"><?= $this->lang->line('total');?></th>
                                                <th><?= number_format($balance, 10); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->