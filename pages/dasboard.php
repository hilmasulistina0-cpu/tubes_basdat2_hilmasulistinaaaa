<?php require '../config/database.php';
$db = getDB();

// Tampilkan daftar tabel (Bab 2 - DDL verification)
$tables = $db->query('SHOW TABLES');
while ($t = $tables->fetch_array()) {
    $tname = $t[0];
    $desc  = $db->query("DESCRIBE `$tname`");
    echo "<h4>$tname</h4><table>";
    while ($col = $desc->fetch_assoc()) {
        echo "<tr><td>{$col['Field']}</td>"
           . "<td>{$col['Type']}</td>"
           . "<td>{$col['Key']}</td></tr>";
    }
    echo '</table>';
}
?>
