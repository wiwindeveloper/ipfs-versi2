<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('customer_service') ?></h1>
    <?= $this->session->flashdata('message'); ?>
    <br>
    <!-- content -->
    <div class="row">
        <div class="col-md-12">
            <div class="p-4 box bg-transparent box-info direct-chat direct-chat-info">

                <?php if ($message != NULL) : ?>
                    <div class="box-header with-border">
                        <h3 class="box-title text-white"><?= $this->lang->line('chatbox') ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="direct-chat-messages" id="element">
                            <?php foreach ($message as $row_message) : ?>
                                <?php if ($user['email'] != $row_message->sender_email) : ?>
                                    <div class="direct-chat-msg" id="msg">
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
                                    <div class="direct-chat-msg right" id="msg" <?= $row_message->message == NULL && $row_message->image == NULL ? 'hidden' : ''; ?>>
                                        <div class="direct-chat-information clearfix">
                                            <span class="direct-chat-name pull-right"><?= $row_message->name; ?></span>
                                            <span class="direct-chat-timestamp pull-right"><?= date('d M H:i', $row_message->time); ?></span>
                                        </div>
                                        <div class="direct-chat-text">
                                            <?php if ($row_message->message != '') : ?>
                                                <?= $row_message->message ?>
                                            <?php else : ?>
                                                <img src="<?= base_url('assets/photo/cs/' . $row_message->image); ?>" style="height:150px; cursor:pointer" onclick="csImage(this)">
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <?php if ($message_robot == NULL) : ?>
                                        <div class="direct-chat-robot mt-3 mb-1" id="msg">
                                        <?= $this->lang->line('message_chatbox') ?>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php else : ?>
                    <!-- <div class="card my-5">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-info">Chat With Us</h6>
                        </div>
                        <form class="user" method="post" action="<?= base_url('user/customer_service'); ?>">
                            <div class="card-body">
                                <div class="mt-3">
                                    <label class="text-dark" for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?= set_value('name'); ?>" required>
                                </div>
                                <div class="mt-3">
                                    <label class="text-dark" for="name">Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?= set_value('email'); ?>" required>
                                </div>
                                <div class="mt-3">
                                    <label class="text-dark" for="name">Phone (optional)</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="" value="<?= set_value('phone'); ?>">
                                </div>
                                <div class="mt-3">
                                    <label class="text-dark" for="name">Message (optional)</label>
                                    <textarea name="message" class="form-control" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <button class="btn btn-info float-right" name="send">Start Chat</button>
                            </div>
                        </form>
                    </div> -->
                    <div class="d-flex justify-content-center">
                        <img src="<?= base_url('assets/img/start_chat.png'); ?>" alt="Message User Image" class="cs-image">
                    </div>
                    <h2 class="text-center"><?= $this->lang->line('start_chat') ?> . . .</h2>
                <?php endif ?>
                
                <div class="box-footer mt-4">
                    <form method="post" action="<?php base_url('user/customer_service') ?>" enctype="multipart/form-data">
                        <div class="input-group">
                            <input type="text" name="message" id="message" placeholder="<?= $this->lang->line('type_message');?> . . ." class="form-control" onkeydown="if (event.keyCode == 13) document.getElementById('btnSend').click()">
                            <?= form_error('message', '<small class="text-danger pl-3">', '</small>'); ?>
                            <span class="input-group-append">
                                <label for="image" class="btn btn-info custom-file" style="cursor:pointer;"><?= $this->lang->line('browse_image') ?></label>
                                <input type="file" hidden="" name="image" id="image" onchange="previewImg()"></input>
                                <button type="submit" name="submit" id="btnSend" class="btn btn-info btn-flat"><?= $this->lang->line('send') ?></button>
                            </span>
                        </div>
                    </form>
                </div>

            </div>
            <!--/.direct-chat -->
        </div>

    </div>
    <!-- /.content -->
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<div class="modal-banner" id="modal_cs_img" tabindex="-1" role="dialog" aria-hidden="true" onclick="this.style.display='none'">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-dark">
                <img id="img_cs" style="width:100%">
            </div>
        </div>
    </div>
</div>