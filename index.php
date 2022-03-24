<?php
    include_once("loadmodul.php");

    if(cekkonfig()){
        include_once("konfigurasi.php");
        include_once("moduls/prosedur.php");
        
        $hslpost = "";
        $dtax["stt"] = false;
        $p["pageslist"]="";
        $p["addnew"]="";
        $p["edit"]="";
        $p["del"]="";

        //post data
        if(isset($_POST["storedata"])){
            $dta["NIM"] = $_POST["txNIM"];
            $dta["NAMA"] = $_POST["txNAMA"];
            $dta["ALAMAT"] = $_POST["txALAMAT"];
            $dta["KOTA"] = $_POST["txKOTA"];
            $dta["JK"] = $_POST["txJK"];
            $dta["TGL_LAHIR"] = $_POST["txTALAG"];
            $dtax = storedata($dta);
        }
        if(isset($_POST["updatedata"])){
            $dta["NIM"] = $_POST["txNIM"];
            $dta["NAMA"] = $_POST["txNAMA"];
            $dta["ALAMAT"] = $_POST["txALAMAT"];
            $dta["KOTA"] = $_POST["txKOTA"];
            $dta["JK"] = $_POST["txJK"];
            $dta["TGL_LAHIR"] = $_POST["txTALAG"];            
            $dtax = updatedata($dta);

        }
        if(isset($_POST["Deletedata"])){
            $dta["NIM"] = $_POST["txNIM"];        
            $dtax = destroydata($dta);

        }
        //get data
        if(isset($_GET["act"])){
           $page = $_GET["act"];
           $p[$page]=" active";
        }else{
            $page = "";
            $p["pageslist"]=" active";
        }
        include_once("template.php");
    }else{
        include_once("moduls/buatdata.php");
        $judul = "Setup Database";
        include_once("setupdatabase.php");
    }