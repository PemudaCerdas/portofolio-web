<?php
$host = "sql107.infinityfree.com";   // dari halaman tadi
$user = "if0_39133495";              // MySQL username
$pass = "Yogasaputra22";             // salin dari tombol 'eye' di atas
$db   = "if0_39133495_biodata";      // nama database

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
