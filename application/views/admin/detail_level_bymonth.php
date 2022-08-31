<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">Detail Level</h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Level</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                        //row bonus global
                        foreach ($detail as $row) : ?>
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
                                <td><?= $row->name == null ? '0' : $row->name; ?></td>
                                <td>
                                    <a href="<?= base_url() . 'admin/sponsornet/' . $row->sponsor_id; ?>">
                                        <?= $row->sponsor; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?= base_url() . 'admin/network/' . $row->position_id; ?>">
                                        <?= $row->position; ?>
                                    </a>
                                </td>
                                <td><?= $row->level_fm == NULL ? '-' : $row->level_fm; ?></td>
                            </tr>
                        <?php 
                        endforeach;
                            
                        //row excess bonus
                        if(!empty($excess))
                        {
                            foreach ($excess as $row_ex) : ?>
                                <tr>
                                    <td><?= $row_ex->update_date == NULL ? '-' : date('Y/m/d H:i:s', $row_ex->update_date); ?></td>
                                    <td><?= $row_ex->id; ?></td>
                                    <td>
                                        <a style="color:#858796;" href="<?= base_url() . 'admin/userDetail/' . $row_ex->id; ?>">
                                            <?= $row_ex->username; ?>
                                        </a>
                                    </td>
                                    <td><?= $row_ex->first_name; ?></td>
                                    <td>+<?= $row_ex->country_code; ?><?= $row_ex->phone; ?></td>
                                    <td><?= $row_ex->name == null ? '0' : $row_ex->name; ?> BOX</td>
                                    <td>
                                        <a href="<?= base_url() . 'admin/sponsornet/' . $row_ex->sponsor_id; ?>">
                                            <?= $row_ex->sponsor; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url() . 'admin/network/' . $row_ex->position_id; ?>">
                                            <?= $row_ex->position; ?>
                                        </a>
                                    </td>
                                    <td><?= $row_ex->level_fm == NULL ? '-' : $row_ex->level_fm; ?></td>
                                </tr>
                            <?php 
                            endforeach;
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