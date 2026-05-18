<?php
// ============================================
// elimina.php — Elimina un gioco dal database
// ============================================

// Include la connessione al database
require_once 'db.php';

// ---- Leggi e valida l'ID passato nell'URL ----
// Es: elimina.php?id=5
$id = (int)($_GET['id'] ?? 0);

// Se l'ID non è valido (0 o negativo), torna alla homepage
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// ---- Elimina il gioco con Prepared Statement ----
// Protezione da SQL Injection anche in fase di cancellazione
$stmt = $conn->prepare("DELETE FROM giochi WHERE id = ?");

// "i" = intero
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Successo: torna alla homepage con messaggio
    header('Location: index.php?deleted=1');
} else {
    // Errore generico
    header('Location: index.php?errore=1');
}

// Chiude connessioni
$stmt->close();
$conn->close();
exit;
?>
