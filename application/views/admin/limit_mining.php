
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-white">Limit Mining</h1>

                    <?= $this->session->flashdata('message'); ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>Package</th>
                                            <th>Limit</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach($list_mining as $row_list){ 
                                            $dateNow        = date('Y-m-d');
                                            $datepay        = date('Y-m-d', $row_list->update_date);
                                            $start_mining   = date('Y-m-d', strtotime("+45 day", strtotime($datepay)));
                                            $use_mining = (strtotime($dateNow) - strtotime($start_mining)) / (60 * 60 * 24);

                                            if($use_mining <= 0)
                                            {
                                                $all_use_mining = 0;
                                            }
                                            else
                                            {
                                                $all_use_mining = $use_mining;
                                            }
                                        ?>
                                        
                                            <tr>
                                                <td><?= $row_list->username;  ?></td>
                                                <td><?= $row_list->name; ?></td>
                                                <td><?= $all_use_mining.'/'.$row_list->daysmining; ?></td>
                                                <td>
                                                    <?php
                                                        if($row_list->pause_min == '1')
                                                        {
                                                            echo "<span class='badge badge-danger'>Pause</span>";
                                                        }
                                                        else
                                                        {
                                                            echo "<span class='badge badge-success'>Active</span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php 
                                                        if($row_list->pause_min != '1')
                                                        {
                                                            ?>
                                                                <span data-toggle="tooltip" data-placement="left" title="Pause Mining">
                                                                    <a href="#" class="btn btn-danger btn-circle btn-sm" id="<?= $row_list->id; ?>" onclick="event.preventDefault(); pause_mining(this);">
                                                                        <i class="fas fa-pause"></i>
                                                                    </a>
                                                                </span>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                                <span data-toggle="tooltip" data-placement="left" title="Continue Mining">
                                                                    <a href="#" class="btn btn-warning btn-circle btn-sm" id="<?= $row_list->id; ?>" onclick="event.preventDefault(); continue_mining(this);">
                                                                        <i class="fas fa-play"></i>
                                                                    </a>
                                                                </span>
                                                            <?php
                                                        }
                                                    ?> 
                                                </td>
                                            </tr>
                                        <?php } ?>
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
            <div class="modal fade" id="pauseModal" tabindex="-1" role="dialog" aria-labelledby="pauseModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pauseModalLabel"></h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" id="pauseModalBody"></div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="#" id="pauseLink">OK</a>
                        </div>
                    </div>
                </div>
            </div>