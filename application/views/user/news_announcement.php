<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('news');?></h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="accordion" id="accordionExample">
        <?php foreach ($news as $key => $row) : ?>
            <div class="card mb-2" style="border-radius: 20px; border:1px solid white">
                <div class="card-header text-white" style="background-color: #000;" id="heading<?= $row->id; ?>">
                    <div class="mb-0" id="news-wrapper">
                        <button class="btn btn-link text-right text-white d-flex justify-content-between align-items-center w-100 text-decoration-none <?= $key == $this->uri->segment(3) ? '' : 'collapsed'; ?>" onfocus="this.blur()" type="button" data-toggle="collapse" data-target="#collapse<?= $row->id; ?>" aria-expanded="true" aria-controls="collapse<?= $row->id; ?>">
                            <h5 class="mb-0 title-news"><?= date('d/m/Y', $row->datecreate); ?></h5>
                            <h5 class="mb-0 title-news">
                                <?php 
                                     if($this->session->userdata('site_lang') == 'korea')
                                     {
                                         echo $row->title_kr;
                                     }
                                     else
                                     {
                                         echo $row->title;
                                     }
                                ?>
                            </h5>
                            <!-- <i class="fas fa-chevron-down"></i> -->
                        </button>
                    </div>
                </div>
                <div id="collapse<?= $row->id; ?>" class="collapse <?= $key == $this->uri->segment(3) ? 'show' : ''; ?>" aria-labelledby="heading<?= $row->id; ?>" data-parent="#accordionExample">
                    <div class="card-body text-dark bg-white">
                        <?php if (!empty($row->image)) : ?>
                            <img src="<?= base_url('assets/photo/news/' . $row->image); ?>" alt="Image" class="d-block mx-auto" height="500px" onclick="zoomImage(this)" style="cursor:zoom-in">
                        <?php endif ?>
                        <p class="mb-0 p-4 text-justify">
                            <?php
                                if($this->session->userdata('site_lang') == 'korea')
                                {
                                    echo $row->message_kr;
                                }
                                else
                                {
                                    echo $row->message;
                                }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->