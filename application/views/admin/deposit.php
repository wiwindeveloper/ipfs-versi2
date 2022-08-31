<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">Deposit</h1>

    <?= $this->session->flashdata('message'); ?>

    <!-- wallet -->
    <?= $this->session->flashdata('message_min_wd'); ?>
    <div class="col-lg-12 col-md-12 mb-4 px-0">
        <div class="card shadow h-100 py-2">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Wallet Address</h6>
            </div>
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 mb-0 text-gray-800 text-left">
                            <form action="<?= base_url('admin/editWalletAddress'); ?>" method="post">
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <label style="font-size: 16px;" for="wallet_fil">Wallet FIL</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="wallet_fil" name="wallet_fil" value="<?= $wallet_address['filecoin']; ?>" placeholder="Wallet FIL">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_fil">Save</button>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label style="font-size: 16px;" for="wallet_mtm">Wallet MTM</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="wallet_mtm" name="wallet_mtm" value="<?= $wallet_address['mtm']; ?>" placeholder="Wallet MTM">
                                        </div>
                                        <button class="btn btn-primary w-100 mt-2" name="save_mtm">Save</button>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label style="font-size: 16px;" for="wallet_zenx">Wallet ZENX</label>
                                        <div class="input-group">
                                            <input type=" text" class="form-control" id="wallet_zenx" name="wallet_zenx" value="<?= $wallet_address['zenx']; ?>" placeholder="Wallet ZENX">
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


    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User ID</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>TXID</th>
                            <th>Image</th>
                            <th>Note</th>
                            <th>Confirm</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($deposit as $row_deposit) { ?>

                            <tr>
                                <td><?= date('Y/m/d H:i:s', $row_deposit->datecreate); ?></td>
                                <td><?= $row_deposit->username;  ?></td>
                                <td>
                                    <?php
                                    if ($row_deposit->type_coin == 1) {
                                        echo "FIL";
                                    } elseif ($row_deposit->type_coin == 2) {
                                        echo "MTM";
                                    } elseif ($row_deposit->type_coin == 3) {
                                        echo "ZENX";
                                    }
                                    ?>
                                </td>
                                <td><?= $row_deposit->coin; ?></td>
                                <td><?= $row_deposit->txid; ?></td>
                                <td>
                                    <?php
                                        if($row_deposit->image != null)
                                        {
                                    ?>
                                        <a href="#" id="<?= $row_deposit->image; ?>" onclick="event.preventDefault(); show_image_deposit(this);">
                                            <img src="<?= base_url('assets/deposit/').$row_deposit->image;?>" width="100px">
                                        </a>
                                        <!-- <a href="<?= base_url('assets/deposit/').$row_deposit->image;?>" target="_blank">
                                            <img src="<?= base_url('assets/deposit/').$row_deposit->image;?>" width="100px">
                                        </a> -->
                                    <?php
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row_deposit->is_confirm == 0) {
                                    ?>
                                        <form method="post" action="<?= base_url('admin/saveNoteDeposit'); ?>">
                                            <textarea class="form-control" name="note" cols="15" rows="5" style="width: auto;"><?= $row_deposit->note; ?></textarea>
                                            <input type="hidden" name="id_deposit" value="<?= $row_deposit->id; ?>">
                                            <button type="submit" class="btn btn-info btn-sm">
                                                Send Note
                                            </button>
                                        </form>
                                    <?php
                                    } else {
                                    ?>
                                        <?= $row_deposit->note; ?>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    if ($row_deposit->is_confirm == 0) {
                                    ?>
                                        <span data-toggle="tooltip" data-placement="left" title="Confirm deposit">
                                            <a href="#" class="btn btn-success btn-circle btn-sm" id="<?= $row_deposit->id; ?>" onclick="event.preventDefault(); show_confirm_deposit(this);">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#edit_modal<?= $row_deposit->id ?>">Edit</a>
                                        <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#delete_modal<?= $row_deposit->id ?>">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Confirm Modal-->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="confirmModalBody"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="#" id="confirmLink">OK</a>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal-->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="imageModalBody"></div>
        </div>
    </div>
</div>

<?php
foreach ($deposit as $row_deposit) {
?>
    <div class="modal fade" id="edit_modal<?= $row_deposit->id ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Deposit</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="<?php echo base_url('admin/editDeposit') ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username">ID</label>
                            <input type="text" class="form-control bg-white" name="username" id="username" value="<?php echo $row_deposit->username ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="coin">Coin</label>
                            <select class="form-control form-control " id="type_coin" name="type_coin">
                                <option class="text-black" value="1" <?= $row_deposit->type_coin == '1' ? 'selected' : '' ?>>FIL</option>
                                <option class="text-black" value="2" <?= $row_deposit->type_coin == '2' ? 'selected' : '' ?>>MTM</option>
                                <option class="text-black" value="3" <?= $row_deposit->type_coin == '3' ? 'selected' : '' ?>>ZENX</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="coin">Quantity</label>
                            <input type="text" class="form-control" name="coin" id="coin" value="<?php echo $row_deposit->coin ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_deposit" value="<?php echo $row_deposit->id; ?>">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        <button class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_modal<?= $row_deposit->id ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Deposit</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="<?php echo base_url('admin/deleteDeposit') ?>">
                    <div class="modal-body">
                        <p>Are you sure want to delete deposit from <b><?php echo $row_deposit->username; ?></b>?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_deposit" value="<?php echo $row_deposit->id; ?>">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        <button class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>