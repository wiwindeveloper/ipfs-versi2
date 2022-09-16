<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('bonus');?></h1>

    <div class="dropdown header-withmenu">
        <button class="btn btn-blue dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= $this->lang->line('basecamp'); ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="<?= base_url('user/bonusList'); ?>"><?= $this->lang->line('mining'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/sponsor'); ?>"><?= $this->lang->line('recommended'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/sponsorMatching'); ?>"><?= $this->lang->line('recommended_matching'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/miningMatching'); ?>"><?= $this->lang->line('recommended_mining'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/miningGenerasi'); ?>"><?= $this->lang->line('mining_generation'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/pairingmatching'); ?>"><?= $this->lang->line('pairing'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/binaryMatching'); ?>"><?= $this->lang->line('pairing_matching'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/bonusGlobal'); ?>"><?= $this->lang->line('global'); ?></a>
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
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/bonusGlobal'); ?>"><?= $this->lang->line('global'); ?></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url('user/bonusBasecamp'); ?>"><?= $this->lang->line('basecamp'); ?> <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- DataTales Example -->
    <!-- <div class="card shadow mb-4"> -->
    <!-- <div class="card-body"> -->
    <!-- <div class="table-responsive"> -->

    <div class="row mb-5 px-3">
        <div class="logo-index col-lg-3 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                <?= $this->lang->line('basecamp');?> :
                </div>
                <div class="p-2 small">
                    <?= $user['basecamp']; ?>
                </div>
            </div>
        </div>
        <div class="logo-index col-lg-3 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                <?= $this->lang->line('today_omset');?> :
                </div>
                <div class="p-2 small">
                    <?= empty($today_omset_box['point']) ? '0' : $today_omset_box['point']; ?> <?= $this->lang->line('box');?>
                </div>
            </div>
        </div>
        <div class="logo-index col-lg-3 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                <?= $this->lang->line('total_omset_month');?> :
                </div>
                <div class="p-2 small">
                    <?= empty($total_omset_box['point']) ? '0' : $total_omset_box['point']; ?> <?= $this->lang->line('box');?>
                </div>
            </div>
        </div>
        <div class="logo-index col-lg-3 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                <?= $this->lang->line('total_omset');?> :
                </div>
                <div class="p-2 small">
                    <?= empty($total_box) ? '0' : $total_box; ?> <?= $this->lang->line('box');?>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><?= $this->lang->line('receive');?></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?= $this->lang->line('collected');?></a>
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
                        <th colspan="3" class="text-right"><?= $this->lang->line('total');?>: </th>
                        <th class="tb-column"><?= !empty($total_box) ? round($total_box, 10) . ' BOX' : '0'; ?> </th>
                        <th class="tb-column"><?= !empty($total) ? round($total, 10) . ' USDT' : '0'; ?> </th>
                    </tr>
                    <tr>
                        <th><?= $this->lang->line('date');?></th>
                        <th><?= $this->lang->line('basecamp');?></th>
                        <th>User ID </th>
                        <th><?= $this->lang->line('package');?></th>
                        <th>USDT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($bonus as $row_bonus) {
                    ?>
                        <tr>
                            <td class="tb-column">
                                <?= date('d/m/Y', $row_bonus->update_date); ?>
                            </td>
                            <td class="tb-column">
                                <?= $row_bonus->bs_name; ?>
                            </td>
                            <td class="tb-column">
                                <?php
                                if ($row_bonus->cart_id != 0) {
                                    $userId = $userClass->usernameBasecamp($row_bonus->cart_id);
                                    echo $userId;
                                } else {
                                    echo $this->lang->line('team').' ' . $row_bonus->team;
                                }
                                ?>
                            </td>
                            <td class="tb-column"><?= $row_bonus->name; ?></td>
                            <td class="tb-column">
                                <?= $row_bonus->usdt; ?> USDT
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <table class="text-center tb-custom" width="100%" cellspacing="0">
                <thead class="text-tb-head">
                    <tr>
                        <th colspan="3" class="text-right"><?= $this->lang->line('total'); ?>: </th>
                        <th class="tb-column"><?= !empty($total_collected_box) ? round($total_collected_box, 10) . ' '.$this->lang->line('box') : '0'; ?> </th>
                        <th class="tb-column"><?= !empty($total_collected) ? round($total_collected, 10) . ' USDT' : '0'; ?> </th>
                    </tr>
                    <tr>
                        <th><?= $this->lang->line('date'); ?></th>
                        <th><?= $this->lang->line('basecamp'); ?></th>
                        <th>User ID</th>
                        <th><?= $this->lang->line('package'); ?></th>
                        <th>USDT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($bonus_collected as $row_bonus_collected) {
                    ?>
                        <tr>
                            <td class="tb-column">
                                <?= date('d/m/Y', $row_bonus_collected->datecreate); ?>
                            </td>
                            <td class="tb-column">
                                <?= $row_bonus_collected->bs_name; ?>
                            </td>
                            <td class="tb-column">
                                <?php
                                if ($row_bonus_collected->cart_id != 0) {
                                    $userId = $userClass->usernameBasecamp($row_bonus_collected->cart_id);
                                    echo $userId;
                                } else {
                                    echo $this->lang->line('team').' ' . $row_bonus_collected->team;
                                }
                                ?>
                            </td>
                            <td class="tb-column"><?= $row_bonus_collected->purchase; ?></td>
                            <td class="tb-column">
                                <?= $row_bonus_collected->usdt; ?> USDT
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
                        <th colspan="4" class="text-right"><?= $this->lang->line('total'); ?>: </th>
                        <th class="tb-column"><?= !empty($total_excess) ? round($total_excess, 10) . " USDT" : "0"; ?></th>
                    </tr>
                    <tr>
                        <th><?= $this->lang->line('date'); ?></th>
                        <th><?= $this->lang->line('basecamp'); ?></th>
                        <th>User ID</th>
                        <th><?= $this->lang->line('package'); ?></th>
                        <th>USDT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($bonus_excess as $row_bonus_excess) {
                    ?>
                        <tr>
                            <td class="tb-column">
                                <?= date('d/m/Y', $row_bonus_excess->datecreate); ?>
                            </td>
                            <td class="tb-column">
                                <?= $row_bonus_excess->bs_name; ?>
                            </td>
                            <td class="tb-column">
                                <?php
                                if ($row_bonus_excess->cart_id != 0) {
                                    $userId = $userClass->usernameBasecamp($row_bonus_excess->cart_id);
                                    echo $userId;
                                } else {
                                    echo $this->lang->line('team').' ' . $row_bonus_excess->team;
                                }
                                ?>
                            </td>
                            <td class="tb-column"><?= $row_bonus_excess->name; ?></td>
                            <td class="tb-column">
                                <?= $row_bonus_excess->usdt; ?> USDT
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- </div> -->
    <!-- </div> -->
    <!-- </div> -->
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->