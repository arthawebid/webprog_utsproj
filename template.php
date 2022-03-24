<?php
    $dtpage = loadpage($page,$dtax);
?><!DOCTYPE html>
<html>
    <head>
        <title><?=$dtpage["judul"];?></title>
        <link rel="stylesheet" href="framework/bootstrap/css/bootstrap.min.css">
    </head>
    <body>

        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#">Data Mahasiswa</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link<?=$p["pageslist"];?>" href="index.php">ListData</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?=$p["addnew"];?>" href="index.php?act=addnew">AddNew</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?=$p["edit"];?>" href="index.php?act=edit">EditData</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?=$p["del"];?>" href="index.php?act=del">Delete</a>
                </li>
                </ul>
            </div>
            </nav>
        </div>
        <div class="container">
            <?=$dtpage["page"]; ?>
        </div>
        <script src="framework/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
</html>