<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Noteva — My Notes</title>
    <meta name="theme-color" content="#0f0e17">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Noteva">
    <link rel="manifest" href="/manifest.json">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#0f0e17;--surface:#1a1827;--surface2:#221f33;--accent:#ff6b6b;--accent2:#ffd93d;--text:#fffffe;--muted:#a7a9be;--border:rgba(255,255,255,0.07);--radius:18px;}
        body.light{--bg:#f5f4f0;--surface:#ffffff;--surface2:#eeedf4;--text:#0f0e17;--muted:#6e6d7a;--border:rgba(0,0,0,0.09);}
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;overflow-x:hidden;transition:background 0.3s,color 0.3s;}
        body::before{content:'';position:fixed;top:-200px;left:-200px;width:600px;height:600px;background:radial-gradient(circle,rgba(255,107,107,0.12) 0%,transparent 70%);pointer-events:none;z-index:0;}
        body::after{content:'';position:fixed;bottom:-150px;right:-150px;width:500px;height:500px;background:radial-gradient(circle,rgba(77,150,255,0.1) 0%,transparent 70%);pointer-events:none;z-index:0;}

        /* NAV */
        nav{position:sticky;top:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:14px 24px;background:rgba(15,14,23,0.88);backdrop-filter:blur(20px);border-bottom:1px solid var(--border);transition:background 0.3s;}
        body.light nav{background:rgba(245,244,240,0.9);}
        .nav-left{display:flex;align-items:center;gap:14px;}
        .nav-logo{font-family:'Syne',sans-serif;font-weight:800;font-size:22px;background:linear-gradient(135deg,var(--accent),var(--accent2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
        .theme-btn{background:var(--surface);border:1px solid var(--border);color:var(--text);border-radius:50px;padding:6px 14px;cursor:pointer;font-size:13px;font-family:'DM Sans',sans-serif;transition:all 0.2s;}
        .theme-btn:hover{border-color:var(--accent);}
        .nav-right{display:flex;align-items:center;gap:10px;}
        .nav-user{font-size:13px;color:var(--muted);}
        .btn-nav{font-size:13px;padding:6px 14px;border-radius:50px;border:1px solid var(--border);background:transparent;color:var(--muted);cursor:pointer;transition:all 0.2s;text-decoration:none;}
        .btn-nav:hover{border-color:var(--accent);color:var(--accent);}

        /* OFFLINE BANNER */
        .offline-banner{display:none;position:fixed;top:65px;left:0;right:0;z-index:99;background:linear-gradient(135deg,#ff6b6b,#ff4444);color:white;text-align:center;padding:8px 16px;font-size:13px;font-weight:600;}
        .offline-banner.show{display:block;}
        .sync-banner{display:none;position:fixed;top:65px;left:0;right:0;z-index:99;background:linear-gradient(135deg,#6bcb77,#4caf50);color:white;text-align:center;padding:8px 16px;font-size:13px;font-weight:600;}
        .sync-banner.show{display:block;}

        /* MAIN */
        main{position:relative;z-index:1;max-width:1200px;margin:0 auto;padding:32px 20px 100px;}
        .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;}
        .page-title{font-family:'Syne',sans-serif;font-weight:700;font-size:clamp(24px,5vw,36px);}
        .note-count{font-size:13px;color:var(--muted);background:var(--surface);padding:4px 12px;border-radius:50px;border:1px solid var(--border);}

        /* SEARCH */
        .search-wrap{position:relative;margin-bottom:28px;}
        .search-icon{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:16px;pointer-events:none;}
        #search{width:100%;padding:14px 16px 14px 44px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);color:var(--text);font-size:15px;font-family:'DM Sans',sans-serif;outline:none;transition:border-color 0.2s;}
        #search::placeholder{color:var(--muted);}
        #search:focus{border-color:rgba(255,107,107,0.5);}

        /* ADD CARD */
        .add-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:32px;transition:border-color 0.3s;}
        .add-card:focus-within{border-color:rgba(255,107,107,0.4);}
        .add-card-collapsed{cursor:pointer;display:flex;align-items:center;gap:12px;color:var(--muted);font-size:15px;user-select:none;}
        .add-card-expanded{display:none;}
        .add-card.open .add-card-collapsed{display:none;}
        .add-card.open .add-card-expanded{display:block;}
        .add-title-input,.add-body-input{width:100%;background:transparent;border:none;outline:none;color:var(--text);font-family:'DM Sans',sans-serif;resize:none;}
        .add-title-input{font-family:'Syne',sans-serif;font-size:17px;font-weight:700;margin-bottom:10px;display:block;}
        .add-title-input::placeholder{color:var(--muted);font-weight:400;font-family:'DM Sans',sans-serif;}
        .add-body-input{font-size:14px;line-height:1.7;min-height:80px;display:block;}
        .add-body-input::placeholder{color:var(--muted);}
        .add-footer{display:flex;align-items:center;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:10px;}
        .color-picks{display:flex;gap:8px;align-items:center;}
        .color-swatch{width:22px;height:22px;border-radius:50%;border:2px solid transparent;cursor:pointer;transition:transform 0.15s;}
        .color-swatch:hover,.color-swatch.selected{transform:scale(1.3);border-color:rgba(255,255,255,0.5);}
        body.light .color-swatch:hover,body.light .color-swatch.selected{border-color:rgba(0,0,0,0.4);}
        .add-actions{display:flex;gap:8px;}
        .btn-cancel{padding:8px 18px;border-radius:50px;border:1px solid var(--border);background:transparent;color:var(--muted);cursor:pointer;font-size:13px;font-family:'DM Sans',sans-serif;transition:all 0.2s;}
        .btn-cancel:hover{color:var(--text);}
        .btn-save{padding:8px 20px;border-radius:50px;border:none;background:linear-gradient(135deg,var(--accent),#ff8e53);color:white;cursor:pointer;font-size:13px;font-weight:600;font-family:'DM Sans',sans-serif;transition:opacity 0.2s,transform 0.15s;}
        .btn-save:hover{opacity:0.9;transform:translateY(-1px);}

        /* NOTES GRID */
        .section-label{font-size:11px;text-transform:uppercase;letter-spacing:2px;color:var(--muted);margin-bottom:14px;}
        .notes-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;}
        @media(max-width:500px){.notes-grid{grid-template-columns:1fr;}}

        /* NOTE CARD */
        .note-card{border-radius:var(--radius);padding:20px;position:relative;border:1px solid var(--border);cursor:pointer;transition:transform 0.2s,box-shadow 0.2s;animation:fadeUp 0.3s ease both;overflow:hidden;}
        .note-card:hover{transform:translateY(-4px);box-shadow:0 16px 40px rgba(0,0,0,0.3);}
        .note-card.offline-pending{border-color:rgba(255,211,61,0.5);}
        .offline-badge{position:absolute;top:10px;left:10px;font-size:10px;background:rgba(255,211,61,0.2);border:1px solid rgba(255,211,61,0.4);color:#ffd93d;padding:2px 8px;border-radius:50px;}
        @keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
        .note-card-title{font-family:'Syne',sans-serif;font-weight:700;font-size:16px;margin-bottom:8px;word-break:break-word;}
        .note-card-body{font-size:13px;line-height:1.65;color:var(--muted);overflow:hidden;display:-webkit-box;-webkit-line-clamp:5;-webkit-box-orient:vertical;word-break:break-word;}
        .note-meta{margin-top:14px;display:flex;align-items:center;justify-content:space-between;}
        .note-date{font-size:11px;color:var(--muted);}
        .note-actions{display:flex;gap:6px;opacity:0;transition:opacity 0.2s;}
        .note-card:hover .note-actions{opacity:1;}
        .action-btn{width:28px;height:28px;border-radius:50%;border:1px solid rgba(128,128,128,0.3);background:rgba(0,0,0,0.15);color:var(--text);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;transition:all 0.2s;}
        .action-btn:hover{background:rgba(128,128,128,0.2);}
        .action-btn.danger:hover{background:rgba(255,107,107,0.3);border-color:var(--accent);}
        .action-btn.read:hover{background:rgba(77,150,255,0.3);border-color:#4d96ff;}
        .pin-badge{position:absolute;top:12px;right:12px;font-size:14px;}

        /* MODALS */
        .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.7);backdrop-filter:blur(8px);z-index:200;display:none;align-items:center;justify-content:center;padding:20px;}
        .modal-overlay.open{display:flex;}
        @keyframes modalIn{from{opacity:0;transform:scale(0.95) translateY(10px);}to{opacity:1;transform:scale(1) translateY(0);}}

        .modal{background:var(--surface2);border:1px solid var(--border);border-radius:24px;padding:28px;width:100%;max-width:520px;max-height:90vh;overflow-y:auto;animation:modalIn 0.25s ease;}
        .modal-title-input,.modal-body-input{width:100%;background:rgba(128,128,128,0.1);border:1px solid var(--border);border-radius:12px;color:var(--text);font-family:'DM Sans',sans-serif;outline:none;padding:12px 16px;transition:border-color 0.2s;}
        .modal-title-input:focus,.modal-body-input:focus{border-color:rgba(255,107,107,0.5);}
        .modal-title-input{font-family:'Syne',sans-serif;font-size:17px;font-weight:700;margin-bottom:12px;}
        .modal-body-input{font-size:14px;line-height:1.7;min-height:160px;resize:vertical;}
        .modal-footer{display:flex;align-items:center;justify-content:space-between;margin-top:20px;flex-wrap:wrap;gap:12px;}
        .modal-footer-right{display:flex;gap:8px;}

        .read-modal{background:var(--surface2);border:1px solid var(--border);border-radius:24px;padding:36px;width:100%;max-width:640px;max-height:90vh;overflow-y:auto;animation:modalIn 0.25s ease;}
        .read-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;}
        .read-badge{font-size:12px;color:#4d96ff;letter-spacing:2px;text-transform:uppercase;background:rgba(77,150,255,0.1);border:1px solid rgba(77,150,255,0.3);padding:4px 12px;border-radius:50px;}
        .read-title{font-family:'Syne',sans-serif;font-size:26px;font-weight:800;margin-bottom:20px;line-height:1.3;color:var(--text);}
        .read-body{font-size:15px;line-height:1.9;color:var(--muted);white-space:pre-wrap;word-break:break-word;}
        .read-divider{height:1px;background:var(--border);margin:20px 0;}
        .read-date{font-size:12px;color:var(--muted);}

        .delete-modal{background:var(--surface2);border:1px solid rgba(255,107,107,0.3);border-radius:24px;padding:36px;width:100%;max-width:400px;text-align:center;animation:modalIn 0.25s ease;}
        .delete-icon{font-size:48px;margin-bottom:16px;}
        .delete-title{font-family:'Syne',sans-serif;font-weight:800;font-size:22px;margin-bottom:10px;color:var(--text);}
        .delete-desc{font-size:14px;color:var(--muted);margin-bottom:28px;line-height:1.6;}
        .delete-actions{display:flex;gap:12px;justify-content:center;}
        .btn-confirm-delete{padding:12px 28px;border-radius:50px;border:none;background:linear-gradient(135deg,#ff6b6b,#ff4444);color:white;font-size:14px;font-weight:600;font-family:'DM Sans',sans-serif;cursor:pointer;transition:all 0.2s;}
        .btn-confirm-delete:hover{opacity:0.9;transform:translateY(-1px);}
        .btn-keep{padding:12px 28px;border-radius:50px;border:1px solid var(--border);background:transparent;color:var(--muted);font-size:14px;font-family:'DM Sans',sans-serif;cursor:pointer;transition:all 0.2s;}
        .btn-keep:hover{color:var(--text);}

        /* EMPTY */
        .empty{text-align:center;padding:80px 20px;color:var(--muted);}
        .empty-icon{font-size:56px;margin-bottom:16px;}
        .empty h3{font-family:'Syne',sans-serif;font-size:20px;margin-bottom:8px;color:var(--text);}
        .empty p{font-size:14px;}

        /* FAB */
        .fab{position:fixed;bottom:28px;right:28px;width:58px;height:58px;border-radius:50%;background:linear-gradient(135deg,var(--accent),#ff8e53);border:none;color:white;font-size:28px;cursor:pointer;box-shadow:0 8px 24px rgba(255,107,107,0.5);display:none;align-items:center;justify-content:center;transition:transform 0.2s;z-index:50;}
        .fab:hover{transform:scale(1.1);}
        @media(max-width:640px){.fab{display:flex;}}

        #installBtn{display:none;padding:6px 14px;border-radius:50px;border:none;background:linear-gradient(135deg,#ff6b6b,#ff8e53);color:white;font-size:13px;font-weight:600;font-family:'DM Sans',sans-serif;cursor:pointer;box-shadow:0 4px 14px rgba(255,107,107,0.4);transition:all 0.2s;}#installBtn:hover{opacity:0.9;transform:translateY(-1px);}

        .toast{position:fixed;bottom:90px;left:50%;transform:translateX(-50%) translateY(20px);background:var(--surface2);border:1px solid var(--border);border-radius:50px;padding:10px 22px;font-size:13px;opacity:0;transition:all 0.3s;pointer-events:none;z-index:300;}
        .toast.show{opacity:1;transform:translateX(-50%) translateY(0);}
    </style>
</head>
<body>

<div class="offline-banner" id="offlineBanner">📡 You're offline — notes saved locally and will sync when back online</div>
<div class="sync-banner" id="syncBanner">✓ Back online! Syncing your notes…</div>

<nav>
    <div class="nav-left">
        <span class="nav-logo">✦ Noteva</span>
        <button class="theme-btn" id="themeBtn" onclick="toggleTheme()">☀️ Light</button>
    </div>
    <div class="nav-right">
        <span class="nav-user">{{ auth()->user()->name }}</span>
        <button id="installBtn" onclick="triggerInstall()">📲 Install</button>
        <a href="{{ route('dashboard') }}" class="btn-nav">🏠 Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-nav">Sign out</button>
        </form>
    </div>
</nav>

<main>
    <div class="page-header">
        <h1 class="page-title">My Notes</h1>
        <span class="note-count" id="noteCount">{{ $notes->count() }} notes</span>
    </div>

    <div class="search-wrap">
        <span class="search-icon">🔍</span>
        <input type="text" id="search" placeholder="Search notes…" autocomplete="off">
    </div>

    <div class="add-card" id="addCard">
        <div class="add-card-collapsed" id="addCollapsed"><span>📝</span><span>Take a note…</span></div>
        <div class="add-card-expanded" id="addExpanded">
            <input class="add-title-input" id="newTitle" placeholder="Title" autocomplete="off">
            <textarea class="add-body-input" id="newBody" placeholder="Write your note here…"></textarea>
            <div class="add-footer">
                <div class="color-picks" id="addColorPicks"></div>
                <div class="add-actions">
                    <button class="btn-cancel" type="button" onclick="closeAddCard()">Close</button>
                    <button class="btn-save" type="button" onclick="saveNote()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="notesContainer">
        @php $pinned = $notes->where('pinned', true); $others = $notes->where('pinned', false); @endphp
        @if($pinned->count())
        <p class="section-label">📌 Pinned</p>
        <div class="notes-grid" id="pinnedGrid">
            @foreach($pinned as $note) @include('notes._card', ['note' => $note]) @endforeach
        </div><br>
        @endif
        @if($others->count())
        <p class="section-label">🗒 Others</p>
        <div class="notes-grid" id="othersGrid">
            @foreach($others as $note) @include('notes._card', ['note' => $note]) @endforeach
        </div>
        @endif
        @if($notes->isEmpty())
        <div class="empty" id="emptyState">
            <div class="empty-icon">🌙</div>
            <h3>No notes yet</h3>
            <p>Click <strong>Take a note</strong> above to start writing.</p>
        </div>
        @endif
    </div>
</main>

{{-- READ MODAL --}}
<div class="modal-overlay" id="readModal">
    <div class="read-modal">
        <div class="read-header">
            <span class="read-badge">👁 Reading</span>
            <button class="btn-cancel" type="button" onclick="closeReadModal()">✕ Close</button>
        </div>
        <div class="read-title" id="readTitle"></div>
        <div class="read-divider"></div>
        <div class="read-body" id="readBody"></div>
        <div class="read-divider"></div>
        <div class="read-date" id="readDate"></div>
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <input class="modal-title-input" id="editTitle" placeholder="Title">
        <textarea class="modal-body-input" id="editBody" placeholder="Write your note…"></textarea>
        <div class="modal-footer">
            <div class="color-picks" id="editColorPicks"></div>
            <div class="modal-footer-right">
                <button class="btn-cancel" type="button" onclick="closeModal()">Cancel</button>
                <button class="btn-save" type="button" onclick="updateNote()">Update</button>
            </div>
        </div>
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="modal-overlay" id="deleteModal">
    <div class="delete-modal">
        <div class="delete-icon">🗑️</div>
        <div class="delete-title">Delete Note?</div>
        <div class="delete-desc">This note will be permanently deleted.<br>This action cannot be undone.</div>
        <div class="delete-actions">
            <button class="btn-keep" type="button" onclick="closeDeleteModal()">Keep it</button>
            <button class="btn-confirm-delete" type="button" onclick="confirmDelete()">Yes, Delete</button>
        </div>
    </div>
</div>

<button class="fab" type="button" onclick="openAddCard();window.scrollTo({top:0,behavior:'smooth'})">+</button>

<div class="toast" id="toast"></div>

<script>
const CSRF   = document.querySelector('meta[name="csrf-token"]').content;
const USER_ID = {{ auth()->id() }};
const DARK_COLORS  = ['#1a1827','#3d2b2b','#2b3d2b','#2b2b3d','#3d3d2b','#4d2525','#25334d','#254d3a','#4d3d25'];
const LIGHT_COLORS = ['#ffffff','#ffd6d6','#d6f5d6','#d6e8ff','#fffbcc','#ffe0e0','#dce8ff','#d6f0ea','#fff3dc'];
const COLOR_LABELS = ['Default','Red','Green','Blue','Yellow','Dark Red','Navy','Teal','Amber'];

let currentEditId   = null;
let pendingDeleteId = null;
let selectedAddColor  = DARK_COLORS[0];
let selectedEditColor = DARK_COLORS[0];
let isLight = false;
let isOnline = navigator.onLine;
let allNotes = [];

// ── IndexedDB ──────────────────────────────────────────
const DB_NAME = 'noteva_db';
const DB_VER  = 1;
let db;

function openDB() {
    return new Promise((res, rej) => {
        const req = indexedDB.open(DB_NAME, DB_VER);
        req.onupgradeneeded = e => {
            const d = e.target.result;
            if (!d.objectStoreNames.contains('notes')) {
                d.createObjectStore('notes', { keyPath: 'local_id', autoIncrement: true });
            }
            if (!d.objectStoreNames.contains('queue')) {
                d.createObjectStore('queue', { keyPath: 'id', autoIncrement: true });
            }
        };
        req.onsuccess = e => { db = e.target.result; res(db); };
        req.onerror   = () => rej(req.error);
    });
}

function dbAll(store) {
    return new Promise((res, rej) => {
        const tx  = db.transaction(store, 'readonly');
        const req = tx.objectStore(store).getAll();
        req.onsuccess = () => res(req.result);
        req.onerror   = () => rej(req.error);
    });
}

function dbPut(store, obj) {
    return new Promise((res, rej) => {
        const tx  = db.transaction(store, 'readwrite');
        const req = tx.objectStore(store).put(obj);
        req.onsuccess = () => res(req.result);
        req.onerror   = () => rej(req.error);
    });
}

function dbDelete(store, key) {
    return new Promise((res, rej) => {
        const tx  = db.transaction(store, 'readwrite');
        const req = tx.objectStore(store).delete(key);
        req.onsuccess = () => res();
        req.onerror   = () => rej(req.error);
    });
}

function dbClear(store) {
    return new Promise((res, rej) => {
        const tx  = db.transaction(store, 'readwrite');
        const req = tx.objectStore(store).clear();
        req.onsuccess = () => res();
        req.onerror   = () => rej(req.error);
    });
}

// ── Load notes ────────────────────────────────────────
async function loadNotes() {
    if (isOnline) {
        try {
            const res   = await fetch('/notes', { headers: { 'Accept': 'application/json' } });
            const data  = await res.json();
            allNotes    = data;
            // Cache in IndexedDB
            await dbClear('notes');
            for (const n of data) await dbPut('notes', { ...n, local_id: n.id });
        } catch {
            allNotes = await dbAll('notes');
        }
    } else {
        allNotes = await dbAll('notes');
    }
    renderNotes();
}

// ── Render ────────────────────────────────────────────
function renderNotes() {
    const container = document.getElementById('notesContainer');
    const pinned    = allNotes.filter(n => n.pinned);
    const others    = allNotes.filter(n => !n.pinned);
    let html = '';

    if (pinned.length) {
        html += `<p class="section-label">📌 Pinned</p><div class="notes-grid" id="pinnedGrid">`;
        pinned.forEach(n => { html += buildCardHTML(n); });
        html += `</div><br>`;
    }
    if (others.length) {
        html += `<p class="section-label">🗒 Others</p><div class="notes-grid" id="othersGrid">`;
        others.forEach(n => { html += buildCardHTML(n); });
        html += `</div>`;
    }
    if (!allNotes.length) {
        html = `<div class="empty" id="emptyState"><div class="empty-icon">🌙</div><h3>No notes yet</h3><p>Click <strong>Take a note</strong> above to start writing.</p></div>`;
    }
    container.innerHTML = html;
    document.getElementById('noteCount').textContent = `${allNotes.length} note${allNotes.length===1?'':'s'}`;
}

function buildCardHTML(note) {
    const d       = note.updated_at ? new Date(note.updated_at).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'}) : 'Just now';
    const pending = note._pending ? '<span class="offline-badge">⏳ Pending sync</span>' : '';
    const pinIcon = note.pinned ? '<span class="pin-badge">📌</span>' : '';
    return `<div class="note-card${note._pending?' offline-pending':''}" data-id="${note.id||note.local_id}" style="background:${note.color||'#1a1827'}"
        onclick="openModal(${JSON.stringify(note.id||null)},${JSON.stringify(note.local_id||null)},'${esc(note.title||'')}','${esc(note.body||'')}','${note.color||'#1a1827'}',${note.pinned?'true':'false'})">
        ${pinIcon}${pending}
        <div class="note-card-title">${esc2(note.title||'(no title)')}</div>
        <div class="note-card-body">${esc2(note.body||'')}</div>
        <div class="note-meta">
            <span class="note-date">${d}</span>
            <div class="note-actions">
                <button class="action-btn read" title="Read" onclick="openReadModal('${esc(note.title||'')}','${esc(note.body||'')}','${d}',event)">👁</button>
                <button class="action-btn" title="${note.pinned?'Unpin':'Pin'}" onclick="togglePin(${JSON.stringify(note.id||null)},${JSON.stringify(note.local_id||null)},${note.pinned?'true':'false'},event)">${note.pinned?'📍':'📌'}</button>
                <button class="action-btn danger" title="Delete" onclick="askDelete(${JSON.stringify(note.id||null)},${JSON.stringify(note.local_id||null)},event)">🗑</button>
            </div>
        </div></div>`;
}

// ── Save Note ─────────────────────────────────────────
async function saveNote() {
    const title = document.getElementById('newTitle').value.trim();
    const body  = document.getElementById('newBody').value.trim();
    if (!title && !body) { showToast('Write something first!'); return; }

    const note = { title, body, color: selectedAddColor, pinned: false, updated_at: new Date().toISOString(), _pending: !isOnline };

    if (isOnline) {
        try {
            const res  = await fetch('/notes', {
                method: 'POST',
                headers: { 'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json' },
                body: JSON.stringify({ title, body, color: selectedAddColor })
            });
            const saved = await res.json();
            allNotes.unshift(saved);
            await dbPut('notes', { ...saved, local_id: saved.id });
        } catch {
            await saveOffline(note);
        }
    } else {
        await saveOffline(note);
    }
    closeAddCard();
    renderNotes();
    showToast(isOnline ? 'Note saved ✓' : 'Saved offline ✓');
}

async function saveOffline(note) {
    const local_id = await dbPut('notes', note);
    note.local_id  = local_id;
    allNotes.unshift(note);
    await dbPut('queue', { action: 'create', data: note, local_id });
}

// ── Update Note ───────────────────────────────────────
async function updateNote() {
    const title    = document.getElementById('editTitle').value.trim();
    const body     = document.getElementById('editBody').value.trim();
    const serverId = currentEditId?.server;
    const localId  = currentEditId?.local;

    if (isOnline && serverId) {
        try {
            const res  = await fetch(`/notes/${serverId}`, {
                method: 'PATCH',
                headers: { 'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json' },
                body: JSON.stringify({ title, body, color: selectedEditColor })
            });
            const updated = await res.json();
            const idx = allNotes.findIndex(n => n.id === serverId);
            if (idx > -1) allNotes[idx] = { ...allNotes[idx], ...updated };
            await dbPut('notes', { ...updated, local_id: updated.id });
        } catch {
            updateOffline(serverId, localId, title, body);
        }
    } else {
        updateOffline(serverId, localId, title, body);
    }
    closeModal();
    renderNotes();
    showToast(isOnline ? 'Note updated ✓' : 'Updated offline ✓');
}

async function updateOffline(serverId, localId, title, body) {
    const idx = allNotes.findIndex(n => (serverId && n.id===serverId)||(localId && n.local_id===localId));
    if (idx > -1) {
        allNotes[idx] = { ...allNotes[idx], title, body, color: selectedEditColor, _pending: true, updated_at: new Date().toISOString() };
        await dbPut('notes', { ...allNotes[idx] });
        await dbPut('queue', { action:'update', server_id: serverId, local_id: localId, data: { title, body, color: selectedEditColor } });
    }
}

// ── Delete Note ───────────────────────────────────────
function askDelete(serverId, localId, e) {
    e.stopPropagation();
    pendingDeleteId = { server: serverId, local: localId };
    document.getElementById('deleteModal').classList.add('open');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
    pendingDeleteId = null;
}
async function confirmDelete() {
    if (!pendingDeleteId) return;
    const { server: serverId, local: localId } = pendingDeleteId;
    closeDeleteModal();

    if (isOnline && serverId) {
        try {
            await fetch(`/notes/${serverId}`, { method:'DELETE', headers:{'X-CSRF-TOKEN':CSRF,'Accept':'application/json'} });
            await dbDelete('notes', serverId);
        } catch {
            await dbPut('queue', { action:'delete', server_id: serverId, local_id: localId });
        }
    } else {
        await dbPut('queue', { action:'delete', server_id: serverId, local_id: localId });
        if (localId) await dbDelete('notes', localId);
    }
    allNotes = allNotes.filter(n => !(n.id===serverId || n.local_id===localId));
    renderNotes();
    showToast('Note deleted');
}

// ── Sync Queue ────────────────────────────────────────
async function syncQueue() {
    const queue = await dbAll('queue');
    if (!queue.length) return;
    let synced = 0;
    for (const item of queue) {
        try {
            if (item.action === 'create') {
                const res  = await fetch('/notes', {
                    method:'POST',
                    headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
                    body: JSON.stringify(item.data)
                });
                const saved = await res.json();
                await dbDelete('notes', item.local_id);
                await dbPut('notes', { ...saved, local_id: saved.id });
                const idx = allNotes.findIndex(n => n.local_id === item.local_id);
                if (idx > -1) allNotes[idx] = { ...saved };
            } else if (item.action === 'update' && item.server_id) {
                await fetch(`/notes/${item.server_id}`, {
                    method:'PATCH',
                    headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
                    body: JSON.stringify(item.data)
                });
                const idx = allNotes.findIndex(n => n.id===item.server_id);
                if (idx > -1) { allNotes[idx] = { ...allNotes[idx], ...item.data, _pending: false }; }
            } else if (item.action === 'delete' && item.server_id) {
                await fetch(`/notes/${item.server_id}`, { method:'DELETE', headers:{'X-CSRF-TOKEN':CSRF,'Accept':'application/json'} });
            }
            await dbDelete('queue', item.id);
            synced++;
        } catch {}
    }
    if (synced) { renderNotes(); showToast(`✓ Synced ${synced} note${synced>1?'s':''}!`); }
}

// ── Pin ───────────────────────────────────────────────
async function togglePin(serverId, localId, current, e) {
    e.stopPropagation();
    const idx = allNotes.findIndex(n => (serverId && n.id===serverId)||(localId && n.local_id===localId));
    if (idx > -1) allNotes[idx].pinned = !current;
    if (isOnline && serverId) {
        await fetch(`/notes/${serverId}`, {
            method:'PATCH',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
            body: JSON.stringify({ pinned: !current })
        }).catch(()=>{});
    }
    renderNotes();
    showToast(current ? 'Unpinned' : 'Pinned 📌');
}

// ── Read Modal ────────────────────────────────────────
function openReadModal(title, body, date, e) {
    e.stopPropagation();
    document.getElementById('readTitle').textContent = title || '(no title)';
    document.getElementById('readBody').textContent  = body  || '(empty note)';
    document.getElementById('readDate').textContent  = date  ? 'Last updated: ' + date : '';
    document.getElementById('readModal').classList.add('open');
}
function closeReadModal() { document.getElementById('readModal').classList.remove('open'); }
document.getElementById('readModal').addEventListener('click', e => { if(e.target===document.getElementById('readModal')) closeReadModal(); });

// ── Edit Modal ────────────────────────────────────────
function openModal(serverId, localId, title, body, color, pinned) {
    currentEditId = { server: serverId, local: localId };
    selectedEditColor = color;
    document.getElementById('editTitle').value = title;
    document.getElementById('editBody').value  = body;
    buildSwatches('editColorPicks', c => selectedEditColor = c, color);
    document.getElementById('editModal').classList.add('open');
    setTimeout(() => document.getElementById('editTitle').focus(), 50);
}
function closeModal() { document.getElementById('editModal').classList.remove('open'); currentEditId = null; }
document.getElementById('editModal').addEventListener('click', e => { if(e.target===document.getElementById('editModal')) closeModal(); });

// ── Theme ─────────────────────────────────────────────
function getColors() { return isLight ? LIGHT_COLORS : DARK_COLORS; }
function toggleTheme() {
    isLight = !isLight;
    document.body.classList.toggle('light', isLight);
    document.getElementById('themeBtn').textContent = isLight ? '🌙 Dark' : '☀️ Light';
    localStorage.setItem('theme', isLight ? 'light' : 'dark');
    selectedAddColor = selectedEditColor = getColors()[0];
    buildSwatches('addColorPicks', c => selectedAddColor = c, selectedAddColor);
    buildSwatches('editColorPicks', c => selectedEditColor = c, selectedEditColor);
}
(function(){
    if (localStorage.getItem('theme') === 'light') {
        isLight = true;
        document.body.classList.add('light');
        document.getElementById('themeBtn').textContent = '🌙 Dark';
        selectedAddColor = LIGHT_COLORS[0];
    }
})();

// ── Swatches ──────────────────────────────────────────
function buildSwatches(containerId, onSelect, current) {
    const c = document.getElementById(containerId);
    c.innerHTML = '';
    getColors().forEach((col, i) => {
        const s = document.createElement('div');
        s.className = 'color-swatch' + (col===current?' selected':'');
        s.style.cssText = `background:${col};border-color:${col===current?'rgba(128,128,128,0.6)':'transparent'}`;
        s.title = COLOR_LABELS[i];
        s.onclick = () => {
            c.querySelectorAll('.color-swatch').forEach(x => { x.classList.remove('selected'); x.style.borderColor='transparent'; });
            s.classList.add('selected'); s.style.borderColor='rgba(128,128,128,0.6)';
            onSelect(col);
        };
        c.appendChild(s);
    });
}
buildSwatches('addColorPicks',  c => selectedAddColor  = c, selectedAddColor);
buildSwatches('editColorPicks', c => selectedEditColor = c, selectedEditColor);

// ── Add Card ──────────────────────────────────────────
document.getElementById('addCollapsed').addEventListener('click', openAddCard);
function openAddCard() {
    document.getElementById('addCard').classList.add('open');
    setTimeout(() => document.getElementById('newTitle').focus(), 50);
}
function closeAddCard() {
    document.getElementById('addCard').classList.remove('open');
    document.getElementById('newTitle').value = '';
    document.getElementById('newBody').value  = '';
    selectedAddColor = getColors()[0];
    buildSwatches('addColorPicks', c => selectedAddColor = c, selectedAddColor);
}

// ── Search ────────────────────────────────────────────
document.getElementById('search').addEventListener('input', function(){
    const q = this.value.toLowerCase();
    document.querySelectorAll('.note-card').forEach(card => {
        const t = card.querySelector('.note-card-title')?.textContent.toLowerCase()||'';
        const b = card.querySelector('.note-card-body')?.textContent.toLowerCase()||'';
        card.style.display = (t+b).includes(q)?'':'none';
    });
});

// ── Toast ─────────────────────────────────────────────
function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg; t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2500);
}

// ── Helpers ───────────────────────────────────────────
function esc(s){ return String(s).replace(/\\/g,'\\\\').replace(/'/g,"\\'").replace(/\n/g,'\\n'); }
function esc2(s){ return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

// ── Online / Offline events ───────────────────────────
window.addEventListener('offline', () => {
    isOnline = false;
    document.getElementById('offlineBanner').classList.add('show');
    document.getElementById('syncBanner').classList.remove('show');
});
window.addEventListener('online', async () => {
    isOnline = true;
    document.getElementById('offlineBanner').classList.remove('show');
    document.getElementById('syncBanner').classList.add('show');
    await syncQueue();
    await loadNotes();
    setTimeout(() => document.getElementById('syncBanner').classList.remove('show'), 3000);
});

// ── Keyboard ──────────────────────────────────────────
document.addEventListener('keydown', e => {
    if (e.key==='Escape'){ closeModal(); closeAddCard(); closeReadModal(); closeDeleteModal(); }
});

// ── PWA Install ───────────────────────────────────────
let deferredPrompt;
const installBtn = document.getElementById('installBtn');

window.addEventListener('beforeinstallprompt', e => {
    e.preventDefault();
    deferredPrompt = e;
    installBtn.style.display = 'block';
});

window.addEventListener('appinstalled', () => {
    installBtn.style.display = 'none';
    deferredPrompt = null;
    showToast('✓ App installed successfully!');
});

async function triggerInstall() {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        const r = await deferredPrompt.userChoice;
        if (r.outcome === 'accepted') {
            installBtn.style.display = 'none';
            showToast('✓ App installed!');
        }
        deferredPrompt = null;
    } else {
        showToast('To install: tap 3 dots → Add to Home Screen');
    }
}

// ── Service Worker ────────────────────────────────────
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(()=>{});
    navigator.serviceWorker.register('/service-worker.js').catch(()=>{});
}

// ── Init ──────────────────────────────────────────────
openDB().then(() => {
    if (!isOnline) document.getElementById('offlineBanner').classList.add('show');
    loadNotes();
});
</script>
</body>
</html>