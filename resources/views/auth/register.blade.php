@extends('layouts.guest')

@section('title', 'Daftar Panitia | SI Qurban')

@section('content')
<style>
    body { background: #f0ece4 !important; }
    .auth-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem 1rem; }
    .auth-grid { width: 100%; max-width: 1100px; display: grid; gap: 1.5rem; }
    .bg-hero { background: linear-gradient(145deg, #166534 0%, #15803d 55%, #1a7a42 100%); border-radius: 2rem; padding: 3rem 2.5rem; color: white; position: relative; overflow: hidden; }
    .card-form { background: rgba(255,255,255,0.97); border-radius: 2rem; padding: 2.5rem 2rem; box-shadow: 0 8px 40px rgba(0,0,0,0.09); }
    .input-reg { width: 100%; padding: 0.8rem 2.8rem 0.8rem 1rem; border: 1.5px solid #d1fae5; border-radius: 12px; background: #f8fafb; font-size: 0.9rem; color: #1e293b; transition: all 0.2s; outline: none; box-sizing: border-box; font-family: inherit; }
    .input-reg:focus { border-color: #15803d; background: #fff; box-shadow: 0 0 0 4px rgba(21,128,61,0.08); }
    .input-reg::placeholder { color: #cbd5e1; }
    .input-reg-plain { padding-right: 1rem; }
    .pw-wrap { position: relative; }
    .pw-toggle { position: absolute; top: 50%; right: 0.85rem; transform: translateY(-50%); background: none; border: none; padding: 4px; cursor: pointer; color: #94a3b8; display: flex; align-items: center; line-height: 0; transition: color 0.2s; }
    .pw-toggle:hover { color: #15803d; }
    .btn-submit { width: 100%; padding: 0.9rem; background: linear-gradient(135deg, #15803d, #166534); color: #fff; font-weight: 700; font-size: 1rem; border-radius: 12px; border: none; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 15px rgba(21,128,61,0.28); font-family: inherit; }
    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(21,128,61,0.38); }
    .label-f { display: block; font-size: 0.7rem; font-weight: 700; color: #64748b; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 6px; }
    .err-msg { font-size: 0.75rem; color: #dc2626; margin-top: 4px; display: block; }
    .alert-e { background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: 10px; padding: 0.75rem 1rem; color: #dc2626; font-size: 0.83rem; font-weight: 600; margin-bottom: 1.1rem; }
    @media (min-width: 1024px) {
        .auth-grid { grid-template-columns: 0.85fr 1.3fr; }
    }
</style>

<div class="auth-wrap">
    <div class="auth-grid">

        {{-- FORM --}}
        <section class="card-form">
            <div style="text-align:center;margin-bottom:1.6rem;">
                <div style="width:56px;height:56px;background:linear-gradient(135deg,#dcfce7,#bbf7d0);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.7rem;margin:0 auto .9rem;box-shadow:0 4px 12px rgba(21,128,61,.14);">📝</div>
                <h2 style="font-size:1.5rem;font-weight:800;color:#15803d;margin:0 0 4px;">Buat Akun Panitia</h2>
                <p style="font-size:.82rem;color:#94a3b8;font-weight:500;margin:0;">Registrasi akun untuk membantu distribusi kupon kurban.</p>
            </div>

            @if($errors->any())
                <div class="alert-e">⚠️ {{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:1rem;">
                @csrf

                <div>
                    <label for="name" class="label-f">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="input-reg input-reg-plain" placeholder="Nama lengkap Anda..." required>
                    @error('name')<span class="err-msg">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="phone" class="label-f">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="input-reg input-reg-plain" placeholder="08xxxxxxxxxx">
                    @error('phone')<span class="err-msg">{{ $message }}</span>@enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.85rem;">
                    <div>
                        <label for="password" class="label-f">Password</label>
                        <div class="pw-wrap" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" id="password" name="password" class="input-reg" placeholder="Min. 8 karakter" required>
                            <button type="button" class="pw-toggle" @click="show = !show">
                                <svg x-show="!show" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        @error('password')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="label-f">Konfirmasi</label>
                        <div class="pw-wrap" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" class="input-reg" placeholder="Ulangi password" required>
                            <button type="button" class="pw-toggle" @click="show = !show">
                                <svg x-show="!show" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Informasi Aktivasi --}}
                <div style="background:#fffbeb;border:1.5px solid #fde68a;border-radius:10px;padding:.75rem 1rem;font-size:.8rem;color:#92400e;font-weight:600;">
                    ℹ️ Akun Anda akan aktif setelah dikonfirmasi oleh Admin / Panitia Inti.
                </div>

                <button type="submit" class="btn-submit">Daftar Sekarang &rarr;</button>
            </form>

            <p style="text-align:center;font-size:.83rem;color:#94a3b8;margin-top:1.5rem;font-weight:500;">
                Sudah punya akun?
                <a href="{{ route('login') }}" style="color:#15803d;font-weight:700;text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Masuk ke sistem</a>
            </p>
        </section>

        {{-- HERO --}}
        <section class="bg-hero">
            <div style="position:absolute;inset:0;background-image:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23fff\' fill-opacity=\'0.04\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/svg%3E');"></div>
            <div style="position:relative;z-index:10;">
                <span style="display:inline-block;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);border-radius:999px;padding:5px 16px;font-size:.68rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;margin-bottom:1.5rem;">✦ Akses Khusus Panitia</span>
                <h1 style="font-size:clamp(1.9rem,4vw,2.9rem);font-weight:800;line-height:1.18;margin-bottom:1rem;">Bergabung Menjadi <span style="color:#fde68a;">Panitia Kurban.</span></h1>
                <div style="display:flex;flex-direction:column;gap:1.25rem;margin-top:1.5rem;">
                    <div style="display:flex;align-items:flex-start;gap:1rem;">
                        <div style="width:42px;height:42px;min-width:42px;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.1rem;">🤝</div>
                        <p style="color:rgba(240,255,240,.88);font-size:.95rem;line-height:1.6;margin:0;">Bantu kelancaran distribusi daging kurban di lapangan.</p>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:1rem;">
                        <div style="width:42px;height:42px;min-width:42px;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.1rem;">📷</div>
                        <p style="color:rgba(240,255,240,.88);font-size:.95rem;line-height:1.6;margin:0;">Gunakan fitur scan QR Code dari smartphone Anda.</p>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:1rem;">
                        <div style="width:42px;height:42px;min-width:42px;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.1rem;">✅</div>
                        <p style="color:rgba(240,255,240,.88);font-size:.95rem;line-height:1.6;margin:0;">Pastikan penyaluran daging tepat sasaran dan terdokumentasi.</p>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection
