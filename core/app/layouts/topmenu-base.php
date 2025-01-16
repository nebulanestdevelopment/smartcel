<header class="header header-sticky mb-4">
        <div class="container-fluid">
          <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
            </svg>
          </button><a class="header-brand d-md-none" href="#">
            <svg width="118" height="46" alt="CoreUI Logo">
              <use xlink:href="assets/brand/coreui.svg#full"></use>
            </svg></a>
          
         
          <ul class="header-nav ms-3">
          <li class="nav-item dropdown">
               <strong>Tasa de Cambio Registrada: </strong>
               <span class=" badge text-bg-success text-white"><?php 
                    $tasa_cambio = floatval((new SystemData)->obtenerTasaCambio());
                    $tasa_cambio = number_format($tasa_cambio, 2, '.', ','); 
                    echo $tasa_cambio;
               ?>
               </span>
            </li>
            <li class="nav-item py-1">
              <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>
          <li class="nav-item dropdown">
                 
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                  <?php echo UsuarioData::getUserData(); ?>
              </a>
              <div class="dropdown-menu dropdown-menu-end pt-0">
                <div class="dropdown-header bg-light py-2">
                  <div class="fw-semibold">Cuenta</div>
                </div><a class="dropdown-item" href="./index.php?view=usuario-edit-password">
                  <svg class="icon me-2">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                  </svg> Configuracion</a>
                <div class="dropdown-header bg-light py-2">
                  <div class="fw-semibold">Settings</div>
                </div>
                <?php if(Roles::hasAdmin()){ ?>
                  <a class="dropdown-item" href="./index.php?view=usuario">
                  <svg class="icon me-2">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                  </svg> Usuarios</a>
				  <a class="dropdown-item" href="./backup/index.php">
                  <svg class="icon me-2">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-briefcase"></use>
                  </svg> Respaldar Base de Datos</a>
                <?php } ?>
                  <a class="dropdown-item" href="./index.php?view=sistemadata">
                  <svg class="icon me-2">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-file"></use>
                  </svg> Info Adicional</a>
               
                 
                <div class="dropdown-divider"></div><a class="dropdown-item" href="./logout.php">
                  <svg class="icon me-2">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                  </svg> Log out</a>
              </div>
            </li>
          </ul>
        </div>
      </header>