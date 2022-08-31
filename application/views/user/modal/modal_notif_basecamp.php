<!-- Notif Modal-->
<div class="modal fade" id="notifBasecampModal" tabindex="-1" role="dialog" aria-labelledby="notifBasecampModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mb-2">
                    <?= $message; ?>
                </div> 
                <div class="text-center">
                    <a class="btn btn-primary" href="<?= base_url().$link; ?>">
                        OK
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>