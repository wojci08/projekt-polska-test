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

// Pobierz aktualną stronę z URL-a
$page = isset($_GET['page']) ? $_GET['page'] : 'demografia';

// Generuj zawartość na podstawie wybranej strony
$tableContent = '';
$pageTitle = 'Polska';

if ($page === 'demografia') {
    $pageTitle = 'Demografia Polski';
    // Pobierz dane demograficzne
    $sql = 'SELECT * FROM demografia';
    $result = $conn->query($sql);

    // Generuj HTML tabel z danymi
    $tableContent = '<table><tr><th>Rok</th><th>Liczba ludności</th><th>Przyrost naturalny</th></tr>';
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tableContent .= '<tr>';
            $tableContent .= '<td>' . htmlspecialchars($row['rok']) . '</td>';
            $tableContent .= '<td>' . htmlspecialchars($row['liczba_ludnosci']) . '</td>';
            $tableContent .= '<td>' . htmlspecialchars($row['przyrost_naturalny']) . '</td>';
            $tableContent .= '</tr>';
        }
    } else {
        $tableContent .= '<tr><td colspan="3">Brak danych w bazie.</td></tr>';
    }
    $tableContent .= '</table>';
} elseif ($page === 'miasta') {
    $pageTitle = 'Miasta Polski';
    // Pobierz dane miast z bazy danych
    $sql = 'SELECT * FROM miasta';
    $result = $conn->query($sql);

    // Generuj kafelki miast
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tableContent .= '<div class="city-card">';
            
            // Lewy panel - zdjęcie
            $tableContent .= '<div class="city-card-image">';
            $zdjecie = htmlspecialchars($row['zdjęcie']) ?: 'https://via.placeholder.com/400x300?text=' . urlencode($row['nazwa']);
            $tableContent .= '<img src="' . $zdjecie . '" alt="' . htmlspecialchars($row['nazwa']) . '">';
            $tableContent .= '</div>';
            
            // Prawy panel - info
            $tableContent .= '<div class="city-card-content">';
            $tableContent .= '<h3>' . htmlspecialchars($row['nazwa']) . '</h3>';
            $tableContent .= '<div class="city-info">';
            $tableContent .= '<p><strong>Liczba ludności:</strong> ' . number_format($row['liczba_ludnosci'], 0, ',', ' ') . '</p>';
            $tableContent .= '<p><strong>Województwo:</strong> ' . htmlspecialchars($row['wojewodztwo']) . '</p>';
            $tableContent .= '<p><strong>Turyści (2024):</strong> ' . number_format($row['turyści_2024'], 0, ',', ' ') . '</p>';
            if (!empty($row['opis'])) {
                $tableContent .= '<p><strong>Opis:</strong> ' . htmlspecialchars($row['opis']) . '</p>';
            }
            $tableContent .= '</div>';
            $tableContent .= '</div>';
            
            $tableContent .= '</div>';
        }
    } else {
        $tableContent = '<p style="text-align: center; margin-top: 30px;">Brak miast w bazie danych.</p>';
    }
} elseif ($page === 'wartozobaczyc') {
    $pageTitle = 'Co warto zobaczyć';
    $tableContent = '<p style="text-align: center; margin-top: 30px;">Zawartość o atrakcjach turystycznych będzie wkrótce dostępna...</p>';
}

$sql = 'SELECT * FROM linki';
$result = $conn->query($sql);

// Generuj HTML linków z danymi
$linkContent = '<ul>';
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $linkContent .= '<li><a href="' . htmlspecialchars($row['url']) . '" class="menu-link">' . htmlspecialchars($row['nazwa']) . '</a></li>';
    }
} else {
    $linkContent .= '<li>Brak linków w bazie danych.</li>';
}
$linkContent .= '</ul>';

// Załaduj szablon HTML i wstaw linki
// Załaduj szablon HTML
$html = file_get_contents('public_html/index.html');
$html = str_replace('{TITLE}', htmlspecialchars($pageTitle), $html);
$html = str_replace('{CONTENT}', $tableContent, $html);
$html = str_replace('{LINKS}', $linkContent, $html);
echo $html;

$conn->close();