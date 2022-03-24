<?php
    function listdata(){
        $sql = "SELECT * FROM mhs;";
        $cnn = new mysqli(DBSERVER,DBUSER,DBPWD,DBNAME,DBPORT);
            
        if ($cnn->connect_error) {
            die("Connection failed: " . $cnn->connect_error);
        }
        $result = $cnn->query($sql);

        $ls = '<table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th><a href="?act=addnew">AddNew</a></th>
                </tr>
            </thead><tbody>';
        if ($result->num_rows > 0) {
            $no=0;
            while($row = $result->fetch_assoc()) {
                $no++;
                $ls .= '
                <tr>
                    <td>'.$no.'</td>
                    <td>'.$row["NIM"].'</td>
                    <td>'.$row["NAMA"].'</td>
                    <td><a href="index.php?act=edit&nim='.$row["NIM"].'">edit</a> <a href="index.php?act=del&nim='.$row["NIM"].'">del</a></td>
                    
                </tr>';
                
            }
        }
        $ls .= '</tbody></table>';
        return $ls;
    }

    function addnew($stt=""){
        $sttx = "";
        if(!$stt["stt"]==""){
            if($stt["stt"]=="SUKSES"){
                $sttx = '<div class="alert alert-success" role="alert">
                    Data telah tersimpan
                </div><script>const myTimeout = setTimeout(autoloadpage, 5000);
                function autoloadpage() {
                    window.location.href ="index.php";  
                }</script>';
            }else{
                $sttx = '<div class="alert alert-danger" role="alert">
                    Terjadi masalah saat penyimpanan
                </div>';
            }
        }
        return '<div class="container">
        <h3>Add New Data</h3>'.$sttx.'<form method="post">
            <div class="form-group">
                <label for="txDatabase">NIM</label>
                <input type="text" class="form-control" id="txNIM" name="txNIM" placeholder="NIM Mahasiswa">
            </div>
            <div class="form-group">
                <label for="txDatabase">Nama</label>
                <input type="text" class="form-control" id="txNAMA" name="txNAMA" placeholder="Nama Mahasiswa">
            </div>
            <div class="form-group">
                <label for="txDatabase">Alamat</label>
                <input type="text" class="form-control" id="txALAMAT" name="txALAMAT" placeholder="Alamat Mahasiswa">
            </div>
            <div class="form-group">
                <label for="txDatabase">Kota</label>
                <input type="text" class="form-control" id="txKOTA" name="txKOTA" placeholder="Kota Mahasiswa">
            </div>
            <div class="form-group">
                <label for="txDatabase">Jenis Kelamin</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="txJK" value="L" name="txJK"><label class="form-check-label" for="LakiLaki">Laki-Laki</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="txJK" value="P" name="txJK"><label class="form-check-label" for="Peremouan">Perempuan</label>
                </div>
            </div>
            <div class="form-group">
                <label for="txDatabase">TGL Lahir</label>
                <input type="date" class="form-control" id="txTALAG" name="txTALAG" placeholder="NIM Mahasiswa">
            </div>
            <div class="card-body">
                <button type="submit" name="storedata" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>';
    }
    function storedata($dta) {
        $sql = "INSERT INTO mhs(NIM,NAMA,ALAMAT,KOTA,JK,TGL_LAHIR) Values('".$dta["NIM"]."','".$dta["NAMA"]."','".$dta["ALAMAT"]."','".$dta["KOTA"]."','".$dta["JK"]."','".$dta["TGL_LAHIR"]."');";
        $cnn = new mysqli(DBSERVER,DBUSER,DBPWD,DBNAME,DBPORT);
            
        if ($cnn->connect_error) {
            die("Connection failed: " . $cnn->connect_error);
        }
        $res = $cnn->query($sql);
        $cnn->close();  
        if($res){
            $hsl["stt"] = "SUKSES";
        }else{
            $hsl["stt"] = "GAGAL";
        }
        return $hsl;
    }

    function editdata($dta){
        if(isset($dta["sttupdate"])){
            $udt = $dta["sttupdate"];
        }
        if(!isset($_GET["nim"])){
            $dta["err"]="";
            $dta["act"]="edit";
            $dtx=searchdata($dta);
        }else{
            $dta = cariedit();
            if(isset($udt)){
                $dta["sttupdate"]=$udt;
            }
            
            if($dta["stt"]){
                $dta=frmeditdata($dta);    
            }else{
                $dta["err"]=1;
                $dta["act"]="edit";
                $dta=searchdata($dta);
            }
            $dtx = $dta;
        }
        
        return $dtx;
    }
    function frmeditdata($dta){
        $stt="";
        $jkL="";$jkP="";

        if($dta["JK"]=="L"){
            $jkL=" checked";
        }else{
            $jkP=" checked";
        }
        if(isset($dta["sttupdate"]) && ($dta["sttupdate"]==true)){
            $stt = '<div class="alert alert-success" role="alert">
            Data telah tersimpan
        </div><script>const myTimeout = setTimeout(autoloadpage, 5000);
        function autoloadpage() {
            window.location.href ="index.php";  
        }</script>';
        }
        if(isset($dta["sttupdate"]) && ($dta["sttupdate"]==false)){
                $stt = '<div class="alert alert-danger" role="alert">
                Terjadi masalah saat penyimpanan
            </div>';
        }
        $dtx='<div class="container">
            <h3>Edit Data</h3>'.$stt.'<form method="post">
                <div class="form-group">
                    <label for="txDatabase">NIM</label>
                    <input type="text" class="form-control" id="txNIM" name="txNIM" value="'.$dta["NIM"].'" placeholder="NIM Mahasiswa">
                </div>
                <div class="form-group">
                    <label for="txDatabase">Nama</label>
                    <input type="text" class="form-control" id="txNAMA" name="txNAMA" value="'.$dta["NAMA"].'" placeholder="Nama Mahasiswa">
                </div>
                <div class="form-group">
                    <label for="txDatabase">Alamat</label>
                    <input type="text" class="form-control" id="txALAMAT" name="txALAMAT" value="'.$dta["ALAMAT"].'" placeholder="Alamat Mahasiswa">
                </div>
                <div class="form-group">
                    <label for="txDatabase">Kota</label>
                    <input type="text" class="form-control" id="txKOTA" name="txKOTA" value="'.$dta["KOTA"].'" placeholder="Kota Mahasiswa">
                </div>
                <div class="form-group">
                    <label for="txDatabase">Jenis Kelamin</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="txJK" value="L" name="txJK"'.$jkL.'><label class="form-check-label" for="LakiLaki">Laki-Laki</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="txJK" value="P" name="txJK"'.$jkP.'><label class="form-check-label" for="Peremouan">Perempuan</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="txDatabase">TGL Lahir</label>
                    <input type="date" class="form-control" id="txTALAG" name="txTALAG" value="'.$dta["TGL_LAHIR"].'">
                </div>
                <div class="card-body">
                    <button type="submit" name="updatedata" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>';
        return $dtx;
    }
    function updatedata($dta){
        $hsl["sttupdate"] = false;
        $sql = "UPDATE mhs SET 
            NIM='".$dta["NIM"]."',
            NAMA='".$dta["NAMA"]."',
            ALAMAT='".$dta["ALAMAT"]."',
            KOTA='".$dta["KOTA"]."',
            JK='".$dta["JK"]."',
            TGL_LAHIR= '".$dta["TGL_LAHIR"]."'
            WHERE NIM='".$dta["NIM"]."';";
            
        $cnn = new mysqli(DBSERVER,DBUSER,DBPWD,DBNAME,DBPORT);
            
        if ($cnn->connect_error) {
            die("Connection failed: " . $cnn->connect_error);
        }
        $res = $cnn->query($sql);
        
        if($res){
            $hsl["sttupdate"] = true;
            //echo "Sukses";
        }else{
            $hsl["sttupdate"] = false;
        }
        $cnn->close();  
        $hsl["sql"] = $sql;
        return $hsl;
    }
    function deletedata($dta=""){
        $stthapus="";
        if(isset($dta["sttupdate"])){
            $stthapus="OK";
        }
        
        if(!isset($_GET["nim"])){
            $dta["err"]="";
            $dta["act"]="del";
            if($stthapus=="OK"){
                echo $stt;
            }else{
                $dtx=searchdata($dta);
            }
        }else{
            
            $dta = cariedit();
            if(($dta["stt"]) || ($stthapus=="OK")){
                if($stthapus=="OK"){
                    $dta = frmhapusukses();
                }else{
                    $dta=frmdeldata($dta);    
                }
            }else{
                $dta["err"]=1;
                $dta["act"]="del";
                $dtx=searchdata($dta);
            }
            $dtx = $dta;
        }
        
        return $dtx;
    }
    function frmhapusukses(){
        $stt = '<div class="alert alert-success" role="alert">
            Data telah dihapus
        </div><script>const myTimeout = setTimeout(autoloadpage, 5000);
        function autoloadpage() {
            window.location.href ="index.php";  
        }</script>';
        $dtx='<div class="container"><h3>Edit Data</h3>'.$stt ."</div>";
        return $dtx;
    }
    function destroydata($dta){
        $hsl["sttupdate"] = false;
        $sql = "DELETE FROM mhs WHERE NIM='".$dta["NIM"]."';";
            
        $cnn = new mysqli(DBSERVER,DBUSER,DBPWD,DBNAME,DBPORT);
            
        if ($cnn->connect_error) {
            die("Connection failed: " . $cnn->connect_error);
        }
        $res = $cnn->query($sql);
        
        if($res){
            $hsl["sttupdate"] = true;
        }
        $cnn->close();  
        $hsl["sql"] = $sql;
        return $hsl;
    }
    function frmdeldata($dta){
        $stt="";
        $jkL="";$jkP="";

        if($dta["JK"]=="L"){
            $jkL=" checked";
        }else{
            $jkP=" checked";
        }
        if(isset($dta["sttupdate"]) && ($dta["sttupdate"]==true)){
            $stt = '<div class="alert alert-success" role="alert">
            Data telah dihapus
        </div><script>const myTimeout = setTimeout(autoloadpage, 5000);
        function autoloadpage() {
            window.location.href ="index.php";  
        }</script>';
        }
        if(isset($dta["sttupdate"]) && ($dta["sttupdate"]==false)){
                $stt = '<div class="alert alert-danger" role="alert">
                Terjadi masalah saat penghapusan data
            </div>';
        }
        $dtx='<div class="container">
            <h3>Hapus Data</h3>'.$stt.'<form method="post">
            <input type="hidden" name="txNIM" value="'.$dta["NIM"].'">
                <div class="form-group">
                    <label for="txDatabase">NIM</label>
                    <input type="text" class="form-control" id="txNIM" name="txNIM" value="'.$dta["NIM"].'" placeholder="NIM Mahasiswa" disabled>
                </div>
                <div class="form-group">
                    <label for="txDatabase">Nama</label>
                    <input type="text" class="form-control" id="txNAMA" name="txNAMA" value="'.$dta["NAMA"].'" placeholder="Nama Mahasiswa" disabled>
                </div>
                <div class="form-group">
                    <label for="txDatabase">Alamat</label>
                    <input type="text" class="form-control" id="txALAMAT" name="txALAMAT" value="'.$dta["ALAMAT"].'" placeholder="Alamat Mahasiswa" disabled>
                </div>
                <div class="form-group">
                    <label for="txDatabase">Kota</label>
                    <input type="text" class="form-control" id="txKOTA" name="txKOTA" value="'.$dta["KOTA"].'" placeholder="Kota Mahasiswa" disabled>
                </div>
                <div class="form-group">
                    <label for="txDatabase">Jenis Kelamin</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="txJK" value="L" name="txJK"'.$jkL.' disabled><label class="form-check-label" for="LakiLaki">Laki-Laki</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="txJK" value="P" name="txJK"'.$jkP.' disabled><label class="form-check-label" for="Peremouan">Perempuan</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="txDatabase">TGL Lahir</label>
                    <input type="date" class="form-control" id="txTALAG" name="txTALAG" value="'.$dta["TGL_LAHIR"].'" disabled>
                </div>
                <div class="card-body">
                    <button type="submit" name="Deletedata" class="btn btn-danger">Delete Data</button>
                </div>
            </form>
        </div>';
        return $dtx;
    }
    function searchdata($dta){
        $sttx = "";
        
        if(!$dta["err"]==""){
            $sttx .= '<div class="alert alert-danger" role="alert">
                    Pencarian tidak berhasil, Coba ulangi dengan NIM yang lain
                </div>';
        }
        $frmdata = '<div class="container">
                <h3>'.ucwords($dta["act"]).' Data</h3>'. $sttx .'<form method="GET"><div class="form-group">
                <label for="txDatabase">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" placeholder="NIM Mahasiswa yang akan di edit">
            </div><div class="card-body">
            <button type="submit" class="btn btn-primary">Cari Data</button>
            <input type="hidden" name="act" value="'.$dta["act"].'">
        </div></form></div>';
        return $frmdata;
    }
    function cariedit(){
        $dta["stt"]=false;
        if(isset($_GET["nim"])){
            $nim = $_GET["nim"];
            $sql = "SELECT * FROM mhs WHERE NIM='".$nim."';";

            $cnn = new mysqli(DBSERVER,DBUSER,DBPWD,DBNAME,DBPORT);    
            if ($cnn->connect_error) {
                die("Connection failed: " . $cnn->connect_error);
            }
            $result = $cnn->query($sql);

            if ($result->num_rows > 0) {
                $dta = $result->fetch_assoc();
                $dta["stt"]=true;
            }
            $cnn->close();    
        }
        $dta["sql"]=$sql;
        return $dta;
    }
    function loadpage($page,$dta){
        switch($page){
            case "addnew": 
                $dt["judul"] = "Add Data Mahasiswa";
                $dt["page"] = addnew($dta);
                break;
            case "edit": 
                $dt["page"] = editdata($dta);
                $dt["judul"] = "Edit Data Mahasiswa";
                break;
            case "del": 
                $dt["page"] = deletedata($dta);
                $dt["judul"] = "Delete Data Mahasiswa";
                break;
            case "cariedit":
                $dt["page"] = cariedit();
                $dt["judul"] = "Edit Data Mahasiswa";
                break;
            default:
                $dt["judul"] = "Data Mahasiswa";
                $dt["page"] = listdata();
                break;    
        }
        return $dt;
    }