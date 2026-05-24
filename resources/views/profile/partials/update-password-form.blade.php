<section class="password-card">
    <header class="password-header">
        <div>
            <h2 class="password-title">
                {{ __('Update Password') }}
            </h2>

            <p class="password-subtitle">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </div>

        <div class="password-icon">
            🔒
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="password-form">
        @csrf
        @method('put')

        <div class="input-group">
            <x-input-label
                for="update_password_current_password"
                :value="__('Current Password')"
                class="custom-label"
            />

            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="custom-input"
                autocomplete="current-password"
            />

            <x-input-error
                :messages="$errors->updatePassword->get('current_password')"
                class="mt-2"
            />
        </div>

        <div class="input-group">
            <x-input-label
                for="update_password_password"
                :value="__('New Password')"
                class="custom-label"
            />

            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                class="custom-input"
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->updatePassword->get('password')"
                class="mt-2"
            />
        </div>

        <div class="input-group">
            <x-input-label
                for="update_password_password_confirmation"
                :value="__('Confirm Password')"
                class="custom-label"
            />

            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="custom-input"
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <div class="save-row">
            <x-primary-button class="save-btn">
                {{ __('Update Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="saved-text"
                >
                    {{ __('Password Updated ✓') }}
                </p>
            @endif
        </div>
    </form>
</section>

<style>
.password-card{
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
    margin-top: 28px;
}

.password-card::before{
    content:'';
    position:absolute;
    bottom:-120px;
    left:-120px;
    width:240px;
    height:240px;
    background: radial-gradient(circle,
        rgba(99,102,241,0.18) 0%,
        transparent 70%);
    pointer-events:none;
}

.password-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:32px;
    gap:20px;
}

.password-title{
    font-size:32px;
    font-weight:800;
    color:#2d1b69;
    margin-bottom:10px;
    letter-spacing:-1px;
}

.password-subtitle{
    color:#6b7280;
    font-size:15px;
    line-height:1.6;
}

.password-icon{
    width:70px;
    height:70px;
    border-radius:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:30px;
    background: linear-gradient(135deg,#6366f1,#8b5cf6);
    box-shadow:0 10px 30px rgba(99,102,241,0.25);
}

.password-form{
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
        0 0 0 4px rgba(99,102,241,0.12),
        inset 0 0 0 1px #6366f1 !important;
    transform:translateY(-1px);
}

.save-row{
    display:flex;
    align-items:center;
    gap:14px;
    margin-top:8px;
}

.save-btn{
    background: linear-gradient(135deg,#6366f1,#8b5cf6) !important;
    border:none !important;
    border-radius:50px !important;
    padding:14px 28px !important;
    font-size:14px !important;
    font-weight:700 !important;
    letter-spacing:0.5px;
    box-shadow:0 8px 24px rgba(99,102,241,0.25);
    transition:all 0.25s ease;
}

.save-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 14px 30px rgba(99,102,241,0.35);
}

.saved-text{
    color:#16a34a;
    font-size:14px;
    font-weight:600;
}

@media (max-width:768px){

    .password-card{
        padding:24px;
        border-radius:24px;
    }

    .password-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .password-title{
        font-size:26px;
    }

    .password-icon{
        width:58px;
        height:58px;
        font-size:24px;
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