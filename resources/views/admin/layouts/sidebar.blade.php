 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">    
      <span class="brand-text font-weight-light">FormBulider</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">       
        <div class="info"> 
          <a href="#" class="d-block"> User Name: {{auth()->user()->name;}}</a>       
          <a href="#" class="d-block">Role: <?php
             if(auth()->user()->is_admin !=1) 
             {
              echo "User";
             }else{
              echo "Admin";
             }
             ?>
            </a>           
        </div>
      </div>

  
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <!-- <i class="right fas fa-angle-left"></i> -->
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('forms.index')}}"  class="nav-link">
              <i class="nav-icon fab fa-wpforms "></i>
              <p>
                Form
                <!-- <i class="right fas fa-angle-left"></i> -->
              </p>
            </a>
          </li>        
          <?php if(auth()->user()->is_admin == 1) 
             { ?>
          <li class="nav-item">
            <a href="{{route('users.index')}}"  class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
                <!-- <i class="right fas fa-angle-left"></i> -->
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('roles.index')}}"  class="nav-link">
              <!-- <i class="nav-icon fas fa-user-cog"></i> -->
              <p>
                <!-- Roles -->
                
              </p>
            </a>
            </li>
            <a href="{{ route('permission') }}" class="nav-link">         
              <!-- <i class="nav-icon 	fas fa-user-lock"></i> -->
              <p>
                <!-- Permissions               -->
              </p>
            </a>
            </li>
          </li>
              <?php } ?>

            <li class="nav-item">
              <a href="{{ route('usersubmitform.index') }}" class="nav-link"> 
              <i class="fa fa-paper-plane" aria-hidden="true"></i>
                User Submit Forms
              </a>
            </li>
          
        
      
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
