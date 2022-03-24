<?php
    function updatekonfig($dtkonfig){
        $file = fopen("konfigurasi.php","w+");
        fwrite($file,"<?php\n//file konfigurasi\n");
        fwrite($file,'define("DBNAME","'.$dtkonfig["dbname"].'");'."\n");
        fwrite($file,'define("DBUSER","'.$dtkonfig["dbuser"].'");'."\n");
        fwrite($file,'define("DBPWD","'.$dtkonfig["dbpass"].'");'."\n");
        fwrite($file,'define("DBSERVER","'.$dtkonfig["dbhost"].'");'."\n");
        fwrite($file,'define("DBPORT","'.$dtkonfig["dbport"].'");'."\n");
        fclose($file);
    }
    function createdata($dtkonfig){
        $table = "mhs";
        $sql = "CREATE TABLE $table(
            NIM varchar(8) PRIMARY KEY,
            NAMA varchar(30) NOT NULL,
            ALAMAT varchar(50) NOT NULL,
            KOTA varchar(50),
            JK varchar(1),
            TGL_LAHIR date
        );";

        $cnn = new mysqli($dtkonfig["dbhost"],$dtkonfig["dbuser"],$dtkonfig["dbpass"],$dtkonfig["dbname"],$dtkonfig["dbport"]);
            
        if ($cnn->connect_error) {
            die("Connection failed: " . $cnn->connect_error);
        }

        if ($cnn->query($sql) === TRUE) {
            echo "<br>Table $table created successfully";
        } else {
            echo "Error Created Table $table: " . $cnn->error;
        }
    }
    function createdb($dtkonfig){
        $sql = "CREATE DATABASE ".$dtkonfig["dbname"] .";";
        $cnn = new mysqli($dtkonfig["dbhost"],$dtkonfig["dbuser"],$dtkonfig["dbpass"]);
    
        if ($cnn->connect_error) {
            die("Connection failed: " . $cnn->connect_error);
        }
        //membuat database dengan nama datamhs
        if ($cnn->query($sql) === TRUE) {
        echo "<br>Database created successfully";
        } else {
        echo "Error creating database: " . $cnn->error;
        }

        $cnn->close();    
    }
    function reloadpage(){
        $js = "<script>location.reload();</script>";
        echo $js;
    }
    function setupdb($dtkonfig){
        updatekonfig($dtkonfig);
        createdb($dtkonfig);
        createdata($dtkonfig);
        reloadpage();
        die();
    }