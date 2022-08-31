<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h3 text-white">News</h1>
        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addNewsModal">Add News</a>
    </div>

    <?= $this->session->flashdata('message'); ?>
    <div class="card shadow mb-4 mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="table2" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($news as $row) : ?>
                            <tr>
                                <td><?= date('Y-m-d H:i:s', $row->datecreate); ?></td>
                                <td><?= $row->title ?></td>
                                <td><?= $row->message ?></td>
                                <td>
                                    <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#delete_modal<?= $row->id ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<div class="modal-banner fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="<?= base_url('admin/news_announcement'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add News</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home">English</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu1">Korea</a>
                        </li>
                    </ul>

                    <!-- Tab Body -->
                    <div class="tab-content mt-3">
                        <div class="tab-pane container active" id="home">
                            <div class="form-group">
                                <label for="title">Title (en)</label>
                                <input type="text" class="form-control bg-white" name="title" id="title" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Message (en)</label>
                                <textarea class="form-control" id="message" name="message" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="tab-pane container fade" id="menu1">
                            <div class="form-group">
                                <label for="title">Title (kr)</label>
                                <input type="text" class="form-control bg-white" name="title_kr" id="title_kr" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Message (kr)</label>
                                <textarea class="form-control" id="message_kr" name="message_kr" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="custom-file">
                        <input type="file" class="custom-file-input image-name" name="image" id="image" onchange="previewImg()">
                        <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" name="addNews" id="confirmLink">OK</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
foreach ($news as $row) {
?>
    <div class="modal fade" id="delete_modal<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete News</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="<?php echo base_url('admin/news_announcement') ?>">
                    <div class="modal-body">
                        <p>Are you sure want to delete this news?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_news" value="<?php echo $row->id; ?>">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        <button class="btn btn-primary" type="submit" name="deleteNews">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>