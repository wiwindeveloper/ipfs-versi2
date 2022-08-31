<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">Package Purchase</h1>

    <?= $this->session->flashdata('message'); ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Package Mining</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tablenotorder" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center">Name</th>
                            <th colspan="3" class="text-center">Price</th>
                            <th rowspan="2" class="text-center">Action</th>
                        </tr>
                        <tr>
                            <th>FILECOIN</th>
                            <th>MTM</th>
                            <th>ZENX</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($mining as $row_mining)
                            {
                                ?>
                            <tr>
                                <td><?= $row_mining->name; ?></td>
                                <form action="<?= base_url('admin/savePackageMining/') ?>" method="post">
                                    <td><input class="form-control" type='text' name="miningfil" value="<?= $row_mining->fil; ?>"></td>
                                    <td><input class="form-control" type='text' name="miningmtm" value="<?= $row_mining->mtm; ?>"></td>
                                    <td><input class="form-control" type='text' name="miningzenx" value="<?= $row_mining->price_zenx; ?>"></td>
                                    <td>
                                        <button type="submit" class="btn btn-info btn-sm">
                                            Save
                                        </button>
                                    </td>
                                </form>
                            </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Package Tour</h6>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Tour Korea</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Tour Bali</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="table-responsive mt-5">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">Name</th>
                                    <th colspan="4" class="text-center">Price</th>
                                    <th rowspan="2" class="text-center">Action</th>
                                </tr>
                                <tr>
                                    <th>FILECOIN</th>
                                    <th>MTM</th>
                                    <th>ZENX</th>
                                    <th>USDT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($tour_korea as $row_tour_korea)
                                    {
                                        ?>
                                    <tr>
                                        <td><?= $row_tour_korea->name; ?></td>
                                        <form action="<?= base_url('admin/savePackageTour/').$row_tour_korea->id; ?>" method="post">
                                            <td><input class="form-control" type='text' name="tourfil" value="<?= $row_tour_korea->price_fil; ?>"></td>
                                            <td><input class="form-control" type='text' name="tourmtm" value="<?= $row_tour_korea->price_mtm; ?>"></td>
                                            <td><input class="form-control" type='text' name="tourzenx" value="<?= $row_tour_korea->price_zenx; ?>"></td>
                                            <td><input class="form-control" type='text' name="tourusdt" value="<?= $row_tour_korea->price_usdt; ?>"></td>
                                            <td>
                                                <button type="submit" class="btn btn-info btn-sm">
                                                    Save
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive mt-5">
                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">Name</th>
                                    <th colspan="4" class="text-center">Price</th>
                                    <th rowspan="2" class="text-center">Action</th>
                                </tr>
                                <tr>
                                    <th>FILECOIN</th>
                                    <th>MTM</th>
                                    <th>ZENX</th>
                                    <th>USDT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($tour_bali as $row_tour_bali)
                                    {
                                        ?>
                                    <tr>
                                        <td><?= $row_tour_bali->name; ?></td>
                                        <form action="<?= base_url('admin/savePackageTour/').$row_tour_bali->id; ?>" method="post">
                                            <td><input class="form-control" type='text' name="tourfil" value="<?= $row_tour_bali->price_fil; ?>"></td>
                                            <td><input class="form-control" type='text' name="tourmtm" value="<?= $row_tour_bali->price_mtm; ?>"></td>
                                            <td><input class="form-control" type='text' name="tourzenx" value="<?= $row_tour_bali->price_zenx; ?>"></td>
                                            <td><input class="form-control" type='text' name="tourusdt" value="<?= $row_tour_bali->price_usdt; ?>"></td>
                                            <td>
                                                <button type="submit" class="btn btn-info btn-sm">
                                                    Save
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->