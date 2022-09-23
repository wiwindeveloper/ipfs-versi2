<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('bonus'); ?></h1>

    <div class="dropdown header-withmenu">
        <button class="btn btn-blue dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $this->lang->line('mining'); ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="<?= base_url('user/sponsor'); ?>">Airdrop/<?= $this->lang->line('recommended'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/sponsorMatching'); ?>"><?= $this->lang->line('recommended_matching'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/miningMatching'); ?>"><?= $this->lang->line('recommended_mining'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/miningGenerasi'); ?>"><?= $this->lang->line('mining_generation'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/pairingmatching'); ?>"><?= $this->lang->line('pairing'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/binaryMatching'); ?>"><?= $this->lang->line('pairing_matching'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/bonusGlobal'); ?>"><?= $this->lang->line('global'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/bonusBasecamp'); ?>"><?= $this->lang->line('basecamp'); ?></a>
        </div>
    </div>
    <?= $this->session->flashdata('message'); ?>

    <nav class="navbar navbar-expand-lg navbar-light mb-5">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav navbar-menubonus">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Airdrop/<?= $this->lang->line('mining'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/sponsor'); ?>"><?= $this->lang->line('recommended'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/sponsorMatching'); ?>"><?= $this->lang->line('recommended_matching'); ?> <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/miningMatching'); ?>"><?= $this->lang->line('recommended_mining'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/miningGenerasi'); ?>"><?= $this->lang->line('mining_generation'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/pairingmatching'); ?>"><?= $this->lang->line('pairing'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/binaryMatching'); ?>"><?= $this->lang->line('pairing_matching'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/bonusGlobal'); ?>"><?= $this->lang->line('global'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/bonusBasecamp'); ?>"><?= $this->lang->line('basecamp'); ?></a>
                </li>
            </ul>
        </div>
    </nav>

    <?php
        $urisegment = $this->uri->segment(3);
    ?>
    <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= empty($urisegment) ? 'active' : '';?>" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Airdrops</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= $urisegment == 'mining' ? 'active' : '';?>" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"><?= $this->lang->line('mining'); ?></a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade <?= empty($urisegment) ? 'show active' : '';?>" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                                    <i class="fas fa-dollar-sign"></i> <?= $market_price['mtm'] * $balance; ?>
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

        <div class="tab-pane fade <?= $urisegment == 'mining' ? 'show active' : '';?>" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="col-xl-12 col-md-12 mb-4 wallet">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 my-auto">
                                <img class="img-balance" src="<?= base_url('assets/img/filcoin_logo.png') ?>" alt="img" width="100px">
                            </div>
                            <div class="col-9 text-right">
                                <div class="text-balance font-weight-bold text-white text-uppercase mb-1 ">
                                    FILL MINING <?= $this->lang->line('balance');?>
                                </div>
                                <h2 class="amount-balance"><?= number_format($balance_mining, 10); ?></h2>
                                <div class="dollar-balance h5 mb-0 text-tb-head font-w-8">
                                    <i class="fas fa-dollar-sign"></i> <?= $market_price['filecoin'] * $balance_mining ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-md-12 mb-4">
                <a href="<?= base_url('user/transfer_mining_fil') ?>" class="btn btn-ok btn-block">
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
                                        <table class="table table-bordered text-white" id="dataTable2" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th><?= $this->lang->line('date');?></th>
                                                    <th><?= $this->lang->line('description');?></th>
                                                    <th><?= $this->lang->line('amount');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($list_mining as $row_mining) : ?>
                                                    <tr>
                                                        <td><?= date('Y/m/d H:i', $row_mining->datecreate); ?></td>
                                                        <td>
                                                            <span class="badge badge-secondary text-lowercase"><?= $this->lang->line('mining');?></span> -
                                                            FIL <?= $this->lang->line('income_from');?> mining plan <?= $row_mining->box; ?>
                                                        </td>
                                                        <td><?= number_format($row_mining->amount, 10); ?></td>

                                                    </tr>
                                                <?php endforeach ?>
                                                <?php foreach ($transfer_list_fil as $trf_list) : ?>
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
                                                    <th><?= number_format($balance_mining, 10); ?></th>
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
<!-- /.container-fluid -->

</div>

<!-- End of Main Content -->