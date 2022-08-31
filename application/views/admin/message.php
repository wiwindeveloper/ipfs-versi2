<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">Message</h1>

    <?= $this->session->flashdata('message'); ?>

    <!-- DataTales Example -->
    <?php if ($message != NULL) : ?>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($message as $row_message) : ?>
                                <tr>
                                    <td><?= date('Y-m-d H:i:s', $row_message->max_time); ?></td>
                                    <td><?= $row_message->name ?></td>
                                    <td><?= $row_message->email ?></td>
                                    <td style="width:100px">
                                        <a class="btn btn-sm btn-primary" href="<?php base_url('/') ?>reply_message/<?= $row_message->uniq_id; ?>">Chat</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="card p-4 bg-transparent text-white">
            <h4 class="text-center align-middle">No messages received</h4>
        </div>
    <?php endif ?>

    <!-- chat yang sudah selesai -->
    <?php if ($message_end != NULL) : ?>
        <div class="card shadow mb-4 mt-5">
            <div class="card-body">
                <div class="table-responsive">
                    <h4 class="mb-4 text-gray-800">Finished Message</h4>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($message_end as $row_message) : ?>
                                <tr>
                                    <td><?= date('Y-m-d H:i:s', $row_message->max_time); ?></td>
                                    <td><?= $row_message->name ?></td>
                                    <td><?= $row_message->email ?></td>
                                    <td style="width: 100px;">
                                        <a class="btn btn-sm btn-primary" href="<?php base_url('/') ?>reply_message/<?= $row_message->uniq_id; ?>">Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="card p-4 bg-transparent text-white mt-5">
            <h4 class="text-center align-middle">No completed messages</h4>
        </div>
    <?php endif ?>
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
                <a class="btn btn-primary" href="#" id="confirmPaymentLink">OK</a>
            </div>
        </div>
    </div>
</div>