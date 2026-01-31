<?php
// Połączenie z bazą danych MySQL
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'polska';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die('Błąd połączenia z bazą danych: ' . $conn->connect_error);
}

// Pobierz dane demograficzne
$sql = 'SELECT * FROM demografia';
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dane demograficzne Polski</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Dane demograficzne Polski</h1>
    <table>
        <tr>
            <th>Rok</th>
            <th>Liczba ludności</th>
            <th>Przyrost naturalny</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['rok']) ?></td>
                    <td><?= htmlspecialchars($row['liczba_ludnosci']) ?></td>
                    <td><?= htmlspecialchars($row['przyrost_naturalny']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3">Brak danych w bazie.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
<?php
$conn->close();
