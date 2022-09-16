<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('bonus');?></h1>

    <div class="dropdown header-withmenu">
        <button class="btn btn-blue dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $this->lang->line('mining_generation'); ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="<?= base_url('user/bonusList'); ?>"><?= $this->lang->line('mining'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/sponsor'); ?>"><?= $this->lang->line('recommended'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/sponsorMatching'); ?>"><?= $this->lang->line('recommended_matching'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/miningMatching'); ?>"><?= $this->lang->line('recommended_mining'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/pairingmatching'); ?>"><?= $this->lang->line('pairing'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/binaryMatching'); ?>"><?= $this->lang->line('pairing_matching'); ?></a>
            <a class="dropdown-item" href="<?= base_url('user/bonusGlobal'); ?>"><?= $this->lang->line('global'); ?></a>
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
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url('user/miningGenerasi'); ?>"><?= $this->lang->line('mining_generation'); ?> <span class="sr-only">(current)</span></a>
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

    <!-- DataTales Example -->
    <!-- <div class="card shadow mb-4"> -->
    <!-- <div class="card-body"> -->
    <!-- <div class="table-responsive"> -->
    <table class="text-center tb-custom" width="100%" cellspacing="0">
        <thead class="text-tb-head">
            <tr>
                <th colspan="5" class="text-right"><?= $this->lang->line('total');?>: </th>
                <th class="tb-column"><?= $total; ?> FIL</th>
            </tr>
            <tr>
                <th><?= $this->lang->line('date');?></th>
                <th>User ID</th>
                <th><?= $this->lang->line('member');?> ID</th>
                <th><?= $this->lang->line('generation');?></th>
                <th><?= $this->lang->line('team');?></th>
                <th><?= $this->lang->line('amount');?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($bonus as $row_bonus) {

            ?>
                <tr>
                    <td class="tb-column">
                        <?= date('d/m/Y', $row_bonus->datecreate); ?>
                    </td>
                    <td class="tb-column">
                        <?= $row_bonus->username; ?>
                    </td>
                    <td class="tb-column">
                        <?= $this->M_user->get_user_byid($row_bonus->member_sponsor)['username']; ?>
                    </td>
                    <td class="tb-column">
                        <?= $row_bonus->generation; ?>
                    </td>
                    <td class="tb-column">
                    <?= $this->lang->line('team');?> <?= $row_bonus->team; ?>
                    </td>
                    <td class="tb-column">
                        <?= $row_bonus->amount; ?> FIL
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <!-- </div> -->
    <!-- </div> -->
    <!-- </div> -->
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->