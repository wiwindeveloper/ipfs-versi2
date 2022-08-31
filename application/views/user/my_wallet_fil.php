<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase">Fil <?= $this->lang->line('wallet'); ?> </h1>
    
    <?php
        $uriSegment = $this->uri->segment(3);
    ?>

    <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
        <li class="nav-item " role="presentation">
            <a class="nav-link <?= empty($uriSegment) ? 'active' : ''; ?>" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                General <?= $this->lang->line('balance');?>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= $uriSegment == 'bonus' ? 'active' : ''; ?>" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                Bonus <?= $this->lang->line('balance');?>
            </a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade <?= empty($uriSegment) ? 'show active' : ''; ?>" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">
                <div class="col-xl-12 col-md-12 mb-4 wallet">
                    <div class="card shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 my-auto">
                                    <img class="img-balance" src="<?= base_url('assets/img/filcoin_logo.png') ?>" alt="img" width="100px">
                                </div>
                                <div class="col-9 text-right">
                                    <div class="text-balance font-weight-bold text-white text-uppercase mb-1 ">
                                        FILL GENERAL <?= $this->lang->line('balance');?>
                                    </div>
                                    <h2 class="amount-balance"><?= number_format($general_balance_fil, 10, ',', '.'); ?></h2>
                                    <div class="dollar-balance h5 mb-0 text-tb-head font-w-8">
                                        <i class="fas fa-dollar-sign"></i><?= $market_price['filecoin'] * $general_balance_fil ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-md-12 mb-4">
                    <a href="<?= base_url('user/withdrawal_fil') ?>" class="btn btn-ok btn-block text-capitalize">
                    <?= $this->lang->line('withdrawal');?>
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
                                    <div class="h5 mb-0 ">
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-white" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width:150px"><?= $this->lang->line('date');?></th>
                                                        <th><?= $this->lang->line('description');?></th>
                                                        <th><?= $this->lang->line('amount');?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- list withdrawal -->
                                                    <?php foreach ($withdrawal as $row_withdrawal) : ?>
                                                        <tr>
                                                            <td><?= date('Y/m/d H:i', $row_withdrawal->datecreate); ?></td>
                                                            <?php if ($row_withdrawal->txid == NULL) : ?>
                                                                <td>
                                                                    <span class="badge badge-secondary"><?= $this->lang->line('withdrawal');?></span> -
                                                                    <?= $this->lang->line('to');?> <?= $row_withdrawal->wallet_address; ?> (<?= $this->lang->line('waiting');?> . . .)
                                                                </td>
                                                            <?php else : ?>
                                                                <td>
                                                                    <span class="badge badge-secondary"><?= $this->lang->line('withdrawal');?></span> -
                                                                    <?= $this->lang->line('to');?> <?= $row_withdrawal->wallet_address; ?> (<?= $row_withdrawal->txid; ?>)
                                                                </td>
                                                            <?php endif ?>
                                                            <td>-<?= number_format($row_withdrawal->amount, 10, ',', '.'); ?></td>
                                                        </tr>
                                                    <?php endforeach ?>

                                                    <!-- list transfer from mining -->
                                                    <?php foreach ($transfer_list_mining as $list_mining) : ?>
                                                        <tr>
                                                            <td><?= date('Y/m/d H:i', $list_mining->datecreate); ?></td>
                                                            <td><?= $this->lang->line('transfer_from_mining');?></td>
                                                            <td><?= number_format($list_mining->amount, 10, ',', '.'); ?></td>
                                                        </tr>
                                                    <?php endforeach ?>

                                                    <!-- list transfer from bonus -->
                                                    <?php foreach ($transfer_list_bonus as $list_bonus) : ?>
                                                        <tr>
                                                            <td><?= date('Y/m/d H:i', $list_bonus->datecreate); ?></td>
                                                            <td><?= $this->lang->line('transfer_from_bonus');?></td>
                                                            <td><?= number_format($list_bonus->amount, 10, ',', '.'); ?></td>
                                                        </tr>
                                                    <?php endforeach ?>

                                                    <!-- list deposit -->
                                                    <?php foreach ($deposit as $row_deposit) : ?>
                                                        <tr>
                                                            <td><?= date('Y/m/d H:i', $row_deposit->datecreate); ?></td>
                                                            <td>
                                                                <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('deposit');?></span> -
                                                                <?= $this->lang->line('from');?> <?= $row_deposit->txid; ?>
                                                            </td>
                                                            <td><?= number_format($row_deposit->coin, 10, ',', '.'); ?></td>
                                                        </tr>
                                                    <?php endforeach ?>

                                                    <!-- list purchase -->
                                                    <?php foreach ($purchase as $row_purchase) : ?>
                                                        <?php if ($row_purchase->fill != 0) : ?>
                                                            <tr>
                                                                <td><?= date('Y/m/d H:i', $row_purchase->datecreate); ?></td>
                                                                <td>
                                                                    <span class="badge badge-secondary"><?= $this->lang->line('purchase');?></span> -
                                                                    <?= $this->lang->line('package_purchase');?> <?= $row_purchase->name; ?>
                                                                </td>
                                                                <td>- <?= number_format($row_purchase->fill, 10, ',', '.'); ?></td>
                                                            </tr>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2"><?= $this->lang->line('total');?></th>
                                                        <th><?= number_format($general_balance_fil, 10, ',', '.'); ?></th>
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
        <div class="tab-pane fade <?= $uriSegment == 'bonus' ? 'show active' : ''; ?>" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="row">
                <div class="col-xl-12 col-md-12 mb-4 wallet">
                    <div class="card shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 my-auto">
                                    <img class="img-balance" src="<?= base_url('assets/img/filcoin_logo.png') ?>" alt="img" width="100px">
                                </div>
                                <div class="col-9 text-right">
                                    <div class="text-balance font-weight-bold text-white text-uppercase mb-1 ">
                                        FILL <?= $this->lang->line('bonus_balance');?>
                                    </div>
                                    <h2 class="amount-balance"><?= number_format($balance, 10); ?></h2>
                                    <div class="dollar-balance h5 mb-0 text-tb-head font-w-8">
                                        <i class="fas fa-dollar-sign"></i> <?= $market_price['filecoin'] * $balance ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-md-12 mb-4">
                    <a href="<?= base_url('user/transfer_bonus_fil'); ?>" class="btn btn-ok btn-block">
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
                                    <div class="h5 mb-0">
                                        <div class="table-responsive ">
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
                                                                FIL <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                            </td>
                                                            <td><?= number_format($row_list->filecoin, 10); ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                    <?php foreach ($bonus_sm_list as $row_list) : ?>
                                                        <tr>
                                                            <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                            <td>
                                                                <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('recommended_matching');?></span> -
                                                                FIL <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                            </td>
                                                            <td><?= number_format($row_list->filecoin, 10); ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                    <?php foreach ($bonus_minmatching_list as $row_list) : ?>
                                                        <tr>
                                                            <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                            <td>
                                                                <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('recommended_mining');?></span> -
                                                                FIL <?= $this->lang->line('income_from');?> <?= $row_list->username; ?> <?= $this->lang->line('team');?> <?= $row_list->team; ?>
                                                            </td>
                                                            <td><?= number_format($row_list->amount, 10); ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                    <?php foreach ($bonus_minpairing_list as $row_list) : ?>
                                                        <tr>
                                                            <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                            <td>
                                                                <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('mining_matching');?></span> -
                                                                FIL <?= $this->lang->line('income_from');?> <?= $row_list->generation; ?> <?= $row_list->username; ?>
                                                            </td>
                                                            <td><?= number_format($row_list->amount, 10); ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                    <?php foreach ($transfer_list as $trf_list) : ?>
                                                        <tr>
                                                            <td><?= date('Y/m/d H:i', $trf_list->datecreate); ?></td>
                                                            <td><?= $this->lang->line('trf_to_general');?></td>
                                                            <td>-<?= number_format($trf_list->amount, 10); ?></td>
                                                        </tr>
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
    </div>
</div>
<!-- /.container-fluid -->

</div>

<!-- End of Main Content -->