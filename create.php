<?php
$conn = new mysqli("localhost", "root", "", "biodata");

// Handle file upload
$bukti = '';
if (isset($_FILES['bukti_file']) && $_FILES['bukti_file']['error'] == 0) {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $file_ext = pathinfo($_FILES['bukti_file']['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $file_ext;
    $target_file = $target_dir . $filename;
    
    if (move_uploaded_file($_FILES['bukti_file']['tmp_name'], $target_file)) {
        $bukti = $target_file;
    }
} else {
    $bukti = $_POST['bukti_link'];
}

$nama = $_POST['nama_kegiatan'];
$waktu = $_POST['waktu'];
$conn->query("INSERT INTO portofolio (nama_kegiatan, waktu, bukti) VALUES ('$nama', '$waktu', '$bukti')");

header("Content-Type: application/json");
echo json_encode(['status' => 'success']);
?>