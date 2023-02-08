<?php

usleep(500000);

require '../function.php';

$keyword = $_GET["keyword"];

$query = "SELECT * FROM siswa
              WHERE
          nama LIKE '%$keyword%' OR
          alamat LIKE '%$keyword%'
          ";

$siswa = query($query);

?>

<table border="1">
    <tr>
        <td>No</td>
        <td>Nama</td>
        <td>Alamat</td>
        <td>Gambar</td>
        <td>Action</td>
    </tr>

    <?php
    $i = 1;
    foreach ($siswa as $value) {
    ?>
        <tr>
            <td><?= $i++; ?></td>
            <td><?= $value['nama']; ?></td>
            <td><?= $value['alamat']; ?></td>
            <td><img src="img/<?= $value['gambar']; ?>" alt="" width="50"></td>
            <td>
                <a href="edit.php?id=<?= $value['id']; ?>">Edit</a>
                <a href="hapus.php?id=<?= $value['id']; ?>" onclick="return confirm('yakin?');">Hapus</a>
            </td>
        </tr>
    <?php
    }
    ?>

</table>