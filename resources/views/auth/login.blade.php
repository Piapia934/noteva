<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Noteva — Log In</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0f0e17">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'DM Sans',sans-serif;background:#0f0e17;color:#fffffe;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px;overflow-x:hidden;}
        body::before{content:'';position:fixed;top:-200px;left:-200px;width:600px;height:600px;background:radial-gradient(circle,rgba(255,107,107,0.12) 0%,transparent 70%);pointer-events:none;}
        body::after{content:'';position:fixed;bottom:-150px;right:-150px;width:500px;height:500px;background:radial-gradient(circle,rgba(77,150,255,0.1) 0%,transparent 70%);pointer-events:none;}

        .card{background:#1a1827;border:1px solid rgba(255,255,255,0.07);border-radius:24px;padding:40px 36px;width:100%;max-width:420px;position:relative;z-index:1;animation:fadeUp 0.4s ease both;}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}

        .logo{font-family:'Syne',sans-serif;font-weight:800;font-size:22px;background:linear-gradient(135deg,#ff6b6b,#ffd93d);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;text-align:center;margin-bottom:8px;}
        .app-icon{width:72px;height:72px;border-radius:18px;display:block;margin:0 auto 16px;box-shadow:0 8px 24px rgba(255,107,107,0.3);}
        .card-title{font-family:'Syne',sans-serif;font-weight:700;font-size:24px;text-align:center;margin-bottom:6px;}
        .card-sub{font-size:14px;color:#a7a9be;text-align:center;margin-bottom:32px;}

        .form-group{margin-bottom:18px;}
        label{display:block;font-size:13px;color:#a7a9be;margin-bottom:6px;font-weight:500;}
        input{width:100%;padding:12px 16px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:12px;color:#fffffe;font-size:15px;font-family:'DM Sans',sans-serif;outline:none;transition:border-color 0.2s;}
        input:focus{border-color:rgba(255,107,107,0.5);}
        input::placeholder{color:#a7a9be;}

        .remember-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;}
        .remember{display:flex;align-items:center;gap:8px;font-size:13px;color:#a7a9be;cursor:pointer;}
        .remember input[type=checkbox]{width:16px;height:16px;accent-color:#ff6b6b;cursor:pointer;}
        .forgot{font-size:13px;color:#a7a9be;text-decoration:none;transition:color 0.2s;}
        .forgot:hover{color:#ff6b6b;}

        .btn-submit{width:100%;padding:14px;border-radius:50px;border:none;background:linear-gradient(135deg,#ff6b6b,#ff8e53);color:white;font-size:15px;font-weight:600;font-family:'DM Sans',sans-serif;cursor:pointer;transition:all 0.2s;box-shadow:0 8px 24px rgba(255,107,107,0.3);margin-bottom:20px;}
        .btn-submit:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(255,107,107,0.4);}

        .divider{text-align:center;font-size:13px;color:#a7a9be;margin-bottom:20px;position:relative;}
        .divider::before,.divider::after{content:'';position:absolute;top:50%;width:40%;height:1px;background:rgba(255,255,255,0.07);}
        .divider::before{left:0;} .divider::after{right:0;}

        .link-row{text-align:center;font-size:14px;color:#a7a9be;}
        .link-row a{color:#ff6b6b;text-decoration:none;font-weight:600;}
        .link-row a:hover{text-decoration:underline;}

        .error{background:rgba(255,107,107,0.1);border:1px solid rgba(255,107,107,0.3);border-radius:10px;padding:10px 14px;font-size:13px;color:#ff6b6b;margin-bottom:16px;}
    </style>
</head>
<body>
<div class="card">
    <img src="/icons/icon-192.png" alt="Noteva" class="app-icon">
    <div class="logo">✦ Noteva</div>
    <h1 class="card-title">Welcome back</h1>
    <p class="card-sub">Log in to your account to continue</p>

    @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="you@email.com" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>
        <div class="remember-row">
            <label class="remember">
                <input type="checkbox" name="remember"> Remember me
            </label>
            @if(Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot">Forgot password?</a>
            @endif
        </div>
        <button type="submit" class="btn-submit">Log In</button>
    </form>

    <div class="divider">or</div>
    <div class="link-row">Don't have an account? <a href="{{ route('register') }}">Register</a></div>
</div>
</body>
</html>