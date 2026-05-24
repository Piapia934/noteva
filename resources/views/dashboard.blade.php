<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Noteva — Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:#0f0e17;--surface:#1a1827;--surface2:#221f33;
            --accent:#ff6b6b;--accent2:#ffd93d;--accent3:#6bcb77;--accent4:#4d96ff;
            --text:#fffffe;--muted:#a7a9be;--border:rgba(255,255,255,0.07);--radius:18px;
        }
        body.light {
            --bg:#f5f4f0;--surface:#ffffff;--surface2:#eeedf4;
            --text:#0f0e17;--muted:#6e6d7a;--border:rgba(0,0,0,0.09);
        }
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;overflow-x:hidden;transition:background 0.3s,color 0.3s;}
        body::before{content:'';position:fixed;top:-200px;left:-200px;width:600px;height:600px;background:radial-gradient(circle,rgba(255,107,107,0.12) 0%,transparent 70%);pointer-events:none;z-index:0;}
        body::after{content:'';position:fixed;bottom:-150px;right:-150px;width:500px;height:500px;background:radial-gradient(circle,rgba(77,150,255,0.1) 0%,transparent 70%);pointer-events:none;z-index:0;}

        /* NAV */
        nav{position:sticky;top:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:14px 24px;background:rgba(15,14,23,0.88);backdrop-filter:blur(20px);border-bottom:1px solid var(--border);transition:background 0.3s;}
        body.light nav{background:rgba(245,244,240,0.9);}
        .nav-left{display:flex;align-items:center;gap:14px;}
        .nav-logo{font-family:'Syne',sans-serif;font-weight:800;font-size:22px;background:linear-gradient(135deg,var(--accent),var(--accent2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;text-decoration:none;}
        .theme-btn{background:var(--surface);border:1px solid var(--border);color:var(--text);border-radius:50px;padding:6px 14px;cursor:pointer;font-size:13px;font-family:'DM Sans',sans-serif;transition:all 0.2s;}
        .theme-btn:hover{border-color:var(--accent);}
        .nav-right{display:flex;align-items:center;gap:10px;}
        .nav-user{font-size:13px;color:var(--muted);}
        .btn-nav{font-size:13px;padding:6px 14px;border-radius:50px;border:1px solid var(--border);background:transparent;color:var(--muted);cursor:pointer;transition:all 0.2s;text-decoration:none;}
        .btn-nav:hover{border-color:var(--accent);color:var(--accent);}

        /* MAIN */
        main{position:relative;z-index:1;max-width:900px;margin:0 auto;padding:48px 20px 80px;}

        /* WELCOME */
        .welcome-section{text-align:center;margin-bottom:56px;animation:fadeUp 0.5s ease both;}
        .welcome-greeting{font-size:14px;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;}
        .welcome-name{font-family:'Syne',sans-serif;font-weight:800;font-size:clamp(32px,7vw,56px);margin-bottom:16px;background:linear-gradient(135deg,var(--text) 0%,var(--muted) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
        .welcome-sub{font-size:15px;color:var(--muted);max-width:400px;margin:0 auto;}

        /* CARDS GRID */
        .cards-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px;margin-bottom:40px;}

        .dash-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:28px;cursor:pointer;text-decoration:none;display:block;transition:transform 0.2s,box-shadow 0.2s,border-color 0.2s;animation:fadeUp 0.5s ease both;position:relative;overflow:hidden;}
        .dash-card::before{content:'';position:absolute;inset:0;opacity:0;transition:opacity 0.3s;}
        .dash-card:hover{transform:translateY(-5px);box-shadow:0 20px 40px rgba(0,0,0,0.3);}
        .dash-card:hover::before{opacity:1;}
        .dash-card:nth-child(1){animation-delay:0.1s;}
        .dash-card:nth-child(2){animation-delay:0.2s;}
        .dash-card:nth-child(3){animation-delay:0.3s;}

        .dash-card.notes:hover{border-color:rgba(255,107,107,0.5);}
        .dash-card.notes::before{background:radial-gradient(circle at top left,rgba(255,107,107,0.08),transparent 70%);}
        .dash-card.profile:hover{border-color:rgba(77,150,255,0.5);}
        .dash-card.profile::before{background:radial-gradient(circle at top left,rgba(77,150,255,0.08),transparent 70%);}
        .dash-card.activity:hover{border-color:rgba(107,203,119,0.5);}
        .dash-card.activity::before{background:radial-gradient(circle at top left,rgba(107,203,119,0.08),transparent 70%);}

        .card-icon{font-size:32px;margin-bottom:16px;}
        .card-title{font-family:'Syne',sans-serif;font-weight:700;font-size:18px;margin-bottom:8px;}
        .card-desc{font-size:13px;color:var(--muted);line-height:1.6;}
        .card-arrow{position:absolute;bottom:24px;right:24px;font-size:18px;color:var(--muted);transition:transform 0.2s,color 0.2s;}
        .dash-card:hover .card-arrow{transform:translate(3px,-3px);}
        .dash-card.notes:hover .card-arrow{color:var(--accent);}
        .dash-card.profile:hover .card-arrow{color:var(--accent4);}
        .dash-card.activity:hover .card-arrow{color:var(--accent3);}

        /* STATS ROW */
        .stats-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:16px;margin-bottom:40px;animation:fadeUp 0.5s ease 0.3s both;}
        .stat-box{background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:20px;text-align:center;}
        .stat-num{font-family:'Syne',sans-serif;font-weight:800;font-size:32px;background:linear-gradient(135deg,var(--accent),var(--accent2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
        .stat-label{font-size:12px;color:var(--muted);margin-top:4px;text-transform:uppercase;letter-spacing:1px;}

        /* SIGN OUT */
        .signout-wrap{text-align:center;animation:fadeUp 0.5s ease 0.4s both;}
        .btn-signout{display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:50px;border:1px solid var(--border);background:transparent;color:var(--muted);cursor:pointer;font-size:13px;font-family:'DM Sans',sans-serif;transition:all 0.2s;}
        .btn-signout:hover{border-color:#ff6b6b;color:#ff6b6b;}

        @keyframes fadeUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
    </style>
</head>
<body>

<nav>
    <div class="nav-left">
        <span class="nav-logo">✦ Noteva</span>
        <button class="theme-btn" id="themeBtn" onclick="toggleTheme()">☀️ Light</button>
    </div>
    <div class="nav-right">
        <span class="nav-user">{{ auth()->user()->name }}</span>
    </div>
</nav>

<main>
    {{-- WELCOME --}}
    <div class="welcome-section">
        <p class="welcome-greeting">Welcome back</p>
        <h1 class="welcome-name">{{ Auth::user()->name }} ✦</h1>
        <p class="welcome-sub">What would you like to do today?</p>
    </div>

    {{-- STATS --}}
    <div class="stats-row">
        <div class="stat-box">
            <div class="stat-num">{{ \App\Models\Note::where('user_id', Auth::id())->count() }}</div>
            <div class="stat-label">Total Notes</div>
        </div>
        <div class="stat-box">
            <div class="stat-num">{{ \App\Models\Note::where('user_id', Auth::id())->where('pinned', true)->count() }}</div>
            <div class="stat-label">Pinned</div>
        </div>
        <div class="stat-box">
            <div class="stat-num">{{ \App\Models\Note::where('user_id', Auth::id())->whereDate('created_at', today())->count() }}</div>
            <div class="stat-label">Today</div>
        </div>
    </div>

    {{-- CARDS --}}
    <div class="cards-grid">
        <a href="{{ route('notes.index') }}" class="dash-card notes">
            <div class="card-icon">📝</div>
            <div class="card-title">My Notes</div>
            <div class="card-desc">Create, edit and organize all your notes in one place.</div>
            <span class="card-arrow">↗</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="dash-card profile">
            <div class="card-icon">👤</div>
            <div class="card-title">Profile</div>
            <div class="card-desc">Update your name, email and password settings.</div>
            <span class="card-arrow">↗</span>
        </a>
        <div class="dash-card activity" style="cursor:default;">
            <div class="card-icon">🕐</div>
            <div class="card-title">Last Active</div>
            <div class="card-desc">{{ now()->format('F j, Y') }}<br>{{ now()->format('g:i A') }}</div>
        </div>
    </div>

    {{-- SIGN OUT --}}
    <div class="signout-wrap">
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-signout">🚪 Sign out</button>
        </form>
    </div>
</main>

<script>
function toggleTheme() {
    const isLight = document.body.classList.toggle('light');
    document.getElementById('themeBtn').textContent = isLight ? '🌙 Dark' : '☀️ Light';
    localStorage.setItem('theme', isLight ? 'light' : 'dark');
}
(function(){
    if (localStorage.getItem('theme') === 'light') {
        document.body.classList.add('light');
        document.getElementById('themeBtn').textContent = '🌙 Dark';
    }
})();
</script>
</body>
</html>