<?php
// ============================================
// API per il catalogo videogiochi
// ============================================

// Include la connessione al database
require_once 'db.php';

// ---- Imposta gli header HTTP ----
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');

// ---- Leggi parametri di filtro ----
$filtro_piattaforma = trim($_GET['piattaforma'] ?? '');
$filtro_genere      = trim($_GET['genere']      ?? '');

// ---- Costruzione query ----
$sql    = "SELECT id, titolo, piattaforma, genere, voto, created_at FROM giochi";
$params = [];
$types  = '';
$where  = [];

if (!empty($filtro_piattaforma)) {
    $where[]  = "piattaforma = ?";
    $types   .= 's';
    $params[] = $filtro_piattaforma;
}

if (!empty($filtro_genere)) {
    $where[]  = "genere = ?";
    $types   .= 's';
    $params[] = $filtro_genere;
}

if (!empty($where)) {
    $sql .= " WHERE " . implode(' AND ', $where);
}

$sql .= " ORDER BY id ASC";

// ---- Esecuzione query ----
if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

// ---- Raccoglimento risultati in un array ----
$giochi = [];
while ($row = $result->fetch_assoc()) {
    $row['voto'] = (int)$row['voto'];
    $row['id']   = (int)$row['id'];
    $giochi[]    = $row;
}

// ---- Costruzione file JSON ----
$risposta = [
    'success' => true,
    'totale'  => count($giochi),
    'filtri'  => [
        'piattaforma' => $filtro_piattaforma ?: null,
        'genere'      => $filtro_genere      ?: null,
    ],
    'giochi'  => $giochi,
];

// ---- Restituzione JSON ----
echo json_encode($risposta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$conn->close();
?>
