<a class="nav-link dropdown-toggle topbar-icon" href="#" id="alertsDropdown" role="button"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <!-- <i class="fas fa-bell fa-fw"></i> -->
    <img src="<?= base_url('assets/img/icon-04.png'); ?>" width="24px">
    <!-- Counter - Alerts -->
    <?php
        if($amount_notif > 0){
    ?>
        <span class="badge badge-danger badge-counter"><?= $amount_notif; ?>+</span>
    <?php
        }
    ?>
</a>
<!-- Dropdown - Alerts -->
<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
    aria-labelledby="alertsDropdown">
    <h6 class="dropdown-header">
        Notification
    </h6>

    <?php
        foreach($list_notif as $row_list)
        {
            if($row_list->type == 1 || $row_list->type == 2 || $row_list->type == 4 || $row_list->type == 5 || $row_list->type == 6)
            {
                $url = base_url().$row_list->link.'/'.$row_list->id;
            }
            elseif($row_list->type == 3)
            {
                $url = '#';
            }
    ?>
    <a class="dropdown-item d-flex align-items-center" href="<?= $url; ?>" <?php if($row_list->is_show == 0){ echo "style='background: #f7f7f7;'";}?>>
        <div class="mr-3">
            <?php
                if($row_list->type == 1 || $row_list->type == 3 || $row_list->type == 5 || $row_list->type == 6)
                {
            ?>
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
            <?php
                }
                elseif($row_list->type == 2 || $row_list->type == 4)
                {
            ?>
                    <div class="icon-circle bg-success">
                        <i class="fas fa-check text-white"></i>
                    </div>
            <?php
                }
            ?>
        </div>
        <div>
            <div class="small text-gray-500"><?= date('d M Y', $row_list->datecreate); ?></div>
            <div>
                <?= $row_list->title; ?>: <?= $row_list->message; ?>
            </div>
        </div>
    </a>
    <?php
        }
    ?>

    <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Notification</a> -->
</div>

