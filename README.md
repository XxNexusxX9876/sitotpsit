# 🎮 Catalogo Videogiochi
**Progetto TPSIT — Istituto Tecnico Informatico**

---

## 📁 Struttura del progetto

```
catalogo_videogiochi/
├── css/
│   └── style.css       ← Stile dell'intera applicazione
├── db.php              ← Connessione al database MySQL
├── index.php           ← Homepage con elenco giochi
├── aggiungi.php        ← Form per aggiungere un gioco
├── salva.php           ← Elabora il form e salva nel DB
├── elimina.php         ← Elimina un gioco dal DB
├── api.php             ← API JSON (restituisce i giochi)
├── database.sql        ← Script per creare il database
└── README.md           ← Questo file
```

---

## 🚀 Avvio del progetto su XAMPP

### 1. Avvia XAMPP
- Apri il **Pannello di Controllo XAMPP**
- Avvia **Apache** e **MySQL**

### 2. Copia i file
- Copia l'intera cartella `catalogo_videogiochi/` in:
  ```
  C:\xampp\htdocs\
  ```

### 3. Crea il database
- Apri il browser e vai su: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
- Clicca su **"Nuovo"** nel menu a sinistra (oppure vai su "SQL")
- Incolla il contenuto di `database.sql` nel pannello SQL
- Clicca **"Esegui"**

> Il database `videogiochi` e la tabella `giochi` verranno creati automaticamente, con 6 giochi di esempio.

### 4. Apri il sito
- Vai su: [http://localhost/catalogo_videogiochi/](http://localhost/catalogo_videogiochi/)

---

## 🌐 Pagine del sito

| URL | Descrizione |
|-----|-------------|
| `/index.php` | Homepage con l'elenco di tutti i giochi |
| `/aggiungi.php` | Form per aggiungere un nuovo gioco |
| `/salva.php` | (solo POST) Salva il gioco nel database |
| `/elimina.php?id=N` | Elimina il gioco con ID = N |
| `/api.php` | API JSON con tutti i giochi |

---

## 🔗 API JSON

L'API è accessibile via browser o qualsiasi client HTTP.

**URL base:**
```
http://localhost/catalogo_videogiochi/api.php
```

**Risposta di esempio:**
```json
{
  "success": true,
  "totale": 2,
  "filtri": {
    "piattaforma": null,
    "genere": null
  },
  "giochi": [
    {
      "id": 1,
      "titolo": "Zelda: Breath of the Wild",
      "piattaforma": "Nintendo Switch",
      "genere": "Avventura",
      "voto": 10,
      "created_at": "2025-01-01 10:00:00"
    }
  ]
}
```

**Filtri opzionali:**
```
api.php?piattaforma=PC
api.php?genere=RPG
api.php?piattaforma=PC&genere=RPG
```

---

## 🛡️ Sicurezza implementata

- **Prepared Statement** in `salva.php` e `elimina.php` → protezione da SQL Injection
- **htmlspecialchars()** nell'output → protezione da XSS
- **Validazione lato server** in `salva.php` → i dati vengono sempre verificati

---

## ⚙️ Tecnologie utilizzate

| Tecnologia | Utilizzo |
|-----------|----------|
| **PHP** | Backend, logica del server |
| **MySQL** | Database dei videogiochi |
| **HTML5** | Struttura delle pagine |
| **CSS3** | Stile e layout responsive |
| **JavaScript** | Conferma eliminazione (`confirm()`) |
| **JSON** | Formato di risposta dell'API |

---

*Progetto scolastico — Istituto Tecnico Informatico — TPSIT*
