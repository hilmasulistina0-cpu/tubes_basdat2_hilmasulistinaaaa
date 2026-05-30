<?php
require '../config/database.php';
$db = getDB();

// SELECT dengan pencarian (Bab 3 - SELECT + WHERE)
$search = isset($_GET['q']) ? $db->real_escape_string($_GET['q']) : '';
$filter = isset($_GET['angkatan']) ? (int)$_GET['angkatan'] : 0;

$sql  = "SELECT * FROM mahasiswa WHERE 1=1";
if ($search) $sql .= " AND (nim LIKE '%$search%'
                          OR nama_mahasiswa LIKE '%$search%')";
if ($filter) $sql .= " AND angkatan = $filter";
$sql .= " ORDER BY nama_mahasiswa ASC";

$result = $db->query($sql);
?>
<!-- Tabel HTML untuk menampilkan data -->
<table class='table'>
  <thead><tr>
    <th>NIM</th><th>Nama</th><th>Angkatan</th><th>J/K</th><th>Aksi</th>
  </tr></thead>
  <tbody>
  <?php while ($row = $result->fetch_assoc()): ?>
  <tr>
    <td><code><?= htmlspecialchars($row['nim']) ?></code></td>
    <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
    <td><?= $row['angkatan'] ?></td>
    <td><?= $row['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
    <td>
      <a href='?edit=<?= $row['nim'] ?>'>Edit</a>
      <a href='actions/mahasiswa_action.php?aksi=hapus&nim=<?= $row['nim'] ?>'
         onclick='return confirm("Hapus data ini?")'>Hapus</a>
    </td>
  </tr>
  <?php endwhile; ?>
  </tbody>
</table>
