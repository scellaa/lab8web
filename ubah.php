
<?php

error_reporting(E_ALL);

include_once 'koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$id) {
    die('ID barang tidak ditemukan!');
}

// Proses update barang
if (isset($_POST['submit'])) {

    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];

    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;

    if ($file_gambar['error'] == 0) {

        $filename = str_replace(' ', '_', basename($file_gambar['name']));

        $destination = dirname(__FILE__) . '/gambar/' . $filename;

        if (move_uploaded_file($file_gambar['tmp_name'], $destination)) {
            $gambar = 'gambar/' . $filename;
        }
    }

    $sql = "UPDATE data_barang SET
            nama = '$nama',
            kategori = '$kategori',
            harga_jual = '$harga_jual',
            harga_beli = '$harga_beli',
            stok = '$stok'";

    if (!empty($gambar)) {
        $sql .= ", gambar = '$gambar'";
    }

    $sql .= " WHERE id_barang = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: index.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($conn));
    }
}

// Ambil data barang berdasarkan ID
$sql = "SELECT * FROM data_barang WHERE id_barang = '$id'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($result);

if (!$data) {
    die('Data barang tidak ditemukan!');
}

// Fungsi memilih kategori
function is_select($var, $val) {
    return ($var == $val) ? 'selected="selected"' : '';
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Ubah Barang</title>
</head>

<body>

    <div class="container">

        <h1>Ubah Barang</h1>

        <div class="main">

            <form method="post" action="ubah.php?id=<?php echo $id; ?>" enctype="multipart/form-data">

                <div class="input">
                    <label>Nama Barang</label>
                    <input type="text" name="nama"
                    value="<?php echo htmlspecialchars($data['nama']); ?>" />
                </div>

                <div class="input">
                    <label>Kategori</label>

                    <select name="kategori">

                        <option value="Komputer"
                        <?php echo is_select('Komputer', $data['kategori']); ?>>
                        Komputer</option>

                        <option value="Elektronik"
                        <?php echo is_select('Elektronik', $data['kategori']); ?>>
                        Elektronik</option>

                        <option value="Hand Phone"
                        <?php echo is_select('Hand Phone', $data['kategori']); ?>>
                        Hand Phone</option>

                    </select>
                </div>

                <div class="input">
                    <label>Harga Jual</label>
                    <input type="text" name="harga_jual"
                    value="<?php echo htmlspecialchars($data['harga_jual']); ?>" />
                </div>

                <div class="input">
                    <label>Harga Beli</label>
                    <input type="text" name="harga_beli"
                    value="<?php echo htmlspecialchars($data['harga_beli']); ?>" />
                </div>

                <div class="input">
                    <label>Stok</label>
                    <input type="text" name="stok"
                    value="<?php echo htmlspecialchars($data['stok']); ?>" />
                </div>

                <div class="input">
                    <label>File Gambar</label>
                    <input type="file" name="file_gambar" />
                </div>

                <div class="submit">

                    <input type="hidden" name="id"
                    value="<?php echo $data['id_barang']; ?>" />

                    <input type="submit" name="submit" value="Simpan" />

                </div>

            </form>

        </div>

    </div>

</body>
</html>
