<!DOCTYPE html>
<html lang="en">
    <head>
            <script src="<?php echo base_url('js/jquery-2.1.1.min.js'); ?>"></script>
            <script src="<?php echo base_url('js/bootstrap.js'); ?>" type="text/javascript" ></script>
            <link href="<?php echo base_url('css/bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" type="text/css" href="<?php  echo base_url('css/style.css'); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php  echo base_url('css/website-style.css'); ?>" />
            <style>
              
              #sign_in_header{
                padding:10px;
                 margin:0px -30px;
                margin-bottom: 50px;
                background-color: #428bca;

              }

              #sign_in_header>img{
                width: 100px;
                margin: 0px auto;
                display: block;
              }
              #sign_in{
                margin:50px auto;
                max-width: 500px;
                border-radius:5px;
                border:1px solid #ccc;
                overflow: hidden;
                padding:0px 5px;
              }
            </style>
    </head>
    <body>
    <div  class="container">
      <div id="sign_in">
    <div id="sign_in_header">
        <img src="<?php echo base_url('image/icon.png'); ?>" />
    </div>
    <h4 style="text-align:center;">Sign In</h4>
    <form class="form-horizontal" role="form">
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
        </div>
      </div>
      <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <div class="checkbox">
            <label>
              <input type="checkbox"> Remember me
            </label>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Sign in</button>
          <button type="button" class="btn btn-primary">Sign Up</button>
        </div>
      </div>
    </form>
  </div>
  </div>
</body>
</html>