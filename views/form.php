<!DOCTYPE html>
<html>

<head>
    <title><?php echo $options['title']; ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <div id="content">
        <h2>Product update form</h2>

        <form action="/index.php?id=process" method="post" enctype="multipart/form-data">
            Upload a file
            <input type="file" name="products_form" id="products_form" accept=".xml,.csv">
            <input type="submit" value="Upload" name="submit">
        </form>

        <?php echo $options['imports']; ?>
    </div>
</body>

</html>