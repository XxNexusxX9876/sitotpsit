<?php
// ============================================
// salva.php — Inserisce un gioco nel database
// ============================================
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// ---- Lettura e pulizia dati form ----
$titolo      = trim($_POST['titolo']      ?? '');
$piattaforma = trim($_POST['piattaforma'] ?? '');
$genere      = trim($_POST['genere']      ?? '');
$voto        = (int)($_POST['voto']       ?? 0);
$copertina = null;

if (isset($_FILES['copertina']) && $_FILES['copertina']['error'] === 0) {
    $copertina = file_get_contents($_FILES['copertina']['tmp_name']);
}

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

if (!empty($errori)) {
    $msg_errori = urlencode(implode(' | ', $errori));
    header("Location: aggiungi.php?errore=$msg_errori");
    exit;
}

// ---- Preparazione query di inserimento ----
$stmt = $conn->prepare(
    "INSERT INTO giochi (titolo, piattaforma, genere, voto, copertina)
    VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param('sssib', $titolo, $piattaforma, $genere, $voto, $copertina);

if ($copertina !== null) {
    $stmt->send_long_data(4, $copertina);
}

// Esecuzione query
if ($stmt->execute()) {
    header('Location: index.php?added=1');
} else {
    header('Location: aggiungi.php?errore=Errore+nel+salvataggio');
}

// Chiusura connesione
$stmt->close();
$conn->close();
exit;
?>
