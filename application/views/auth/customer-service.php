<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg mt-5 mb-3 bg-transparent">

                <?php if ($message != NULL) : ?>
                    <div class="p-4 box bg-white box-info direct-chat direct-chat-info">
                        <div class="box-header with-border">
                            <h3 class="box-title text-dark bg-seco">ChatBox</h3>
                        </div>
                        <div class="box-body">
                            <div class="direct-chat-messages" id="element">
                                <?php foreach ($message as $row_message) : ?>
                                    <?php if ($get_uniq['email'] != $row_message->sender_email) : ?>
                                        <div class="direct-chat-msg" id="msg">
                                            <div class="direct-chat-information clearfix">
                                                <span class="direct-chat-name pull-left text-dark"><?= $row_message->name; ?></span>
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
                                                <span class="direct-chat-name pull-right text-dark"><?= $row_message->name; ?></span>
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
                                            <?= $this->lang->line('please_wait');?> . . .
                                            </div>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="box-footer mt-4">
                            <form method="post" action="<?php base_url('user/customer_service') ?>" enctype="multipart/form-data">
                                <div class="input-group">
                                    <input type="text" name="message" id="message" placeholder="Type Message . . ." class="form-control" onkeydown="if (event.keyCode == 13) document.getElementById('btnSend').click()">
                                    <?= form_error('message', '<small class="text-danger pl-3">', '</small>'); ?>
                                    <span class="input-group-append">
                                        <label for="image" class="btn btn-info custom-file" style="cursor:pointer;"><?= $this->lang->line('browse_image');?></label>
                                        <input type="file" hidden="" name="image" id="image" onchange="previewImg()"></input>
                                        <button type="submit" name="submit" id="btnSend" class="btn btn-info btn-flat"><?= $this->lang->line('send');?></button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="card" style="border-radius: 5px !important;">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-info"><?= $this->lang->line('chat_with_us');?></h6>
                        </div>
                        <form method="post" action="<?= base_url('auth/customer_service'); ?>">
                            <div class="card-body">
                                <div class="mt-3">
                                    <label class="text-dark" for="name"><?= $this->lang->line('name');?> <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?= set_value('name'); ?>" required>
                                </div>
                                <div class="mt-3">
                                    <label class="text-dark" for="name">Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?= set_value('email'); ?>" required>
                                </div>
                                <div class="mt-3">
                                    <label class="text-dark" for="name"><?= $this->lang->line('phone');?> (<?= $this->lang->line('optional');?>)</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="" value="<?= set_value('phone'); ?>">
                                </div>
                                <div class="mt-3">
                                    <label class="text-dark" for="name"><?= $this->lang->line('message');?> (<?= $this->lang->line('optional');?>)</label>
                                    <textarea name="message" class="form-control" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <button class="btn btn-info float-right mb-3" name="send"><?= $this->lang->line('start_chat');?></button>
                            </div>
                        </form>
                    </div>
                <?php endif ?>

                <!--/.direct-chat -->
            </div>
        </div>
        <div class="col-xl-10 col-lg-12 col-md-9">
            <a href="<?= base_url('auth'); ?>" class="btn btn-outline-secondary text-white btn-block">
            <?= $this->lang->line('back');?>
            </a>
        </div>
    </div>

</div>