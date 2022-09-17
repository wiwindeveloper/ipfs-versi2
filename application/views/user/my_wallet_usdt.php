<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase">USDT <?= $this->lang->line('wallet'); ?> </h1>

    <?php
        $uriSegment = $this->uri->segment(3);
    ?>

    <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
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
                                <div class="col-lg-2 mx-auto my-2">
                                    <img class="img-balance d-block d-lg-inline mx-auto" src="<?= base_url('assets/img/icon-usdt.png') ?>" alt="img" width="100px">
                                </div>
                                <div class="col-lg-2 my-2">
                                    <div class="gauge mx-auto">
                                        <?php
                                        $usdt = $total_usdt;
                                        $i = $usdt;
                                        $max = $detail['total_usdt'] ?? 1;
                                        $max_bonus = $max * 3;
                                        $hasil = $i / $max_bonus * 300;
                                        ?>
                                        <div class="arc" style="background-image:
                                                            radial-gradient(#000 0, #000 60%, transparent 60%),
                                                            conic-gradient(#e7141a 0, #ec4c48 <?= $hasil / 300 * 180; ?>deg, #ccc <?= $hasil / 300 * 180; ?>deg, #ccc 180deg, transparent 180deg, transparent 360deg);"></div>
                                        <div class="pointer" style="transform: rotate(<?= $hasil / 300 * 180; ?>deg) translateX(0%) translateY(-100%);"></div>
                                        <div class="mask"></div>
                                        <div class="label"><?= round($hasil, 1) ?>%</div>
                                    </div>
                                </div>
                                <div class="col-lg-8 d-flex justify-content-end my-2 px-0">
                                    <div class="mr-3 wrapper-excess-usdt">
                                        <div class="text-balance font-weight-bold text-white text-uppercase mb-1 ">
                                            USDT <?= $this->lang->line('excess_bonus');?>
                                        </div>
                                        <h2 class="amount-balance"><?= number_format($excess_bonus['usdt'], 10, ',', '.'); ?></h2>
                                        <div class="dollar-balance h5 mb-0 text-tb-head font-w-8">
                                            <i class="fas fa-dollar-sign"></i> <?= $market_price['usdt'] * $excess_bonus['usdt'] ?>
                                        </div>
                                    </div>
                                    <div class="wrapper-balance-usdt">
                                        <div class="text-balance font-weight-bold text-white text-uppercase mb-1 ">
                                            USDT <?= $this->lang->line('general_balance');?>
                                        </div>
                                        <h2 class="amount-balance"><?= number_format($general_balance_usdt, 10, ',', '.'); ?></h2>
                                        <div class="dollar-balance h5 mb-0 text-tb-head font-w-8">
                                            <i class="fas fa-dollar-sign"></i> <?= $market_price['usdt'] * $general_balance_usdt ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-md-12 mb-4">
                    <a href="<?= base_url('user/withdrawal_mtm'); ?>" class="btn btn-ok btn-block text-capitalize">
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
                                                        <?php if ($row_purchase->usdt != 0) : ?>
                                                            <tr>
                                                                <td><?= date('Y/m/d H:i', $row_purchase->datecreate); ?></td>
                                                                <td>
                                                                    <span class="badge badge-secondary"><?= $this->lang->line('purchase');?></span> -
                                                                    <?= $this->lang->line('package_purchase');?> <?= $row_purchase->name; ?>
                                                                </td>
                                                                <td>- <?= number_format($row_purchase->usdt, 10, ',', '.'); ?></td>
                                                            </tr>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2"><?= $this->lang->line('total');?></th>
                                                        <th><?= number_format($general_balance_usdt, 10, ',', '.'); ?></th>
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
                                    <img class="img-balance" src="<?= base_url('assets/img/icon-usdt.png') ?>" alt="img" width="100px">
                                </div>
                                <div class="col-9 text-right">
                                    <div class="text-balance font-weight-bold text-white text-uppercase mb-1 ">
                                        USDT <?= $this->lang->line('bonus_balance');?>
                                    </div>
                                    <h2 class="amount-balance"><?= number_format($balance, 10); ?></h2>
                                    <div class="dollar-balance h5 mb-0 text-tb-head font-w-8">
                                        <i class="fas fa-dollar-sign"></i> <?= $market_price['usdt'] * $balance ?>
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
                                                        <?php
                                                            if($row_list->usdt != 0)
                                                            {
                                                                ?>
                                                                    <tr>
                                                                        <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                                        <td>
                                                                            <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('recommended');?></span> -
                                                                            USDT <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                                        </td>
                                                                        <td><?= number_format($row_list->usdt, 10); ?></td>
                                                                    </tr>
                                                                <?php
                                                            }
                                                        ?>
                                                    <?php endforeach ?>
                                                    <?php foreach ($bonus_sm_list as $row_list) : ?>
                                                        <?php
                                                            if($row_list->usdt != 0)
                                                            {
                                                                ?>
                                                                <tr>
                                                                    <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                                    <td>
                                                                        <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('recommended_matching');?></span> -
                                                                        USDT <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                                    </td>
                                                                    <td><?= number_format($row_list->usdt, 10); ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        ?>
                                                    <?php endforeach ?>
                                                    <?php foreach ($bonus_pairingmatch_list as $row_list) : ?>
                                                        <tr>
                                                            <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                            <td>
                                                                <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('pairing');?></span> -
                                                                USDT <?= $this->lang->line('income_from');?> <?= $row_list->set_amount / 4; ?> set
                                                            </td>
                                                            <td><?= number_format($row_list->usdt, 10); ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                    <?php foreach ($bonus_minmatching_list as $row_list) : ?>
                                                        <?php
                                                            if($row_list->usdt != 0)
                                                            {
                                                                ?>
                                                                <tr>
                                                                    <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                                    <td>
                                                                        <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('recommended_mining');?></span> -
                                                                        USDT <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                                    </td>
                                                                    <td><?= number_format($row_list->usdt, 10); ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        ?>
                                                    <?php endforeach ?>
                                                    <?php foreach ($bonus_minpairing_list as $row_list) : ?>
                                                        <tr>
                                                            <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                            <td>
                                                                <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('mining_generation');?></span> -
                                                                USDT <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                            </td>
                                                            <td><?= number_format($row_list->usdt, 10); ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                    <?php foreach ($bonus_binary_list as $row_list) : ?>
                                                        <tr>
                                                            <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                            <td>
                                                                <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('pairing_matching');?></span> -
                                                                USDT <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                            </td>
                                                            <td><?= number_format($row_list->usdt, 10); ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                    <?php foreach ($bonus_global_list as $row_list) : ?>
                                                        <tr>
                                                            <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                            <td>
                                                                <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('global');?></span> -
                                                                USDT <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                            </td>
                                                            <td><?= number_format($row_list->usdt, 10); ?></td>
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
                                                                    USDT <?= $this->lang->line('income_from');?> <?= $row_list->username; ?>
                                                                </td>
                                                                <td><?= number_format($row_list->usdt, 10); ?></td>
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
    </div>
</div>
<!-- /.container-fluid -->

</div>

<!-- End of Main Content -->