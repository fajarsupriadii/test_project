<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?= csrf_hash() ?>" />
        <title>Coding Test</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="/css/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="/css/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/css/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/css/datatables-buttons/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" href="/css/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="/css/adminlte/adminlte.min.css">
    </head>
    <?php $session = session(); ?>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="preloader flex-column justify-content-center align-items-center">
            </div>
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="/auth/logout" class="nav-link">Logout</a>
                    </li>
                </ul>
            </nav>

            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <a href="#" class="brand-link">
                    <span class="brand-text font-weight-light">Test Coding</span>
                </a>
                <div class="sidebar">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="info">
                            <a href="#" class="d-block"><?= $session->get('name') ?></a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <?php $menu = $session->get('menu'); ?>
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="/" class="nav-link">
                                    <i class="nav-icon fas fa-clipboard"></i>
                                    <p>Home</p>
                                </a>
                            </li>
                            <?php foreach ($menu as $value) { ?>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon <?= $value['modul_icon'] ?>"></i>
                                        <p>
                                            <?= $value['modul_name'] ?>
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if (isset($value['menu'])) {
                                        foreach ($value['menu'] as $valMenu) { ?>
                                            <li class="nav-item">
                                                <a href="<?= $valMenu['url'] ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?= $valMenu['name'] ?></p>
                                                </a>
                                            </li>
                                        <?php }
                                        } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                    <!-- End Sidebar Menu -->
                </div>
            </aside>

            <div class="content-wrapper">
                <?= $this->renderSection("content"); ?>
            </div>
            <footer class="main-footer">
                <strong>Copyright &copy; <?php echo date('Y'); ?>.</strong>
                All rights reserved.
            </footer>
        </div>

        <script src="/js/jquery/jquery.min.js"></script>
        <script src="/js/jquery-ui/jquery-ui.min.js"></script>
        <script src="/js/moment/moment.min.js"></script>
        <script src="/js/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/js/datatables/jquery.dataTables.min.js"></script>
        <script src="/js/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="/js/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="/js/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="/js/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="/js/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="/js/daterangepicker/daterangepicker.js"></script>
        <script src="/js/adminlte/adminlte.js"></script>
        <script src="/js/main.js"></script>
        <?= $this->renderSection("script"); ?>
    </body>
</html>
