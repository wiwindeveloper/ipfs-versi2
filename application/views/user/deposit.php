<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800 text-center">Deposit</h1> -->
    <?= $this->session->flashdata('message'); ?>
    <ul class="nav nav-tabs tab-deposit justify-content-center" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link <?= $currentTab == 'fil' ? 'active' : ''; ?>" id="filecoin-tab" data-toggle="tab" href="#filecoin" role="tab" aria-controls="filecoin" aria-selected="true">
                FIL
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $currentTab == 'mtm' ? 'active' : ''; ?>" id="mtm-tab" data-toggle="tab" href="#mtm" role="tab" aria-controls="filecoin" aria-selected="false">
                MTM
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $currentTab == 'usdt' ? 'active' : ''; ?>" id="usdt-tab" data-toggle="tab" href="#usdt" role="tab" aria-controls="usdt" aria-selected="false">
                USDT
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $currentTab == 'krp' ? 'active' : ''; ?>" id="krp-tab" data-toggle="tab" href="#krp" role="tab" aria-controls="krp" aria-selected="false">
                KRP
            </a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade  <?= $currentTab == 'fil' ? 'show active' : ''; ?>" id="filecoin" role="tabpanel" aria-labelledby="filecoin-tab">
            <div class="row">
                <div class="col-md-12">
                    <form class="payment" method="post" action="<?= base_url('user/deposit/1'); ?>" enctype="multipart/form-data">
                        <div class="payment text-center text-white">
                            <div id="qr_code">
                                <p><?= $this->lang->line('address_wallet_payment');?></p>
                                <p><img src="<?= base_url('assets/img/wallet_fil_qr.png'); ?>" alt="" width="200"></p>
                                <p class="code-text">
                                    <b><?= $wallet_address['filecoin']; ?></b>
                                </p>
                                <p class="note"><?= $this->lang->line('note');?>: <?= $this->lang->line('copy_txid');?></p>
                                <p class="note">* <?= $this->lang->line('check_txid');?></p>
                                <p class="note">* <?= $this->lang->line('check_payment_amount');?></p>

                                <div class="col-md-6 m-auto">
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" id="txid" name="txid" value="<?= set_value('txid'); ?>" placeholder="<?= $this->lang->line('placehold_txid');?>">
                                        <?= form_error('txid', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 m-auto">
                                    <!-- <div class="form-group mt-3"> -->
                                    <div class="form-custom-img">
                                        <label for="proof-fil" class="customform-control"><?= $this->lang->line('placehold_proof');?></label>
                                        <input type='file' placeholder="Enter proof of delivery" name='userfile' size='20'  id="proof-fil" onchange="pressed()" /><span id='val-fil' class="val"></span>
                                        <span id='button-image-fil' class="button-image"><?= $this->lang->line('select_file');?></span>
                                    </div>
                                </div>

                                <div class="col-md-6 m-auto">
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" id="coinqty" name="coinqty" value="<?= set_value('coinqty'); ?>" placeholder="<?= $this->lang->line('placehold_coin_qty');?>">
                                        <?= form_error('coinqty', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="p-5">
                                        <input type="hidden" name="typecoin" value="1">
                                        <input type="hidden" name="iddeposit" value="<?= $currentTab == 'fil' ? $id_deposit : ''; ?>">
                                        <input type="hidden" name="id_notif" value="<?= $currentTab == 'fil' ? $id_notif : ''; ?>">
                                        <button type="submit" class="btn btn-ok btn-block wd-100-pr">
                                        <?= $this->lang->line('deposit_request');?>
                                        </button>
                                    </div>
                                    <div class="p-5">
                                        <a href="<?= base_url('user/cancelPayment'); ?>" class="btn btn-cancel btn-block wd-100-pr" data-toggle="modal" data-target="#cancelModal">
                                        <?= $this->lang->line('cancel');?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade <?= $currentTab == 'mtm' ? 'show active' : ''; ?>" id="mtm" role="tabpanel" aria-labelledby="mtm-tab">
            <div class="row">
                <div class="col-md-12">
                    <form class="payment" method="post" action="<?= base_url('user/deposit/2'); ?>" enctype="multipart/form-data">
                        <div class="payment text-center text-white">
                            <div id="qr_code">
                                <p><?= $this->lang->line('address_wallet_payment');?></p>
                                <p><img src="<?= base_url('assets/img/wallet_mtm_qr.png'); ?>" alt="" width="200"></p>
                                <p class="code-text">
                                    <b><?= $wallet_address['mtm']; ?></b>
                                </p>
                                <p class="note"><?= $this->lang->line('note');?>: <?= $this->lang->line('copy_txid');?></p>
                                <p class="note">* <?= $this->lang->line('check_txid');?></p>
                                <p class="note">* <?= $this->lang->line('check_payment_amount');?></p>

                                <div class="col-md-6 m-auto">
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" id="txid" name="txid" value="<?= set_value('txid'); ?>" placeholder="<?= $this->lang->line('placehold_txid');?>">
                                        <?= form_error('txid', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 m-auto">
                                    <!-- <div class="form-group mt-3"> -->
                                    <div class="form-custom-img">
                                        <label for="proof-mtm" class="customform-control"><?= $this->lang->line('placehold_proof');?></label>
                                        <input type='file' placeholder="Enter proof of delivery" name='userfile' size='20'  id="proof-mtm" onchange="pressed()" /><span id='val-mtm' class="val"></span>
                                        <span id='button-image-mtm' class="button-image"><?= $this->lang->line('select_file');?></span>
                                    </div>
                                </div>

                                <div class="col-md-6 m-auto">
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" id="coinqty" name="coinqty" value="<?= set_value('coinqty'); ?>" placeholder="<?= $this->lang->line('placehold_coin_qty');?>">
                                        <?= form_error('coinqty', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="p-5">
                                        <input type="hidden" name="typecoin" value="2">
                                        <input type="hidden" name="iddeposit" value="<?= $currentTab == 'mtm' ? $id_deposit : ''; ?>">
                                        <input type="hidden" name="id_notif" value="<?= $currentTab == 'mtm' ? $id_notif : ''; ?>">
                                        <button type="submit" class="btn btn-ok btn-block wd-100-pr">
                                        <?= $this->lang->line('deposit_request');?>
                                        </button>
                                    </div>
                                    <div class="p-5">
                                        <a href="<?= base_url('user/cancelPayment'); ?>" class="btn btn-cancel btn-block wd-100-pr" data-toggle="modal" data-target="#cancelModal">
                                        <?= $this->lang->line('cancel');?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade <?= $currentTab == 'usdt' ? 'show active' : ''; ?>" id="usdt" role="tabpanel" aria-labelledby="usdt-tab">
            <div class="row">
                <div class="col-md-12">
                    <form class="payment" method="post" action="<?= base_url('user/deposit/4'); ?>" enctype="multipart/form-data">
                        <div class="payment text-center text-white">
                            <div id="qr_code">
                                <p><?= $this->lang->line('address_wallet_payment');?></p>
                                <p><img src="<?= base_url('assets/img/wallet_usdt_qr.png'); ?>" alt="" width="200"></p>
                                <p class="code-text">
                                    <b><?= $wallet_address['usdt']; ?></b>
                                </p>
                                <p class="note"><?= $this->lang->line('note');?>: <?= $this->lang->line('copy_txid');?></p>
                                <p class="note">* <?= $this->lang->line('check_txid');?></p>
                                <p class="note">* <?= $this->lang->line('check_payment_amount');?></p>

                                <div class="col-md-6 m-auto">
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" id="txid" name="txid" value="<?= set_value('txid'); ?>" placeholder="<?= $this->lang->line('placehold_txid');?>">
                                        <?= form_error('txid', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 m-auto">
                                    <!-- <div class="form-group mt-3"> -->
                                    <div class="form-custom-img">
                                        <label for="proof-mtm" class="customform-control"><?= $this->lang->line('placehold_proof');?></label>
                                        <input type='file' placeholder="Enter proof of delivery" name='userfile' size='20'  id="proof-mtm" onchange="pressed()" /><span id='val-mtm' class="val"></span>
                                        <span id='button-image-mtm' class="button-image"><?= $this->lang->line('select_file');?></span>
                                    </div>
                                </div>

                                <div class="col-md-6 m-auto">
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" id="coinqty" name="coinqty" value="<?= set_value('coinqty'); ?>" placeholder="<?= $this->lang->line('placehold_coin_qty');?>">
                                        <?= form_error('coinqty', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="p-5">
                                        <input type="hidden" name="typecoin" value="4">
                                        <input type="hidden" name="iddeposit" value="<?= $currentTab == 'usdt' ? $id_deposit : ''; ?>">
                                        <input type="hidden" name="id_notif" value="<?= $currentTab == 'usdt' ? $id_notif : ''; ?>">
                                        <button type="submit" class="btn btn-ok btn-block wd-100-pr">
                                        <?= $this->lang->line('deposit_request');?>
                                        </button>
                                    </div>
                                    <div class="p-5">
                                        <a href="<?= base_url('user/cancelPayment'); ?>" class="btn btn-cancel btn-block wd-100-pr" data-toggle="modal" data-target="#cancelModal">
                                        <?= $this->lang->line('cancel');?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade <?= $currentTab == 'krp' ? 'show active' : ''; ?>" id="krp" role="tabpanel" aria-labelledby="krp-tab">
            <div class="row">
                <div class="col-md-12">
                    <form class="payment" method="post" action="<?= base_url('user/deposit/5'); ?>" enctype="multipart/form-data">
                        <div class="payment text-center text-white">
                            <div id="qr_code">
                                <p><?= $this->lang->line('address_wallet_payment');?></p>
                                <p><img src="<?= base_url('assets/img/wallet_krp_qr.png'); ?>" alt="" width="200"></p>
                                <p class="code-text">
                                    <b><?= $wallet_address['krp']; ?></b>
                                </p>
                                <p class="note"><?= $this->lang->line('note');?>: <?= $this->lang->line('copy_txid');?></p>
                                <p class="note">* <?= $this->lang->line('check_txid');?></p>
                                <p class="note">* <?= $this->lang->line('check_payment_amount');?></p>

                                <div class="col-md-6 m-auto">
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" id="txid" name="txid" value="<?= set_value('txid'); ?>" placeholder="<?= $this->lang->line('placehold_txid');?>">
                                        <?= form_error('txid', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 m-auto">
                                    <!-- <div class="form-group mt-3"> -->
                                    <div class="form-custom-img">
                                        <label for="proof-zenx" class="customform-control"><?= $this->lang->line('placehold_proof');?></label>
                                        <input type='file' placeholder="Enter proof of delivery" name='userfile' size='20'  id="proof-zenx" onchange="pressed()" /><span id='val-zenx' class="val"></span>
                                        <span id='button-image-zenx' class="button-image"><?= $this->lang->line('select_file');?></span>
                                    </div>
                                </div>

                                <div class="col-md-6 m-auto">
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" id="coinqty" name="coinqty" value="<?= set_value('coinqty'); ?>" placeholder="<?= $this->lang->line('placehold_coin_qty');?>">
                                        <?= form_error('coinqty', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="p-5">
                                        <input type="hidden" name="typecoin" value="5">
                                        <input type="hidden" name="iddeposit" value="<?= $currentTab == 'krp' ? $id_deposit : ''; ?>">
                                        <input type="hidden" name="id_notif" value="<?= $currentTab == 'krp' ? $id_notif : ''; ?>">
                                        <button type="submit" class="btn btn-ok btn-block wd-100-pr">
                                        <?= $this->lang->line('deposit_request');?>
                                        </button>
                                    </div>
                                    <div class="p-5">
                                        <a href="<?= base_url('user/cancelPayment'); ?>" class="btn btn-cancel btn-block wd-100-pr" data-toggle="modal" data-target="#cancelModal">
                                        <?= $this->lang->line('cancel');?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Logout Modal-->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel"><?= $this->lang->line('ready_to_leave');?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"><?= $this->lang->line('ready_to_cancel_deposit');?></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= $this->lang->line('cancel');?></button>
                <a class="btn btn-primary" href="<?= base_url('user/'); ?>"><?= $this->lang->line('ok');?></a>
            </div>
        </div>
    </div>
</div>