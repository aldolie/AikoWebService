<!DOCTYPE html>
<html lang="en">
    <head>
            <script src="<?php echo base_url('js/jquery-2.1.1.min.js'); ?>"></script>
            <script src="<?php echo base_url('js/bootstrap.js'); ?>" type="text/javascript" ></script>
            <script src="<?php  echo base_url('js/modernizr.custom.63321.js'); ?>"></script>
            <link href="<?php echo base_url('css/bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" type="text/css" href="<?php  echo base_url('css/style.css'); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php  echo base_url('css/website-style.css'); ?>" />
            <script>
              $(document).ready(function(){
                  $( '#mi-slider' ).catslider();

              });
            </script>
            
          
    </head>
    <body>
        <!-- Nav bar-->
       <nav class="navbar navbar-default" role="navigation">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php echo base_url('/') ?>">
                <img class="vindy-icon" src="<?php echo base_url('image/icon.png'); ?> " >
              </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pria<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="<?php echo base_url('/items') ?>">Sepatu</a></li>
                    <li><a href="<?php echo base_url('/items') ?>">Pakaian</a></li>
                    <li><a href="<?php echo base_url('/items') ?>">Tas</a></li>
                    <li><a href="<?php echo base_url('/items') ?>">Jam Tangan</a></li>
                    <li><a href="<?php echo base_url('/items') ?>">Aksesoris</a></li>
                  </ul>
                </li>
                  
                  <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Wanita <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="<?php echo base_url('/items') ?>">Sepatu</a></li>
                    <li><a href="<?php echo base_url('/items') ?>">Pakaian</a></li>
                    <li><a href="<?php echo base_url('/items') ?>">Tas</a></li>
                    <li><a href="<?php echo base_url('/items') ?>">Jam Tangan</a></li>
                    <li><a href="<?php echo base_url('/items') ?>">Aksesoris</a></li>
                  </ul>
                </li>
                  
              </ul>
             
              <ul class="nav navbar-nav navbar-right">
                <li>
                  <a href="#">
                    <span class="glyphicon glyphicon-shopping-cart"></span>
                    <span style="margin-left:5px;background-color:#428bca;width:20px;height:20px;display:inline-block;text-align:center;border-radius:50%;color:white;">1</span>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <span class="glyphicon glyphicon-user"></span>
                    <span style="margin-left:5px">Aldo</span>
                  </a>
                </li>
                <li><a href="<?php echo base_url('/signin') ?>">Sign In</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
        <!-- Nav Bar-->
        
        <div class="page-wrap">
          <?php echo $content; ?>
        </div>

        <footer class="site-footer">

        </footer>
    </body>
</html>