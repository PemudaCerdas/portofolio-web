<?php
$conn = new mysqli("sql107.infinityfree.com", "if0_39133495", "Yogasaputra22", "if0_39133495_biodata");
$id = $_POST['id'];
$nama = $_POST['nama_kegiatan'];
$waktu = $_POST['waktu'];
$bukti = $_POST['bukti'];
$conn->query("UPDATE portofolio SET nama_kegiatan='$nama', waktu='$waktu', bukti='$bukti' WHERE id=$id");
?>
