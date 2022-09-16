<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('bonus');?></h1>

    <div class="dropdown header-withmenu">
        <button class="btn btn-blue dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $this->lang->line('global'); ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="<?= base_url('user/bonusList'); ?>"><?= $this->lang->line('mining'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/sponsor'); ?>"><?= $this->lang->line('recommended'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/sponsorMatching'); ?>"><?= $this->lang->line('recommended_matching'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/miningMatching'); ?>"><?= $this->lang->line('recommended_mining'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/miningGenerasi'); ?>"><?= $this->lang->line('mining_generation'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/pairingmatching'); ?>"><?= $this->lang->line('pairing'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/binaryMatching'); ?>"><?= $this->lang->line('pairing_matching'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/bonusBasecamp'); ?>"><?= $this->lang->line('basecamp'); ?></a>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light mb-5">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav navbar-menubonus">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/bonusList'); ?>"><?= $this->lang->line('mining'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/sponsor'); ?>"><?= $this->lang->line('recommended'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/sponsorMatching'); ?>"><?= $this->lang->line('recommended_matching'); ?></a>
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
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url('user/bonusGlobal'); ?>"><?= $this->lang->line('global'); ?> <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/bonusBasecamp'); ?>"><?= $this->lang->line('basecamp'); ?></a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- DataTales Example -->
    <!-- <div class="card shadow mb-4"> -->
    <!-- <div class="card-body"> -->
    <!-- <div class="table-responsive"> -->
    <?php
    $fm = $cart['fm'] ?? null;
    $explode_fm = explode('M', $fm);

    $level = $explode_fm[1] ?? null;

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
    <div class="row mb-3 px-3">
        <div class="logo-index col-lg-6 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                <?= $this->lang->line('today_omset');?> :
                </div>
                <div class="p-2 small">
                    <?= empty($today_omset) ? '0' : $today_omset; ?> USDT 
                </div>
            </div>
        </div>
        <div class="logo-index col-lg-6 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                <?= $this->lang->line('today_omset_month');?> :
                </div>
                <div class="p-2 small">
                    <?= empty($current_omset) ? '0' : $current_omset; ?> USDT
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3 px-3">
        <table class="text-center tb-custom" width="100%" cellspacing="0">
            <thead class="text-tb-head">
                <tr>
                    <th><?= $this->lang->line('level');?> </th>
                    <th><?= $this->lang->line('amount');?> </th>
                    <th><?= $this->lang->line('bonus');?> </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                        if($level >= 4)
                        {
                            ?>
                    <tr>
                        <th class="tb-column">FM4 (2%)</th>
                        <td class="tb-column">
                            <a href="<?= base_url('user/detailLevelMonthNow/FM4');?>">
                                <?= $fm4 ?? 0; ?>
                            </a>
                        </td>
                        <td class="tb-column"><?= !empty($bonus_fm4) ? $bonus_fm4." USDT" : '0'; ?></td>
                    </tr>
                    <?php
                        }

                        if($level >= 5)
                        {
                    ?>
                    <tr>
                        <th class="tb-column">FM5 (1%)</th>
                        <td class="tb-column">
                            <a href="<?= base_url('user/detailLevelMonthNow/FM5');?>">
                                <?= $fm5 ?? 0; ?>
                            </a>
                        </td>
                        <td class="tb-column"><?= !empty($bonus_fm5) ? $bonus_fm5. " USDT" : '0'; ?></td>
                    </tr>
                    <?php
                        }

                        if($level >= 6)
                        {
                    ?>
                    <tr>
                        <th class="tb-column">FM6 (0,5%)</th>
                        <td class="tb-column">
                            <a href="<?= base_url('user/detailLevelMonthNow/FM6');?>">
                                <?= $fm6 ?? 0; ?>
                            </a>
                        </td>
                        <td class="tb-column"><?= !empty($bonus_fm6) ? $bonus_fm6. " USDT" : '0'; ?></td>
                    </tr>
                    <?php
                        }

                        if($level >= 7)
                        {
                    ?>
                    <tr>
                        <th class="tb-column">FM7 (0,4%)</th>
                        <td class="tb-column">
                            <a href="<?= base_url('user/detailLevelMonthNow/FM7');?>">
                                <?= $fm7 ?? 0; ?>
                            </a>
                        </td>
                        <td class="tb-column"><?= !empty($bonus_fm7) ? $bonus_fm7. " USDT" : '0'; ?></td>
                    </tr>
                    <?php
                        }

                        if($level >= 8)
                        {
                    ?>
                    <tr>
                        <th class="tb-column">FM8 (0,3%)</th>
                        <td class="tb-column">
                            <a href="<?= base_url('user/detailLevelMonthNow/FM8');?>">
                                <?= $fm8 ?? 0; ?>
                            </a>
                        </td>
                        <td class="tb-column"><?= !empty($bonus_fm8) ? $bonus_fm8. " USDT" : '0'; ?></td>
                    </tr>
                    <?php
                        }

                        if($level >= 9)
                        {
                    ?>
                    <tr>
                        <th class="tb-column">FM9 (0,2%)</th>
                        <td class="tb-column">
                            <a href="<?= base_url('user/detailLevelMonthNow/FM9');?>">
                                <?= $fm9 ?? 0; ?>
                            </a>
                        </td>
                        <td class="tb-column"><?= !empty($bonus_fm9) ? $bonus_fm9. " USDT" : '0'; ?></td>
                    </tr>
                    <?php
                        }

                        if($level >= 10)
                        {
                    ?>
                    <tr>
                        <th class="tb-column">FM10 (0,1%)</th>
                        <td class="tb-column">
                            <a href="<?= base_url('user/detailLevelMonthNow/FM10');?>">
                                <?= $fm10 ?? 0; ?>
                            </a>
                        </td>
                        <td class="tb-column"><?= !empty($bonus_fm10) ? $bonus_fm10." USDT" : '0'; ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tr>
            </tbody>
        </table>
    </div>
    <ul class="nav nav-tabs my-5" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><?= $this->lang->line('receive');?></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"><?= $this->lang->line('excess');?></a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <table class="text-center tb-custom" width="100%" cellspacing="0">
                <thead class="text-tb-head">
                    <tr>
                        <th colspan="4" class="text-right"><?= $this->lang->line('total');?>: </th>
                        <th class="tb-column"><?= round($total, 10); ?> USDT</th>
                    </tr>
                    <tr>
                        <th><?= $this->lang->line('date');?></th>
                        <th><?= $this->lang->line('omset');?></th>
                        <th><?= $this->lang->line('level');?></th>
                        <th><?= $this->lang->line('accumulation');?></th>
                        <th>USDT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($bonus as $row_bonus) 
                    {
                        $date = date('Y-m-d', $row_bonus->datecreate);
                        $date_omset = new DateTime($date);
                        $date_omset->modify('-1 days');
                        $dateNow = $date_omset->format('Y-m');
                        $level_fm = empty($row_bonus->level_fm) ? $row_bonus->note_level : $row_bonus->level_fm;

                        $total_omset_fil = $this->M_user->get_omset_global($dateNow)['total_fil'] + $this->M_user->get_omset_global($dateNow)['total_usdt'] / $price_usdt + $this->M_user->get_omset_global($dateNow)['total_krp'] / $price_krp;
                        $total_omset_usdt = $total_omset_fil*$price_usdt;
                    ?>

                        <tr>
                            <td class="tb-column">
                                <?= date('d/m/Y', $row_bonus->datecreate); ?>
                            </td>
                            <td class="tb-column"><?= $total_omset_usdt; ?> USDT</td>
                            <td class="tb-column"><?= empty($row_bonus->level_fm) ? $row_bonus->note_level : $row_bonus->level_fm; ?></td>
                            <td class="tb-column"><?= $this->M_user->get_level_month_usdt($level_fm, $dateNow)['total'] + $this->M_user->get_level_month2_usdt($level_fm, $dateNow)['total'] ?></td>
                            <td class="tb-column">
                                <?= round($row_bonus->usdt, 10); ?> USDT
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <table class="text-center tb-custom" width="100%" cellspacing="0">
                <thead class="text-tb-head">
                    <tr>
                        <th colspan="4" class="text-right"><?= $this->lang->line('total');?>: </th>
                        <th class="tb-column"><?= $total_excess; ?> USDT</th>
                    </tr>
                    <tr>
                        <th><?= $this->lang->line('date');?></th>
                        <th><?= $this->lang->line('omset');?></th>
                        <th><?= $this->lang->line('level');?></th>
                        <th><?= $this->lang->line('accumulation');?></th>
                        <th>USDT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($excess_bonus as $row_excess) {
                        $date = date('Y-m-d', $row_excess->datecreate);
                        $date_omset = new DateTime($date);
                        $date_omset->modify('-1 days');
                        $dateNow = $date_omset->format('Y-m');
                        $level_fm = empty($row_excess->level_fm) ? $row_excess->note_level : $row_excess->level_fm;

                        $total_omset_fil = $this->M_user->get_omset_global($dateNow)['total_fil'] + $this->M_user->get_omset_global($dateNow)['total_usdt'] / $price_usdt + $this->M_user->get_omset_global($dateNow)['total_krp'] / $price_krp;
                        $total_omset_usdt = $total_omset_fil*$price_usdt;
                    ?>

                        <tr>
                            <td class="tb-column">
                                <?= date('d/m/Y', $row_excess->datecreate); ?>
                            </td>
                            <td class="tb-column"><?= $total_omset_usdt; ?> USDT</td>
                            <td class="tb-column"><?= empty($row_excess->level_fm) ? $row_excess->note_level : $row_excess->level_fm; ?></td>
                            <td class="tb-column"><?= $this->M_user->get_level_month_usdt($level_fm, $dateNow)['total'] + $this->M_user->get_level_month2_usdt($level_fm, $dateNow)['total'] ?></td>
                            <td class="tb-column">
                                <?= $row_excess->usdt; ?> USDT
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->