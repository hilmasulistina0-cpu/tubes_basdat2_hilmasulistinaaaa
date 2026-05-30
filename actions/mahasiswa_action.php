<?php
require '../config/database.php';
$db  = getDB();
$aksi = $_REQUEST['aksi'] ?? '';

if ($aksi === 'tambah' || $aksi === 'edit') {
    $nim  = $db->real_escape_string($_POST['nim']);
    $nama = $db->real_escape_string($_POST['nama_mahasiswa']);
    $prodi= 'Informatika';
    $th   = (int)$_POST['angkatan'];
    $jk   = $_POST['jenis_kelamin'] === 'P' ? 'P' : 'L';

    if ($aksi === 'tambah') {
        // Bab 3 — INSERT
        $sql = "INSERT INTO mahasiswa VALUES
                ('$nim','$nama','$prodi',$th,'$jk')";
    } else {
        // Bab 3 — UPDATE
        $sql = "UPDATE mahasiswa SET
                nama_mahasiswa='$nama', angkatan=$th,
                jenis_kelamin='$jk'
                WHERE nim='$nim'";
    }
    $db->query($sql);

} elseif ($aksi === 'hapus') {
    // Bab 3 — DELETE
    $nim = $db->real_escape_string($_GET['nim']);
    $db->query("DELETE FROM mahasiswa WHERE nim='$nim'");
}

header('Location: ../pages/mahasiswa.php');
exit;
?>
