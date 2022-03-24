<?php
include_once("moduls/prosedur.php");
if(isset($_POST["setupdb"])){
    $dtkonfig["dbname"] = $_POST["txDatabase"];
    $dtkonfig["dbuser"] = $_POST["txUser"];
    $dtkonfig["dbpass"] = $_POST["txPass"];
    $dtkonfig["dbhost"] = $_POST["txHost"];
    $dtkonfig["dbport"] = $_POST["txPort"];
    setupdb($dtkonfig);
}
?><!DOCTYPE html>
<html>
    <head>
        <title><?=$judul?></title>
        <link rel="stylesheet" href="framework/bootstrap/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <h3>Setup Database</h3>
            <form method="post">
            <div class="form-group">
                <label for="txDatabase">Nama Database</label>
                <input type="text" class="form-control" id="txDatabase" name="txDatabase" placeholder="Nama Database">
            </div>
            <div class="form-group">
                <label for="txUser">User Name</label>
                <input type="text" class="form-control" id="txUser" name="txUser" placeholder="Nama User Database">
            </div>
            <div class="form-group">
                <label for="txPass">Password</label>
                <input type="text" class="form-control" id="txPass" name="txPass" placeholder="Password User Database">
            </div>
            <div class="form-group">
                <label for="txHost">Host</label>
                <input type="text" class="form-control" id="txHost" name="txHost" value="localhost" placeholder="Host Server Database">
            </div>
            <div class="form-group">
                <label for="txPort">Port</label>
                <input type="text" class="form-control" id="txPort" name="txPort" value="3306" placeholder="Port Server Database">
            </div>
            <p>
            <div class="form-group">
            
                <button type="submit" name="setupdb" class="btn btn-primary">Setup Database</button>

            </div>
</p>
            </form>    
        </div>
        <script src="framework/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
</html>