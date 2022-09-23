<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-white">Price Coin</h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
        <div class="card-header bg-white">
            <form action="<?= base_url('admin/marketPrice'); ?>" method="post">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="input-group my-2">
                                    <input type="text" class="form-control" id="filecoin" name="filecoin" placeholder="Price Filecoin">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group my-2">
                                    <input type="text" class="form-control" id="mtm" name="mtm" placeholder="Price MTM">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group my-2">
                                    <input type="text" class="form-control bg-white" id="usdt" name="usdt" placeholder="Price USDT">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group my-2">
                                    <input type="text" class="form-control" id="krp" name="krp" placeholder="Price KRP">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group my-2">
                                    <button class="btn btn-primary w-100" type="submit" name="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-sm-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered display" id="table1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Price FIL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($price_coin as $row) : ?>
                                            <tr>
                                                <td><?= date('Y-m-d H:i:s', $row->time); ?></td>
                                                <td><?= $row->filecoin; ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered display" id="table2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Price USDT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($price_coin as $row) : ?>
                                            <tr>
                                                <td><?= date('Y-m-d H:i:s', $row->time); ?></td>
                                                <td><?= $row->usdt; ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered display" id="table3" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Price KRP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($price_coin as $row) : ?>
                                            <tr>
                                                <td><?= date('Y-m-d H:i:s', $row->time); ?></td>
                                                <td><?= $row->krp ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered display" id="table3" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Price MTM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($price_coin as $row) : ?>
                                            <tr>
                                                <td><?= date('Y-m-d H:i:s', $row->time); ?></td>
                                                <td><?= $row->mtm; ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1 class="h3 mt-4 text-white">Minimum Withdrawal</h1>
    <?= $this->session->flashdata('message_min_wd'); ?>
    <div class="col-lg-12 col-md-12 mb-4 px-0">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 mb-0 text-gray-800 text-left">
                            <form action="<?= base_url('admin/marketPrice'); ?>" method="post">
                                <div class="row">
                                    <div class="col-lg-3 mb-2">
                                        <label style="font-size: 16px;" for="filecoin_min">Minimum Withdrawal FIL</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="filecoin_min" name="filecoin_min" value="<?= $min_withdrawal['filecoin']; ?>" placeholder="Minimum Withdrawal FIL">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_fil">Save</button>
                                    </div>
                                    <div class="col-lg-3 mb-2">
                                        <label style="font-size: 16px;" for="mtm_min">Minimum Withdrawal MTM</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="mtm_min" name="mtm_min" value="<?= $min_withdrawal['mtm']; ?>" placeholder="Minimum Withdrawal MTM">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_mtm">Save</button>
                                    </div>
                                    <div class="col-lg-3 mb-2">
                                        <label style="font-size: 16px;" for="usdt_min">Minimum Withdrawal USDT</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="usdt_min" name="usdt_min" value="<?= $min_withdrawal['usdt']; ?>" placeholder="Minimum Withdrawal USDT">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_usdt">Save</button>
                                    </div>
                                    <div class="col-lg-3 mb-2">
                                        <label style="font-size: 16px;" for="krp_min">Minimum Withdrawal KRP</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="krp_min" name="krp_min" value="<?= $min_withdrawal['krp']; ?>" placeholder="Minimum Withdrawal KRP">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_krp">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1 class="h3 mt-5 text-white">Fee Withdrawal</h1>
    <?= $this->session->flashdata('message_fee_wd'); ?>
    <div class="col-lg-12 col-md-12 mb-4 px-0">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 mb-0 text-gray-800 text-left">
                            <form action="<?= base_url('admin/marketPrice'); ?>" method="post">
                                <div class="row">
                                    <div class="col-lg-3 mb-2">
                                        <label style="font-size: 16px;" for="filecoin_fee">Fee Withdrawal FIL (%)</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="filecoin_fee" name="filecoin_fee" value="<?= $min_withdrawal['fee_filecoin']; ?>" placeholder="Fee Withdrawal FIL">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_filecoin_fee">Save</button>
                                    </div>
                                    <div class="col-lg-3 mb-2">
                                        <label style="font-size: 16px;" for="mtm_fee">Fee Withdrawal MTM (%)</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="mtm_fee" name="mtm_fee" value="<?= $min_withdrawal['fee_mtm']; ?>" placeholder="Fee Withdrawal MTM">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_mtm_fee">Save</button>
                                    </div>
                                    <div class="col-lg-3 mb-2">
                                        <label style="font-size: 16px;" for="usdt_fee">Fee Withdrawal USDT (%)</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="usdt_fee" name="usdt_fee" value="<?= $min_withdrawal['fee_usdt']; ?>" placeholder="Fee Withdrawal USDT">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_usdt_fee">Save</button>
                                    </div>
                                    <div class="col-lg-3 mb-2">
                                        <label style="font-size: 16px;" for="krp_fee">Fee Withdrawal KRP (%)</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="krp_fee" name="krp_fee" value="<?= $min_withdrawal['fee_krp']; ?>" placeholder="Fee Withdrawal KRP">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_krp_fee">Save</button>
                                    </div>
                                </div>
                            </form>
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