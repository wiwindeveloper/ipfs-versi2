<!-- Begin Page Content -->
<div class="container-fluid scroll-content main-container">
    <!-- <input id="myInput" value=""> -->

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">
        All Network
    </h1>
    <div class="v-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group input-group-joined">
            <span class="input-group-text">
                <img src="<?= base_url('assets/img/icon-03.png'); ?>" alt="icon" width="20px">
            </span>
            <input class="form-control border-0 small" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" id="myInputMobile">
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md-8">
            <div class="mobile-btn">
                <span class="btn btn-1box btn-circle btn-md text-white" style="cursor:default;">
                    1
                </span>
            </div>
            <div class="mobile-btn">
                <span class="btn btn-3box btn-circle btn-md text-white" style="cursor:default;">
                    3
                </span>
            </div>
            <div class="mobile-btn">
                <span class="btn btn-9box btn-circle btn-md text-white" style="cursor:default;">
                    9
                </span>
            </div>
            <div class="mobile-btn">
                <span class="btn btn-15box btn-circle btn-md text-white" style="cursor:default;">
                    15
                </span>
            </div>
            <div class="mobile-btn">
                <span class="btn btn-30box btn-circle btn-md text-white" style="cursor:default;">
                    30
                </span>
            </div>
            <div class="mobile-btn">
                <span class="btn btn-60box btn-circle btn-md text-white" style="cursor:default;">
                    60
                </span>
            </div>
            <div class="mobile-btn">
                <span class="btn btn-120box btn-circle btn-md text-white" style="cursor:default;">
                    120
                </span>
            </div>
            <div class="mobile-btn">
                <span class="btn btn-300box btn-circle btn-md text-white" style="cursor:default;">
                    300
                </span>
            </div>
            <div class="mobile-btn">
                <span class="btn btn-540box btn-circle btn-md text-white" style="cursor:default;">
                    540
                </span>
            </div>
        </div>
        <div class="col-md-4 network-level">
            <div class="form-group form-inline">
                <label for="sel1" class="text-white mb-1">Type limit level: &nbsp;</label>
                <input type="number" min="1" id="sel1" class="form-control" placeholder="Your max level is <?= $limitLevel;?>">
            </div>
        </div>
        <div class="col-md-12 col-sm-12 mt-5" id="">
            <div class="tree zoom dragscroll" style="width: auto; height:90vh;">
                <?= $network; ?>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->