<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb text-white mb-4">Users</h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail User</h6>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('admin/userDetail/' . $detail['id']); ?>">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="table-responsive">
                            <input type="hidden" name="id" value="<?= $detail['id']; ?>">
                            <input type="hidden" name="username" value="<?= $detail['username']; ?>">
                            <table border=" 0" width="100%" cellspacing="4" cellpadding="4">
                                <tbody>
                                    <tr>
                                        <th style="width:20%">Register Date :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= date('Y/m/d H:i:s', $detail['date_created']) ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Date :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= date('Y/m/d H:i:s', $detail['update_date']) ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>ID :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= $detail['username'] ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Password :</th>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" id="password" name="password" placeholder="Change Password">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>OTP :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= $detail['is_otp'] == 1 ? 'Active' : 'Unactive'; ?>
                                                <div class="float-right <?= $detail['is_otp'] == 1 ? 'd-inline' : 'd-none'; ?> ml-2">
                                                    <input type="checkbox" name="otp" id="otp" value=0>
                                                    <label for="otp">Unactive</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nama :</th>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" id="first_name" name="first_name" value="<?= $detail['first_name']; ?>" placeholder="Change Name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Email :</th>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" id="email" name="email" value="<?= $detail['email']; ?>" placeholder="Change Email">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Country :</th>
                                        <td>
                                            <select class="form-control form-control-sm " id="country" name="country">
                                                <option class="text-black" value="62" <?= $detail['country_code'] == '62' ? 'selected' : '' ?>>INDONESIA (+62)</option>
                                                <option class="text-black" value="82" <?= $detail['country_code'] == '82' ? 'selected' : '' ?>>KOREA (+82)</option>
                                                <option class="text-black" value="1" <?= $detail['country_code'] == '1' ? 'selected' : '' ?>>UNITED STATE (+1)</option>
                                                <option class="text-black" value="44" <?= $detail['country_code'] == '44' ? 'selected' : '' ?>>UNITED KINGDOM (+44)</option>
                                                <option class="text-black" value="66" <?= $detail['country_code'] == '66' ? 'selected' : '' ?>>CHINA (+66)</option>
                                                <option class="text-black" value="84" <?= $detail['country_code'] == '84' ? 'selected' : '' ?>>VIETNAM (+84)</option>
                                                <option class="text-black" value="86" <?= $detail['country_code'] == '86' ? 'selected' : '' ?>>THAILAND (+86)</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phone :</th>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" id="phone" name="phone" value="<?= $detail['phone']; ?>" placeholder="Change Phone Number">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Basecamp :</th>
                                        <td>
                                            <select class="form-control form-control-sm" id="basecamp" name="basecamp">
                                                <?php foreach ($camp as $row) : ?>
                                                    <option class="text-black" value="<?= $row->id; ?>" <?= $detail['basecamp'] == $row->name ? 'selected' : ''; ?>><?= $row->name; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sponsor :</th>
                                        <td>
                                            <a style="color:#858796;" href="<?= base_url('admin/sponsornet/' . $detail['sponsor_id']); ?>" target="_blank">
                                                <div class="form-control form-control-sm">
                                                    <?= $detail['sponsor_id'] == 0 ? '-' : $this->M_user->get_user_byid($detail['sponsor_id'])['username']; ?>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Position :</th>
                                        <td>
                                            <a style="color:#858796;" href="<?= base_url('admin/network/' . $detail['position_id']); ?>" target="_blank">
                                                <div class="form-control form-control-sm">
                                                    <?= $detail['position_id'] == 0 ? '-' : $this->M_user->get_user_byid($detail['position_id'])['username']; ?>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Level :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= $detail['fm']; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Package :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= $detail['name'] . ' BOX'; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Notif :</th>
                                        <td>
                                            <!-- <input type="text" class="form-control form-control-sm" id="notif" name="notif" value="<?= $detail['note']; ?>" placeholder="Put notif to user here . . ."> -->
                                            <textarea class="form-control form-control-sm" id="notif" name="notif" rows="3"><?= empty($detail['note']) ? NULL : $detail['note'] ?></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="gauge mx-auto my-4">
                            <?php
                            $mtm = $total_mtm + $mining_mtm_total;
                            $i = $mtm;
                            $max = $detail['total_mtm'] ?? 1;
                            $max_bonus = $max * 3;
                            $hasil = $i / $max_bonus * 300;
                            ?>
                            <div class="arc" style="background-image:
                                                    radial-gradient(#fff 0, #fff 60%, transparent 60%),
                                                    conic-gradient(#e7141a 0, #ec4c48 <?= $hasil / 300 * 180; ?>deg, #ccc <?= $hasil / 300 * 180; ?>deg, #ccc 180deg, transparent 180deg, transparent 360deg);"></div>
                            <div class="pointer" style="transform: rotate(<?= $hasil / 300 * 180; ?>deg) translateX(0%) translateY(-100%); background: rgba(37, 37, 37, 0.5)"></div>
                            <div class="mask-white"></div>
                            <div class="label text-dark"><?= str_replace('.', ',', round($hasil, 1)) ?>%</div>
                        </div>
                        <div class="table-responsive">
                            <table border="0" width="100%" cellspacing="4" cellpadding="4">
                                <tbody>
                                    <tr>
                                        <th style="width:30%">General balance ZENX :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= str_replace('.', ',', number_format($general_balance_zenx, 10)) ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Bonus balance ZENX :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= str_replace('.', ',', number_format(0, 10)); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pb-3">Airdrop ZENX :</th>
                                        <td class="pb-3">
                                            <div class="form-control form-control-sm">
                                                <?= str_replace('.', ',', number_format(0, 10)); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%">General balance FIL :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= str_replace('.', ',', number_format($general_balance_fil, 10)); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Bonus balance FIL :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= str_replace('.', ',', number_format($balance_fil, 10)); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pb-3">Mining FIL :</th>
                                        <td class="pb-3">
                                            <div class="form-control form-control-sm">
                                                <?= str_replace('.', ',', number_format($mining_fil_balance, 10)) ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:20%">General balance MTM :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= str_replace('.', ',', number_format($general_balance_mtm, 10)); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Bonus balance MTM :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= str_replace('.', ',', number_format($balance_mtm, 10)); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total Bonus MTM :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= str_replace('.', ',', number_format($total_mtm, 10)); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Airdrop MTM :</th>
                                        <td>
                                            <div class="form-control form-control-sm">
                                                <?= str_replace('.', ',', number_format($mining_mtm_balance, 10)) ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pb-3">Total Airdrop MTM :</th>
                                        <td class="pb-3">
                                            <div class="form-control form-control-sm">
                                                <?= str_replace('.', ',', number_format($mining_mtm_total, 10)) ?>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="pb-3">Excess Bonus :</th>
                                        <td class="pb-3">
                                            <div class="form-control form-control-sm">
                                                <?= str_replace('.', ',', number_format($excess_bonus['mtm'], 10)) ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <div class="p-2 w-50">
                        <button type="submit" name="save" class="btn btn-primary btn-block">
                            Save
                        </button>
                    </div>
                    <div class="p-2 w-50">
                        <a href="<?= base_url('admin/allUsers'); ?>" class="btn btn-secondary btn-block">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->