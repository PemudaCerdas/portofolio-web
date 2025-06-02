<?php
$conn = new mysqli("sql107.infinityfree.com", "if0_39133495", "Yogasaputra22", "if0_39133495_biodata");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_kegiatan'];
    $waktu = $_POST['waktu'];
    
    // Handle file upload
    $bukti = '';
    if (isset($_FILES['bukti_file']) && $_FILES['bukti_file']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Validasi tipe file (hanya gambar)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['bukti_file']['type'];
        
        if (!in_array($file_type, $allowed_types)) {
            die("Hanya file gambar (JPEG, PNG, GIF) yang diizinkan");
        }
        
        $file_ext = pathinfo($_FILES['bukti_file']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $file_ext;
        $target_file = $target_dir . $filename;
        
        if (move_uploaded_file($_FILES['bukti_file']['tmp_name'], $target_file)) {
            $bukti = $target_file;
        }
    } else {
        die("Harap upload file bukti kegiatan");
    }
    
    $conn->query("INSERT INTO portofolio (nama_kegiatan, waktu, bukti) VALUES ('$nama', '$waktu', '$bukti')");
    header("Location: index.html#portofolio");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Portofolio</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
  <div class="container mt-5">
    <h1 class="mb-4"><i class="bi bi-plus-circle"></i> Tambah Data Portofolio</h1>
    
    <form action="form_tambah.php" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
        <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
      </div>
      
      <div class="mb-3">
        <label for="waktu" class="form-label">Waktu</label>
        <input type="date" class="form-control" id="waktu" name="waktu" required>
      </div>
      
      <div class="mb-3">
        <label for="bukti_file" class="form-label">Upload Bukti Kegiatan (Gambar)</label>
        <input type="file" class="form-control" id="bukti_file" name="bukti_file" accept="image/*" required>
        <div class="form-text">Format yang diterima: JPG, PNG, GIF (Maks. 2MB)</div>
      </div>
      
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary me-md-2">
          <i class="bi bi-save"></i> Simpan
        </button>
        <a href="index.html#portofolio" class="btn btn-secondary">
          <i class="bi bi-x-circle"></i> Batal
        </a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>