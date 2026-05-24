<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Noteva — Write. Organize. Remember.</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0f0e17">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'DM Sans',sans-serif;background:#0f0e17;color:#fffffe;min-height:100vh;overflow-x:hidden;}
        body::before{content:'';position:fixed;top:-200px;left:-200px;width:600px;height:600px;background:radial-gradient(circle,rgba(255,107,107,0.15) 0%,transparent 70%);pointer-events:none;}
        body::after{content:'';position:fixed;bottom:-150px;right:-150px;width:500px;height:500px;background:radial-gradient(circle,rgba(107,107,255,0.1) 0%,transparent 70%);pointer-events:none;}

        nav{display:flex;align-items:center;justify-content:space-between;padding:20px 32px;position:relative;z-index:10;}
        .logo{font-family:'Syne',sans-serif;font-weight:800;font-size:22px;background:linear-gradient(135deg,#ff6b6b,#ffd93d);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
        .nav-links{display:flex;gap:12px;align-items:center;}
        .btn-login{padding:8px 20px;border-radius:50px;border:1px solid rgba(255,255,255,0.15);background:transparent;color:#a7a9be;text-decoration:none;font-size:14px;transition:all 0.2s;}
        .btn-login:hover{color:#fff;border-color:rgba(255,255,255,0.4);}
        .btn-register{padding:8px 20px;border-radius:50px;border:none;background:linear-gradient(135deg,#ff6b6b,#ff8e53);color:white;text-decoration:none;font-size:14px;font-weight:600;transition:all 0.2s;}
        .btn-register:hover{opacity:0.9;transform:translateY(-1px);}

        /* HERO */
        .hero{display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:80px 24px 60px;position:relative;z-index:1;}
        .hero-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 16px;border-radius:50px;background:rgba(255,107,107,0.1);border:1px solid rgba(255,107,107,0.3);font-size:12px;color:#ff6b6b;margin-bottom:28px;letter-spacing:1px;text-transform:uppercase;}
        .hero h1{font-family:'Syne',sans-serif;font-weight:800;font-size:clamp(36px,8vw,72px);line-height:1.1;margin-bottom:20px;}
        .hero h1 span{background:linear-gradient(135deg,#ff6b6b,#ffd93d);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
        .hero p{font-size:clamp(15px,2vw,18px);color:#a7a9be;max-width:480px;line-height:1.7;margin-bottom:40px;}
        .hero-btns{display:flex;gap:14px;flex-wrap:wrap;justify-content:center;}
        .hero-btn-main{padding:14px 32px;border-radius:50px;border:none;background:linear-gradient(135deg,#ff6b6b,#ff8e53);color:white;font-size:16px;font-weight:600;font-family:'DM Sans',sans-serif;text-decoration:none;transition:all 0.2s;box-shadow:0 8px 24px rgba(255,107,107,0.4);}
        .hero-btn-main:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(255,107,107,0.5);}
        .hero-btn-sec{padding:14px 32px;border-radius:50px;border:1px solid rgba(255,255,255,0.15);background:transparent;color:#fffffe;font-size:16px;font-family:'DM Sans',sans-serif;text-decoration:none;transition:all 0.2s;}
        .hero-btn-sec:hover{border-color:rgba(255,255,255,0.4);background:rgba(255,255,255,0.05);}

        /* ICON */
        .app-icon{width:120px;height:120px;border-radius:28px;margin:0 auto 40px;box-shadow:0 20px 60px rgba(255,107,107,0.3);animation:float 3s ease-in-out infinite;}
        @keyframes float{0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);}}

        /* FEATURES */
        .features{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;max-width:800px;margin:60px auto 0;padding:0 24px;}
        .feature{background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);border-radius:18px;padding:24px;text-align:center;transition:transform 0.2s,border-color 0.2s;}
        .feature:hover{transform:translateY(-4px);border-color:rgba(255,107,107,0.3);}
        .feature-icon{font-size:32px;margin-bottom:12px;}
        .feature h3{font-family:'Syne',sans-serif;font-size:16px;margin-bottom:8px;}
        .feature p{font-size:13px;color:#a7a9be;line-height:1.6;}

        /* FOOTER */
        footer{text-align:center;padding:40px 24px;color:#a7a9be;font-size:13px;position:relative;z-index:1;}
        footer span{background:linear-gradient(135deg,#ff6b6b,#ffd93d);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;font-weight:700;}

        @media(max-width:480px){
            nav{padding:16px 20px;}
            .hero{padding:60px 20px 40px;}
        }
    </style>
</head>
<body>

<nav>
    <span class="logo">✦ Noteva</span>
    <div class="nav-links">
        @if(Route::has('login'))
            <a href="{{ route('login') }}" class="btn-login">Log in</a>
        @endif
        @if(Route::has('register'))
            <a href="{{ route('register') }}" class="btn-register">Get Started</a>
        @endif
    </div>
</nav>

<div class="hero">
    <div class="hero-badge">✦ Your personal note app</div>

    <img src="/icons/icon-192.png" alt="Noteva" class="app-icon">

    <h1>Write. Organize.<br><span>Remember.</span></h1>
    <p>A beautiful and simple note-taking app. Capture your thoughts, pin what matters, and find everything instantly.</p>

    <div class="hero-btns">
        <a href="{{ route('register') }}" class="hero-btn-main">Get Started Free →</a>
        <a href="{{ route('login') }}" class="hero-btn-sec">Log in</a>
    </div>
</div>

<div class="features">
    <div class="feature">
        <div class="feature-icon">📝</div>
        <h3>Quick Notes</h3>
        <p>Create notes instantly with a beautiful dark interface designed for focus.</p>
    </div>
    <div class="feature">
        <div class="feature-icon">📌</div>
        <h3>Pin & Organize</h3>
        <p>Pin your most important notes to the top so you never lose what matters.</p>
    </div>
    <div class="feature">
        <div class="feature-icon">🔍</div>
        <h3>Instant Search</h3>
        <p>Find any note in seconds with live search — no page reload needed.</p>
    </div>
    <div class="feature">
        <div class="feature-icon">📱</div>
        <h3>Works on Phone</h3>
        <p>Install it on your Android home screen and use it like a real app.</p>
    </div>
</div>

<footer>
    Made with ❤️ — <span>Noteva</span> &copy; {{ date('Y') }}
</footer>

</body>
</html>