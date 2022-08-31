<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar toggled sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <button id="sidebarToggleTop" class="btn btn-outline-secondary rounded-circle d-md-none mr-3 text-white mx-auto mt-3" style="width: min-content;">
        ×
    </button>
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= uri_string() == 'user' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user'); ?>">
            <i class="fas fa-home"></i>
            <span>My Home</span></a>
    </li>
    
    <li class="nav-item <?= uri_string() == 'admin/news_announcement' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/news_announcement'); ?>">
            <i class="fas fa-newspaper"></i>
            <span>News</span></a>
    </li>

    <li class="nav-item <?= uri_string() == 'admin/allUsers' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/allUsers'); ?>">
            <i class="fas fa-users"></i>
            <span>Users</span></a>
    </li>

    <li class="nav-item <?= uri_string() == 'admin/allUserBonus' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/allUserBonus'); ?>">
            <i class="fas fa-users"></i>
            <span>User Bonus</span></a>
    </li>
    
    <li class="nav-item <?= uri_string() == 'admin/allNetwork' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/allNetwork'); ?>">
            <i class="fas fa-network-wired"></i>
            <span>All Network</span></a>
    </li>

    <li class="nav-item <?= uri_string() == 'admin/basecamp' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/basecamp'); ?>">
            <i class="fas fa-campground"></i>
            <span>Basecamp</span></a>
    </li>

    <li class="nav-item <?= uri_string() == 'admin/packagePurchase' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/packagePurchase'); ?>">
            <i class="fas fa-globe-europe"></i>
            <span>Bonus Global</span></a>
    </li>
    
    <li class="nav-item <?= uri_string() == 'admin/packageMining' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/packageMining'); ?>">
            <i class="fas fa-shopping-cart"></i>
            <span>Package Purchase</span></a>
    </li>

    <!-- Nav Item - Payment History -->
    <!-- <li class="nav-item <?= uri_string() == 'admin/payment' ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url('admin/payment'); ?>">
        <i class="fas fa-credit-card"></i>
        <span>Payment</span></a>
</li> -->

    <!-- Nav Item - Deposit -->
    <li class="nav-item <?= uri_string() == 'admin/deposit' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/deposit'); ?>">
            <i class="fas fa-credit-card"></i>
            <span>Deposit</span></a>
    </li>

    <!-- Nav Item - Mining Per day -->
    <li class="nav-item <?= uri_string() == 'admin/mining' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/mining'); ?>">
            <i class="fas fa-chart-bar"></i>
            <span>Mining</span></a>
    </li>

    <!-- Nav Item - Limit Mining -->
    <li class="nav-item <?= uri_string() == 'admin/limitMining' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/limitMining'); ?>">
            <i class="fas fa-stopwatch"></i>
            <span>Limit Mining</span></a>
    </li>

    <!-- Nav Item - Payment History -->
    <!-- <li class="nav-item <?= uri_string() == 'admin/wallet' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/wallet'); ?>">
            <i class="fas fa-wallet"></i>
            <span>Wallet</span></a>
    </li> -->

    <li class="nav-item <?= uri_string() == 'admin/withdrawal' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/withdrawal'); ?>">
            <i class="fas fa-wallet"></i>
            <span>Withdrawal</span></a>
    </li>

    <li class="nav-item <?= uri_string() == 'admin/marketPrice' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/marketPrice'); ?>">
            <i class="fas fa-dollar-sign"></i>
            <span> Market Price</span></a>
    </li>

    <li class="nav-item <?= uri_string() == 'admin/iklanHome' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/iklanHome'); ?>">
            <i class="fas fa-ad"></i>
            <span>Iklan Home</span></a>
    </li>

    <li class="nav-item <?= uri_string() == 'admin/message' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/message'); ?>">
            <i class="fas fa-envelope"></i>
            <span>Message</span></a>
    </li>
</ul>
<!-- End of Sidebar -->