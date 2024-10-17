<?php
session_start(); // Mulai session

// Inisialisasi session jika belum ada
if (!isset($_SESSION['anggota_keluarga'])) {
    $_SESSION['anggota_keluarga'] = array(); // Array untuk nama anggota keluarga
}

if (!isset($_SESSION['hasil'])) {
    $_SESSION['hasil'] = array(); // Array untuk hasil perhitungan
}

// Menghapus data jika ada permintaan penghapusan
if (isset($_GET['hapus']) && $_GET['hapus'] == 'true' && isset($_GET['nama'])) {
    $nama_hapus = $_GET['nama'];
    if (($key = array_search($nama_hapus, $_SESSION['anggota_keluarga'])) !== false) {
        unset($_SESSION['anggota_keluarga'][$key]);
        unset($_SESSION['hasil'][$nama_hapus]);
    }
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $jumlah_kata = str_word_count($nama);
    $jumlah_huruf = strlen($nama);
    $kebalikan_nama = strrev($nama);
    $jumlah_konsonan = preg_match_all('/[bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ]/', $nama, $matches_konsonan);
    $jumlah_vokal = preg_match_all('/[aeiouAEIOU]/', $nama, $matches_vokal);

    // Menyimpan nama ke dalam session array
    $_SESSION['anggota_keluarga'][] = $nama;

    // Menyimpan hasil perhitungan ke dalam session array
    $_SESSION['hasil'][$nama] = array(
        'jumlah_kata' => $jumlah_kata,
        'jumlah_huruf' => $jumlah_huruf,
        'kebalikan_nama' => $kebalikan_nama,
        'jumlah_konsonan' => $jumlah_konsonan,
        'jumlah_vokal' => $jumlah_vokal
    );
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODUL 1</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;800&family=Titillium+Web:ital,wght@0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <h2>Proses Nama Keluarga</h2>
    <form method="post">
        <label class="txt">Masukkan nama anggota keluarga:</label><br>
        <input type="text" name="nama" required><br><br>
        <button type="submit" name="submit">Proses</button>
    </form>
    <br>

    <?php
    // Menampilkan hasil perhitungan untuk setiap nama yang disubmit
    foreach ($_SESSION['hasil'] as $nama => $hasil) {
        echo "<div class='hasil'>";
        echo "<strong>Hasil untuk $nama :</strong><br>";
        echo "Jumlah kata pada nama: " . $hasil['jumlah_kata'] . "<br>";
        echo "Jumlah huruf pada nama: " . $hasil['jumlah_huruf'] . "<br>";
        echo "Kebalikan nama: " . $hasil['kebalikan_nama'] . "<br>";
        echo "Jumlah konsonan pada nama: " . $hasil['jumlah_konsonan'] . "<br>";
        echo "Jumlah vokal pada nama: " . $hasil['jumlah_vokal'] . "<br>";
        echo "<a href='?hapus=true&nama=$nama'>Hapus</a><br><br>"; // Tautan untuk menghapus data
    }
    ?>

</body>
</html>