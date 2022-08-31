<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb text-white mb-4">Users</h1>

    <?= $this->session->flashdata('message'); ?>
    <!-- <?= $this->M_user->get_user_byid(34)['username']; ?> -->

    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <div class="row">
                <div class="col-lg-6">
                    <table border="0" cellspacing="5" cellpadding="4">
                        <tbody>
                            <tr>
                                <td class="pl-0">Filter date:</td>
                                <td><input class="form-control form-control-sm" type="text" id="min" name="min"></td>
                                <td>-</td>
                                <td><input class="form-control form-control-sm" type="text" id="max" name="max"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="col-lg-6">
                    <table border="0" cellspacing="5" cellpadding="5" class="float-right">
                        <tbody>
                            <tr>
                                <td>Search:</td>
                                <td class="pr-0"><input class="form-control form-control-sm" type="text" id="myInputTextField"></td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Payment Date</th>
                            <th>Code User</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Package</th>
                            <th>Sponsor</th>
                            <th>Position</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($all_user as $row) : ?>
                            <tr>
                                <td><?= $row->update_date == NULL ? '-' : date('Y/m/d H:i:s', $row->update_date); ?></td>
                                <td><?= $row->id; ?></td>
                                <td>
                                    <a style="color:#858796;" href="<?= base_url() . 'admin/userDetail/' . $row->id; ?>">
                                        <?= $row->username; ?>
                                    </a>
                                </td>
                                <td><?= $row->first_name; ?></td>
                                <td>+<?= $row->country_code; ?><?= $row->phone; ?></td>
                                <td><?= $row->name == null ? '0' : $row->name; ?> BOX</td>
                                <td>
                                    <a style="color:#858796;" href="<?= base_url() . 'admin/sponsornet/' . $row->sponsor_id; ?>">
                                        <?= $row->sponsor_id == 0 ? '-' : $this->M_user->get_user_byid($row->sponsor_id)['username']; ?>
                                    </a>
                                </td>
                                <td>
                                    <a style="color:#858796;" href="<?= base_url() . 'admin/network/' . $row->position_id; ?>">
                                        <?= $row->position_id == 0 ? '-' : $this->M_user->get_user_byid($row->position_id)['username']; ?>
                                    </a>
                                </td>
                                <td><?= $row->fm == NULL ? '-' : $row->fm; ?></td>
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