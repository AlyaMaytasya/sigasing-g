<section class="content-header">
<?php
if (isset($_POST['button_create'])){

    $database = new database();
    $db = $database->getConnection();

    $validateSql = "SELECT nama_jabatan, gapok_jabatan, tunjangan_jabatan, uang_makan_perhari FROM jabatan WHERE nama_jabatan = ? AND gapok_jabatan = ? AND tunjangan_jabatan = ? AND uang_makan_perhari =?";
    $stmt = $db->prepare($validateSql);
    $stmt->bindParam(1, $_POST['nama_jabatan']);
    $stmt->bindParam(2, $_POST['gapok_jabatan']);
    $stmt->bindParam(3, $_POST['tunjangan_jabatan']);
    $stmt->bindParam(4, $_POST['uang_makan_perhari']);
    $stmt->execute();
    if($stmt->rowCount() > 0){
?>
    <div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    <h5><i class="icon fas fa-ban"></i> Gagal</h5>
    Data Sudah Ada
    </div>
<?php
} else {
    $insertSQL ="INSERT INTO jabatan SET nama_jabatan=?, gapok_jabatan=?, tunjangan_jabatan=?, uang_makan_perhari=?";
    $stmt = $db->prepare($insertSQL);
    $stmt->bindParam(1, $_POST['nama_jabatan']);
    $stmt->bindParam(2, $_POST['gapok_jabatan']);
    $stmt->bindParam(3, $_POST['tunjangan_jabatan']);
    $stmt->bindParam(4, $_POST['uang_makan_perhari']);
    if ($stmt->execute()){
        $_SESSION['hasil'] = true;
        $_SESSION['pesan'] = "Berhasil Simpan Data";
    }else{
        $_SESSION['hasil'] = False;
        $_SESSION['pesan'] = "Gagal Simpan Data";
    }
    echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
}
}
?>

    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data Jabatan</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                <li class="breadcrumb-item"><a href="?page=jabatanread">Jabatan</a></li>
                <li class="breadcrumb-item active">Tambah Data</li>
            </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Jabatan</h3>
        </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label for="nama_jabatan">Nama Jabatan</label>
                <input type="text" class="form-control" name="nama_jabatan" required >
            </div>
            <div class="form-group">
                <label for="gapok_jabatan">Gapok</label>
                <input type="text" class="form-control" name="gapok_jabatan"
                    onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'>
            </div>
            <div class="form-group">
                <label for="tunjangan_jabatan">Tunjangan</label>
                <input type="text" class="form-control" name="tunjangan_jabatan"
                onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'>
            </div>
            <div class="form-group">
                <label for="uang_makan_perhari">Uang Makan</label>
                <input type="text" class="form-control" name="uang_makan_perhari"
                onkeypress='return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46'>
            </div>
            <a href="?page=jabatanread" class="btn btn-danger btn-sm float-right">
                <i class="fa fa-times-circle"></i> Batal
            </a>
            <button type="submit" name="button_create" class="btn-btn-success btn-sm float-right">
                <i class="fa fa-save"></i> Simpan
            </button>
        </form>
    </div>
</section>
<?php include_once "partials/scripts.php"?>