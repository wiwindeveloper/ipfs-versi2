<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('my_wallet');?></h1>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 wallet">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 my-auto">
                            <img class="img-balance" src="<?= base_url('assets/img/zenith_logo.png') ?>" alt="img" width="100px">
                        </div>
                        <div class="col-6 d-none">
                            <div class="gauge float-right">
                                <?php 
                                $i = 5; $max=15; 
                                $hasil = $i/$max * 100; 
                                ?>
                                <div class="arc" style="background-image:
                                                    radial-gradient(#000 0, #000 60%, transparent 60%),
                                                    conic-gradient(#653a96 0, #c46aa8 <?= $hasil/100*180; ?>deg, #ccc <?= $hasil/100*180; ?>deg, #ccc 180deg, transparent 180deg, transparent 360deg);"></div>
                                <div class="pointer" style="transform: rotate(<?= $hasil/100*180; ?>deg) translateX(0%) translateY(-100%);"></div>
                                <div class="mask"></div>
                                <div class="label"><?= round($hasil,1) ?>%</div>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <div class="text-balance font-weight-bold text-white text-uppercase mb-1 ">
                                ZENX <?= $this->lang->line('general_balance');?>
                            </div>
                            <h2 class="amount-balance"><?= number_format($general, 10, ',', '.'); ?></h2>
                            <div class="dollar-balance h5 mb-0 text-tb-head font-w-8">
                                <i class="fas fa-dollar-sign"></i> 0
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12 mb-4">
            <a href="<?= base_url('user/withdrawal_zenx') ?>" class="btn btn-info btn-block text-capitalize">
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
                                                            <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('withdrawal');?></span> -
                                                            <?= $this->lang->line('to');?> <?= $row_withdrawal->wallet_address; ?> (<?= $this->lang->line('waiting');?> . . .)
                                                        </td>
                                                    <?php else : ?>
                                                        <td>
                                                            <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('withdrawal');?></span> -
                                                            <?= $this->lang->line('to');?> <?= $row_withdrawal->wallet_address; ?> (<?= $row_withdrawal->txid; ?>)
                                                        </td>
                                                    <?php endif ?>
                                                    <td>-<?= number_format($row_withdrawal->amount, 10, ',', '.'); ?> MTM</td>
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
                                                <?php if ($row_purchase->zenx != 0) : ?>
                                                    <tr>
                                                        <td><?= date('Y/m/d H:i', $row_purchase->datecreate); ?></td>
                                                        <td>
                                                            <span class="badge badge-secondary"><?= $this->lang->line('purchase');?></span> -
                                                            <?= $this->lang->line('package_purchase');?> <?= $row_purchase->name; ?>
                                                        </td>
                                                        <td>- <?= number_format($row_purchase->zenx, 10, ',', '.'); ?></td>
                                                    </tr>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2"><?= $this->lang->line('total');?></th>
                                                <th><?= number_format($general, 10, ',', '.'); ?></th>
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