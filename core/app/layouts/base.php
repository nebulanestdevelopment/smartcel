<?php if(!isset($_SESSION["user_id"])){header('location: ./login.php');}  ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="SMARTCELL">
    <title>SMARTCELL</title>
    <link rel="apple-touch-icon" sizes="57x57" href="./assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="./assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="./assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="./vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="./assets/css/vendors/simplebar.css">
    <!-- Main styles for this application-->
    <link href="./assets/css/style.css" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="./assets/css/examples.css" rel="stylesheet">
    
    <link rel="stylesheet" href="./vendors/select2/select2.min.css">
    <link rel="stylesheet" href="./vendors/dropzone/dropzone.min.css">    
    <!-- Include Dropzone CSS >
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">

<!-- Include Dropzone JS >
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script-->
    <style>
      .btn-group-xs > .btn, .btn-xs{
          padding: 1px 5px;
          font-size: 12px;
          line-height: 1.5;
          border-radius: 3px;
        }

        .select2-container .select2-selection--single {
          box-sizing: border-box;
          cursor: pointer;
          display: block;
          height: 38px;
          user-select: none;
          -webkit-user-select: none;
        }
    </style>
  </head>
  <body>
        <?php include_once 'sidebarmenu-base.php';?>

    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <?php include_once 'topmenu-base.php';?>
      <div class="body flex-grow-1 px-3">
        <div class="container-fluid">
        <!--load view -->
        <?php View::load("index");?>
        <!-- ./load view -->
        </div>
      </div>
      <footer class="footer">
        <div>SMARTCELL © 2023 - <?php echo date('Y'); ?></div>
        <div class="ms-auto">Powered by&nbsp;Nebula Nest Development</div>
      </footer>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="./vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="./vendors/simplebar/js/simplebar.min.js"></script>
    
  </body>
</html>
