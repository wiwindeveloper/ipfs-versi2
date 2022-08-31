<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb text-white mb-4">Basecamp</h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Package</th>
                            <th>Bonus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail as $row) : ?>
                            <tr>
                                <td><?= date('Y/m/d', $row->update_date); ?></td>
                                <td><?= $row->username; ?></td>
                                <td><?= $row->name; ?></td>
                                <td><?= $row->mtm; ?> MTM</td>
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