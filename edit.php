<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require('function.php');


//ambil data dari URL
$id = $_GET['id'];

$siswa = query("SELECT * FROM siswa WHERE id = $id")[0];


//cek apakah tombol submit sudah ditekan

if (isset($_POST["submit"])) {
    // var_dump($_POST);

    //cek apakah data berhasil dirubah atau tidak
    if (edit($id) > 0) {
        echo "
            <script>
            alert ('data berhasil diubah!');
            document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
        <script>
            alert ('data gagal diubah!');
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

    <h1>Edit Data Siswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $siswa["id"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $siswa["gambar"]; ?>">

        <ul>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" required value="<?= $siswa["nama"]; ?>">
            </li>
            <li>
                <label for="alamat">Alamat : </label>
                <input type="text" name="alamat" id="alamat" required value="<?= $siswa['alamat']; ?>">
            </li>
            <li>
                <label for="gambar">Gambar : </label><br>
                <img src="img/<?= $siswa['gambar']; ?>" alt="" width="40px"><br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Ubah</button>
            </li>
        </ul>
    </form>
</body>

</html>