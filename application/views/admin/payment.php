
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-white">Payment</h1>

                    <?= $this->session->flashdata('message'); ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>User ID</th>
                                            <th>Package</th>
                                            <th>Price</th>
                                            <th>TXID</th>
                                            <th>Note</th>
                                            <th>Status</th>
                                            <th>Confirm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($payment as $row_payment){ 
                                            if($row_payment->type == 1)
                                            {
                                                $package_type = 'FIL Mining';
                                            }
                                            elseif($row_payment->type == 2)
                                            {
                                                $package_type = 'MTM Mining';
                                            }
                                            ?>
                                        
                                            <tr>
                                                <td><?= date('d/m/Y', $row_payment->datecreate); ?></td>
                                                <td><?= $row_payment->username;  ?></td>
                                                <td><?= $row_payment->name . ' ' .$package_type; ?></td>
                                                <td>
                                                    <?php 
                                                        if($row_payment->fill != 0 )
                                                        {
                                                            echo $row_payment->fill . " FIL";
                                                        }
                                                        elseif($row_payment->usdt != 0)
                                                        {
                                                            echo $row_payment->usdt . " USDT";
                                                        }
                                                        elseif($row_payment->mtm != 0)
                                                        {
                                                            echo $row_payment->mtm . " MTM";
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <ul>
                                                    <?php
                                                        $trxid = $adminClass->trxid($row_payment->id);
                                                        foreach($trxid as $row_trxid)
                                                        {
                                                            echo "<li>".$row_trxid->txid."</li>";
                                                        }
                                                    ?>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($row_payment->is_payment == 3)
                                                        { 
                                                    ?>
                                                        <form method="post" action="<?= base_url('admin/saveNotePayment'); ?>">
                                                            <textarea class="form-control" name="note" cols="15" rows="5" style="width: auto;"><?= $row_payment->note; ?></textarea>
                                                            <input type="hidden" name="idcart" value="<?= $row_payment->id; ?>">
                                                            <button type="submit" class="btn btn-info btn-sm">
                                                                Send Note
                                                            </button>
                                                        </form>
                                                    <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                                <?= $row_payment->note; ?>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($row_payment->is_payment == 0)
                                                        {
                                                            echo "<span class='badge badge-warning'>Pending</span>";
                                                        }
                                                        elseif($row_payment->is_payment == 1)
                                                        {
                                                            echo "<span class='badge badge-success'>Success</span>";
                                                        }
                                                        elseif($row_payment->is_payment == 2)
                                                        {
                                                            echo "<span class='badge badge-danger'>Cancel</span>";
                                                        }
                                                        elseif($row_payment->is_payment == 3)
                                                        {
                                                            echo "<span class='badge badge-info'>Unconfirm</span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php 
                                                        if($row_payment->is_payment == 3)
                                                        {
                                                            ?>
                                                                <span data-toggle="tooltip" data-placement="left" title="Confirm payment">
                                                                    <a href="#" class="btn btn-success btn-circle btn-sm" id="<?= $row_payment->id; ?>" onclick="event.preventDefault(); show_confirm(this);">
                                                                        <i class="fas fa-check"></i>
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