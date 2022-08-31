<!-- Notif Modal-->
<div class="modal fade" id="notifMiningModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mb-2">
                    <?= $message; ?>
                </div> 
                <div class="text-center">
                    <a class="btn btn-primary" href="<?= base_url().$link.'/2'; ?>">
                        Continue
                    </a>
                    <a class="btn btn-secondary" href="<?= base_url().$link.'/1'; ?>">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>