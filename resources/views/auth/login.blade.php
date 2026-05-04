@extends('layouts.guest')

@section('title', 'Login | SI Qurban')

@section('content')
<style>
    body { background: #f0ece4 !important; }
    .auth-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem 1rem; }
    .auth-grid { width: 100%; max-width: 1100px; display: grid; gap: 1.5rem; }
    .bg-hero { background: linear-gradient(145deg, #166534 0%, #15803d 55%, #1a7a42 100%); border-radius: 2rem; padding: 3rem 2.5rem; color: white; position: relative; overflow: hidden; }
    .card-form { background: rgba(255,255,255,0.97); border-radius: 2rem; padding: 2.5rem 2rem; box-shadow: 0 8px 40px rgba(0,0,0,0.09); }
    .input-login { width: 100%; padding: 0.85rem 2.8rem 0.85rem 1rem; border: 1.5px solid #d1fae5; border-radius: 12px; background: #f8fafb; font-size: 0.93rem; color: #1e293b; transition: all 0.2s; outline: none; box-sizing: border-box; font-family: inherit; }
    .input-login:focus { border-color: #15803d; background: #fff; box-shadow: 0 0 0 4px rgba(21,128,61,0.08); }
    .input-login::placeholder { color: #cbd5e1; }
    .pw-wrap { position: relative; }
    .pw-toggle { position: absolute; top: 50%; right: 0.85rem; transform: translateY(-50%); background: none; border: none; padding: 4px; cursor: pointer; color: #94a3b8; display: flex; align-items: center; line-height: 0; transition: color 0.2s; }
    .pw-toggle:hover { color: #15803d; }
    .btn-submit { width: 100%; padding: 0.9rem; background: linear-gradient(135deg, #15803d, #166534); color: #fff; font-weight: 700; font-size: 1rem; border-radius: 12px; border: none; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 15px rgba(21,128,61,0.28); font-family: inherit; }
    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(21,128,61,0.38); }
    .label-f { display: block; font-size: 0.7rem; font-weight: 700; color: #64748b; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 6px; }
    .alert-s { background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 10px; padding: 0.75rem 1rem; color: #166534; font-size: 0.83rem; font-weight: 600; margin-bottom: 1.1rem; }
    .alert-e { background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: 10px; padding: 0.75rem 1rem; color: #dc2626; font-size: 0.83rem; font-weight: 600; margin-bottom: 1.1rem; }
    @media (min-width: 1024px) {
        .auth-grid { grid-template-columns: 1.3fr 0.85fr; }
    }
</style>

<div class="auth-wrap">
    <div class="auth-grid">

        {{-- HERO --}}
        <section class="bg-hero">
            <div style="position:absolute;inset:0;background-image:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23fff\' fill-opacity=\'0.04\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/svg%3E');"></div>
            <div style="position:relative;z-index:10;">
                <span style="display:inline-block;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:999px;padding:5px 16px;font-size:0.68rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;margin-bottom:1.5rem;">✦ Sistem Digital Qurban</span>
                <h1 style="font-size:clamp(1.9rem,4vw,2.9rem);font-weight:800;line-height:1.18;margin-bottom:1rem;">Distribusi <span style="color:#fde68a;">Kurban</span><br>Tertib &amp; Akurat.</h1>
                <p style="color:rgba(240,255,240,.85);font-size:.96rem;line-height:1.75;max-width:420px;margin-bottom:2.5rem;">SI Qurban membantu panitia mengelola distribusi daging kurban dengan sistem verifikasi QR Code yang cepat dan real-time.</p>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:.8rem;">
                    <div style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:14px;padding:1rem;">
                        <div style="font-size:1.4rem;margin-bottom:4px;">📱</div>
                        <div style="font-size:.65rem;color:rgba(200,255,200,.8);font-weight:600;text-transform:uppercase;letter-spacing:.06em;">Scan</div>
                        <div style="font-size:.85rem;font-weight:700;margin-top:2px;">QR Code Instan</div>
                    </div>
                    <div style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:14px;padding:1rem;">
                        <div style="font-size:1.4rem;margin-bottom:4px;">📊</div>
                        <div style="font-size:.65rem;color:rgba(200,255,200,.8);font-weight:600;text-transform:uppercase;letter-spacing:.06em;">Laporan</div>
                        <div style="font-size:.85rem;font-weight:700;margin-top:2px;">Real-time</div>
                    </div>
                    <div style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:14px;padding:1rem;">
                        <div style="font-size:1.4rem;margin-bottom:4px;">🕌</div>
                        <div style="font-size:.65rem;color:rgba(200,255,200,.8);font-weight:600;text-transform:uppercase;letter-spacing:.06em;">Akses</div>
                        <div style="font-size:.85rem;font-weight:700;margin-top:2px;">Multi-Panitia</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- FORM --}}
        <section class="card-form">
            <div style="text-align:center;margin-bottom:1.75rem;">
                <div style="width:56px;height:56px;background:linear-gradient(135deg,#dcfce7,#bbf7d0);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.7rem;margin:0 auto .9rem;box-shadow:0 4px 12px rgba(21,128,61,.14);">🕌</div>
                <h2 style="font-size:1.55rem;font-weight:800;color:#15803d;margin:0 0 4px;">Masuk ke Sistem</h2>
                <p style="font-size:.82rem;color:#94a3b8;font-weight:500;margin:0;">Login menggunakan nama dan password akun Anda.</p>
            </div>

            @if(session('success'))
                <div class="alert-s">✅ {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-e">⚠️ {{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:1.1rem;">
                @csrf

                <div>
                    <label for="name" class="label-f">Nama Lengkap / Username</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="input-login" placeholder="Masukkan nama Anda..." required autofocus>
                </div>

                <div>
                    <label for="password" class="label-f">Password</label>
                    <div class="pw-wrap" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" id="password" name="password" class="input-login" placeholder="••••••••" required>
                        <button type="button" class="pw-toggle" @click="show = !show">
                            <svg x-show="!show" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="show" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit" style="margin-top:.4rem;">Masuk &rarr;</button>
            </form>

            <p style="text-align:center;font-size:.83rem;color:#94a3b8;margin-top:1.5rem;font-weight:500;">
                Belum memiliki akun?
                <a href="{{ route('register') }}" style="color:#15803d;font-weight:700;text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Daftar sebagai panitia</a>
            </p>
        </section>

    </div>
</div>
@endsection
