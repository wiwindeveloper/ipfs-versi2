<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">
        
    </h1>

    <?= $this->session->flashdata('message'); ?>
    
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tablenotorder" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date Purchase</th>
                            <th>ID User</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Package</th>
                            <th>Level</th>
                            <th>Sponsor</th>
                            <th>Position</th>
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
                                    <td><?= $row_list->first_name; ?></td>
                                    <td><?= '+'.$row_list->country_code.$row_list->phone; ?></td>
                                    <td><?= $row_list->name; ?></td>
                                    <td><?= $row_list->fm; ?></td>
                                    <td><?= $row_list->sponsor; ?></td>
                                    <td><?= $row_list->position; ?></td>
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
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Confirm Modal-->
<div class="modal fade" id="basecampModal" tabindex="-1" role="dialog" aria-labelledby="basecampModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basecampModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="basecampModalBody"></div>
            
        </div>
    </div>
</div>