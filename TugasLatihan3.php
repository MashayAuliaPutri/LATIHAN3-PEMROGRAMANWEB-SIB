<?php
// Memulai sesi untuk menyimpan data penjualan
session_start();

// Inisialisasi array penjualan jika belum ada dalam sesi
if (!isset($_SESSION['penjualan'])) {
    $_SESSION['penjualan'] = [];
}

// Menangani input dari form
if (isset($_POST['submit'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    // Menambahkan data baru ke array penjualan yang ada di session
    $_SESSION['penjualan'][] = [
        "nama" => $nama_produk,
        "harga" => $harga,
        "jumlah" => $jumlah
    ];
}

// Fungsi untuk menghitung total penjualan
function hitungTotalPenjualan($penjualan) {
    $total = 0;
    foreach ($penjualan as $item) {
        $total += $item['harga'] * $item['jumlah'];
    }
    return $total;
}

// Fungsi untuk menghitung total jumlah produk yang terjual
function hitungTotalJumlahTerjual($penjualan) {
    $totalJumlah = 0;
    foreach ($penjualan as $item) {
        $totalJumlah += $item['jumlah'];
    }
    return $totalJumlah;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Sistem Pencatatan Data Penjualan</h2>

<!-- Form Input untuk Data Penjualan -->
<form method="POST">
    Nama Produk: <input type="text" name="nama_produk" required><br><br>
    Harga Per Produk: <input type="number" name="harga" required><br><br>
    Jumlah Terjual: <input type="number" name="jumlah" required><br><br>
    <input type="submit" name="submit" value="Tambahkan Data">
</form>

<!-- Menampilkan Laporan Penjualan -->
<?php if (!empty($_SESSION['penjualan'])) : ?>
<h3>Laporan Penjualan:</h3>
<table>
    <tr>
        <th>Nama</th>
        <th>Harga Per Produk</th>
        <th>Jumlah Terjual</th>
        <th>Total</th>
    </tr>
    <?php foreach ($_SESSION['penjualan'] as $item) : ?>
    <tr>
        <td><?= htmlspecialchars($item['nama']); ?></td>
        <td>Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
        <td><?= $item['jumlah']; ?></td>
        <td>Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="2"><strong>Total Penjualan</strong></td>
        <td><strong><?= hitungTotalJumlahTerjual($_SESSION['penjualan']); ?></strong></td>
        <td><strong>Rp <?= number_format(hitungTotalPenjualan($_SESSION['penjualan']), 0, ',', '.'); ?></strong></td>
    </tr>
</table>
<?php endif; ?>

<!-- Tombol untuk menghapus semua data -->
<form method="POST">
    <input type="submit" name="reset" value="Hapus Semua Data">
</form>

<?php
// Fungsi untuk menghapus semua data penjualan
if (isset($_POST['reset'])) {
    unset($_SESSION['penjualan']); // Hapus semua data dari sesi
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh halaman untuk membersihkan tampilan
    exit;
}
?>

</body>
</html>
