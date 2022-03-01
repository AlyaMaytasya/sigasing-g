<section class="content-header">
<?php
if (isset($_POST['button_create'])){

    $database = new database();
    $db = $database->getConnection();

    $validateSql = "SELECT nama_bagian FROM Bagian WHERE nama_bagian = ?";
    $stmt = $db->prepare($validateSql);
    $stmt->bindParam(1, $_POST['nama_bagian']);
    $stmt->execute();
    if($stmt->rowCount() > 0){
?>
        <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <h5><i class="icon fas fa-ban"></i> Gagal</h5>
        Nama Bagian Sama Sudah Ada
        </div>
    
<?php
} else {
    $insertSQL ="INSERT INTO Bagian SET nama_bagian=?";
    $stmt = $db->prepare($insertSQL);
    $stmt->bindParam(1, $_POST['nama_bagian']);
    if ($stmt->execute()){

        $insertkaryawanSql = "INSERT INTO karyawan SET nama_kepala_bagian=?";
        $stmt_karyawan = $db->prepare($insertkaryawanSql);
        $stmt_karyawan->bindParam(1, $_POST['nama_kepala_bagian']);
        if($stmt_karyawan->execute()){

            $karyawan_id = $db->lastInsertId();

            $insertlokasiSql = "INSERT INTO lokasi SET nama_lokasi_bagian=? karyawan_id=?";
            $stmt_lokasi = $db->prepare($insertlokasiSql);
            $stmt_lokasi->bindParam(1, $_POST['nama_lokasi_bagian']);
            $stmt_lokasi->bindParam(2, $karyawan_id);
             
            if($stmt_lokasi->execute()){
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil Simpan Data";
        }else{
            $_SESSION['hasil'] = False;
            $_SESSION['pesan'] = "Gagal Simpan Data";
        }
    }
    echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
}
}
//coding masih error
}
?>

    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data Bagian</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                <li class="breadcrumb-item"><a href="?page=bagianread">Bagian</a></li>
                <li class="breadcrumb-item active">Tambah Data</li>
            </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Bagian</h3>
        </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label for="nama_bagian">Nama Bagian</label>
                <input type="text" class="form-control" name="nama_bagian" required >
            </div>
            <div class="form-group">
                <label for="karyawan_id">Kepala Bagian</label>
                <select class="form-control" name="karyawan_id">
                <option value="">--Pilih Kepala Bagian---</option>
                <?php
                $database = new Database ();
                $db = $database->getConnection();

                $selectSql = "SELECT * FROM karyawan";
                $stmt_karyawan = $db->prepare($selectSql);
                $stmt_karyawan->execute();

                while ($row_karyawan = $stmt_karyawan->fetch(PDO::FETCH_ASSOC)){
                    echo "<option value=\"" . $row_karyawan["id"] . "\">" . $row_karyawan["nama_lengkap"] . "</option>";
                }
//al
                ?>
                </select>
            </div>
            <div class="form-group">
                <label for="lokasi_id">Lokasi</label>
                <select class="form-control" name="lokasi_id">
                <option value="">--Pilih Lokasi Bagian---</option>
                <?php
                $database = new Database ();
                $db = $database->getConnection();

                $selectSql = "SELECT * FROM lokasi";
                $stmt_lokasi = $db->prepare($selectSql);
                $stmt_lokasi->execute();

                while ($row_lokasi = $stmt_lokasi->fetch(PDO::FETCH_ASSOC)){
                    echo "<option value=\"" . $row_lokasi["id"] . "\">" . $row_lokasi["nama_lokasi"] . "</option>";
                }
//ya
                ?>
                </select>
            </div>
            <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">
                <i class="fa fa-times-circle"></i> Batal
            </a>
            <button type="submit" name="button_create" class="btn-btn-success btn-sm float-right">
                <i class="fa fa-save"></i> Simpan
            </button>
        </form>
    </div>
</section>
<?php include_once "partials/scripts.php"?> 