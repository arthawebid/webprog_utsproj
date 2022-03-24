<?php
    function cekkonfig(){
        $ret = false;
        $ret = file_exists("konfigurasi.php");
        return $ret;
    }