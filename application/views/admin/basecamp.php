<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">Basecamp</h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>Create Basecamp</h5>
            <form action="<?= base_url('admin/basecamp'); ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Basecamp Name:</label>
                            <input class="form-control" id="exampleFormControlInput1" type="text" name="basecampname">
                            <?= form_error('basecampname', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select user:</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="usercamp">
                                <option value="">- Select -</option>
                                <?php
                                    foreach($list as $rowlist)
                                    {
                                        ?>
                                        <option value="<?= $rowlist->id; ?>"><?= $rowlist->username; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <?= form_error('usercamp', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="mt-2 col-md-6">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>Basecamp Leader</h5>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Basecamp</th>
                            <th>Omset</th>
                            <th>User</th>
                            <th>Total Bonus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($basecamp as $row_basecamp) { 
                                $bonus = $row_basecamp->bonus + $row_basecamp->excess;
                            ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url('admin/detailBasecamp/').$row_basecamp->id;?>">
                                        <?= $row_basecamp->name; ?>
                                    </a>
                                </td>
                                <td>
                                        <?= !empty($row_basecamp->omset) ? $row_basecamp->omset." BOX" : "0"; ?>  
                                </td>
                                <td>
                                    <a href="#" id="<?= $row_basecamp->id; ?>" onclick="event.preventDefault(); open_basecamp(this);">
                                        <?= $row_basecamp->username; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/detailBasecampOmset/').$row_basecamp->id.'/'.$row_basecamp->userid;?>">
                                        <?= !empty($bonus) ? $bonus : '0'; ?> MTM
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>History Basecamp Bonus</h5>
            <div class="table-responsive">
                <table class="table table-bordered" id="tablenotorder" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Name</th>
                            <th>Basecamp</th>
                            <th>Level</th>
                            <th>Purchase</th>
                            <th>Total Bonus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($history as $row_history)
                            {
                                ?>
                                <tr>
                                    <td><?= $row_history->username;?></td>
                                    <td><?= $row_history->first_name;?></td>
                                    <td><?= $row_history->name;?></td>
                                    <td><?= $row_history->fm;?></td>
                                    <td><?= !empty($row_history->purchase) ? $row_history->purchase.' BOX' : '0';?></td>
                                    <td><?= $row_history->bonus;?></td>
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