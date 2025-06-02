<?php
// Koneksi ke database
$conn = new mysqli("sql107.infinityfree.com", "if0_39133495", "Yogasaputra22", "if0_39133495_biodata");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses form ketika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama_kegiatan'];
    $waktu = $_POST['waktu'];
    $bukti_lama = $_POST['bukti_lama'];
    
    // Handle file upload
    $bukti = $bukti_lama; // Default gunakan bukti lama
    
    if (isset($_FILES['bukti_file']) && $_FILES['bukti_file']['error'] == 0) {
        // Validasi tipe file (hanya gambar)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['bukti_file']['type'];
        
        if (!in_array($file_type, $allowed_types)) {
            die("Hanya file gambar (JPEG, PNG, GIF) yang diizinkan");
        }

        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Hapus file lama jika ada
        if ($bukti_lama && file_exists($bukti_lama)) {
            unlink($bukti_lama);
        }
        
        $file_ext = pathinfo($_FILES['bukti_file']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $file_ext;
        $target_file = $target_dir . $filename;
        
        if (move_uploaded_file($_FILES['bukti_file']['tmp_name'], $target_file)) {
            $bukti = $target_file;
        }
    }
    
    // Update data di database
    $stmt = $conn->prepare("UPDATE portofolio SET nama_kegiatan=?, waktu=?, bukti=? WHERE id=?");
    $stmt->bind_param("sssi", $nama, $waktu, $bukti, $id);
    $stmt->execute();
    
    // Redirect kembali ke halaman portofolio
    header("Location: index.html#portofolio");
    exit();
}

// Ambil data yang akan diedit
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM portofolio WHERE id=$id");
if ($result->num_rows == 0) {
    die("Data tidak ditemukan");
}
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Portofolio</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    .preview-image {
      max-width: 300px;
      max-height: 200px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h1 class="mb-4"><i class="bi bi-pencil-square"></i> Edit Portofolio</h1>
    
    <form action="form_edit.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $data['id'] ?>">
      <input type="hidden" name="bukti_lama" value="<?= htmlspecialchars($data['bukti']) ?>">
      
      <div class="mb-3">
        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
        <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" 
               value="<?= htmlspecialchars($data['nama_kegiatan']) ?>" required>
      </div>
      
      <div class="mb-3">
        <label for="waktu" class="form-label">Waktu</label>
        <input type="date" class="form-control" id="waktu" name="waktu" 
               value="<?= $data['waktu'] ?>" required>
      </div>
      
      <div class="mb-3">
        <label for="bukti_file" class="form-label">Bukti Kegiatan (Gambar)</label>
        
        <?php if (!empty($data['bukti']) && file_exists($data['bukti'])): ?>
          <div class="mb-3">
            <p>File saat ini:</p>
            <img src="<?= $data['bukti'] ?>" class="img-thumbnail preview-image" id="currentImage">
            <div class="mt-2">
              <a href="<?= $data['bukti'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-eye"></i> Lihat Full Size
              </a>
            </div>
          </div>
        <?php endif; ?>
        
        <input type="file" class="form-control" id="bukti_file" name="bukti_file" accept="image/*">
        <div class="form-text">Upload file baru jika ingin mengganti (Format: JPG, PNG, GIF)</div>
      </div>
      
      <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
        <button type="submit" class="btn btn-primary me-md-2">
          <i class="bi bi-save"></i> Simpan Perubahan
        </button>
        <a href="index.html#portofolio" class="btn btn-secondary">
          <i class="bi bi-x-circle"></i> Batal
        </a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Preview gambar yang dipilih
    document.getElementById('bukti_file').addEventListener('change', function(e) {
      if (this.files && this.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          // Buat atau update preview image
          let preview = document.getElementById('imagePreview');
          if (!preview) {
            preview = document.createElement('img');
            preview.id = 'imagePreview';
            preview.className = 'img-thumbnail preview-image mt-3';
            document.querySelector('.mb-3').appendChild(preview);
          }
          preview.src = e.target.result;
        }
        
        reader.readAsDataURL(this.files[0]);
      }
    });
  </script>
</body>
</html>