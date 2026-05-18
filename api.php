<?php
// ============================================
// api.php — API REST in formato JSON
// Restituisce tutti i videogiochi
// ============================================

// Include la connessione al database
require_once 'db.php';

// ---- Imposta gli header HTTP ----
// Dice al browser (o a chi consuma l'API) che la risposta è JSON
header('Content-Type: application/json; charset=UTF-8');

// CORS: permette di chiamare questa API da altri siti/domini
// Utile se vuoi consumarla con JavaScript da un'altra pagina
header('Access-Control-Allow-Origin: *');

// ---- Leggi eventuale parametro di filtro (opzionale) ----
// Es: api.php?piattaforma=PC
$filtro_piattaforma = trim($_GET['piattaforma'] ?? '');
$filtro_genere      = trim($_GET['genere']      ?? '');

// ---- Costruisce la query in base ai filtri ----
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

// ---- Esegui la query (con o senza parametri) ----
if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

// ---- Raccoglie i risultati in un array PHP ----
$giochi = [];
while ($row = $result->fetch_assoc()) {
    // Converte il voto in intero per il JSON
    $row['voto'] = (int)$row['voto'];
    $row['id']   = (int)$row['id'];
    $giochi[]    = $row;
}

// ---- Costruisce la risposta JSON ----
$risposta = [
    'success' => true,
    'totale'  => count($giochi),
    'filtri'  => [
        'piattaforma' => $filtro_piattaforma ?: null,
        'genere'      => $filtro_genere      ?: null,
    ],
    'giochi'  => $giochi,
];

// ---- Restituisce il JSON ----
// JSON_PRETTY_PRINT: formattazione leggibile
// JSON_UNESCAPED_UNICODE: caratteri speciali (es. à, è) non vengono escaped
echo json_encode($risposta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$conn->close();
?>
