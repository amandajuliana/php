<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Pengaturan dasar dokumen -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Mahasiswa</title>

    <!-- Memuat Bootstrap 5.3 untuk styling dan komponen -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS tambahan -->
    <style>
        body            { background-color:#f8f9fa; } /* Warna latar belakang */
        .card-header    { background:#007bff; color:#fff; } /* Header biru */
        .form-label     { font-weight:bold; } /* Label form tebal */
        .table-borderless  tr, td, th { border:0 !important; } /* Tabel tanpa garis */
    </style>
</head>
<body>
<div class="container mt-4 mb-5 px-5">
    <div class="card shadow-sm">
        <div class="card-header text-center">
            <h1 class="h4 mb-0">Form Penilaian Mahasiswa</h1>
        </div>
        <div class="card-body">

            <!-- Form input nilai -->
            <form method="post">
                <!-- Input Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Masukkan Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Agus">
                </div>
                <!-- Input NIM -->
                <div class="mb-3">
                    <label for="nim" class="form-label">Masukkan NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" placeholder="202332xxx">
                </div>
                <!-- Input Kehadiran -->
                <div class="mb-3">
                    <label for="kehadiran" class="form-label">Nilai Kehadiran (10%)</label>
                    <input type="number" class="form-control" id="kehadiran" name="kehadiran" min="0" max="100">
                </div>
                <!-- Input Tugas -->
                <div class="mb-3">
                    <label for="tugas" class="form-label">Nilai Tugas (20%)</label>
                    <input type="number" class="form-control" id="tugas" name="tugas" min="0" max="100">
                </div>
                <!-- Input UTS -->
                <div class="mb-3">
                    <label for="uts" class="form-label">Nilai UTS (30%)</label>
                    <input type="number" class="form-control" id="uts" name="uts" min="0" max="100">
                </div>
                <!-- Input UAS -->
                <div class="mb-3">
                    <label for="uas" class="form-label">Nilai UAS (40%)</label>
                    <input type="number" class="form-control" id="uas" name="uas" min="0" max="100">
                </div>

                <!-- Tombol Proses -->
                <div class="d-grid gap-2">
                    <button type="submit" name="proses" class="btn btn-primary">Proses</button>
                </div>
            </form>

<?php
// Mengecek apakah tombol "Proses" ditekan
if (isset($_POST['proses'])) {
    // Mengambil nilai dari form
    $nama       = trim($_POST['nama']);          // Menghilangkan spasi
    $nim        = trim($_POST['nim']);
    $kehadiran  = $_POST['kehadiran'];
    $tugas      = $_POST['tugas'];
    $uts        = $_POST['uts'];
    $uas        = $_POST['uas'];

    // Validasi: Pastikan semua input diisi
    if ($nama==""||$nim==""||$kehadiran===""||$tugas===""||$uts===""||$uas===""){
        echo '<div class="alert alert-danger mt-3">Semua kolom harus diisi!</div>';
    } else {
        // Menghitung nilai akhir berdasarkan bobot
        $nilaiAkhir = ($kehadiran*0.10)+($tugas*0.20)+($uts*0.30)+($uas*0.40);

        // Menentukan grade berdasarkan nilai akhir
        if     ($nilaiAkhir>=85){ $grade='A'; }
        elseif ($nilaiAkhir>=70){ $grade='B'; }
        elseif ($nilaiAkhir>=55){ $grade='C'; }
        elseif ($nilaiAkhir>=40){ $grade='D'; }
        else                    { $grade='E'; }

        // Menentukan status kelulusan
        if ($kehadiran < 70){
            $status = "TIDAK LULUS"; // Kehadiran < 70 = Tidak lulus
        } elseif ($nilaiAkhir>=60 && $tugas>=40 && $uts>=40 && $uas>=40){
            $status = "LULUS"; // Semua syarat lulus terpenuhi
        } else {
            $status = "TIDAK LULUS"; // Nilai ada yang kurang
        }

        // Mengatur warna tampilan berdasarkan status
        $warnaHeader = ($status=="LULUS") ? "bg-success" : "bg-danger";
        $warnaBtn    = ($status=="LULUS") ? "success"    : "danger";

        // Menampilkan hasil
        echo "
        <div class='mt-4 border border-$warnaBtn rounded'>
            <!-- Header hasil -->
            <div class='p-3 text-white fw-bold $warnaHeader text-center'>Hasil Penilaian</div>

            <!-- Isi tabel hasil -->
            <div class='p-4'>
                <div class='d-flex justify-content-between mb-3'>
                    <h5 class='mb-0'><strong>Nama:</strong> $nama</h5>
                    <h5 class='mb-0'><strong>NIM:</strong> $nim</h5>
                </div>

                <table class='table table-borderless mb-0'>
                    <tr><th width='35%'>Nilai Kehadiran:</th> <td class='ps-1'>$kehadiran%</td></tr>
                    <tr><th>Nilai Tugas:</th>       <td class='ps-1'>$tugas</td></tr>
                    <tr><th>Nilai UTS:</th>         <td class='ps-1'>$uts</td></tr>
                    <tr><th>Nilai UAS:</th>         <td class='ps-1'>$uas</td></tr>
                    <tr><th>Nilai Akhir:</th>       <td class='ps-1'>".number_format($nilaiAkhir, 2)."</td></tr>
                    <tr><th>Grade:</th>             <td class='ps-1'>$grade</td></tr>
                    <tr><th>Status:</th>            <td class='ps-1 fw-bold text-".($status=='LULUS'?'success':'danger')."'>$status</td></tr>
                </table>
            </div>

            <!-- Tombol bawah -->
            <div class='text-center pb-3'>
                <button class='btn btn-$warnaBtn'>Selesai</button>
            </div>
        </div>";
    }
}
?>
        </div><!-- /.card-body -->
    </div><!-- /.card -->
</div><!-- /.container -->
</body>
</html>
