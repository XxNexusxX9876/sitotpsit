<?php
// ============================================
// index.php — Homepage: lista dei videogiochi
// ============================================

// Include la connessione al database
require_once 'db.php';

// ---- Recupera tutti i giochi dal database ----
$sql    = "SELECT * FROM giochi ORDER BY id DESC";
$result = $conn->query($sql);

// ---- Conta totale giochi ----
$totale = $result->num_rows;

// ---- Calcola voto medio ----
$sql_media = "SELECT ROUND(AVG(voto), 1) AS media FROM giochi";
$res_media = $conn->query($sql_media);
$row_media = $res_media->fetch_assoc();
$media_voto = $row_media['media'] ?? '—';

// ---- Messaggio di feedback (es. dopo eliminazione) ----
$msg = '';
if (isset($_GET['deleted']) && $_GET['deleted'] == '1') {
    $msg = '<div class="alert alert-success">🗑️ Gioco eliminato con successo.</div>';
}
if (isset($_GET['added']) && $_GET['added'] == '1') {
    $msg = '<div class="alert alert-success">✅ Gioco aggiunto con successo!</div>';
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo Videogiochi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ========== HEADER ========== -->
<header>
    <a href="index.php" class="logo">
        <div class="logo-icon">🎮</div>
        <span class="logo-text">Game<span>Catalog</span></span>
    </a>
    <nav>
        <a href="api.php" target="_blank">🔗 API JSON</a>
    </nav>
</header>

<!-- ========== MAIN ========== -->
<main>

    <!-- Titolo pagina -->
    <div class="page-header">
        <h1>Catalogo Videogiochi</h1>
        <p>Gestisci la tua collezione personale di videogiochi</p>
    </div>

    <!-- Messaggio di feedback -->
    <?= $msg ?>

    <!-- Statistiche rapide -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue">🎮</div>
            <div class="stat-info">
                <div class="number"><?= $totale ?></div>
                <div class="label">Giochi totali</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">⭐</div>
            <div class="stat-info">
                <div class="number"><?= $media_voto ?></div>
                <div class="label">Voto medio</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">🔗</div>
            <div class="stat-info">
                <div class="number">ESPORTA JSON</div>
                <div class="label"><a href="api.php" target="_blank" style="color:var(--blue-mid)">Apri API</a></div>
            </div>
        </div>
    </div>

    <!-- Tabella giochi -->
    <div class="card">
        <div class="card-header">
            <h2>📋 Elenco Giochi</h2>
            <a href="aggiungi.php" class="btn btn-primary">
                ➕ Aggiungi Gioco
            </a>
        </div>

        <div class="table-wrapper">
            <?php if ($totale === 0): ?>
                <!-- Stato vuoto -->
                <div class="empty-state">
                    <div class="empty-icon">🕹️</div>
                    <p>Nessun gioco nel catalogo.<br>
                    <a href="aggiungi.php" style="color:var(--blue-mid)">Aggiungi il primo!</a></p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Titolo</th>
                            <th>Piattaforma</th>
                            <th>Genere</th>
                            <th>Voto</th>
                            <th>Azione</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($gioco = $result->fetch_assoc()): ?>
                        <tr>
                            <!-- ID -->
                            <td style="color:var(--gray-400); font-size:.8rem"><?= $gioco['id'] ?></td>

                            <!-- Titolo -->
                            <td class="titolo"><?= htmlspecialchars($gioco['titolo']) ?></td>

                            <!-- Piattaforma con badge -->
                            <td>
                                <span class="badge badge-platform">
                                    <?= htmlspecialchars($gioco['piattaforma']) ?>
                                </span>
                            </td>

                            <!-- Genere con badge -->
                            <td>
                                <span class="badge badge-genre">
                                    <?= htmlspecialchars($gioco['genere']) ?>
                                </span>
                            </td>

                            <!-- Voto con colore dinamico -->
                            <td>
                                <?php
                                    $v = (int)$gioco['voto'];
                                    // Colore in base al voto
                                    if ($v >= 8)      $cls = 'voto-high';
                                    elseif ($v >= 5)  $cls = 'voto-mid';
                                    else              $cls = 'voto-low';

                                    // Icona stellina
                                    $stars = str_repeat('★', $v) . str_repeat('☆', 10 - $v);
                                ?>
                                <span class="voto <?= $cls ?>">
                                    <?= $v ?>/10
                                </span>
                            </td>

                            <!-- Pulsante elimina (con conferma JS) -->
                            <td>
                                <a href="elimina.php?id=<?= $gioco['id'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Sei sicuro di voler eliminare questo gioco?')">
                                    🗑️ Elimina
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div><!-- /table-wrapper -->
    </div><!-- /card -->

</main>

<!-- ========== FOOTER ========== -->
<footer>
    Giuseppe Matto e Christian Polessi 5D - Progetto TPSIT — Istituto Tecnico Informatico &nbsp;|&nbsp; Catalogo Videogiochi
</footer>

</body>
</html>
<?php $conn->close(); ?>
