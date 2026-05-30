<?php
require '../config/database.php';
$db = getDB();

if ($_POST['aksi'] === 'tambah') {
    $nim    = $db->real_escape_string($_POST['nim']);
    $kelas  = (int)$_POST['id_kelas'];
    $nilai  = (float)$_POST['nilai_akhir'];

    // Bab 9 — Validasi nilai
    if ($nilai < 0 || $nilai > 100) {
        die('Error: Nilai harus antara 0 dan 100');
    }

    // Bab 9 — Mulai Transaction
    $db->begin_transaction();
    try {
        // Cek mahasiswa ada
        $cek = $db->query(
            "SELECT nim FROM mahasiswa WHERE nim='$nim'"
        )->num_rows;
        if ($cek === 0) throw new Exception('Mahasiswa tidak ditemukan');

        // INSERT nilai
        $db->query(
            "INSERT INTO nilai (nim, id_kelas, nilai_akhir)
             VALUES ('$nim', $kelas, $nilai)"
        );

        // Bab 9 — COMMIT jika berhasil
        $db->commit();
        $_SESSION['success'] = 'Nilai berhasil disimpan';

    } catch (Exception $e) {
        // Bab 9 — ROLLBACK jika gagal
        $db->rollback();
        $_SESSION['error'] = 'Gagal: ' . $e->getMessage();
    }
}

header('Location: ../pages/nilai.php');
exit;
?>
