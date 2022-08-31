
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-white text-center">PAYMENT PACKAGE</h1>

                    <div class="row">
                        <div class="col-md-12">
                            <form class="payment" method="post" action="<?= base_url('user/payment'); ?>">
                                <div class="payment text-center text-white">
                                    <p>Time remaining</p>
                                    <h2 id="timecount" class="text-white"></h2>
                                    <div id="qr_code">
                                        <p class="mt-5">Address wallet payment</p>
                                        <p><img src="<?= base_url('assets/img/new_qrcode.png');?>" alt="" width="200"></p>
                                        <p class="code-text">
                                            <b>f1fzgcduywwfq7dqkahiwztsbdzv3g6j2hxjhgzey</b>
                                        </p>
                                        <p class="note">Note: Copy TXID</p>
                                        <p class="note">* Please re-check the TXID so it's not wrong</p>
                                        <p class="note">* Please check the payment amount to match</p>

                                        <div class="col-md-6 m-auto">
                                            <div class="form-group mt-3">
                                                <input type="text" class="form-control" id="txid" name="txid" value="<?= set_value('txid'); ?>"
                                                    placeholder="Please enter TXID">
                                                <?= form_error('txid', '<small class="text-danger pl-3 float-left">', '</small>'); ?>
                                            </div>
                                        </div>

                                        <p class="mt-5">Price</p>
                                        <h2 class="text-white mb-3"><?= $cart_pay['fill']; ?> Fil</h2>

                                        <div class="d-flex justify-content-center">
                                            <div class="p-5">
                                                <input type="hidden" name="cartid" value="<?= $this->session->userdata('cart') != '' ? $this->session->userdata('cart') : $this->uri->segment(3); ?>">
                                                <button type="submit" class="btn btn-ok btn-block wd-px">
                                                    PAYMENT
                                                </button>
                                            </div>
                                            <div class="p-5">
                                                <a href="<?= base_url('user/cancelPayment'); ?>" class="btn btn-cancel btn-block wd-px" data-toggle="modal" data-target="#cancelModal">
                                                    CANCEL
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Cancel Modal-->
            <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelModalLabel">Ready to Leave?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Select "OK" below if you are ready to cancel this payment.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="<?= base_url('user/cancelPayment'); ?>">OK</a>
                        </div>
                    </div>
                </div>
            </div>
            

<script>
//set the date we're counting down to
var dateCreate = <?php echo $cart_pay['update_date']; ?>

var countDownDate = (dateCreate * 1000) + (30 * 60 * 1000);

//update the countdown every 1 second
var x = setInterval(function(){
    //get today's date and time
    var now = new Date().getTime();

    //find the distance between now and the countdown date
    var distance = countDownDate - now;

    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    document.getElementById("timecount").innerHTML = minutes + "." + seconds;

    //if the count down is over, write some text//

    if(distance < 0) {
        clearInterval(x);

        document.getElementById("timecount").innerHTML = "<span style='color:red;'>EXPIRED</span>";
        document.getElementById("qr_code").innerHTML = "";
    } 
}, 1000);

</script>