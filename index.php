
<?php
include("koneksi.php");

// Query untuk menampilkan data
$sql = 'SELECT * FROM data_barang';
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
</head>

<body>

    <h1>Data Barang</h1>

    <table border="1" cellpadding="5" cellspacing="0">

        <tr>
            <th>Gambar</th>
            <th>Nama Barang</th>
            <th>Katagori</th>
            <th>Harga Jual</th>
            <th>Harga Beli</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php if($result): ?>

            <?php while($row = mysqli_fetch_array($result)): ?>

                <tr>

                    <td>
                        <img src="gambar/<?php echo $row['gambar']; ?>"
                        alt="<?php echo $row['nama']; ?>" width="100">
                    </td>

                    <td><?php echo $row['nama']; ?></td>

                    <td><?php echo $row['kategori']; ?></td>

                    <td><?php echo $row['harga_jual']; ?></td>

                    <td><?php echo $row['harga_beli']; ?></td>

                    <td><?php echo $row['stok']; ?></td>

                    <td>
                        <a href="ubah.php?id=<?php echo $row['id_barang']; ?>">
                            Ubah
                        </a>
                    </td>

                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="7">Belum ada data</td>
            </tr>

        <?php endif; ?>

    </table>

</body>
</html>
