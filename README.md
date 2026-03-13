# FluxSpire — Demo Sites

Raccolta di landing page demo e redesign, con dashboard clienti protetta da login.

---

## Struttura

```
demo_sites/
├── index.html          ← Dashboard con login (Area Clienti)
├── README.md           ← Questo file
├── riwatch/
│   └── index.html      ← Demo landing page Riwatch
└── gruppotrio/
    ├── index.html      ← Demo landing page Gruppo Trio S.p.A.
    ├── logo.png        ← Logo icona Gruppo Trio
    └── logo-full.png   ← Logo completo Gruppo Trio
```

**URL live:** `https://www.fluxspire.it/clienti/`

---

## Sistema di Login

La dashboard è protetta da login client-side (JavaScript puro, no backend).
La sessione è mantenuta con `sessionStorage` (si azzera chiudendo il browser).

### Utenti e credenziali

| Utente    | Password        | Progetti visibili         |
|-----------|-----------------|---------------------------|
| `admin`   | `fluxspire2026` | Tutti i progetti          |
| `riwatch` | `riwatch2026`   | Solo Riwatch              |
| `trio`    | `trio2026`      | Solo Gruppo Trio S.p.A.   |
| `ddd`     | `ddd2026`       | Solo DDD Reader           |

---

## Come aggiungere un progetto

Nel file `index.html`, all'interno dello script, modifica l'array `PROJECTS`:

```js
const PROJECTS = [
  {
    id: 'nuovo-cliente',          // identificatore univoco
    title: 'Nome Cliente',        // titolo visualizzato nella card
    description: 'Descrizione...', // testo della card
    tags: ['Settore', 'Tech'],    // tag visualizzati
    badge: 'demo',                // 'demo' oppure 'live'
    href: 'nomecartella/index.html', // link al progetto (relativo o assoluto)
    ref: 'sito-cliente.it',       // testo piccolo in basso a destra
    previewColor: '#2c37c7',      // colore dominante del preview mockup
  },
  // ... altri progetti
];
```

## Come aggiungere un utente

Nell'oggetto `USERS` dello stesso script:

```js
const USERS = {
  // utente che vede solo un progetto
  'nomecliente': {
    password: 'passwordsicura',
    projects: ['nuovo-cliente'],  // array di id da PROJECTS
    label: 'Nome Visualizzato',
  },

  // utente che vede più progetti
  'multicliente': {
    password: 'password',
    projects: ['riwatch', 'nuovo-cliente'],
    label: 'Multi Cliente',
  },

  // admin vede tutto
  'admin': {
    password: 'fluxspire2026',
    projects: 'all',
    label: 'Admin',
  },
};
```

Dopo ogni modifica, ricaricare il file `index.html` sul server FTP Aruba.

---

## Deploy su Aruba (FTP)

```bash
# Credenziali FTP
# Host:  ftp.fluxspire.it  |  Porta: 21
# User:  14479229@aruba.it
# Path:  /www.fluxspire.it/clienti/

# Carica dashboard
curl -T index.html "ftp://ftp.fluxspire.it/www.fluxspire.it/clienti/index.html" \
  --user "14479229@aruba.it:PASSWORD"

# Carica un progetto (es. nuovo cliente)
curl -T nomecartella/index.html \
  "ftp://ftp.fluxspire.it/www.fluxspire.it/clienti/nomecartella/index.html" \
  --user "14479229@aruba.it:PASSWORD" --ftp-create-dirs
```

---

## Siti presenti

| Cartella      | Cliente             | Stato | Referente |
|---------------|---------------------|-------|-----------|
| `riwatch/`    | Riwatch             | Demo  | utente `riwatch` |
| `gruppotrio/` | Gruppo Trio S.p.A.  | Demo  | utente `trio` |
| DDD Reader    | (esterno)           | Live  | utente `ddd` → `http://89.46.70.88` |
