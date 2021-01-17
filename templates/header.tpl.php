<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?=BASE;?>public/head.css">
</head>
<body>
<div class="nav">
  <input type="checkbox" id="nav-check">
  <div class="nav-header">
    <div class="nav-title">
      TheBlog
    </div>
  </div>
  <div class="nav-btn">
    <label for="nav-check">
      <span></span>
      <span></span>
      <span></span>
    </label>
  </div>
  
  <div class="nav-links">
    <a href="<?=BASE;?>">Inicio</a>
    <a href="<?=BASE;?>login">Login</a>
    <a href="<?=BASE;?>register">Register</a>
    <?php 
            use App\Session;
            if(Session::get('email') != null){?>
                <a href="<?=BASE;?>logout/logout">Cerrar sesion</a>
            <?php }
        ?>
    <a href="<?=BASE;?>post">Crear Post</a>
    <a href="<?=BASE;?>account"><?php echo Session::get('email');?></a>
  </div>
</div>
</body>
</html>