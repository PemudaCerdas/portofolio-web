<?php
$conn = new mysqli("sql107.infinityfree.com", "if0_39133495", "Yogasaputra22", "if0_39133495_biodata");;
$id = $_POST['id'];
$conn->query("DELETE FROM portofolio WHERE id=$id");
?>
