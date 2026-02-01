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

// Generuj HTML tabel z danymi
$tableContent = '';
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tableContent .= '<tr>';
        $tableContent .= '<td>' . htmlspecialchars($row['rok']) . '</td>';
        $tableContent .= '<td>' . htmlspecialchars($row['liczba_ludnosci']) . '</td>';
        $tableContent .= '<td>' . htmlspecialchars($row['przyrost_naturalny']) . '</td>';
        $tableContent .= '</tr>';
    }
} else {
    $tableContent = '<tr><td colspan="3">Brak danych w bazie.</td></tr>';
}

// Załaduj szablon HTML
$html = file_get_contents('public_html/index.html');
$html = str_replace('{CONTENT}', $tableContent, $html);
echo $html;

$conn->close();
