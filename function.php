
<?php
//koneksi ke database postgree


$conn = pg_connect("host=localhost port=5432 dbname=belajar user=postgres password=postgres");


function query($query)
{
    global $conn;
    $result = pg_query($conn, $query);
    $rows = [];
    while ($row = pg_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function tambah()
{
    global $conn;
    //ambil elemen dalam form
    $nama = htmlspecialchars($_POST["nama"]);
    $alamat = htmlspecialchars($_POST["alamat"]);

    // $gambar = htmlspecialchars($_POST["gambar"]);

    //upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }
    //query insert data

    $result = "INSERT INTO siswa(nama,alamat,gambar) VALUES ('$nama', '$alamat', '$gambar')";

    $result = pg_query($conn, $result);

    $cmdtuples = pg_affected_rows($result);

    return $cmdtuples;
}

function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>
            alert('pilih gambar terlebih dahulu!')
              </script>";
        return false;
    }

    //cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
            alert('yang anda upload bukan gambar')
              </script>";
        return false;
    }

    //cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>
            alert('ukuran gambar terlalu besar')
              </script>";
        return false;
    }

    //lolos pengecekan,upload gambar
    //generate nama baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}


function hapus($id)
{
    global $conn;

    $result = "DELETE FROM siswa WHERE id = $id";

    $result = pg_query($result);

    $cmdtuples = pg_affected_rows($result);

    return $cmdtuples;
}

function edit($id)
{

    global $conn;
    //ambil elemen dalam form
    $id = $_POST["id"];
    $nama = htmlspecialchars($_POST["nama"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $gambarLama = htmlspecialchars($_POST["gambarLama"]);

    //cek apakah user pilih gambar baru apa tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }


    //query update data

    $query = "UPDATE siswa SET (nama,alamat,gambar) = ('$nama', '$alamat', '$gambar') WHERE id=$id ";

    $result = pg_query($conn, $query);

    $cmdtuples = pg_affected_rows($result);

    return $cmdtuples;
}

function cari($keyword)
{
    $query = "SELECT * FROM siswa
              WHERE
              nama LIKE '%$keyword%' OR
              alamat LIKE '%$keyword%'
              ";
    return query($query);
}


function registrasi($data)
{
    global $conn;

    $username = $data["username"];

    $password = $data["password"];

    $password2 = $data["password2"];


    //cek username sudah ada atau belum
    $query = "SELECT username FROM users
              WHERE username ='$username'";
    $result = pg_query($conn, $query);

    if (pg_fetch_assoc($result)) {
        echo "<script>
             alert('username telah dipakai');
             </script>";
        return false;
    }

    //cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
             alert('konfirmasi password tidak sesuai');
             </script>";
        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan userbaru ke database
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    $result = pg_query($conn, $query);

    echo "<script>
        alert('user berhasil ditambahkan');
        </script>";

    return $result;
}

?>