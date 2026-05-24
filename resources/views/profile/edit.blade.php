<x-app-layout>
    <main class="profile-main">
        <div class="profile-wrapper">

            <div class="profile-page-title">
                <h1>Profile Settings</h1>
                <p>Manage your account information and security.</p>
            </div>

            <div class="profile-sections">

                {{-- PROFILE INFO --}}
                <div class="profile-box">
                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- UPDATE PASSWORD --}}
                <div class="profile-box">
                    @include('profile.partials.update-password-form')
                </div>

                {{-- DELETE ACCOUNT --}}
                <div class="profile-box danger-box">
                    @include('profile.partials.delete-user-form')
                </div>

            </div>

        </div>
    </main>

    <style>
    body{
        background:
            radial-gradient(circle at top left, rgba(255,153,0,0.08), transparent 30%),
            radial-gradient(circle at bottom right, rgba(99,102,241,0.08), transparent 30%),
            #f5f5f7;
    }

    .profile-main{
        min-height:100vh;
        padding:50px 20px 80px;
    }

    .profile-wrapper{
        max-width:1100px;
        margin:auto;
    }

    .profile-page-title{
        text-align:center;
        margin-bottom:40px;
    }

    .profile-page-title h1{
        font-size:48px;
        font-weight:800;
        color:#2d1b69;
        margin-bottom:10px;
        letter-spacing:-2px;
    }

    .profile-page-title p{
        font-size:16px;
        color:#6b7280;
    }

    .profile-sections{
        display:flex;
        flex-direction:column;
        gap:30px;
    }

    .profile-box{
        background:rgba(255,255,255,0.75);
        backdrop-filter:blur(18px);
        border:1px solid rgba(255,255,255,0.4);
        border-radius:32px;
        padding:34px;
        box-shadow:
            0 10px 40px rgba(0,0,0,0.06),
            inset 0 1px 0 rgba(255,255,255,0.6);
        transition:all 0.25s ease;
        position:relative;
        overflow:hidden;
    }

    .profile-box:hover{
        transform:translateY(-3px);
        box-shadow:
            0 16px 50px rgba(0,0,0,0.08),
            inset 0 1px 0 rgba(255,255,255,0.6);
    }

    .profile-box::before{
        content:'';
        position:absolute;
        top:-100px;
        right:-100px;
        width:220px;
        height:220px;
        background:radial-gradient(circle,
            rgba(255,153,0,0.12) 0%,
            transparent 70%);
        pointer-events:none;
    }

    .danger-box::before{
        background:radial-gradient(circle,
            rgba(255,0,0,0.08) 0%,
            transparent 70%);
    }

    @media (max-width:768px){

        .profile-main{
            padding:30px 14px 60px;
        }

        .profile-page-title h1{
            font-size:34px;
        }

        .profile-page-title p{
            font-size:14px;
        }

        .profile-box{
            padding:22px;
            border-radius:24px;
        }
    }
    </style>
</x-app-layout>