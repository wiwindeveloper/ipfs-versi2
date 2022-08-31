<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('information_detail');?></h1>
    <?= $this->session->flashdata('message'); ?>

    <div class="container text-center mt-5 mb-6">
        <div class="square mx-auto">
            <?php if ($information_detail['photo'] != '') : ?>
                <img class="rounded-circle border border-info" src="<?= base_url('assets/photo/' . $information_detail['photo']); ?>" alt="">
            <?php else : ?>
                <img class="rounded-circle border border-info" src="<?= base_url('assets/img/guest.png'); ?>">
            <?php endif; ?>
        </div>

        <?php echo form_open("user/upload", array('enctype' => 'multipart/form-data')); ?>
        <input type="hidden" name="old_photo" value="<?= $information_detail['photo']; ?>">
        <input type="hidden" name="id" value="<?= $information_detail['id']; ?>">
        <div class="form-group w-200px d-flex justify-content-center mx-auto ">
            <label for="foto" class="content-detail mt-4 bg-info w-100 text-white" style="cursor:pointer;"><?= $this->lang->line('change_photo');?></label>
            <input type="file" name="photo" id="foto" hidden="" onchange="document.getElementById('save').click()">
            <!-- <label for="save" class="mt-4 bg-info w-50 text-white border-left" style="cursor:pointer;">Save</label> -->
            <input type="submit" name="submit" id="save" hidden="">
        </div>
        <?php echo form_close(); ?>

        <div class="content-detail d-flex w-50 justify-content-between align-content-center align-items-center mx-auto mt-4 position-relative">
            <label class="text-white" for=""><?= $this->lang->line('name');?></label>
            <div class="line"></div>
            <div class="item text-white"><?= $information_detail['username'] ?></div>
        </div>

        <div class="content-detail d-flex w-50 justify-content-between align-content-center align-items-center mx-auto mt-25 position-relative">
            <label class="text-white" for="">ID</label>
            <div class="line"></div>
            <div class="item text-white"><?= $information_detail['username'] ?></div>
        </div>

        <div class="content-detail d-flex w-50 justify-content-between align-content-center align-items-center mx-auto mt-25 position-relative">
            <label class="text-white" for="">Email</label>
            <div class="line"></div>
            <div class="item text-white"><?= $information_detail['email'] ?></div>
        </div>

        <div class="content-detail d-flex w-50 justify-content-between align-content-center align-items-center mx-auto mt-25 position-relative">
            <label class="text-white" for=""><?= $this->lang->line('phone');?></label>
            <div class="line"></div>
            <div class="item text-white">+<?= $information_detail['country_code'] ?><?= $information_detail['phone'] ?></div>
        </div>

        <div class="content-detail d-flex w-50 justify-content-between align-content-center align-items-center mx-auto mt-25 position-relative">
            <label class="text-white" for=""><?= $this->lang->line('level');?></label>
            <div class="line"></div>
            <div class="item text-white"><?= $cart['fm'] ?? null; ?></div>
        </div>

        <div class="content-detail d-flex w-50 justify-content-between align-content-center align-items-center mx-auto mt-25 position-relative">
            <label class="text-white" for=""><?= $this->lang->line('recommended');?></label>
            <div class="line"></div>
            <div class="item text-white"><?= $cart['sponsor'] ?? null; ?></div>
        </div>

        <div class="content-detail d-flex w-50 justify-content-between align-content-center align-items-center mx-auto mt-25 position-relative">
            <label class="text-white" for=""><?= $this->lang->line('package');?></label>
            <div class="line"></div>
            <div class="item text-white text-uppercase"><?= $cart['name'] ?? null; ?> <?= $this->lang->line('box');?></div>
        </div>

        <div class="content-detail d-flex w-50 justify-content-between align-content-center align-items-center mx-auto mt-25 position-relative">
            <label class="text-white" for="">Mining <?= $this->lang->line('payment');?></label>
            <div class="line"></div>
            <div class="item text-white"><?= !empty($cart['name']) ? date('Y/m/d', $cart['update_date']) : ''; ?></div>
        </div>

        <div class="content-detail d-flex w-50 justify-content-between align-content-center align-items-center mx-auto mt-25 position-relative">
            <label class="text-white" for=""><?= $this->lang->line('start_payment');?></label>
            <div class="item">
                <div class="d-flex ">
                    <?php if (!empty($cart['name'])) { ?>
                        <div class="border-custom text-white mx-2">
                            FIL <?= $fil_startpayment; ?>
                        </div>
                        <div class="border-custom text-white">
                            MTM <?= $mtm_startpayment; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="content-detail d-flex w-50 justify-content-between align-content-center align-items-center mx-auto mt-25 position-relative">
            <label class="text-white" for=""><?= $this->lang->line('end_payment');?></label>
            <?php
            $cart_updatedate = $cart['update_date'] ?? null;
            ?>
            <div class="item" <?= empty($cart_updatedate) ? 'hidden' : '' ?>>
                <div class="d-flex ">
                    <?php if (!empty($cart['name'])) { ?>
                        <div class="border-custom text-white mx-2">
                            FIL <?= $fil_endpayment; ?>
                        </div>
                        <div class="border-custom text-white">
                            MTM <?= $mtm_endpayment; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->