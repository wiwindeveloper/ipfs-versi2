<!-- Sidebar -->
<ul class="navbar-nav sidebar toggled sidebar-dark accordion my-3" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <button id="sidebarToggleTop" class="btn btn-outline-secondary rounded-circle d-md-none mr-3 text-white mx-auto" style="width: min-content;">
        ×
    </button>
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('user'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <!-- <i class="fas fa-laugh-wink"></i> -->
            <img src="<?= base_url('assets/img/filcoin_logo.png'); ?>" alt="logo" width="35px;">
        </div>
        <div class="sidebar-brand-text mx-3">IPFS.CO.ID</div>
    </a>

    <!-- Divider -->
    <!-- <hr class="sidebar-divider my-0"> -->

    <li class="nav-item mx-auto text-center">
        <div class="square-sidebar mx-auto">
            <?php if ($user['photo'] != NULL) : ?>
                <img class="img-profile rounded-circle" src="<?= base_url('assets/photo/' . $user['photo']); ?>">
            <?php else : ?>
                <img class="img-profile rounded-circle" src="<?= base_url('assets/img/guest.png'); ?>">
            <?php endif; ?>
        </div>
        <p class="text-white mt-3 mb-0"><?= $user['first_name']; ?></p>
        <p class="text-white mt-0 small">(<?= $user['username']; ?>)</p>
    </li>

    <div class="sidebar-card d-none d-lg-flex">
        <table class="table table-borderless text-white">
            <tr>
                <td><?= $this->lang->line('rank');?></td>
                <td>: <?= $cart['fm'] ?? null; ?></td>
            </tr>
            <tr>
                <td><?= $this->lang->line('recommended');?></td>
                <td>: <?= $cart['sponsor'] ?? null; ?></td>
            </tr>
            <tr>
                <td><?= $this->lang->line('package');?></td>
                <td>: <?= !empty($cart['name']) ? $cart['name'] . " " . $this->lang->line('box') : '' ?> </td>
            </tr>
        </table>
    </div>

    <!-- Heading -->
    <div class="sidebar-heading">
        <?= $this->lang->line('menu');?>
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= uri_string() == 'user' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user'); ?>">
            <img src="<?= base_url('assets/img/icon-07.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('my_home');?></span></a>
    </li>

    <!-- Nav Item - Package Purchase -->
    <li class="nav-item <?= $this->uri->segment(2) == 'deposit' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/deposit'); ?>">
            <img src="<?= base_url('assets/img/icon-08.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('deposit');?></span></a>
    </li>

    <!-- Nav Item - Package Purchase -->
    <li class="nav-item <?= $this->uri->segment(2) == 'package' || $this->uri->segment(2) == 'packageTour' || $this->uri->segment(2) == 'purchase' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/package'); ?>">
            <img src="<?= base_url('assets/img/icon-09.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('package_purchase');?></span></a>
    </li>

    <!-- Nav Item - Bonus -->
    <li class="nav-item <?= uri_string() == 'user/bonusList' || uri_string() == 'user/sponsor' || uri_string() == 'user/sponsorMatching' || uri_string() == 'user/miningMatching' || uri_string() == 'user/miningGenerasi' || uri_string() == 'user/pairingmatching' || uri_string() == 'user/binaryMatching' || uri_string() == 'user/bonusGlobal' || uri_string() == 'user/bonusGlobal' || uri_string() == 'user/bonusBasecamp' || uri_string() == 'user/transfer_airdrops_mtm' || uri_string() == 'user/transfer_mining_fil' || uri_string() == 'user/bonusList/mining' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/bonusList'); ?>">
            <img src="<?= base_url('assets/img/icon-10.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('bonus');?></span></a>
    </li>

    <!-- Nav Item - My Wallet -->
    <!-- <li class="nav-item <?= uri_string() == 'user/mywallet' || uri_string() == 'user/walletfillmining' || uri_string() == 'user/walletfillgeneral' || uri_string() == 'user/walletfillbonus' || uri_string() == 'user/walletmtmgeneral' || uri_string() == 'user/walletmtmairdrop' || uri_string() == 'user/walletmtmbonus' || uri_string() == 'user/walletzenxgeneral' || uri_string() == 'user/walletzenxairdrop' || uri_string() == 'user/walletzenxbonus' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/mywallet'); ?>">
            <img src="<?= base_url('assets/img/icon-11.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('my_wallet');?></span>
        </a>
    </li> -->

    <li class="nav-item">
        <a class="nav-link <?= uri_string() == 'user/mywalletusdt' ||  uri_string() == 'user/mywalletfil' || uri_string() == 'user/mywalletkrp' || uri_string() == 'user/withdrawal_usdt' || uri_string() == 'user/transfer_bonus_usdt' || uri_string() == 'user/mywalletusdt/bonus' || uri_string() == 'user/mywalletfil/bonus' || uri_string() == 'user/withdrawal_fil' || uri_string() == 'user/transfer_bonus_fil' || uri_string() == 'user/withdrawal_krp' || uri_string() == 'user/transfer_bonus_krp' || uri_string() == 'user/mywalletkrp/bonus' ? '' : 'collapsed';?>" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <img src="<?= base_url('assets/img/icon-11.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('my_wallet');?></span>
        </a>
        <div id="collapseUtilities" class="collapse <?= uri_string() == 'user/mywalletusdt' || uri_string() == 'user/mywalletmtm' || uri_string() == 'user/mywalletfil' || uri_string() == 'user/mywalletkrp' || uri_string() == 'user/withdrawal_usdt' || uri_string() == 'user/transfer_bonus_usdt' || uri_string() == 'user/mywalletusdt/bonus' || uri_string() == 'user/mywalletfil/bonus' || uri_string() == 'user/withdrawal_fil' || uri_string() == 'user/transfer_bonus_fil' || uri_string() == 'user/withdrawal_krp' || uri_string() == 'user/withdrawal_mtm' || uri_string() == 'user/transfer_bonus_krp' || uri_string() == 'user/mywalletkrp/bonus' ? 'show' : '';?>" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item <?= uri_string() == 'user/mywalletfil' || uri_string() == 'user/mywalletfil/bonus' || uri_string() == 'user/withdrawal_fil' || uri_string() == 'user/transfer_bonus_fil' ? 'active' : '';?>" href="<?= base_url('user/mywalletfil'); ?>">
                    <img class="img-balance" src="<?= base_url('assets/img/filcoin_logo.png') ?>" alt="img" style="width: 16px;"> Filecoin
                </a>
                <a class="collapse-item <?= uri_string() == 'user/mywalletmtm' || uri_string() == 'user/mywalletmtm/bonus' || uri_string() == 'user/withdrawal_mtm' || uri_string() == 'user/transfer_bonus_mtm' ? 'active' : '';?>" href="<?= base_url('user/mywalletmtm'); ?>">
                    <img class="img-balance" src="<?= base_url('assets/img/mtm_logo.png') ?>" alt="img" style="width: 16px;"> MTM
                </a>
                <a class="collapse-item <?= uri_string() == 'user/mywalletusdt' || uri_string() == 'user/withdrawal_usdt' || uri_string() == 'user/transfer_bonus_usdt' || uri_string() == 'user/mywalletusdt/bonus' ? 'active' : '';?>" href="<?= base_url('user/mywalletusdt'); ?>">
                    <img class="img-balance" src="<?= base_url('assets/img/icon-usdt.png') ?>" alt="img" style="width: 16px;"> USDT
                </a>
                <a class="collapse-item <?= uri_string() == 'user/mywalletkrp' || uri_string() == 'user/withdrawal_krp' || uri_string() == 'user/transfer_bonus_krp' || uri_string() == 'user/mywalletkrp/bonus' ? 'active' : '';?>" href="<?= base_url('user/mywalletkrp'); ?>">
                    <img class="img-balance" src="<?= base_url('assets/img/krp_logo.png') ?>" alt="img" style="width: 16px;"> KRP
                </a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Payment History -->
    <li class="nav-item <?= uri_string() == 'user/history' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/history'); ?>">
            <img src="<?= base_url('assets/img/icon-12.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('payment_history');?></span></a>
    </li>

    <!-- Nav Item - Network -->
    <li class="nav-item <?= $this->uri->segment(2) == 'network' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/network'); ?>">
            <img src="<?= base_url('assets/img/icon-13.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('network');?></span></a>
    </li>

    <!-- Nav Item - Sponsor -->
    <li class="nav-item <?= $this->uri->segment(2) == 'sponsornet' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/sponsornet'); ?>">
            <img src="<?= base_url('assets/img/icon-14.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('recommended');?></span></a>
    </li>

    <!-- Nav Item - My Team -->
    <li class="nav-item <?= uri_string() == 'user/myteam' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/myteam'); ?>">
            <img src="<?= base_url('assets/img/icon-15.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('my_team');?></span></a>
    </li>

    <!-- Nav Item -Achievements Level FM -->
    <li class="nav-item <?= uri_string() == 'user/achievement' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/achievement'); ?>">
            <img src="<?= base_url('assets/img/icon 46-42.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('achievements');?></span></a>
    </li>

    <!-- Nav Item - Information Detail -->
    <li class="nav-item <?= uri_string() == 'user/information_detail' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/information_detail'); ?>">
            <img src="<?= base_url('assets/img/icon-16.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('information_detail');?></span></a>
    </li>


    <!-- Nav Item - Marketing Plan -->
    <li class="nav-item <?= uri_string() == 'user/marketing_plan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/marketing_plan'); ?>">
            <img src="<?= base_url('assets/img/icon-17.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('marketing_plan');?></span></a>
    </li>

    <!-- Nav Item - Market Trade -->
    <li class="nav-item <?= uri_string() == 'user/market_trade' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/market_trade'); ?>">
            <img src="<?= base_url('assets/img/icon-18.png'); ?>" width="15px">&nbsp;
            <span><?= $this->lang->line('market_trade');?></span></a>
    </li>
</ul>
<!-- End of Sidebar -->