<?php
require '../config/database.php';
$db = getDB();

// Bab 7 — Panggil VIEW (jika ada)
// SELECT dari VIEW vw_transkrip (BAB 7)
$nim_filter = isset($_GET['nim'])
    ? $db->real_escape_string($_GET['nim']) : '';

if ($nim_filter) {
    // Gunakan VIEW (Bab 7)
    $sql = "SELECT * FROM vw_transkrip WHERE nim='$nim_filter'";
} else {
    // Atau gunakan JOIN langsung (Bab 4)
    $sql = "SELECT m.nim, m.nama_mahasiswa, m.angkatan,
                   mk.kode_mk, mk.nama_mk, mk.sks,
                   n.nilai_akhir,
                   CASE
                     WHEN n.nilai_akhir >= 85 THEN 'A'
                     WHEN n.nilai_akhir >= 75 THEN 'B'
                     WHEN n.nilai_akhir >= 65 THEN 'C'
                     WHEN n.nilai_akhir >= 55 THEN 'D'
                     ELSE 'E'
                   END AS grade
            FROM mahasiswa m
            INNER JOIN nilai n  ON m.nim = n.nim
            INNER JOIN kelas k  ON n.id_kelas = k.id_kelas
            INNER JOIN mata_kuliah mk ON k.kode_mk = mk.kode_mk
            ORDER BY m.nama_mahasiswa, mk.nama_mk";
}
$result = $db->query($sql);

// Bab 8 — Panggil Stored Procedure untuk status kelulusan
if ($nim_filter) {
    $db->query("CALL sp_status_lulus('$nim_filter')");
    $status = $db->store_result()->fetch_assoc();
    $db->next_result();
}
?>
