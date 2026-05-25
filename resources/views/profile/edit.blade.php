<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Noteva — Profile</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0f0e17">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'DM Sans',sans-serif;background:#0f0e17;color:#fffffe;min-height:100vh;overflow-x:hidden;}
        body::before{content:'';position:fixed;top:-200px;left:-200px;width:600px;height:600px;background:radial-gradient(circle,rgba(255,107,107,0.12) 0%,transparent 70%);pointer-events:none;z-index:0;}
        body::after{content:'';position:fixed;bottom:-150px;right:-150px;width:500px;height:500px;background:radial-gradient(circle,rgba(77,150,255,0.1) 0%,transparent 70%);pointer-events:none;z-index:0;}

        nav{position:sticky;top:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:14px 24px;background:rgba(15,14,23,0.88);backdrop-filter:blur(20px);border-bottom:1px solid rgba(255,255,255,0.07);}
        .nav-logo{font-family:'Syne',sans-serif;font-weight:800;font-size:22px;background:linear-gradient(135deg,#ff6b6b,#ffd93d);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;text-decoration:none;}
        .nav-right{display:flex;gap:10px;align-items:center;}
        .btn-nav{font-size:13px;padding:6px 14px;border-radius:50px;border:1px solid rgba(255,255,255,0.1);background:transparent;color:#a7a9be;cursor:pointer;transition:all 0.2s;text-decoration:none;}
        .btn-nav:hover{border-color:#ff6b6b;color:#ff6b6b;}

        main{position:relative;z-index:1;max-width:600px;margin:0 auto;padding:40px 20px 80px;}

        .page-title{font-family:'Syne',sans-serif;font-weight:800;font-size:28px;margin-bottom:8px;}
        .page-sub{font-size:14px;color:#a7a9be;margin-bottom:32px;}

        .card{background:#1a1827;border:1px solid rgba(255,255,255,0.07);border-radius:20px;padding:28px;margin-bottom:20px;animation:fadeUp 0.4s ease both;}
        .card:nth-child(1){animation-delay:0.1s;}
        .card:nth-child(2){animation-delay:0.2s;}
        .card:nth-child(3){animation-delay:0.3s;}
        @keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}

        .card-title{font-family:'Syne',sans-serif;font-weight:700;font-size:17px;margin-bottom:4px;}
        .card-desc{font-size:13px;color:#a7a9be;margin-bottom:24px;}

        .form-group{margin-bottom:18px;}
        label{display:block;font-size:13px;color:#a7a9be;margin-bottom:6px;}
        input[type=text],input[type=email],input[type=password]{width:100%;padding:12px 16px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:12px;color:#fffffe;font-size:15px;font-family:'DM Sans',sans-serif;outline:none;transition:border-color 0.2s;}
        input:focus{border-color:rgba(255,107,107,0.5);}
        input::placeholder{color:#a7a9be;}

        .btn-save{padding:10px 24px;border-radius:50px;border:none;background:linear-gradient(135deg,#ff6b6b,#ff8e53);color:white;font-size:14px;font-weight:600;font-family:'DM Sans',sans-serif;cursor:pointer;transition:all 0.2s;}
        .btn-save:hover{opacity:0.9;transform:translateY(-1px);}
        .btn-danger{padding:10px 24px;border-radius:50px;border:1px solid rgba(255,107,107,0.4);background:transparent;color:#ff6b6b;font-size:14px;font-weight:600;font-family:'DM Sans',sans-serif;cursor:pointer;transition:all 0.2s;}
        .btn-danger:hover{background:rgba(255,107,107,0.1);}

        .alert-success{background:rgba(107,203,119,0.1);border:1px solid rgba(107,203,119,0.3);border-radius:10px;padding:10px 14px;font-size:13px;color:#6bcb77;margin-bottom:16px;}
        .alert-error{background:rgba(255,107,107,0.1);border:1px solid rgba(255,107,107,0.3);border-radius:10px;padding:10px 14px;font-size:13px;color:#ff6b6b;margin-bottom:16px;}
    </style>
</head>
<body>

<nav>
    <a href="{{ route('notes.index') }}" class="nav-logo">✦ Noteva</a>
    <div class="nav-right">
        <a href="{{ route('dashboard') }}" class="btn-nav">🏠 Dashboard</a>
        <a href="{{ route('notes.index') }}" class="btn-nav">📝 Notes</a>
    </div>
</nav>

<main>
    <h1 class="page-title">Profile Settings</h1>
    <p class="page-sub">Manage your account information and security.</p>

    {{-- PERSONAL INFO --}}
    <div class="card">
        <div class="card-title">Personal Info</div>
        <div class="card-desc">Update your name and email address.</div>

        @if(session('status') === 'profile-updated')
        <div class="alert-success">✓ Profile updated successfully!</div>
        @endif
        @if($errors->get('name') || $errors->get('email'))
        <div class="alert-error">{{ $errors->first('name') ?? $errors->first('email') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('patch')
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <button type="submit" class="btn-save">Save Changes</button>
        </form>
    </div>

    {{-- CHANGE PASSWORD --}}
    <div class="card">
        <div class="card-title">Change Password</div>
        <div class="card-desc">Use a strong password to keep your account secure.</div>

        @if(session('status') === 'password-updated')
        <div class="alert-success">✓ Password updated successfully!</div>
        @endif
        @if($errors->get('current_password') || $errors->get('password'))
        <div class="alert-error">{{ $errors->first('current_password') ?? $errors->first('password') }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf @method('put')
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" placeholder="••••••••">
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" placeholder="••••••••">
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" placeholder="••••••••">
            </div>
            <button type="submit" class="btn-save">Update Password</button>
        </form>
    </div>

    {{-- DELETE ACCOUNT --}}
    <div class="card">
        <div class="card-title">Delete Account</div>
        <div class="card-desc">Permanently delete your account and all your notes. This cannot be undone.</div>

        @if($errors->get('password'))
        <div class="alert-error">{{ $errors->first('password') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure? This will permanently delete your account and all notes!')">
            @csrf @method('delete')
            <div class="form-group">
                <label>Enter your password to confirm</label>
                <input type="password" name="password" placeholder="••••••••">
            </div>
            <button type="submit" class="btn-danger">🗑 Delete My Account</button>
        </form>
    </div>
</main>

</body>
</html>