<?php
// ============================================
// elimina.php — Elimina un gioco dal database
// ============================================

require_once 'db.php';

// ---- Lettura e validazione URL ----
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// ---- Query di eliminazione gioco ----
$stmt = $conn->prepare("DELETE FROM giochi WHERE id = ?");

$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    header('Location: index.php?deleted=1');
} else {
    header('Location: index.php?errore=1');
}

// Chiusura connesione
$stmt->close();
$conn->close();
exit;
?>
