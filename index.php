<?php

require_once 'helpers/db_functions.php';

$instance = new DB_Functions();

$devices = [
    'yunique', 
    'yuphoria', 
    'yureka',
    'yunicorn', 
    'yutopia',
];

$codenames = [
    'jalebi',
    'lettuce',
    'tomato',
    '',
    ''
];

$builds = [];

foreach ($codenames as $idx => $codename)
    $builds[$idx] = $instance->getBuildDate($codename);

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

        <nav class="navbar navbar-blue no-margin">
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
                    </li>
                <?php
                    }
                ?>
                </ul>
            </div><!-- /#sidebar-wrapper -->
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid xyz">
                    <div class="row">
                        <div class="col-lg-12">
                        <?php

                            foreach ($builds as $idx => $build) {
                        ?>            
                            <table id="<?= $devices[$idx] ?>" class="table table-responsive table-hover table-striped table-condensed">
                            <caption class="text-center"><h3><?= ucfirst($devices[$idx]) ?> Build(s)</h3></caption>
                                <thead>
                                    <tr>
                                        <th>Device</th>
                                        <th>Type</th>
                                        <th>Filename</th>
                                        <th>sha1</th>
                                        <th>Date Added</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                  
                                    if ($build->num_rows == 0) {
                                ?>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <h4>Coming Soon</h4>
                                        </td>
                                    </tr>
                                <?php
                                    } else {
                                        while ($b = $build->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?= $b->device ?></td>
                                        <td><?= $b->build_type ?></td>
                                        <td>
                                            <a href="<?= $b->build_path ?>">
                                                <?= $b->build_name ?>
                                            </a>
                                        </td>
                                        <td><?= $b->sha_1 ?></td>
                                        <td><?= date_format(date_create($b->time_added), 'M d, Y g:i:s A') ?></td>
                                    </tr>
                                <?php
                                       }
                                    }
                                ?>
                                </tbody>
                            </table>
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

        <!-- Bootstrap JavaScript -->
        <script src="assets/js/bootstrap.min.js"></script>

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="Hello World"></script>

        <!-- Custom js -->
        <script src="assets/js/main.js"></script>
    </body>

</html>
