<!-- Notif Modal-->
<div class="modal fade" id="notifWd" tabindex="-1" role="dialog" aria-labelledby="notifWdModalLabel" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Withdraw Notification!</h5>
            </div>
            <div class="modal-body">
                <div class="text-center mb-2">
                    <?= $message; ?>
                </div>
                <div class="text-center">
                    <a class="btn btn-info text-center w-100" href="<?= base_url() . $link; ?>">
                        OK
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>