<?php
// ============================================
// salva.php — Inserisce un gioco nel database
// ============================================

// Include la connessione al database
require_once 'db.php';

// ---- Controlla che la richiesta sia di tipo POST ----
// Questo file non deve essere aperto direttamente dal browser
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Se qualcuno tenta di aprire salva.php direttamente, lo reindirizziamo
    header('Location: index.php');
    exit;
}

// ---- Leggi e pulisce i dati inviati dal form ----
// trim() rimuove spazi iniziali/finali
// htmlspecialchars() previene attacchi XSS
$titolo      = trim($_POST['titolo']      ?? '');
$piattaforma = trim($_POST['piattaforma'] ?? '');
$genere      = trim($_POST['genere']      ?? '');
$voto        = (int)($_POST['voto']       ?? 0);

// ---- Validazione lato server ----
// (il form già valida lato client con required e min/max,
//  ma è buona pratica farlo anche qui)

$errori = [];

if (empty($titolo)) {
    $errori[] = 'Il titolo è obbligatorio.';
}

if (empty($piattaforma)) {
    $errori[] = 'La piattaforma è obbligatoria.';
}

if (empty($genere)) {
    $errori[] = 'Il genere è obbligatorio.';
}

if ($voto < 1 || $voto > 10) {
    $errori[] = 'Il voto deve essere compreso tra 1 e 10.';
}

// Se ci sono errori, torna al form con un messaggio
if (!empty($errori)) {
    $msg_errori = urlencode(implode(' | ', $errori));
    header("Location: aggiungi.php?errore=$msg_errori");
    exit;
}

// ---- Inserimento nel database con Prepared Statement ----
// I Prepared Statement proteggono dalle SQL Injection!
// Il ? è un segnaposto: il valore reale viene passato con bind_param()

$stmt = $conn->prepare(
    "INSERT INTO giochi (titolo, piattaforma, genere, voto)
     VALUES (?, ?, ?, ?)"
);

// Collega i parametri al prepared statement
// "sssi" = stringa, stringa, stringa, intero
$stmt->bind_param('sssi', $titolo, $piattaforma, $genere, $voto);

// Esegue la query
if ($stmt->execute()) {
    // Successo: torna alla homepage con messaggio positivo
    header('Location: index.php?added=1');
} else {
    // Errore: torna al form
    header('Location: aggiungi.php?errore=Errore+nel+salvataggio');
}

// Chiude lo statement e la connessione
$stmt->close();
$conn->close();
exit;
?>
