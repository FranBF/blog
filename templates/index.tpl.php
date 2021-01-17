<?php
    include 'header.tpl.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?=BASE;?>public/index.css">
    <title>Document</title>
    <script>  
        $(document).ready(function(){
            $(".btn1").on("click", function(){
                $(".form_comm").css("opacity", "1");
            });
        });
    </script>
</head>
<body>

<h1>Buscar</h1>
<form method="post" action="<?=BASE;?>buscar/index">
<input type='text' name='tag'>
<input type='submit' value='Enviar'>
</form>

    <h1><?php 
        if(isset($posts) && isset($comm)){
            foreach($posts as $row){?>
                <table border="1px solid black">
                    <tr>
                        <th>Titulo</th>
                        <th>Contenido</th>
                        <th>Fecha</th>
                        <th>Categoria</th>
                        <th>Tag</th>
                    </tr>
                    <tr>
                        <td><?=$row['title']?></td>
                        <td><?=$row['content']?></td>
                        <td><?=$row['created']?></td>
                        <td><?=$row['category']?></td>
                        <td><?=$row['tag']?></td>
                        <td><button name='bt' href='<?=BASE?>comment/insC/id/<?=$row['id_post']?>'
                        class='btn1'>Comentar</button></td>
                        <td class='form_comm'><form  method='post' action='<?=BASE?>comment/insC/id/<?=$row['id_post']?>'>
                        <input type='text' name='comm'>
                        <input type='submit' value='Enviar'>
                        </form></td><?php
                        if($row['user'] == $ident){?>
                            <td><form  method='post' action='<?=BASE?>index/delete/id/<?=$row['id_post']?>'>
                        <input type='submit' value='BORRAR'>
                        </form></td>
                        <?php } ?>
                        <br>
                    </tr>
                </table>
                <table border="2px olid black">
                    <tr>
                        <?php
                            foreach($comm as $c){
                                if($row['id_post'] == $c['post_id_comm']){?>
                                    <td><?=$c['content_comm']?></td>
                                    <?php if(isset($ident) && $ident != $c['id_user_comm'] && $ident == $row['user']){ ?>
                                        <td><form class='' method='post' action='<?=BASE?>index/block/id/<?=$c['id_user_comm']?>'>
                                    <input type='submit' value='Bloquear'>
                                    </form></td>
                        <?php   }
                            }
                            }
                        ?>
                    </tr>
                </table>
        <?php
            }
        }
        ?>
    </h1>
</body>
</html>
<?php
    include 'footer.tpl.php';
?>