<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 text-white">Price Coin</h1>

    <?= $this->session->flashdata('message'); ?>

    <!-- <form action="<?= base_url('admin/marketPrice'); ?>" method="post">
        <div class="row" style="padding-inline:0.50rem;">
            <div class="input-group px-1 mb-3" style="width: 30%;">
                <input type=" text" class="form-control" id="filecoin" name="filecoin" placeholder="Price Filecoin" onkeypress="return (event.charCode == 46 || event.charCode < 31 || (event.charCode > 47 && event.charCode < 58))">
            </div>
            <div class="input-group px-1 mb-3" style="width: 30%;">
                <input type=" text" class="form-control" id="mtm" name="mtm" placeholder="Price MTM" readonly>
            </div>
            <div class="input-group px-1 mb-3" style="width: 30%;">
                <input type=" text" class="form-control" id="zenx" name="zenx" placeholder="Price ZENX">
            </div>
            <div class="input-group px-1 mb-3" style="width: 10%;">
                <button class="btn btn-primary w-100" type="submit" name="submit">Save</button>
            </div>
        </div>
    </form> -->

    <div class="card shadow mb-4">
        <div class="card-header bg-white">
            <form action="<?= base_url('admin/marketPrice'); ?>" method="post">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group my-2">
                                    <input type="text" class="form-control" id="filecoin" name="filecoin" placeholder="Price Filecoin" onkeypress="return (event.charCode == 46 || event.charCode < 31 || (event.charCode > 47 && event.charCode < 58))">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group my-2">
                                    <input type="text" class="form-control bg-white" id="mtm" name="mtm" placeholder="Price MTM" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="input-group my-2">
                                    <input type="text" class="form-control" id="zenx" name="zenx" placeholder="Price ZENX">
                                </div>
                            </div>
                            <div class="col-lg-4">
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
                <div class="col-lg-4 col-sm-12">
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
                                                <td><?= $row->filecoin ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered display" id="table2" width="100%" cellspacing="0">
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
                                                <td><?= $row->mtm ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered display" id="table3" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Price ZENX</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($price_coin as $row) : ?>
                                            <tr>
                                                <td><?= date('Y-m-d H:i:s', $row->time); ?></td>
                                                <td><?= $row->zenx ?></td>
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
                                    <div class="col-lg-4 mb-2">
                                        <label style="font-size: 16px;" for="filecoin_min">Minimum Withdrawal FIL</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="filecoin_min" name="filecoin_min" value="<?= $min_withdrawal['filecoin']; ?>" placeholder="Minimum Withdrawal FIL">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_fil">Save</button>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label style="font-size: 16px;" for="mtm_min">Minimum Withdrawal MTM</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="mtm_min" name="mtm_min" value="<?= $min_withdrawal['mtm']; ?>" placeholder="Minimum Withdrawal MTM">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_mtm">Save</button>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label style="font-size: 16px;" for="zenx_min">Minimum Withdrawal ZENX</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="zenx_min" name="zenx_min" value="<?= $min_withdrawal['zenx']; ?>" placeholder="Minimum Withdrawal ZENX">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_zenx">Save</button>
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
                                    <div class="col-lg-4 mb-2">
                                        <label style="font-size: 16px;" for="filecoin_fee">Fee Withdrawal FIL (%)</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="filecoin_fee" name="filecoin_fee" value="<?= $min_withdrawal['fee_filecoin']; ?>" placeholder="Fee Withdrawal FIL">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_filecoin_fee">Save</button>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label style="font-size: 16px;" for="mtm_fee">Fee Withdrawal MTM (%)</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="mtm_fee" name="mtm_fee" value="<?= $min_withdrawal['fee_mtm']; ?>" placeholder="Fee Withdrawal MTM">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_mtm_fee">Save</button>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label style="font-size: 16px;" for="zenx_fee">Fee Withdrawal ZENX (%)</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="zenx_fee" name="zenx_fee" value="<?= $min_withdrawal['fee_zenx']; ?>" placeholder="Fee Withdrawal ZENX">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_zenx_fee">Save</button>
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