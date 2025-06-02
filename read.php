<?php
// read.php
header("Content-Type: application/json");

// Tampilkan error jika terjadi
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Koneksi ke database InfinityFree
$host = "sql107.infinityfree.com";
$user = "if0_39133495";
$pass = "Yogasaputra22"; // Ganti dengan password MySQL kamu dari dashboard
$db   = "if0_39133495_biodata";

// Buat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Koneksi ke database gagal: " . mysqli_connect_error()]);
    exit;
}

// Ambil data dari tabel
$query = "SELECT * FROM portofolio ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Siapkan array hasil
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Tampilkan dalam format JSON
echo json_encode($data);
?>
