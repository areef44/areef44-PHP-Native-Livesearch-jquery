<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require('function.php');

//cek apakah tombol submit sudah ditekan 
if (isset($_POST["submit"])) {
    // var_dump($_POST);
    // var_dump($_FILES);
    // die;

    //cek apakah data berhasil ditambahkan atau tidak
    if (tambah() > 0) {
        echo "
            <script>
            alert ('data berhasil ditambahkan!');
            document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
        <script>
            alert ('data gagal ditambahkan!');
            document.location.href = 'index.php';
            </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
</head>

<body>

    <h1>Tambah Data Siswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" required>
            </li>
            <li>
                <label for="alamat">Alamat : </label>
                <input type="text" name="alamat" id="alamat" required>
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Submit</button>
            </li>
        </ul>
    </form>
</body>

</html>