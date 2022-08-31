<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="filecoin community">
    <meta name="author" content="PT Coop World Indonesia">

    <title><?= $title ?></title>
    <link rel="icon" href="<?= base_url('assets/img/filcoin_logo.png');?>">

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>css/custome.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary bg-signin">
    <?php if ($this->uri->segment(2) != 'customer_service') { ?>
        <div class="chatbutton">
            <a href="<?= base_url('auth/customer_service'); ?>">
                <img src="<?= base_url('assets/img/icon-05.png'); ?>" alt="Chat-Button" width="40px">
            </a>
        </div>
    <?php } ?>