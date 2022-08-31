<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">Detail User Bonus</h1>

    <?= $this->session->flashdata('message'); ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bonus Sponsor (<?= $user['username']; ?>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="table1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Filecoin</th>
                            <th>MTM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bonus_sponsor as $row) : ?>
                            <tr>
                                <td><?= date('Y/m/d', $row->datecreate); ?></td>
                                <td><?= $row->username; ?></td>
                                <td><?= $row->filecoin; ?> FIL</td>
                                <td><?= $row->mtm; ?> MTM</td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bonus Sponsor Matching (<?= $user['username']; ?>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="table1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Filecoin</th>
                            <th>MTM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bonus_sponmatching as $row) : ?>
                            <tr>
                                <td><?= date('Y/m/d', $row->datecreate); ?></td>
                                <td><?= $row->username; ?></td>
                                <td><?= $row->filecoin; ?> FIL</td>
                                <td><?= $row->mtm; ?> MTM</td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bonus Recommended Mining (<?= $user['username']; ?>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="table1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Team</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bonus_recommended_mining as $row) : ?>
                            <tr>
                                <td><?= date('Y/m/d', $row->datecreate); ?></td>
                                <td><?= $row->username; ?></td>
                                <td>Team <?= $row->team; ?></td>
                                <td><?= $row->amount; ?> FIL</td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bonus Mining Generasi (<?= $user['username']; ?>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="table1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User ID</th>
                            <th>Member ID</th>
                            <th>Generation</th>
                            <th>Team</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bonus_mining_generasi as $row) : ?>
                            <tr>
                                <td><?= date('Y/m/d', $row->datecreate); ?></td>
                                <td><?= $row->username; ?></td>
                                <td><?= $this->M_user->get_user_byid($row->member_sponsor)['username']; ?></td>
                                <td><?= $row->generation; ?></td>
                                <td>Team <?= $row->team; ?></td>
                                <td><?= $row->amount; ?> FIL</td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bonus Pairing (<?= $user['username']; ?>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="table1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User ID</th>
                            <th>Set</th>
                            <th>MTM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bonus_pairing as $row) : ?>
                            <tr>
                                <td><?= date('Y/m/d', $row->datecreate); ?></td>
                                <td><?= $row->username; ?></td>
                                <td><?= $row->set_amount / 4; ?> set</td>
                                <td><?= $row->mtm; ?> MTM</td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bonus Pairing Matching (<?= $user['username']; ?>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="table1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User ID</th>
                            <th>Generation</th>
                            <th>MTM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bonus_pairing_matching as $row) : ?>
                            <tr>
                                <td><?= date('d/m/Y', $row->datecreate); ?></td>
                                <td><?= $row->username; ?></td>
                                <td><?= $row->generation; ?></td>
                                <td><?= $row->mtm; ?> MTM</td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bonus Global (<?= $user['username']; ?>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="table1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Omset</th>
                            <th>accumulation</th>
                            <th>MTM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($bonus_global as $row) :
                            $date = date('Y-m', $row->datecreate);
                            $date_omset = new DateTime($date);
                            $date_omset->modify('-1 month');
                            $dateNow = $date_omset->format('Y-m');
                        ?>

                            <tr>
                                <td><?= date('d/m/Y', $row->datecreate); ?></td>
                                <td><?= $this->M_user->get_omset_global($dateNow, $row->mtm, $date)[0]->total; ?> FIL</td>
                                <td><?= $this->M_user->get_omset_global($dateNow, $row->mtm, $date)[0]->accumulation; ?></td>
                                <td><?= $row->mtm; ?> MTM</td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bonus Basecamp (<?= $user['username']; ?>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="table1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>MTM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($bonus_basecamp as $row) {
                        ?>
                            <tr>
                                <td><?= date('d/m/Y', $row->update_date); ?></td>
                                <td>
                                    <?php if ($row->cart_id != 0) : ?>
                                        <?= $row->username; ?>
                                    <?php else : ?>
                                        <?= 'Team ' . $row->team; ?>
                                    <?php endif ?>
                                </td>
                                <td><?= $row->mtm; ?> MTM</td>
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