<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('bonus');?></h1>

    <div class="dropdown header-withmenu">
        <button class="btn btn-blue dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $this->lang->line('pairing'); ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="<?= base_url('user/bonusList'); ?>">Airdrops/<?= $this->lang->line('mining'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/sponsor'); ?>"><?= $this->lang->line('recommended'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/sponsorMatching'); ?>"><?= $this->lang->line('recommended_matching'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/miningMatching'); ?>"><?= $this->lang->line('recommended_mining'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/miningGenerasi'); ?>"><?= $this->lang->line('mining_generation'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/binaryMatching'); ?>"><?= $this->lang->line('pairing_matching'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/bonusGlobal'); ?>"><?= $this->lang->line('global'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/bonusBasecamp'); ?>"><?= $this->lang->line('basecamp'); ?></a>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light mb-5">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav navbar-menubonus">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/bonusList'); ?>">Airdrops/<?= $this->lang->line('mining'); ?></a>
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
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url('user/pairingmatching'); ?>"><?= $this->lang->line('pairing'); ?> <span class="sr-only">(current)</span></a>
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

    <!-- DataTales Example -->
    <!-- <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive"> -->
    <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
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
                        <th colspan="3" class="text-right"><?= $this->lang->line('total');?>: </th>
                        <th class="tb-column"><?= $total_mtm; ?> MTM</th>
                    </tr>
                    <tr>
                        <th><?= $this->lang->line('date');?></th>
                        <th>User ID</th>
                        <th><?= $this->lang->line('set');?></th>
                        <th>MTM</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($bonus as $row_bonus) {
                    ?>
                        <tr>
                            <td class="tb-column"><?= date('d/m/Y', $row_bonus->datecreate); ?></td>
                            <td class="tb-column"><?= $row_bonus->username; ?></td>
                            <td class="tb-column"><?= $row_bonus->set_amount / 2; ?> <?= $this->lang->line('set');?></td>
                            <td class="tb-column"><?= $row_bonus->mtm; ?> MTM</td>
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
                        <th colspan="3" class="text-right"><?= $this->lang->line('total');?>: </th>
                        <th class="tb-column"><?= !empty($total_mtm_excess) ? $total_mtm_excess.' MTM' : '0'; ?> </th>
                    </tr>
                    <tr>
                        <th><?= $this->lang->line('date');?></th>
                        <th>User ID</th>
                        <th><?= $this->lang->line('set');?></th>
                        <th>MTM</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($bonus_excess as $row_bonus_excess) {
                    ?>
                        <tr>
                            <td class="tb-column"><?= date('d/m/Y', $row_bonus_excess->datecreate); ?></td>
                            <td class="tb-column"><?= $row_bonus_excess->username; ?></td>
                            <td class="tb-column"><?= $row_bonus_excess->mtm * 2; ?> <?= $this->lang->line('set');?></td>
                            <td class="tb-column"><?= $row_bonus_excess->mtm; ?> MTM</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- </div>
                        </div> -->
    <!-- </div> -->
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->