<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase">
        MTM AIR DROPS <?= $this->lang->line('balance');?>
    </h1>

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
                                MTM AIR DROPS <?= $this->lang->line('balance');?>
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
            <a href="<?= base_url('user/transfer_airdrops_mtm'); ?>" class="btn btn-info btn-block">
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
                                            <?php foreach ($airdrops as $row_list) : ?>
                                                <tr>
                                                    <td>
                                                        <?= date('Y/m/d H:i', $row_list->datecreate); ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-secondary">airdrops</span> -
                                                        <?php
                                                            if(empty($row_list->note))
                                                            {
                                                                echo "MTM ".$this->lang->line('income_from')." mining plan ".$row_list->box;
                                                            }
                                                            else
                                                            {
                                                                echo $row_list->note;
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?= number_format($row_list->amount, 10); ?>
                                                    </td>
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
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->