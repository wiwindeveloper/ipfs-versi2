<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">Message</h1>
    <?= $this->session->flashdata('message'); ?>

    <!-- content -->
    <div class="row">
        <?php if ($message) : ?>
            <div class="col-md-12">
                <form method="post" action="<?php base_url('admin/reply_message') ?>" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                    <div class="p-4 box bg-transparent box-primary direct-chat direct-chat-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title text-white">ChatBox</h3>
                            <button name="end_chat" type="submit" class="btn btn-sm btn-primary float-right">
                                End Chat
                            </button>
                        </div>
                        <div class="box-body">
                            <div class="direct-chat-messages" id="element">
                                <?php foreach ($message as $row_message) : ?>
                                    <?php if ($user['email'] != $row_message->sender_email) : ?>
                                        <div class="direct-chat-msg" id="msg" <?= $row_message->message == NULL && $row_message->image == NULL ? 'hidden' : ''; ?>>
                                            <div class="direct-chat-information clearfix">
                                                <span class="direct-chat-name pull-left"><?= $row_message->name; ?></span>
                                                <span class="direct-chat-timestamp pull-left"><?= date('d M H:i', $row_message->time); ?></span>
                                            </div>
                                            <div class="direct-chat-text">
                                                <?php if ($row_message->message != '') : ?>
                                                    <?= $row_message->message ?>
                                                <?php else : ?>
                                                    <img src="<?= base_url('assets/photo/cs/' . $row_message->image); ?>" alt="" style="height:150px; cursor:pointer" onclick="csImage(this)">
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="direct-chat-msg right" id="msg">
                                            <div class="direct-chat-information clearfix">
                                                <span class="direct-chat-name pull-right"><?= $row_message->name; ?></span>
                                                <span class="direct-chat-timestamp pull-right"><?= date('d M H:i', $row_message->time); ?></span>
                                            </div>
                                            <div class="direct-chat-text">
                                                <?php if ($row_message->message != '') : ?>
                                                    <?= $row_message->message ?>
                                                <?php else : ?>
                                                    <img src="<?= base_url('assets/photo/cs/' . $row_message->image); ?>" alt="" style="height:150px; cursor:pointer" onclick="csImage(this)">
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer mt-4">
                            <div class="input-group">
                                <input type="text" name="message" placeholder="Type Message ..." class="form-control" onkeydown="if (event.keyCode == 13) document.getElementById('btnSend').click()">
                                <?= form_error('message', '<small class="text-danger pl-3">', '</small>'); ?>
                                <span class="input-group-append">
                                    <label for="image" class="btn btn-primary custom-file" style="cursor:pointer; border-right:1px solid blue">Browse Image</label>
                                    <input type="file" hidden="" name="image" id="image" onchange="previewImg()"></input>
                                    <button type="submit" name="submit" id="btnSend" class="btn btn-primary btn-flat">Send</button>
                                </span>
                            </div>
                        </div>
                        <!-- /.box-footer-->
                    </div>
                </form>
                <!--/.direct-chat -->
            </div>

        <?php elseif ($message_end) : ?>
            <!-- chat yang sudah selesai -->
            <div class="col-md-12">
                <div class="p-4 box bg-transparent box-primary direct-chat direct-chat-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title text-white">ChatBox</h3>
                    </div>
                    <div class="box-body">
                        <div class="direct-chat-messages" id="element">
                            <?php foreach ($message_end as $row_message) : ?>
                                <?php if ($user['email'] != $row_message->sender_email) : ?>
                                    <div class="direct-chat-msg" id="msg" <?= $row_message->message == NULL && $row_message->image == NULL ? 'hidden' : ''; ?>>
                                        <div class="direct-chat-information clearfix">
                                            <span class="direct-chat-name pull-left"><?= $row_message->name; ?></span>
                                            <span class="direct-chat-timestamp pull-left"><?= date('d M H:i', $row_message->time); ?></span>
                                        </div>
                                        <div class="direct-chat-text">
                                            <?php if ($row_message->message != '') : ?>
                                                <?= $row_message->message ?>
                                            <?php else : ?>
                                                <img src="<?= base_url('assets/photo/cs/' . $row_message->image); ?>" alt="" style="height:150px; cursor:pointer" onclick="csImage(this)">
                                            <?php endif ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="direct-chat-msg right" id="msg">
                                        <div class="direct-chat-information clearfix">
                                            <span class="direct-chat-name pull-right"><?= $row_message->name; ?></span>
                                            <span class="direct-chat-timestamp pull-right"><?= date('d M H:i', $row_message->time); ?></span>
                                        </div>
                                        <div class="direct-chat-text">
                                            <?php if ($row_message->message != '') : ?>
                                                <?= $row_message->message ?>
                                            <?php else : ?>
                                                <img src="<?= base_url('assets/photo/cs/' . $row_message->image); ?>" alt="" style="height:150px; cursor:pointer" onclick="csImage(this)">
                                            <?php endif ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <!-- /.box-footer-->
                </div>
                <!--/.direct-chat -->
            </div>
        <?php endif ?>


        <!-- /.content -->

    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<div class="modal" id="modal_cs_img" tabindex="-1" role="dialog" aria-hidden="true" onclick="this.style.display='none'">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-dark">
                <img id="img_cs" style="width:100%">
            </div>
        </div>
    </div>
</div>