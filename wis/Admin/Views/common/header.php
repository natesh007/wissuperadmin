<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WIS Admin</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/public/admin_assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/public/admin_assets/dist/css/adminlte.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url() ?>/public/admin_assets/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url() ?>/public/admin_assets/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/admin_assets/css/styles.css">
    <link rel="stylesheet" href=" <?= base_url() ?>/public/admin_assets/plugins/multiselect/bootstrap-multiselect.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">   
    
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="0">
  </div> -->

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
               
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                
                <li class="nav-item dropdown">
                  <a class="nav-link" data-toggle="dropdown" href="#">
                    <?= 'Hi, <span style="font-weight:900">' . session('Name') . '</span>'; ?> &nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-down"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-md dropdown-menu-center">
                    <a href="#" class="dropdown-item">
                      <i class="fas fa-key mr-2"></i> Change Password
                    </a>
                  </div>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('/admin/logout') ?>" role="button">Logout</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link text-center">
                <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
                <span class="brand-text font-weight-light">WIS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <!-- <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div> -->
                   
                </div>

                <!-- SidebarSearch Form -->
                <!-- <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                    </div>
                </div> -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                                  <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
                                      <i class="nav-icon fas fa-tachometer-alt"></i>
                                      <p>
                                          Dashboard
                                      </p>
                                  </a>
                              </li>
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-dice-d20  nav-icon"></i>
                                <p>
                                    Master Data
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php /*<li class="nav-item">
                                    <a href="<?= base_url('admin/admins') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Admins</p>
                                    </a>
                                </li>*/?>
                                 
                                <li class="nav-item">
                                    <a href="<?= base_url('admin/roles') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= base_url('admin/shifts') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Shifts</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= base_url('admin/organization_types') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Organization Types</p>
                                    </a>
                                </li>

                                
                                
                                
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-dice-d20  nav-icon"></i>
                                <p>
                                    Organizations
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                 
                                <li class="nav-item">
                                    <a href="<?= base_url('admin/organizations') ?>" class="nav-link">
                                        <i class="far fa-building nav-icon"></i>
                                        <p>Organizations</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('admin/buildings') ?>" class="nav-link">
                                        <i class="far fa-building nav-icon"></i>
                                        <p>Buildings</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('admin/floors') ?>" class="nav-link">
                                        <i class="far fa-building nav-icon"></i>
                                        <p>Floors</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                       
                        <li class="nav-item">
                          <a href="<?= base_url('admin/branches'); ?>" class="nav-link" id="UsersTab">
                              <i class="nav-icon fa fa-map-marker"></i>
                              <p>Branches</p>
                          </a>
                        </li>

                        <li class="nav-item">
                          <a href="<?= base_url('admin/departments'); ?>" class="nav-link" id="UsersTab">
                              <i class="nav-icon fa fa-users"></i>
                              <p>Departments</p>
                          </a>
                        </li>

                        <li class="nav-item">
                          <a href="<?= base_url('admin/departments'); ?>" class="nav-link" id="UsersTab">
                              <i class="nav-icon fa fa-user"></i>
                              <p>Employees</p>
                          </a>
                        </li>
                        
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>