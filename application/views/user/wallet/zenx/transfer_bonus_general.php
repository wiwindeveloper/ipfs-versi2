<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('bonus_balance');?></h1>
    <!--./ Page Heading -->

    <div>
        <?= $this->session->flashdata('message'); ?>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="term-condition">
                <h4 class="text-white text-center mb-3"><?= $this->lang->line('bonus_balance');?></h4>
                <form method="post" action="<?php base_url('user/transfer_bonus_zenx') ?>">
                    <div class="form-group btn border-withdrawal text-white" style="width: 100%; text-align:left !important; cursor:default">
                        <span><img src="<?= base_url('assets/img/zenith_logo.png') ?>" width="25px">&nbsp; <b>ZENX <?= $this->lang->line('wallet');?></b></span> <span class="float-right"><b>0,0000000000 ZENX</b></span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="amount" name="amount" value="<?= set_value('amount'); ?>" placeholder="<?= $this->lang->line('amount');?>" onkeypress="return (event.charCode == 46 || event.charCode < 31 || (event.charCode > 47 && event.charCode < 58))">
                        <?= form_error('amount', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                    </div>
                    <div class="form-group input-group check">
                        <input type="text" class="form-control" id="email_code" name="email_code" placeholder="Email Code" value="<?= set_value('email_code'); ?>" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn term-condition border text-white" name="check" type="submit">
                            <?= $this->lang->line('check');?>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="otp_code" name="otp_code" value="<?= set_value('otp_code'); ?>" placeholder="Otp Code">
                        <?= form_error('otp_code', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                    </div>
                    <div>
                        <textarea class="form-control" rows="7" readonly><?= $this->lang->line('term_condition');?>
                        </textarea>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6 mb-2">
                            <button type="submit" class="btn btn-ok btn-user btn-block">
                            <?= $this->lang->line('transfer');?>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('user/mywalletzenx/bonus'); ?>" class="btn btn-cancel btn-user btn-block">
                            <?= $this->lang->line('cancel');?>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->