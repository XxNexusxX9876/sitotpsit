<?php
// ============================================
// index.php — Homepage: lista dei videogiochi
// ============================================

require_once 'db.php';

// ---- Recupera giochi ----
$sql    = "SELECT * FROM giochi ORDER BY id DESC";
$result = $conn->query($sql);

// ---- Statistiche ----
$totale = $result->num_rows;

$sql_media = "SELECT ROUND(AVG(voto), 1) AS media FROM giochi";
$res_media = $conn->query($sql_media);
$row_media = $res_media->fetch_assoc();
$media_voto = $row_media['media'] ?? '—';

// ---- Messaggi ----
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

<!-- HEADER -->
<header>
    <a href="index.php" class="logo">
        <div class="logo-icon">
            <img src="img/logo.png" alt="Logo GameCenter">
        </div>
        <span class="logo-text">Game<span>Center</span></span>
    </a>
</header>

<!-- MAIN -->
<main>

    <div class="page-header">
        <h1>Catalogo Videogiochi</h1>
        <p>Gestisci la tua collezione personale di videogiochi</p>
    </div>

    <?= $msg ?>

    <!-- STATISTICHE -->
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
                <div class="number">API JSON</div>
                <div class="label">
                    <a href="api.php" target="_blank" style="color:var(--blue-mid)">
                        Visualizza
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- TABELLA -->
    <div class="card">
        <div class="card-header">
            <h2>📋 Elenco Giochi</h2>
            <a href="aggiungi.php" class="btn btn-primary">
                ➕ Aggiungi Gioco
            </a>
        </div>

        <div class="table-wrapper">

            <?php if ($totale === 0): ?>

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
                            <th>Copertina</th>
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
                            <td style="color:var(--gray-400); font-size:.8rem">
                                <?= $gioco['id'] ?>
                            </td>

                            <!-- COPERTINA -->
                            <td>
                                <?php if (!empty($gioco['copertina'])): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($gioco['copertina']) ?>"
                                         style="width:50px; height:50px; object-fit:cover; border-radius:8px;">
                                <?php else: ?>
                                    <span style="color:var(--gray-400); font-size:.8rem">—</span>
                                <?php endif; ?>
                            </td>

                            <!-- TITOLO -->
                            <td class="titolo">
                                <?= htmlspecialchars($gioco['titolo']) ?>
                            </td>

                            <!-- PIATTAFORMA -->
                            <td>
                                <span class="badge badge-platform">
                                    <?= htmlspecialchars($gioco['piattaforma']) ?>
                                </span>
                            </td>

                            <!-- GENERE -->
                            <td>
                                <span class="badge badge-genre">
                                    <?= htmlspecialchars($gioco['genere']) ?>
                                </span>
                            </td>

                            <!-- VOTO -->
                            <td>
                                <?php
                                    $v = (int)$gioco['voto'];
                                    if ($v >= 8)      $cls = 'voto-high';
                                    elseif ($v >= 5)  $cls = 'voto-mid';
                                    else              $cls = 'voto-low';
                                ?>
                                <span class="voto <?= $cls ?>">
                                    <?= $v ?>/10
                                </span>
                            </td>

                            <!-- AZIONE -->
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

        </div>
    </div>

</main>

<!-- FOOTER -->
<footer>
    Giuseppe Matto e Christian Polessi 5D - Progetto TPSIT — Catalogo Videogiochi
</footer>

</body>
</html>

<?php $conn->close(); ?>