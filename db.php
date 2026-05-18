<?php
// ============================================
// db.php — Connessione al database MySQL
// ============================================

// Parametri di connessione (modifica se necessario)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'videogiochi');

// Creazione della connessione con mysqli
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Controllo errore di connessione
if ($conn->connect_error) {
    // Mostra un messaggio di errore leggibile
    die('
        <div style="
            font-family: sans-serif;
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 20px;
            margin: 40px auto;
            max-width: 500px;
            border-radius: 10px;
            text-align: center;
        ">
            <strong>Errore di connessione al database!</strong><br><br>
            ' . $conn->connect_error . '<br><br>
            Assicurati che XAMPP sia avviato e che il database
            <code>videogiochi</code> esista.
        </div>
    ');
}

// Imposta il charset a UTF-8 per supportare caratteri speciali
$conn->set_charset('utf8mb4');
?>
