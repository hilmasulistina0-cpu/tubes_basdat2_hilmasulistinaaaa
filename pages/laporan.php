<?php
require '../config/database.php';
$db = getDB();

// Bab 5 — Aggregate Function
$stat = $db->query(
    "SELECT COUNT(*) AS total_mhs,
            AVG(nilai_akhir) AS rata_rata,
            MAX(nilai_akhir) AS tertinggi,
            MIN(nilai_akhir) AS terendah
     FROM nilai"
)->fetch_assoc();

// Bab 5 — GROUP BY: Rata-rata per mata kuliah
$per_mk = $db->query(
    "SELECT mk.nama_mk,
            COUNT(n.id_nilai) AS peserta,
            ROUND(AVG(n.nilai_akhir),2) AS rata_rata
     FROM nilai n
     JOIN kelas k ON n.id_kelas = k.id_kelas
     JOIN mata_kuliah mk ON k.kode_mk = mk.kode_mk
     GROUP BY mk.nama_mk
     ORDER BY rata_rata DESC"
);

// Bab 6 — Subquery: Mahasiswa belum punya nilai
$belum = $db->query(
    "SELECT nama_mahasiswa, angkatan
     FROM mahasiswa
     WHERE nim NOT IN (SELECT nim FROM nilai)"
);

// Bab 6 — Subquery: Nilai di atas rata-rata
$diatas = $db->query(
    "SELECT m.nama_mahasiswa, n.nilai_akhir
     FROM mahasiswa m
     JOIN nilai n ON m.nim = n.nim
     WHERE n.nilai_akhir > (SELECT AVG(nilai_akhir) FROM nilai)
     ORDER BY n.nilai_akhir DESC"
);
?>
