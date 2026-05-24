<section class="profile-card">
    <header class="profile-header">
        <div>
            <h2 class="profile-title">
                {{ __('Profile Information') }}
            </h2>

            <p class="profile-subtitle">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </div>

        <div class="profile-icon">
            👤
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="profile-form">
        @csrf
        @method('patch')

        <div class="input-group">
            <x-input-label for="name" :value="__('Name')" class="custom-label" />

            <x-text-input
                id="name"
                name="name"
                type="text"
                class="custom-input"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="input-group">
            <x-input-label for="email" :value="__('Email')" class="custom-label" />

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="custom-input"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />

            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="verify-box">
                    <p class="verify-text">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="verify-link">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="verify-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="save-row">
            <x-primary-button class="save-btn">
                {{ __('Save Changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="saved-text"
                >
                    {{ __('Saved ✓') }}
                </p>
            @endif
        </div>
    </form>
</section>

<style>
.profile-card{
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 28px;
    padding: 38px;
    box-shadow:
        0 10px 40px rgba(0,0,0,0.06),
        inset 0 1px 0 rgba(255,255,255,0.4);
    position: relative;
    overflow: hidden;
}

.profile-card::before{
    content:'';
    position:absolute;
    top:-120px;
    right:-120px;
    width:240px;
    height:240px;
    background: radial-gradient(circle,
        rgba(255,153,0,0.18) 0%,
        transparent 70%);
    pointer-events:none;
}

.profile-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:32px;
    gap:20px;
}

.profile-title{
    font-size:32px;
    font-weight:800;
    color:#2d1b69;
    margin-bottom:10px;
    letter-spacing:-1px;
}

.profile-subtitle{
    color:#6b7280;
    font-size:15px;
    line-height:1.6;
}

.profile-icon{
    width:70px;
    height:70px;
    border-radius:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:32px;
    background: linear-gradient(135deg,#ff9a3d,#ff6b6b);
    box-shadow:0 10px 30px rgba(255,107,107,0.25);
}

.profile-form{
    display:flex;
    flex-direction:column;
    gap:24px;
}

.input-group{
    display:flex;
    flex-direction:column;
}

.custom-label{
    margin-bottom:10px;
    font-size:14px;
    font-weight:700;
    color:#2d1b69;
}

.custom-input{
    width:100%;
    border:none !important;
    background:#f8f8fc !important;
    border-radius:18px !important;
    padding:16px 18px !important;
    font-size:15px !important;
    color:#111827 !important;
    transition:all 0.25s ease;
    box-shadow:
        inset 0 0 0 1px rgba(0,0,0,0.05);
}

.custom-input:focus{
    background:white !important;
    box-shadow:
        0 0 0 4px rgba(255,153,0,0.12),
        inset 0 0 0 1px #ff9a3d !important;
    transform:translateY(-1px);
}

.verify-box{
    margin-top:12px;
    padding:14px 16px;
    border-radius:16px;
    background:#fff7ed;
    border:1px solid #fed7aa;
}

.verify-text{
    font-size:14px;
    color:#7c2d12;
    line-height:1.6;
}

.verify-link{
    background:none;
    border:none;
    color:#ea580c;
    font-weight:700;
    cursor:pointer;
    margin-left:4px;
}

.verify-link:hover{
    text-decoration:underline;
}

.verify-success{
    margin-top:10px;
    color:#16a34a;
    font-size:14px;
    font-weight:600;
}

.save-row{
    display:flex;
    align-items:center;
    gap:14px;
    margin-top:8px;
}

.save-btn{
    background: linear-gradient(135deg,#ff9a3d,#ff6b6b) !important;
    border:none !important;
    border-radius:50px !important;
    padding:14px 28px !important;
    font-size:14px !important;
    font-weight:700 !important;
    letter-spacing:0.5px;
    box-shadow:0 8px 24px rgba(255,107,107,0.25);
    transition:all 0.25s ease;
}

.save-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 14px 30px rgba(255,107,107,0.35);
}

.saved-text{
    color:#16a34a;
    font-size:14px;
    font-weight:600;
}

@media (max-width:768px){

    .profile-card{
        padding:24px;
        border-radius:24px;
    }

    .profile-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .profile-title{
        font-size:26px;
    }

    .profile-icon{
        width:58px;
        height:58px;
        font-size:26px;
    }

    .save-btn{
        width:100%;
        justify-content:center;
    }

    .save-row{
        flex-direction:column;
        align-items:stretch;
    }
}
</style>