<?php
// ============================================
// aggiungi.php — Form per aggiungere un gioco
// ============================================
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Gioco — Catalogo Videogiochi</title>
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
        <a href="index.php">← Torna al catalogo</a>
    </nav>
</header>

<!-- ========== MAIN ========== -->
<main>

    <div class="page-header">
        <h1>➕ Aggiungi un Gioco</h1>
        <p>Compila il modulo per inserire un nuovo videogioco nel catalogo</p>
    </div>

    <!-- Card con il form -->
    <div class="card form-wrapper">
        <div class="card-header">
            <h2>🕹️ Nuovo Videogioco</h2>
        </div>

        <div style="padding: 28px 24px;">
            <!--
                Il form invia i dati in POST a salva.php
                method="post" → i dati NON appaiono nell'URL
                action="salva.php" → il file che elabora i dati
            -->
            <form action="salva.php" method="post">

                <!-- Campo: Titolo -->
                <div class="form-group">
                    <label for="titolo">🎮 Titolo del Gioco *</label>
                    <input
                        type="text"
                        id="titolo"
                        name="titolo"
                        placeholder="Es. The Legend of Zelda"
                        required
                        maxlength="100"
                    >
                </div>

                <!-- Campo: Piattaforma -->
                <div class="form-group">
                    <label for="piattaforma">🖥️ Piattaforma *</label>
                    <select id="piattaforma" name="piattaforma" required>
                        <option value="" disabled selected>Seleziona una piattaforma</option>
                        <option value="PC">PC</option>
                        <option value="PlayStation 5">PlayStation 5</option>
                        <option value="PlayStation 4">PlayStation 4</option>
                        <option value="Xbox Series X">Xbox Series X</option>
                        <option value="Xbox One">Xbox One</option>
                        <option value="Nintendo Switch">Nintendo Switch</option>
                        <option value="Mobile">Mobile</option>
                        <option value="Altra">Altra</option>
                    </select>
                </div>

                <!-- Campo: Genere -->
                <div class="form-group">
                    <label for="genere">🏷️ Genere *</label>
                    <select id="genere" name="genere" required>
                        <option value="" disabled selected>Seleziona un genere</option>
                        <option value="Action">Action</option>
                        <option value="Action RPG">Action RPG</option>
                        <option value="RPG">RPG</option>
                        <option value="FPS">FPS (First Person Shooter)</option>
                        <option value="TPS">TPS (Third Person Shooter)</option>
                        <option value="Avventura">Avventura</option>
                        <option value="Piattaforma">Piattaforma</option>
                        <option value="Sport">Sport</option>
                        <option value="Simulazione">Simulazione</option>
                        <option value="Strategia">Strategia</option>
                        <option value="Horror">Horror</option>
                        <option value="Sandbox">Sandbox</option>
                        <option value="Puzzle">Puzzle</option>
                        <option value="Altro">Altro</option>
                    </select>
                </div>

                <!-- Campo: Voto -->
                <div class="form-group">
                    <label for="voto">⭐ Voto (1–10) *</label>
                    <input
                        type="number"
                        id="voto"
                        name="voto"
                        min="1"
                        max="10"
                        placeholder="Es. 8"
                        required
                    >
                </div>

                <!-- Pulsanti -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        💾 Salva Gioco
                    </button>
                    <a href="index.php" class="btn btn-ghost">
                        ✕ Annulla
                    </a>
                </div>

            </form>
        </div>
    </div><!-- /card -->

</main>

<!-- ========== FOOTER ========== -->
<footer>
    Progetto TPSIT — Istituto Tecnico Informatico &nbsp;|&nbsp; Catalogo Videogiochi
</footer>

</body>
</html>
