<?php
$db = new SQLite3($_SERVER['DOCUMENT_ROOT']."/Sistem Gudang Sepatu/gudang sepatu new.db");

function getData($data){
    global $db;
    $result = $db->query($data);
    $rows = [];
    while($row = $result->fetchArray()){
        $rows[] = $row;
    };

    return $rows;
}

function sessionLoginCheck($level){
    if (isset($_SESSION['login'])) {
        if ($_SESSION['level'] != 'LVL001' and $level == 'LVL001') {
            return false;
        }
        elseif ($_SESSION['level'] != 'LVL002' and $level == 'LVL002') {
            return false;
        }
    } else {
        return false;
    }
    return true;
}

function updateProfile($data){
    global $db;
    $username = $data['username'];
    $nama_admin = $data['nama_admin'];
    $notelp_admin = $data['notelp_admin'];
    $email_admin = $data['email_admin'];

    $query = "UPDATE ADMIN SET NAMA_ADMIN = '$nama_admin', NOTELP_ADMIN = '$notelp_admin', EMAIL_ADMIN = '$email_admin' WHERE USERNAME = '$username'";
    $db->exec($query);
    return $db->changes();
}

function changePass($data){
    global $db;
    $username = $data['username'];
    $newpass = base64_encode($data['passbaru']);
    $query = "UPDATE ADMIN SET PASSWORD = '$newpass' WHERE USERNAME = '$username'";
    $db->exec($query);
    return $db->changes();
}

function resetPass($user){
    global $db;
    $query = "UPDATE ADMIN SET PASSWORD = NULL WHERE USERNAME = '$user'";
    $db->exec($query);
    return $db->changes();
}

function tambahAdmin($data){
    global $db;
    $username = strtolower($data['username']);
    // $password = $data['password'];
    $notelp = $data['notelp'];
    $email = $data['email'];
    $nama = $data['nama'];
    $query = "INSERT INTO 'ADMIN' VALUES ('$username', 'LVL002', NULL, '$nama', '$notelp', '$email')";
    $db->exec($query);
    return $db->changes();
}
 
function editAdmin($data){
    global $db;
    $username = strtolower($data['username']);
    $notelp = $data['notelp'];
    $email = $data['email'];
    $nama = $data['nama'];
    $query = "UPDATE ADMIN SET NAMA_ADMIN = '$nama', NOTELP_ADMIN = '$notelp', EMAIL_ADMIN = '$email' WHERE USERNAME = '$username'";
    $db->exec($query);
    return $db->changes();
}

function deleteAdmin($username){
    global $db;
    $query = "DELETE FROM ADMIN WHERE USERNAME = '$username'";
    $db->exec($query);
    return $db->changes();
}