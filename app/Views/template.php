<!DOCTYPE html lang="en">
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo site_info()->site_name ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo plugin_url(); ?>bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo plugin_url(); ?>font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo plugin_url(); ?>Ionicons/css/ionicons.min.css?<?php echo time() ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo css_url(); ?>AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
        <link rel="stylesheet" href="<?php echo css_url(); ?>skins/skin-purple.min.css">

        <link rel="stylesheet" href="<?php echo plugin_url() ?>datatables.net-bs/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-purple sidebar-collapse sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="<?php echo site_url('admin') ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b><?php echo site_info()->short_name ?></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b><?php echo site_info()->site_name ?></b></span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->


            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="<?php echo img_url() ?>user2-160x160.jpg" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?php echo $session->name ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  

                  <p>
                    <?php echo $session->name ?>
                    <small><?php echo $session->mobile_number ?></small>
                   
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  
                  <div class="pull-right">
                    <a href="<?php echo site_url('') ?>" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?php echo img_url(); ?>user2-160x160.jpg" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $session->name ?></p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>



        <!-- Sidebar Menu -->
<?php if($session->role_id==1) { ?>
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">HEADER</li>
          <!-- Optionally, you can add icons to the links -->
          <li class="active"><a href="<?php echo site_url('dashboard') ?>"><i class="fa fa-home"></i> <span>Dashboard</span></a>

            
              </ul>
<?php }?>
              <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
          </aside>

          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              <h1>
                <?php echo $title; ?>
              </h1>
              <ol class="breadcrumb">
                <?php foreach ($breadcrumb as $bc) { ?>
                <li class="<?php echo ($bc['active']===TRUE) ? 'active' : ''  ?>" >
                  <?php if($bc['active']===FALSE) { ?>
                  <a href="<?php echo $bc['url'] ?>">
                    <?php  } ?>
                    <i class="<?php echo $bc['icon'] ?>"></i> <?php echo $bc['title'] ?>
                    <?php if($bc['active']===FALSE) { ?>
                  </a>
                  <?php } ?>
                </li>
                <?php } ?>
              </ol>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">

              <?php echo view($_view); ?>

            </section>
            <!-- /.content -->
          </div>
          <!-- /.content-wrapper -->

          <!-- Main Footer -->
          <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
              Version <?php echo "1.0"; ?>
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; <?php date('Y') ?> <a href="#"><?php echo site_info()->company_name ?></a>.</strong> All rights reserved.
          </footer>

        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 3 -->
        <script src="<?php echo plugin_url(); ?>jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo plugin_url(); ?>bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- AdminLTE App -->


        <script src="<?php echo plugin_url() ?>datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo plugin_url() ?>datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo js_url(); ?>adminlte.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script>
          $(document).ready(function(){
            console.log($("table").hasClass('no-data-table'));
            if($("table").hasClass('no-data-table'))
            {

            }
            else
            {
              $('table').dataTable({
               responsive: true,
               buttons: [
               'copyHtml5',
               'excelHtml5',
               'csvHtml5',
               'pdfHtml5'
               ],
               dom: 'Bfrtip',
             }
             ); 
            }

          });


        </script>

      </body>
      </html>