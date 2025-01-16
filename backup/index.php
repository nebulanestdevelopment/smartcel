<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Respaldo</title>
    <base href="../">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="SMARTCELL">
    <title>SMARTCELL</title>
    <link rel="apple-touch-icon" sizes="57x57" href="../assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="../vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="../assets/css/vendors/simplebar.css">
    <!-- Main styles for this application-->
    <link href="../assets/css/style.css" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="../assets/css/examples.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../vendors/select2/select2.min.css">
     <link rel="stylesheet" href="./backup/toastify.css">
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
</head>
<body>
   
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
 
      <div class="body flex-grow-1 px-3">
        <div class="container-fluid">
        <!--load view -->
            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="card-title"></h2>
                </div>
                <div class="card-body">
                <?php
        include './Connet.php';
    ?>
    
    <a href="../index.php" class="btn btn-danger text-white">Regresar al inicio</a>
<hr>
    <!--a href="./backup/Backup.php" class="btn btn-info text-white">Realizar copia de seguridad</a>
<hr-->
<button  class="btn btn-info text-white" onclick="genererBackup(this)">Realizar copia de seguridad</button>
<hr>
    <form action="./backup/Restore.php" method="POST">
        <label>Selecciona un punto de restauración</label><br>
        <select name="restorePoint" class="form-select">
            <option value="" disabled="" selected="">Selecciona un punto de restauración</option>
            <?php
                $ruta=BACKUP_PATH;
                if(is_dir($ruta)){
                    if($aux=opendir($ruta)){
                        while(($archivo = readdir($aux)) !== false){
                            if($archivo!="."&&$archivo!=".."){
                                $nombrearchivo=str_replace(".sql", "", $archivo);
                                $nombrearchivo=str_replace("-", ":", $nombrearchivo);
                                $ruta_completa=$ruta.$archivo;
                                if(is_dir($ruta_completa)){
                                }else{
                                    echo '<option value="'.$ruta_completa.'">'.$nombrearchivo.'</option>';
                                }
                            }
                        }
                        closedir($aux);
                    }
                }else{
                    echo $ruta." No es ruta válida";
                }
            ?>
        </select>
        <br>
        <button type="submit" class="btn btn-success">Restaurar</button>
    </form>
                </div>
            </div>
        <!-- ./load view -->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Generando copia de la base datos no cerrar la pestaña</h5>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

        </div>
      </div>
      <footer class="footer">
        <div>SMARTCELL © 2023</div>
        <div class="ms-auto">Powered by&nbsp;Nebula Nest Development</div>
      </footer>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="../vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="../vendors/simplebar/js/simplebar.min.js"></script>
    <script src="./backup/jquery-3.6.0.min.js"></script>
    <script src="./backup/toastify.js"></script>
    <script>

function genererBackup(id){
    Toastify({
            text: "Generando respaldo no cerrar la pestaña",
            duration: 3000,
            destination: "#",
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            },
            onClick: function(){} // Callback after click
            }).showToast();
            $("#staticBackdrop").modal({
                backdrop: 'static',
                keyboard: false
            }).modal('show');
           
            $.ajax({
                        url: './backup/respaldo.php', // Replace with your server URL
                        type: 'POST',
                        data: {
                            id: '1'
                        },
                        success: function(response) {
                            $("#staticBackdrop").modal('hide');
                            Toastify({
                                    text: "Respaldo generado con exito",
                                    duration: 60000,
                                    destination: "#",
                                    newWindow: true,
                                    close: true,
                                    gravity: "top", // `top` or `bottom`
                                    position: "center", // `left`, `center` or `right`
                                    stopOnFocus: true, // Prevents dismissing of toast on hover
                                    style: {
                                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                                    },
                                    onClick: function(){} // Callback after click
                                    }).showToast();
                                    
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
            });
            }

          
     
    </script>
    
  </body>
</html>
