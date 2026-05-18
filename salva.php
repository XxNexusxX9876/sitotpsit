<?php
// ============================================
// salva.php — Inserisce un gioco nel database
// ============================================

// Include la connessione al database
require_once 'db.php';

// ---- Controlla che la richiesta sia di tipo POST ----
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// ---- Leggi e pulisce i dati inviati dal form ----
$titolo      = trim($_POST['titolo']      ?? '');
$piattaforma = trim($_POST['piattaforma'] ?? '');
$genere      = trim($_POST['genere']      ?? '');
$voto        = (int)($_POST['voto']       ?? 0);

// ---- Validazione lato server ----

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

$stmt = $conn->prepare(
    "INSERT INTO giochi (titolo, piattaforma, genere, voto)
     VALUES (?, ?, ?, ?)"
);

// Collega i parametri al prepared statement
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
