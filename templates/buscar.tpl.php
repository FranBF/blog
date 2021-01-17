<?php
include 'header.tpl.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--<link rel="stylesheet" href="<?=BASE;?>public/acc.css">-->
</head>
<body>
<div id="general">
<h1>HOLA</h1>
<?php        
            if(isset($postT)){
                foreach($postT as $row){?>
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
                        </tr>
                    </table>
            <?php
                }
            }else{
                echo "No hay posts con ese tag";
            }
        ?>
</div>
</body>
</html>
<?php
include 'footer.tpl.php';