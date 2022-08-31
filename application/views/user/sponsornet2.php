<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">Sponsor</h1>

    <div class="row text-center">
        <div class="col-md-12">
            <?php
            if ($sponsor['user_id'] != '') {
            ?>
                <ul class="tree">
                    <li>
                        <span>
                            <a href="#" id="<?= $user['id']; ?>" onclick="<?= ($user['id'] != '') ? 'event.preventDefault(); show_sponsor_details(this);' : ''; ?>">
                                <img src="<?= base_url('assets/img/') . $cart2['color']; ?>" alt="image">
                                <?= '<p>' . $user['username'] . '</p>'; ?>
                            </a>
                        </span>
                    <?php

                    $userLine = $userClass->showSponsorMember($user['id']);

                    if (count($userLine) != '') {
                        echo "<ul>";

                        foreach ($userLine as $row_line) {
                            $userLine = $userClass->showSponsorMember($row_line['user_id']);

                            if (count($userLine) != '') {
                                echo '<li> <a href="#" id="' . $row_line['user_id'] . '" onclick="event.preventDefault(); show_sponsor_details(this);"><span><img src="' . base_url('assets/img/') . $row_line['color'] . '" alt="image"><p>' . $row_line['username'] . '</p> </span></a>';
                                echo '<ul>';

                                foreach ($userLine as $row_line) {
                                    $userLine = $userClass->showSponsorMember($row_line['user_id']);

                                    if (count($userLine) != '') {
                                        echo '<li><a href="#" id="' . $row_line['user_id'] . '" onclick="event.preventDefault(); show_sponsor_details(this);"><span><img src="' . base_url('assets/img/') . $row_line['color'] . '" alt="image"><p>' . $row_line['username'] . '</p></span></a>';

                                        echo '<ul class="hide-responsive">';

                                        foreach ($userLine as $row_line) {
                                            $userLine = $userClass->showSponsorMember($row_line['user_id']);

                                            echo '<li><a href="#" id="' . $row_line['user_id'] . '" onclick="event.preventDefault(); show_sponsor_details(this);"><span><img src="' . base_url('assets/img/') . $row_line['color'] . '" alt="image"><p>' . $row_line['username'] . '</p></span></a></li>';
                                        }

                                        echo '</ul></li>';
                                    } else {
                                        echo '<li><a href="#" id="' . $row_line['user_id'] . '" onclick="event.preventDefault(); show_sponsor_details(this);"><span><img src="' . base_url('assets/img/') . $row_line['color'] . '" alt="img"><p>' . $row_line['username'] . '</p></span></a></li>';
                                    }
                                }

                                echo "</li></ul>";
                            } else {
                                echo '<li> <a href="#" id="' . $row_line['user_id'] . '" onclick="event.preventDefault(); show_sponsor_details(this);"><span><img src="' . base_url('assets/img/') . $row_line['color'] . '" alt="img"><p>' . $row_line['username'] . '</p> </span></a></li>';
                            }
                        }

                        echo "</ul>";
                    }
                } else {
                    echo "<p>Sponsored member was not found.</p>";
                }
                    ?>
                    </li>
                </ul>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!--Modal-->
<div class="modal fade" id="detailSponsorModal" tabindex="-1" role="dialog" aria-labelledby="detailSponsorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailSponsorModalLabel">Detail User</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="sponsor_detail_show_on_model"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <a class="btn btn-primary" href="" id="detailSponsorModalLink">View Member</a>
            </div>
        </div>
    </div>
</div>