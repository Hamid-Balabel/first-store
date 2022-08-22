
<nav class="navbar navbar-dark bg-dark navbar-expand-lg  ">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php"> Home </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang('sections');?> </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang('ITEMS');?> </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php"><?php echo lang('MEMBERS');?> </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang('STATISTICS');?> </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang('LOGS');?> </a>
        </li>

        
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" style="cursor:pointer" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo lang('admin_area');?> 
          </a>

          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="members.php?do=edit&userid=<?php echo $_SESSION['ID']?>">Edit profile</a>
            <a class="dropdown-item" href="#">Setting</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
        

    </div>
  </div>    
</nav>