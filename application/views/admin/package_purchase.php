<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">Bonus Global</h1>

    <?= $this->session->flashdata('message'); ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Total Purchase</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Omset</th>
                            <th>Total Purchase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchase as $row_purchase) {
                            $omset_fil = $row_purchase->total_fil + ($row_purchase->total_mtm / 4) + ($row_purchase->total_zenx / 12); ?>
                            <tr>
                                <td><?= $row_purchase->year; ?></td>
                                <td><a href="<?= base_url('admin/detailMonth/' . $row_purchase->year . '/' . $row_purchase->month) ?>"><?= date("F", mktime(0, 0, 0, $row_purchase->month, 10));  ?></a></td>
                                <td><?= !empty($row_purchase->total_box) ? $row_purchase->total_box." BOX" : '0'; ?> </td>
                                <td><?= !empty($omset_fil) ? $omset_fil . " FIL" : '0'; ?> </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Total Level</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>FM4 <span class="float-right">2%</span></th>
                            <th>FM5 <span class="float-right">1%</span></th>
                            <th>FM6 <span class="float-right">0,5%</span></th>
                            <th>FM7 <span class="float-right">0,4%</span></th>
                            <th>FM8 <span class="float-right">0,3%</span></th>
                            <th>FM9 <span class="float-right">0,2%</span></th>
                            <th>FM10 <span class="float-right">0,1%</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a class="text-dark" href="<?= base_url('admin/detailLevel/FM4'); ?>"><?= $fm4 + $fm5 + $fm6 + $fm7 + $fm8 + $fm9 + $fm10; ?></a>
                            </td>
                            <td>
                                <a class="text-dark" href="<?= base_url('admin/detailLevel/FM5'); ?>"><?= $fm5 + $fm6 + $fm7 + $fm8 + $fm9 + $fm10; ?></a>
                            </td>
                            <td>
                                <a class="text-dark" href="<?= base_url('admin/detailLevel/FM6'); ?>"><?= $fm6 + $fm7 + $fm8 + $fm9 + $fm10; ?></a>
                            </td>
                            <td>
                                <a class="text-dark" href="<?= base_url('admin/detailLevel/FM7'); ?>"><?= $fm7 + $fm8 + $fm9 + $fm10; ?></a>
                            </td>
                            <td>
                                <a class="text-dark" href="<?= base_url('admin/detailLevel/FM8'); ?>"><?= $fm8 + $fm9 + $fm10; ?></a>
                            </td>
                            <td>
                                <a class="text-dark" href="<?= base_url('admin/detailLevel/FM9'); ?>"><?= $fm9 + $fm10; ?></a>
                            </td>
                            <td>
                                <a class="text-dark" href="<?= base_url('admin/detailLevel/FM10'); ?>"><?= $fm10; ?></a>
                            </td>
                        </tr>
                        <!--<tr>-->
                        <!--    <td>-->
                        <!--        <ul class="list-unstyled mb-0">-->
                        <!--            <?php foreach ($user_fm4 as $row) : ?>-->
                        <!--                <li><?= $row->username; ?></li>-->
                        <!--            <?php endforeach ?>-->
                        <!--        </ul>-->
                        <!--    </td>-->
                        <!--    <td>-->
                        <!--        <ul class="list-unstyled mb-0">-->
                        <!--            <?php foreach ($user_fm5 as $row) : ?>-->
                        <!--                <li><?= $row->username; ?></li>-->
                        <!--            <?php endforeach ?>-->
                        <!--        </ul>-->
                        <!--    </td>-->
                        <!--    <td>-->
                        <!--        <ul class="list-unstyled mb-0">-->
                        <!--            <?php foreach ($user_fm6 as $row) : ?>-->
                        <!--                <li><?= $row->username; ?></li>-->
                        <!--            <?php endforeach ?>-->
                        <!--        </ul>-->
                        <!--    </td>-->
                        <!--    <td>-->
                        <!--        <ul class="list-unstyled mb-0">-->
                        <!--            <?php foreach ($user_fm7 as $row) : ?>-->
                        <!--                <li><?= $row->username; ?></li>-->
                        <!--            <?php endforeach ?>-->
                        <!--        </ul>-->
                        <!--    </td>-->
                        <!--    <td>-->
                        <!--        <ul class="list-unstyled mb-0">-->
                        <!--            <?php foreach ($user_fm8 as $row) : ?>-->
                        <!--                <li><?= $row->username; ?></li>-->
                        <!--            <?php endforeach ?>-->
                        <!--        </ul>-->
                        <!--    </td>-->
                        <!--    <td>-->
                        <!--        <ul class="list-unstyled mb-0">-->
                        <!--            <?php foreach ($user_fm9 as $row) : ?>-->
                        <!--                <li><?= $row->username; ?></li>-->
                        <!--            <?php endforeach ?>-->
                        <!--        </ul>-->
                        <!--    </td>-->
                        <!--    <td>-->
                        <!--        <ul class="list-unstyled mb-0">-->
                        <!--            <?php foreach ($user_fm10 as $row) : ?>-->
                        <!--                <li><?= $row->username; ?></li>-->
                        <!--            <?php endforeach ?>-->
                        <!--        </ul>-->
                        <!--    </td>-->
                        <!--</tr>-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->