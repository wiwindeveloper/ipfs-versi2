
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-white">MINING</h1>

                    <?= $this->session->flashdata('message'); ?>
                    
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-4">
                            <div class="card shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-md-4 px-2 mb-5">
                                            <div class="text-center font-weight-bold text-primary text-uppercase mb-3">
                                                <img src="<?= base_url('assets/img/filcoin_logo.png'); ?>" width="40px" class="my-1">&nbsp;Add Mining Fil
                                            </div>
                                            <div class="h5 mb-0 text-gray-800 text-left">
                                                <form action="<?= base_url('admin/mining/1'); ?>" method="post">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="miningfil" name="miningfil" value="<?= set_value('miningfil'); ?>"
                                                            placeholder="Amount">
                                                        <?= form_error('miningfil', '<small class="text-danger pl-3">', '</small>'); ?>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                                        Save Mining Fil
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-md-4 px-2 mb-5">
                                            <div class="text-center font-weight-bold text-primary text-uppercase mb-3">
                                                <img src="<?= base_url('assets/img/mtm_logo.png'); ?>" width="40px" class="my-1">&nbsp;Add AirDrop MTM
                                            </div>
                                            <div class="h5 mb-0 text-gray-800 text-left">
                                                <form action="<?= base_url('admin/mining/2'); ?>" method="post">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="miningmtm" name="miningmtm" value="<?= set_value('miningmtm'); ?>"
                                                            placeholder="Amount">
                                                        <?= form_error('miningmtm', '<small class="text-danger pl-3">', '</small>'); ?>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                                        Save Airdrop MTM
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-md-4 px-2 mb-5">
                                            <div class="text-center font-weight-bold text-primary text-uppercase mb-3">
                                                <img src="<?= base_url('assets/img/zenith_logo.png'); ?>" width="40px" class="my-1">&nbsp;Add AirDrop Zenx
                                            </div>
                                            <div class="h5 mb-0 text-gray-800 text-left">
                                                <form action="<?= base_url('admin/mining/3'); ?>" method="post">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="miningzenx" name="miningzenx" value="<?= set_value('miningzenx'); ?>"
                                                            placeholder="Amount">
                                                        <?= form_error('miningzenx', '<small class="text-danger pl-3">', '</small>'); ?>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                                        Save Airdrop Zenx
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-12 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-3">
                                                History
                                            </div>
                                            <div class="h5 mb-0 text-gray-800 ">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Type</th>
                                                                <th>Amount</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($history as $row_history)
                                                                {
                                                                    if($row_history->type == 1)
                                                                    {
                                                                        $type = "Mining Fil";
                                                                        $coin = "FIL";
                                                                    }
                                                                    elseif($row_history->type == 2)
                                                                    {
                                                                        $type = "Airdrop MTM";
                                                                        $coin = "MTM";
                                                                    }
                                                                    elseif($row_history->type == 3)
                                                                    {
                                                                        $type = "Airdrop Zenx";
                                                                        $coin = "Zenx";
                                                                    }
                                                            ?>
                                                            <tr>
                                                                <td><?= date('Y/m/d H:i:s',$row_history->datecreate)?></td>
                                                                <td><?= $type; ?></td>
                                                                <td><?= $row_history->amount." ".$coin; ?></td>
                                                                <td>
                                                                    <span data-toggle="tooltip" data-placement="left" title="Edit">
                                                                        <a href="javascript:void(0)" class="btn btn-info btn-sm" title="Edit" onclick="edit_mining(<?= $row_history->id; ?>)">
                                                                            <i class="fas fa-pencil-alt"></i>
                                                                        </a>
                                                                    </span>
                                                                </td>
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
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <div class="modal fade modal-t50" id="modal_form" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Edit Mining Amount</h3>
                        </div>
                        <div class="modal-body form">
                            <form action="#" id="form" class="form-horizontal">
                                <input type="hidden" value="" name="id"/> 
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Date</label>
                                        <div class="col-md-9">
                                            <input name="date" class="form-control" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Type</label>
                                        <div class="col-md-9">
                                            <input name="typecoin" class="form-control" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Amount</label>
                                        <div class="col-md-9">
                                            <input name="mining-edit" placeholder="Amount" class="form-control" type="text">
                                            <small class="text-danger pl-3"></small>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnSave" onclick="save_edit_mining()" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>