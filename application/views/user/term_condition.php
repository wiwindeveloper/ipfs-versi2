<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('package_purchase');?></h1>
    <!--./ Page Heading -->

    <div>
        <?= $this->session->flashdata('message'); ?>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="term-condition">
                <div class="form-group">
                    <textarea class="form-control" rows="10" disabled>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sagittis bibendum quam at ornare. Suspendisse dui ex, malesuada vel risus vel, suscipit ultrices elit. Phasellus viverra ut quam non aliquet. Nullam convallis nibh nec dui tempor ullamcorper. Integer dignissim, mi eu eleifend imperdiet, orci purus semper eros, ut hendrerit est quam sed enim. Ut nec sem purus. Maecenas sollicitudin, orci nec porttitor ultricies, neque nunc rhoncus nisi, vel varius leo diam ut ligula. Ut imperdiet commodo ligula a vestibulum. Donec suscipit id ex quis lobortis. Phasellus pretium lectus sit amet libero varius gravida. Aliquam lobortis diam nec dui sagittis elementum. 
                        Etiam mollis nunc elit, sit amet consectetur odio semper ac. Integer eget elementum sem, nec ullamcorper tellus. Phasellus tempor, odio vitae lobortis pretium, lorem tellus mattis mi, quis cursus risus nunc eu augue. Proin ac justo quis sapien finibus dictum vel malesuada magna. Proin eu orci auctor, blandit nisl quis, dapibus leo. In tempor lacus urna, non auctor libero maximus a. Maecenas consequat finibus nisi, eget sodales massa. Vivamus venenatis leo sit amet lectus luctus varius. Nam nisl libero, pharetra ut massa eu, facilisis volutpat mauris. Aliquam vulputate posuere augue, et dapibus ipsum molestie tristique. Pellentesque vehicula placerat molestie. Nam non viverra nisl. Nunc lacinia volutpat iaculis. Vivamus ultrices vitae lacus semper rutrum. Phasellus ullamcorper eros eget nibh tincidunt gravida. 
                        Phasellus eu viverra turpis, quis consectetur diam. In fermentum sem id quam accumsan, porttitor mollis urna tincidunt. Donec ut elementum sem. Nam pellentesque maximus elit, id facilisis est tristique at. Nulla et consectetur elit. Proin quam lectus, scelerisque eu arcu finibus, egestas hendrerit sapien. Aenean facilisis eu massa quis luctus. Ut quis efficitur quam. Maecenas ornare erat in tortor mollis efficitur. Quisque in sollicitudin libero, vitae laoreet lectus. Mauris quis libero et ipsum laoreet aliquet sed vel tellus. Vestibulum vel ex at libero luctus placerat. Etiam pretium tortor tellus, eget varius tellus luctus quis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis eget euismod sapien. Suspendisse potenti. 
                        Nam at bibendum risus. Sed varius ligula a luctus sagittis. Fusce maximus pellentesque erat ac placerat. Maecenas ac sodales orci, ut vehicula arcu. Sed congue, turpis non ornare condimentum, quam lacus efficitur sapien, non bibendum justo nunc nec tellus. Praesent lacinia leo eget hendrerit facilisis. Pellentesque rhoncus tristique mauris, id rhoncus nisi auctor id. Morbi fermentum arcu mi, quis fringilla mauris rutrum et. Suspendisse quam lorem, sollicitudin in iaculis non, gravida vel ante. 
                        Phasellus in viverra ipsum, non auctor nibh. Quisque suscipit sollicitudin velit in molestie. Pellentesque nulla erat, sagittis eu magna vitae, lobortis dictum ante. Vivamus odio justo, consectetur at consequat sed, sagittis id enim. In eget sapien vel lacus lacinia porta. Phasellus et risus nulla. Curabitur blandit nulla a elit fringilla luctus. Aenean ut euismod risus. Vestibulum eget diam ac turpis fermentum consectetur. Nam efficitur imperdiet faucibus. 
                    </textarea>
                </div>

                <div class="row mb-2 mt-4" id="coinPurchase">
                    <div class="col-lg-4 mb-2">
                        <button class="btn btn-cancel btn-block btn-purchase active" onclick="changeFIL()" value="fil">
                            FIL
                        </button>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <button class="btn btn-cancel btn-block btn-purchase" onclick="changeUSDT()" value="usdt">
                            USDT
                        </button>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <button class="btn btn-cancel btn-block btn-purchase" onclick="changeKRP()" value="krp">
                            KRP
                        </button>
                    </div>
                </div>

                <form class="user" method="post" action="<?= base_url('user/cart') ?>">
                    <div class="form-group">
                        <label class="text-white mb-1" for="balance"><?= $this->lang->line('balance');?></label>
                        <input type="text" class="form-control" id="balance" name="balance" value="<?= number_format($general_balance_fil, 10) ?> FIL" placeholder="<?= $this->lang->line('balance');?>" readonly>
                        <p id="lowBalance"></p>
                    </div>
                    <div class="form-group">
                        <label class="text-white mb-1" for="balance"><?= $this->lang->line('package_price');?></label>
                        <input type="text" class="form-control" id="price" name="price" value="<?= $price_fil; ?> FIL" readonly>
                    </div>
                    <?php
                    if (empty($cart['name'])) {
                    ?>
                        <div class="form-group">
                            <label class="text-white mb-1" for="sponsor"><?= $this->lang->line('recommended');?></label>
                            <input type="text" class="form-control" id="sponsor" name="sponsor" value="<?= set_value('sponsor'); ?>" placeholder="<?= $this->lang->line('recommended_id');?>">
                            <?= form_error('sponsor', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                        </div>
                        <div class="form-group">
                            <label class="text-white mb-1" for="position"><?= $this->lang->line('position');?></label>
                            <input type="text" class="form-control" id="position" name="position" value="<?= set_value('position'); ?>" placeholder="<?= $this->lang->line('position_id');?>">
                            <?= form_error('position', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                        </div>

                        <div class="mb-3">
                            <label class="text-white mb-1" for="selectline"><?= $this->lang->line('select_line');?></label>
                            <select class="form-control" id="selectline" name="line">
                                <option value="A"><?= $this->lang->line('line');?> A</option>
                                <option value="B"><?= $this->lang->line('line');?> B</option>
                            </select>
                            <?= form_error('line', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="form-check mt-4 my-2">
                        <input class="form-check-input" type="checkbox" value="1" id="flexAccept" name="accept_terms" <?php if (!empty($checked1)) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                        <label class="form-check-label text-white" for="flexAccept">
                        <?= $this->lang->line('check_term_condition');?>
                        </label>
                        <?= form_error('accept_terms', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                    </div>
                    <div class="form-check my-2">
                        <input class="form-check-input" type="checkbox" value="1" id="flexAgreeTerm" name="agree_term" <?php if (!empty($checked2)) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                        <label class="form-check-label text-white" for="flexAgreeTerm">
                        <?= $this->lang->line('check_agree_term');?>
                        </label>
                        <?= form_error('agree_term', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                    </div>
                    <div class="form-check my-2">
                        <input class="form-check-input" type="checkbox" value="1" id="flexAgreePrivacy" name="agree_privacy" <?php if (!empty($checked3)) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                        <label class="form-check-label text-white" for="flexAgreePrivacy">
                            <?= $this->lang->line('check_agree_provision');?>
                        </label>
                        <?= form_error('agree_privacy', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="p-5">
                            <a class="btn btn-ok btn-block wd-px" id="btnBuy" href="#" data-toggle="modal" data-target="#notificationModal"><?= $this->lang->line('buy');?></a>
                        </div>
                        <div class="p-5">
                            <input type="hidden" name="data_purchase" value="<?= $this->session->userdata('purchase') ?>">
                            <input type="hidden" value="fil" id="coinType" name="cointype">
                            <!-- <input type="hidden" name="data_fil" value="<?= $fil; ?>"> -->
                            <a href="<?= base_url('user/package'); ?>" class="btn btn-cancel btn-block wd-px text-uppercase" data-toggle="modal" data-target="#cancelModal">
                                <?= $this->lang->line('cancel');?>
                            </a>
                        </div>
                    </div>
                    <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelModalLabel"><?= $this->lang->line('notification_alert');?></h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body"><?= $this->lang->line('notification_alert_sub');?></div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= $this->lang->line('cancel');?></button>
                                    <button type="submit" name="buy" class="btn btn-ok btn-block wd-px" id="btnBuy">
                                    <?= $this->lang->line('ok');?>
                                    </button>
                                </div>
                            </div>
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

<!-- Logout Modal-->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel"><?= $this->lang->line('cancel_purchase_title');?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"><?= $this->lang->line('cancel_purchase_body');?></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= $this->lang->line('cancel');?></button>
                <a class="btn btn-primary" href="<?= base_url('user/package'); ?>"><?= $this->lang->line('ok');?></a>
            </div>
        </div>
    </div>
</div>