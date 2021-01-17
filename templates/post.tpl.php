<?php
    include 'header.tpl.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="general">
        <div id="post">
            <form action="<?=BASE;?>post/insert" method="post">
                <label>Title</label>
                <input type="text" name="title" placeholder="Your Post Title">
                <label>Content</label>
                <input type="textarea" name="content" placeholder="Your Post">
                <label>Category</label>
                <input type="text" name="category" placeholder="Your Post Category">
                <label>Tag</label>
                <input type="text" name="tag" placeholder="Your Post Tag">
                <input type="submit" value="Enviar">
            </form>
        </div>
    </div>
</body>
</html>
<?php
    include 'footer.tpl.php';
?>