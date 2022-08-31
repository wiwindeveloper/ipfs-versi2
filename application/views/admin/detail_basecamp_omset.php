<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">Detail Basecamp Omset</h1>

    <?= $this->session->flashdata('message'); ?>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Receive</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Collected</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Excess</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablenotorder" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>ID User</th>
                                    <th>Basecamp</th>
                                    <th>Member</th>
                                    <th>Purchase</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($basecamp as $row_list)
                                {
                                    ?>
                                        <tr>
                                            <td><?= date('Y/m/d H:i:s', $row_list->datecreate); ?></td>
                                            <td><?= $row_list->username; ?></td>
                                            <td><?= $row_list->name; ?></td>
                                            <td><?= $row_list->member; ?></td>
                                            <td><?= $row_list->purchase; ?></td>
                                            <td><?= $row_list->mtm.' MTM'; ?></td>
                                        </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablenotorder2" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>ID User</th>
                                    <th>Basecamp</th>
                                    <th>Member</th>
                                    <th>Purchase</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($gather as $row_gather)
                                {
                                    ?>
                                        <tr>
                                            <td><?= date('Y/m/d H:i:s', $row_gather->datecreate); ?></td>
                                            <td><?= $row_gather->username; ?></td>
                                            <td><?= $row_gather->name; ?></td>
                                            <td><?= $row_gather->member; ?></td>
                                            <td><?= $row_gather->purchase; ?></td>
                                            <td><?= $row_gather->mtm.' MTM'; ?></td>
                                        </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablenotorder3" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>ID User</th>
                                    <th>Basecamp</th>
                                    <th>Member</th>
                                    <th>Purchase</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($excess as $row_excess)
                                {
                                    ?>
                                        <tr>
                                            <td><?= date('Y/m/d H:i:s', $row_excess->datecreate); ?></td>
                                            <td><?= $row_excess->username; ?></td>
                                            <td><?= $row_excess->name; ?></td>
                                            <td><?= $row_excess->member; ?></td>
                                            <td><?= $row_excess->purchase; ?></td>
                                            <td><?= $row_excess->mtm.' MTM'; ?></td>
                                        </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->