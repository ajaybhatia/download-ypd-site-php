<?php

require_once 'helpers/db_functions.php';

$instance = new DB_Functions();

$devices = [
    /*'yunicorn',*/
    'yutopia',
    'yunique', 
    'yuphoria', 
    'yureka',
];

$codenames = [
    /*'',*/
    'sambar',
    'jalebi',
    'lettuce',
    'tomato'
];

$hexcodes = [
    /*'',*/
    '-i 0x2A96',
    '',
    '-i 0x2A96',
    '-i 0x1ebf'
];

$builds = [];

foreach ($codenames as $idx => $codename) {
    $builds[$idx] = $instance->getBuildData($codename);
    $activeBuilds[$idx] = $instance->isActiveBuildPresent($codename);
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Downloads | YU Play Dev</title>

        <!-- Icon -->
        <link rel="icon" sizes="16x16" href="favicon.ico">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="assets/css/main.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <nav class="navbar navbar-blue navbar-fixed-top no-margin">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header fixed-brand">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  id="menu-toggle">
                    <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
                </button>
                <a class="navbar-brand" href="#">
                    Yu Play Dev Downloads
                </a>
            </div><!-- navbar-header-->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active" ><button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2"> <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></button></li>
                </ul>
            </div><!-- bs-example-navbar-collapse-1 -->
        </nav>
        <div id="wrapper">
            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
                <?php

                    foreach ($devices as $idx => $device) {      
                ?>

                    <li class="<?= ($idx == 0) ? 'active' : '' ?>">
                        <a href="#">
                            <span class="fa-stack fa-lg pull-left">
                                <i class="fa fa-mobile fa-stack-2x"></i>
                            </span>
                            <?= ucfirst($device) ?>
                        </a>
                        <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                            <li class="item-instruct">
                                <a href="#"><span class="fa-stack fa-lg pull-left">
                                    <i class="fa fa-flag fa-stack-1x "></i>
                                    </span>Flashing Instructions
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php
                    }
                ?>
                </ul>
            </div><!-- /#sidebar-wrapper -->
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid xyz">
                    <!-- Agreement Dialog -->                
                    <!-- Agreement Dialog ends -->

                    <div class="row">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="active" id="yu-open-os"><a href="#">YU-Open-OS</a></li>
                            <li><a href="#" id="yu-os">YUOS Official - Android 6.0.1</a></li>
                        </ul>
                        <div class="col-lg-12 table-responsive">
                        <?php

                            foreach ($builds as $idx => $build) {
                        ?>            
                            <table id="<?= $devices[$idx] ?>" class="table table-hover table-striped table-condensed paginated">
                            <caption class="text-center"><h3><?= ucfirst($devices[$idx]) ?> YU-OPEN-OS Build(s)</h3></caption>
                                <thead>
                                    <tr>
                                        <th>Device</th>
                                        <th>Type</th>
                                        <th>Filename</th>
                                        <th>sha1</th>
                                        <th>Date Added</th>
                                        <th>Downloads</th>
                                        <th>Changelog</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                  
                                    if ($build->num_rows == 0) {
                                ?>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <h4>Coming Soon</h4>
                                        </td>
                                    </tr>
                                <?php
                                    } else {
                                        while ($b = $build->fetch_object()) {
                                            if ($b->build_type == 'nightly') {
                                ?>
                                    <tr>
                                        <td><?= $b->device ?></td>
                                        <td><?= $b->build_type ?></td>
                                        <td>
                                            <a class="js-build-path" href="#" data-val="<?= $b->id ?>" data-href="<?= $b->build_path ?>">
                                                <?= $b->build_name ?>
                                            </a>
                                        </td>
                                        <td><?= $b->sha1 ?></td>
                                        <td><?= date_format(date_create($b->time_added), 'M d, Y g:i:s A') ?></td>
                                        <td><?= $b->downloads ?></td>
                                        <td>
                                            <?php if (empty($b->changelog_path)) {?>
                                            <a href="#">
                                                <i class="fa fa-times"></i>
                                            </a> 
                                            <?php } else { ?>
                                            <a href="<?= $b->changelog_path ?>">
                                                <i class="fa fa-file-text-o"></i>
                                            </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php
                                            }
                                       }
                                    }
                                ?>
                                </tbody>
                            </table>

                            <table id="<?= $devices[$idx] ?>-yuos" class="table table-hover table-striped table-condensed paginated">
                                <caption class="text-center"><h3><?= ucfirst($devices[$idx]) ?> YUOS Official - Android 6.0.1 Build(s)</h3></caption>
                                <thead>
                                    <tr>
                                        <th>Device</th>
                                        <th>Type</th>
                                        <th>Filename</th>
                                        <th>sha1</th>
                                        <th>Date Added</th>
                                        <th>Downloads</th>
                                        <th>Changelog</th>
                                    </tr>
                                    <tr>
                                </thead>
                                <tbody>
                                <?php
                                    if ($activeBuilds[$idx] == 0) {
                                ?>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <h4>Coming Soon</h4>
                                        </td>
                                    </tr>
                                <?php
                                    } else {
                                        $build->data_seek(0);
                                        while ($b = $build->fetch_object()) {
                                            if ($b->build_type == 'stable') {
                                ?>
                                    <tr>
                                        <td><?= $b->device ?></td>
                                        <td><?= $b->build_type ?></td>
                                        <td>
                                            <a class="js-build-path" href="#" data-val="<?= $b->id ?>" data-href="<?= $b->build_path ?>">
                                                <?= $b->build_name ?>
                                            </a>
                                        </td>
                                        <td><?= $b->sha1 ?></td>
                                        <td><?= date_format(date_create($b->time_added), 'M d, Y g:i:s A') ?></td>
                                        <td><?= $b->downloads ?></td>
                                        <td>
                                            <?php if (empty($b->changelog_path)) {?>
                                            <a href="#">
                                                <i class="fa fa-times"></i>
                                            </a> 
                                            <?php } else { ?>
                                            <a href="<?= $b->changelog_path ?>">
                                                <i class="fa fa-file-text-o"></i>
                                            </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php
                                            }
                                       }
                                    }
                                ?>
                                </tbody>
                            </table>

                            <div class="<?= $devices[$idx] ?>-flashing">
                                <div id="dialog">
                                    <strong>Flashing Instructions for <?= ucfirst($devices[$idx]) ?></strong>
                                    <ol>
                                        <li>Flash images with Fastboot</li>
                                            <ol class="u-alpha-list">
                                                <li>Execute below commands in terminal</li>
                                                <li>
                                                    Connect device in fastboot mode<br>
                                                    <code>adb reboot bootloader</code>
                                                </li>
                                                <li>
                                                    Check if device is detecting in fastboot mode<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> devices </code>
                                                </li>
                                                <li>
                                                    Unlock bootloader
                                                    <code>fastboot <?= $hexcodes[$idx] ?> oem unlock</code>
                                                </li>
                                                <li>
                                                    Flash kernel<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> flash boot boot.img</code>
                                                </li>
                                            <?php if ($devices[$idx] != "yureka") { ?>
                                                <li>
                                                    Flash emmc boot apps<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> flash aboot emmc_appsboot.mbn</code>
                                                </li>
                                                <li>
                                                    Flash Modem<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> flash modem NON-HLOS.bin</code>
                                                </li>
                                                <li>
                                                    Flash rpm<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> flash rpm rpm.mbn</code>
                                                </li>
                                                <li>
                                                    Flash sbl1<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> flash sbl1 sbl1.mbn</code>
                                                </li>
                                                <li>
                                                    Flash tz<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> flash tz tz.mbn</code>
                                                </li>
                                                <li>
                                                    Flash hyp<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> flash hyp hyp.mbn</code>
                                                </li>
                                                <li>
                                                    Flash splash<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> flash splash splash.img</code>
                                                </li>
                                            <?php } ?>    
                                                <li>
                                                    Flash recovery<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> flash recovery recovery.img</code>
                                                </li>
                                                <li>
                                                    Flash system partition<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> flash system system.img</code>
                                                </li>
                                                <li>
                                                    Flash data partition<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> flash userdata userdata.img</code>
                                                </li>
                                                <li>
                                                    Reboot device<br>
                                                    <code>fastboot <?= $hexcodes[$idx] ?> reboot</code>
                                                </li>
                                            </ol>
                                          <li>
                                            <strong>Flashing zip file with ADB sideload</strong>
                                            <ol class="u-alpha-list">
                                              <li>
                                                Connect device in recovery mode by executing below command in terminal<br>
                                                <code>adb reboot recovery</code>
                                              </li>
                                              <li>
                                                Select Apply Update from ADB
                                              </li>
                                              <li>
                                                Check if device is detecting in sideload<br>
                                                <code>adb devices</code>
                                              </li>
                                              <li>
                                                Sideload YU-OPEN-OS<br>
                                                <code>adb sideload path_to_zipfile</code>
                                              </li>
                                            </ol>
                                      </li>
                                    </ol>
                                </div>
                            </div>
                        <?php
                            }
                        ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="assets/js/jquery-2.2.4.min.js"></script>

        <!-- jQuery Session -->
        <script src="assets/js/jquery.session.js"></script>

        <!-- Bootstrap JavaScript -->
        <script src="assets/js/bootstrap.min.js"></script>

        <!-- Bootbox JS -->
        <script src="assets/js/bootbox.min.js"></script>

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="Hello World"></script>

        <!-- Custom js -->
        <script src="assets/js/main.js"></script>
    </body>

</html>
