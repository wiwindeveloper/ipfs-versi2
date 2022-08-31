<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">Withdrawal</h1>

    <?= $this->session->flashdata('message'); ?>

    <!-- filecoin -->
    <div class="text-center mb-2 logo-index">
        <img src="<?= base_url('assets/img/filcoin_logo.png'); ?>" width="50px" class="my-1">
        <span style="font-size:30px;" class="align-middle text-white">&nbsp;FIL</span>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="table1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Jumlah</th>
                            <th>Wallet</th>
                            <th>Note</th>
                            <th>TXID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($withdrawal_filecoin as $row_withdrawal) : ?>
                            <tr>
                                <td>
                                    <?= date('Y-m-d H:i:s', $row_withdrawal->datecreate); ?>
                                </td>
                                <td><?= $row_withdrawal->username; ?></td>
                                <td><?= $row_withdrawal->total; ?></td>
                                <td><?= $row_withdrawal->wallet_address; ?></td>
                                <td>
                                    <form method="post" action="<?= base_url('admin/saveNoteWithdrawal'); ?>">
                                        <textarea class="form-control" name="note" cols="15" rows="5" style="width: auto;"><?= $row_withdrawal->note; ?></textarea>
                                        <input type="hidden" name="id_wd" value="<?= $row_withdrawal->id; ?>">
                                        <button type="submit" class="btn btn-info btn-sm">
                                            Send Note
                                        </button>
                                    </form>
                                </td>
                                <?php if ($row_withdrawal->txid == NULL) : ?>
                                    <td>
                                        <form method="post" action="<?= base_url('admin/withdrawalSendTXID') ?>">
                                            <input type="hidden" name="id" value="<?= $row_withdrawal->id; ?>">
                                            <input type="hidden" name="username" value="<?= $row_withdrawal->username; ?>">
                                            <div class="input-group withdrawal-txid">
                                                <input type="text" class="form-control form-control-sm" id="txid" name="txid" placeholder="Input TXID">
                                                <div class="input-group-append">
                                                    <input class="btn btn-primary btn-sm" type="submit" name="submit" id="save">
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                <?php else : ?>
                                    <td><?= $row_withdrawal->txid; ?></td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- mtm -->
    <div class="text-center my-2 mt-5 logo-index">
        <img src="<?= base_url('assets/img/mtm_logo.png'); ?>" width="50px" class="my-1">
        <span style="font-size:30px;" class="align-middle text-white">&nbsp;MTM</span>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <!-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> -->
                <table class="table table-bordered display" id="table2" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Jumlah</th>
                            <th>Wallet</th>
                            <th>Note</th>
                            <th>TXID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($withdrawal_mtm as $row_withdrawal) : ?>
                            <tr>
                                <td>
                                    <?= date('Y-m-d H:i:s', $row_withdrawal->datecreate); ?>
                                </td>
                                <td><?= $row_withdrawal->username; ?></td>
                                <td><?= $row_withdrawal->total; ?></td>
                                <td><?= $row_withdrawal->wallet_address; ?></td>
                                <td>
                                    <form method="post" action="<?= base_url('admin/saveNoteWithdrawal'); ?>">
                                        <textarea class="form-control" name="note" cols="15" rows="5" style="width: auto;"><?= $row_withdrawal->note; ?></textarea>
                                        <input type="hidden" name="id_wd" value="<?= $row_withdrawal->id; ?>">
                                        <button type="submit" class="btn btn-info btn-sm">
                                            Send Note
                                        </button>
                                    </form>
                                </td>
                                <?php if ($row_withdrawal->txid == NULL) : ?>
                                    <td>
                                        <form method="post" action="<?= base_url('admin/withdrawalSendTXID') ?>">
                                            <input type="hidden" name="id" value="<?= $row_withdrawal->id; ?>">
                                            <input type="hidden" name="username" value="<?= $row_withdrawal->username; ?>">
                                            <div class="input-group withdrawal-txid">
                                                <input type="text" class="form-control form-control-sm" id="txid" name="txid" placeholder="Input TXID">
                                                <div class="input-group-append">
                                                    <input class="btn btn-primary btn-sm" type="submit" name="submit" id="save">
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                <?php else : ?>
                                    <td><?= $row_withdrawal->txid; ?></td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- zenx -->
    <div class="text-center my-2 mt-5 logo-index">
        <img src="<?= base_url('assets/img/zenith_logo.png'); ?>" width="50px" class="my-1">
        <span style="font-size:30px;" class="align-middle text-white">&nbsp;ZENX</span>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <!-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> -->
                <table class="table table-bordered display" id="table2" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Jumlah</th>
                            <th>Wallet</th>
                            <th>Note</th>
                            <th>TXID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($withdrawal_zenx as $row_withdrawal) : ?>
                            <tr>
                                <td>
                                    <?= date('Y-m-d H:i:s', $row_withdrawal->datecreate); ?>
                                </td>
                                <td><?= $row_withdrawal->username; ?></td>
                                <td><?= $row_withdrawal->total; ?></td>
                                <td><?= $row_withdrawal->wallet_address; ?></td>
                                <td>
                                    <form method="post" action="<?= base_url('admin/saveNoteWithdrawal'); ?>">
                                        <textarea class="form-control" name="note" cols="15" rows="5" style="width: auto;"><?= $row_withdrawal->note; ?></textarea>
                                        <input type="hidden" name="id_wd" value="<?= $row_withdrawal->id; ?>">
                                        <button type="submit" class="btn btn-info btn-sm">
                                            Send Note
                                        </button>
                                    </form>
                                </td>
                                <?php if ($row_withdrawal->txid == NULL) : ?>
                                    <td>
                                        <form method="post" action="<?= base_url('admin/withdrawalSendTXID') ?>">
                                            <input type="hidden" name="id" value="<?= $row_withdrawal->id; ?>">
                                            <input type="hidden" name="username" value="<?= $row_withdrawal->username; ?>">
                                            <div class="input-group withdrawal-txid">
                                                <input type="text" class="form-control form-control-sm" id="txid" name="txid" placeholder="Input TXID">
                                                <div class="input-group-append">
                                                    <input class="btn btn-primary btn-sm" type="submit" name="submit" id="save">
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                <?php else : ?>
                                    <td><?= $row_withdrawal->txid; ?></td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->