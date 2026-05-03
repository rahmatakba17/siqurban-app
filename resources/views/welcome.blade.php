<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SI Qurban — Kupon Kurban Digital</title>
<meta name="description" content="Cek status kupon kurban Anda secara online. SI Qurban membantu distribusi daging kurban lebih tertib dan terdokumentasi.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
*{font-family:'Plus Jakarta Sans',sans-serif;box-sizing:border-box}
body{background:#f8f4ed;color:#1c1917;margin:0}
.arabic{font-family:'Amiri',serif}
.bg-hijau{background:#15803d}
.text-hijau{color:#15803d}
.bg-emas{background:#ca8a04}
.text-emas{color:#ca8a04}
.border-hijau{border-color:#15803d}
nav{background:#fff;border-bottom:2px solid #15803d;position:sticky;top:0;z-index:100;box-shadow:0 2px 12px rgba(21,128,61,0.08)}
.nav-inner{max-width:1100px;margin:0 auto;padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between;height:70px}
.logo{display:flex;align-items:center;gap:12px}
.logo-icon{width:44px;height:44px;background:#15803d;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px}
.logo-text{font-size:1.25rem;font-weight:800;color:#15803d}
.logo-sub{font-size:0.7rem;color:#78716c;font-weight:500}
.nav-btns{display:flex;align-items:center;gap:0.75rem}
.btn-outline{padding:0.5rem 1.25rem;border:2px solid #15803d;color:#15803d;border-radius:10px;font-weight:600;font-size:0.9rem;text-decoration:none;transition:all 0.2s}
.btn-outline:hover{background:#15803d;color:#fff}
.btn-solid{padding:0.5rem 1.25rem;background:#15803d;color:#fff;border-radius:10px;font-weight:600;font-size:0.9rem;text-decoration:none;border:2px solid #15803d;transition:all 0.2s}
.btn-solid:hover{background:#166534}
.hero{background:linear-gradient(160deg,#15803d 0%,#166534 50%,#14532d 100%);color:#fff;padding:5rem 1.5rem 4rem;text-align:center;position:relative;overflow:hidden}
.hero::before{content:'';position:absolute;inset:0;background-image:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")}
.hero-inner{max-width:750px;margin:0 auto;position:relative}
.bismillah{font-family:'Amiri',serif;font-size:2rem;color:#bbf7d0;margin-bottom:1.5rem;display:block}
.hero h1{font-size:2.75rem;font-weight:800;line-height:1.2;margin:0 0 1rem}
.hero h1 span{color:#fde68a}
.hero p{font-size:1.1rem;color:#d1fae5;max-width:560px;margin:0 auto 2.5rem;line-height:1.7}
.hero-btns{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap}
.btn-hero-primary{background:#fff;color:#15803d;padding:1rem 2rem;border-radius:14px;font-weight:700;font-size:1rem;text-decoration:none;border:2px solid #fff;transition:all 0.2s}
.btn-hero-primary:hover{background:#f0fdf4;transform:translateY(-2px)}
.btn-hero-secondary{background:transparent;color:#fff;padding:1rem 2rem;border-radius:14px;font-weight:600;font-size:1rem;text-decoration:none;border:2px solid rgba(255,255,255,0.5);transition:all 0.2s}
.btn-hero-secondary:hover{background:rgba(255,255,255,0.1)}
.container{max-width:1100px;margin:0 auto;padding:0 1.5rem}
.section{padding:5rem 1.5rem}
.section-alt{background:#fff}
.section-title{text-align:center;margin-bottom:3rem}
.section-title .label{display:inline-block;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;border-radius:999px;padding:0.35rem 1rem;font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:1rem}
.section-title h2{font-size:2rem;font-weight:800;color:#1c1917;margin:0 0 0.75rem}
.section-title p{font-size:1rem;color:#78716c;max-width:560px;margin:0 auto;line-height:1.7}
/* CEK KUPON */
.cek-section{background:linear-gradient(180deg,#f8f4ed 0%,#f0fdf4 100%);padding:5rem 1.5rem}
.cek-box{background:#fff;border-radius:24px;padding:3rem 2.5rem;max-width:680px;margin:0 auto;box-shadow:0 4px 40px rgba(21,128,61,0.10);border:1px solid #d1fae5}
.cek-box h2{font-size:1.75rem;font-weight:800;text-align:center;color:#15803d;margin:0 0 0.5rem}
.cek-box p{text-align:center;color:#78716c;margin:0 0 2rem;font-size:1rem;line-height:1.6}
.search-row{display:flex;gap:0.75rem;flex-wrap:wrap}
.search-input{flex:1;min-width:200px;padding:1rem 1.25rem;border:2px solid #d1fae5;border-radius:14px;font-size:1rem;font-family:'Plus Jakarta Sans',sans-serif;outline:none;transition:border-color 0.2s;background:#f8fafc;text-transform:uppercase;letter-spacing:0.05em}
.search-input:focus{border-color:#15803d;background:#fff}
.search-btn{background:#15803d;color:#fff;border:none;padding:1rem 1.75rem;border-radius:14px;font-weight:700;font-size:1rem;cursor:pointer;transition:all 0.2s;white-space:nowrap;font-family:'Plus Jakarta Sans',sans-serif}
.search-btn:hover{background:#166534;transform:translateY(-1px)}
.search-btn:disabled{opacity:0.6;cursor:not-allowed;transform:none}
#errorMsg{color:#dc2626;font-size:0.9rem;margin-top:0.75rem;display:none}
#resultArea{display:none;margin-top:2rem;padding-top:2rem;border-top:1px solid #d1fae5}
.result-card{border-radius:16px;padding:1.75rem;border:1px solid #d1d5db}
.result-found{background:#f0fdf4;border-color:#bbf7d0}
.result-notfound{background:#fff5f5;border-color:#fecaca;text-align:center}
.badge{display:inline-flex;align-items:center;gap:6px;padding:0.4rem 1rem;border-radius:999px;font-weight:700;font-size:0.85rem}
.badge-diterima{background:#dcfce7;color:#15803d;border:1px solid #86efac}
.badge-belum{background:#fef9c3;color:#854d0e;border:1px solid #fde047}
.result-code{font-size:1.5rem;font-weight:800;font-family:monospace;color:#1c1917;letter-spacing:0.05em}
.result-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-top:1.5rem}
.result-item label{font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#78716c;display:block;margin-bottom:0.25rem}
.result-item span{font-size:1rem;font-weight:600;color:#1c1917}
.reset-btn{background:none;border:none;color:#78716c;cursor:pointer;text-decoration:underline;font-size:0.9rem;margin-top:1.5rem;font-family:'Plus Jakarta Sans',sans-serif}
.reset-btn:hover{color:#15803d}
/* FITUR CARDS */
.features-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.5rem}
.feat-card{background:#fff;border-radius:20px;padding:2rem;border:1px solid #e7e5e4;transition:all 0.25s}
.feat-card:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(21,128,61,0.12);border-color:#bbf7d0}
.feat-icon{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1.25rem}
.feat-card h3{font-size:1.1rem;font-weight:700;color:#1c1917;margin:0 0 0.5rem}
.feat-card p{font-size:0.9rem;color:#78716c;line-height:1.6;margin:0}
/* ROLES */
.roles-grid{display:grid;grid-template-columns:1fr 1fr;gap:2rem}
.role-card{border-radius:20px;padding:2.5rem;border:2px solid}
.role-admin{background:#f0fdf4;border-color:#86efac}
.role-panitia{background:#f0f9ff;border-color:#bae6fd}
.role-card h3{font-size:1.4rem;font-weight:800;margin:0 0 0.5rem}
.role-card .role-desc{color:#78716c;margin:0 0 1.5rem;font-size:0.95rem}
.role-card ul{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:0.75rem}
.role-card li{display:flex;align-items:flex-start;gap:0.75rem;font-size:0.95rem;color:#44403c}
.check-icon{width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.75rem;flex-shrink:0;margin-top:1px}
.check-green{background:#dcfce7;color:#15803d}
.check-blue{background:#dbeafe;color:#1d4ed8}
/* CTA */
.cta-section{background:linear-gradient(135deg,#15803d,#0f6630);color:#fff;text-align:center;padding:5rem 1.5rem}
.cta-section h2{font-size:2.25rem;font-weight:800;margin:0 0 1rem;line-height:1.3}
.cta-section h2 span{color:#fde68a}
.cta-section p{font-size:1.05rem;color:#d1fae5;margin:0 0 2.5rem;line-height:1.7}
/* FOOTER */
footer{background:#1c1917;color:#a8a29e;padding:2.5rem 1.5rem;text-align:center}
footer .footer-logo{color:#fff;font-weight:800;font-size:1.1rem;margin-bottom:0.5rem}
footer p{margin:0;font-size:0.875rem}
/* RESPONSIVE */
@media(max-width:768px){
.hero h1{font-size:1.9rem}
.roles-grid{grid-template-columns:1fr}
.result-grid{grid-template-columns:1fr}
.nav-btns .hide-mobile{display:none}
.cek-box{padding:2rem 1.25rem}
.section{padding:3.5rem 1.25rem}
}
@media(max-width:480px){
.search-row{flex-direction:column}
.hero h1{font-size:1.6rem}
.bismillah{font-size:1.5rem}
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav>
  <div class="nav-inner">
    <div class="logo">
      <div class="logo-icon">🕌</div>
      <div>
        <div class="logo-text">SI Qurban</div>
        <div class="logo-sub">Sistem Kupon Kurban Digital</div>
      </div>
    </div>
    <div class="nav-btns">
      <a href="#cek-kupon" class="btn-outline hide-mobile">🔍 Cek Kupon</a>
      <a href="{{ route('login') }}" class="btn-outline">Masuk</a>
      <a href="{{ route('register') }}" class="btn-solid">Daftar Panitia</a>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-inner">
    <span class="bismillah arabic">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</span>
    <h1>Kupon Kurban Digital<br><span>Lebih Tertib & Berkah</span></h1>
    <p>Sistem distribusi daging kurban berbasis digital untuk masjid dan lembaga. Dari QR Code otomatis hingga verifikasi saat pembagian — semua dalam satu sistem.</p>
    <div class="hero-btns">
      <a href="#cek-kupon" class="btn-hero-primary">🔍 Cek Kupon Saya</a>
      <a href="{{ route('register') }}" class="btn-hero-secondary">Daftar Sebagai Panitia</a>
    </div>
  </div>
</section>

<!-- CEK KUPON -->
<section id="cek-kupon" class="cek-section">
  <div class="cek-box">
    <h2>🔍 Cek Status Kupon Anda</h2>
    <p>Masukkan kode kupon yang diberikan panitia untuk melihat status penerimaan daging kurban Anda.</p>
    <form id="couponForm">
      <div class="search-row">
        <input id="searchCode" type="text" class="search-input" placeholder="Masukkan kode kupon (contoh: PKB-2026-XXXXX)" required>
        <button type="submit" id="submitBtn" class="search-btn">
          <span id="btnText">Periksa</span>
          <span id="btnLoading" style="display:none">Memeriksa...</span>
        </button>
      </div>
      <p id="errorMsg"></p>
    </form>
    <div id="resultArea">
      <div id="resultSuccess" class="result-card result-found" style="display:none">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem">
          <div>
            <div style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#78716c;margin-bottom:0.5rem">Kode Kupon</div>
            <div id="resCode" class="result-code"></div>
          </div>
          <div>
            <span id="badgeDiterima" class="badge badge-diterima" style="display:none">✓ Sudah Diterima</span>
            <span id="badgeBelum" class="badge badge-belum" style="display:none">⏳ Belum Diambil</span>
          </div>
        </div>
        <div class="result-grid">
          <div class="result-item"><label>Nama Pekurban</label><span id="resName"></span></div>
          <div class="result-item"><label>Jenis Hewan</label><span id="resType"></span></div>
          <div class="result-item"><label>Wilayah Distribusi</label><span id="resRegion"></span></div>
          <div id="resTimeContainer" class="result-item" style="display:none"><label>Waktu Diterima</label><span id="resTime" style="color:#15803d;font-weight:700"></span></div>
        </div>
        <div style="text-align:center;margin-top:1.5rem">
          <button class="reset-btn" onclick="resetSearch()">← Cek Kupon Lain</button>
        </div>
      </div>
      <div id="resultNotFound" class="result-card result-notfound" style="display:none">
        <div style="font-size:3rem;margin-bottom:1rem">❌</div>
        <h4 style="font-size:1.25rem;font-weight:800;margin:0 0 0.75rem;color:#991b1b">Kupon Tidak Ditemukan</h4>
        <p style="color:#78716c;font-size:0.95rem;max-width:380px;margin:0 auto 1.5rem;line-height:1.6">Kode yang Anda masukkan tidak ditemukan dalam sistem. Pastikan kode sudah benar atau hubungi panitia masjid Anda.</p>
        <button class="reset-btn" onclick="resetSearch()">Coba Lagi</button>
      </div>
    </div>
  </div>
</section>

<!-- FITUR -->
<section class="section section-alt">
  <div class="container">
    <div class="section-title">
      <div class="label">✨ Fitur Unggulan</div>
      <h2>Semua Kebutuhan Panitia Kurban</h2>
      <p>Dari pembuatan kupon hingga verifikasi lapangan — satu sistem lengkap untuk kepanitiaan masjid.</p>
    </div>
    <div class="features-grid">
      <div class="feat-card">
        <div class="feat-icon" style="background:#f0fdf4">🎫</div>
        <h3>Generate Kupon Otomatis</h3>
        <p>Buat ratusan kupon sekaligus lengkap dengan QR Code unik. Hemat waktu dan terhindar dari duplikasi data.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon" style="background:#eff6ff">📷</div>
        <h3>Scan QR via Kamera</h3>
        <p>Panitia cukup arahkan kamera ke QR Code pada kupon untuk verifikasi instan di hari pembagian.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon" style="background:#fefce8">📊</div>
        <h3>Laporan & Rekap Otomatis</h3>
        <p>Dashboard statistik real-time dan ekspor laporan ke format CSV & Excel dengan satu klik.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon" style="background:#fff7ed">📂</div>
        <h3>Import Data Excel/CSV</h3>
        <p>Upload data seluruh pekurban dari file spreadsheet secara massal — tidak perlu input satu per satu.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon" style="background:#fdf2f8">🗺️</div>
        <h3>Manajemen Wilayah</h3>
        <p>Kelola distribusi daging per wilayah/RT/RW dengan pantauan progress penerimaan secara visual.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon" style="background:#f0fdf4">🔐</div>
        <h3>Akses Berbasis Peran</h3>
        <p>Admin kelola data master, Panitia fokus scan kupon. Hak akses jelas dan keamanan data terjaga.</p>
      </div>
    </div>
  </div>
</section>

<!-- ROLES -->
<section class="section" style="background:#f8f4ed">
  <div class="container">
    <div class="section-title">
      <div class="label">👥 Pengguna Sistem</div>
      <h2>Untuk Admin & Panitia Masjid</h2>
      <p>Dua jenis akun dengan fungsi yang berbeda sesuai tanggung jawab masing-masing.</p>
    </div>
    <div class="roles-grid">
      <div class="role-card role-admin">
        <div style="font-size:2.5rem;margin-bottom:1rem">👨‍💼</div>
        <h3 style="color:#15803d">Administrator</h3>
        <p class="role-desc">Kontrol penuh atas sistem distribusi kupon kurban — kelola data, pantau progress, dan buat laporan.</p>
        <ul>
          <li><span class="check-icon check-green">✓</span>Dashboard statistik & grafik distribusi</li>
          <li><span class="check-icon check-green">✓</span>Kelola user, wilayah, dan data kupon</li>
          <li><span class="check-icon check-green">✓</span>Generate & import data kupon massal</li>
          <li><span class="check-icon check-green">✓</span>Riwayat scan seluruh panitia</li>
          <li><span class="check-icon check-green">✓</span>Ekspor laporan CSV & Excel</li>
          <li><span class="check-icon check-green">✓</span>Pengaturan nama masjid & tahun kurban</li>
        </ul>
      </div>
      <div class="role-card role-panitia">
        <div style="font-size:2.5rem;margin-bottom:1rem">🧑‍🤝‍🧑</div>
        <h3 style="color:#1d4ed8">Panitia Scan</h3>
        <p class="role-desc">Fokus pada verifikasi kupon di lapangan saat hari pembagian daging kurban berlangsung.</p>
        <ul>
          <li><span class="check-icon check-blue">✓</span>Dashboard statistik scan hari ini</li>
          <li><span class="check-icon check-blue">✓</span>Scan QR Code via kamera browser</li>
          <li><span class="check-icon check-blue">✓</span>Input kode kupon manual (alternatif)</li>
          <li><span class="check-icon check-blue">✓</span>Riwayat verifikasi pribadi</li>
          <li><span class="check-icon check-blue">✓</span>Notifikasi langsung hasil verifikasi</li>
          <li><span class="check-icon check-blue">✓</span>Kelola profil & ubah password</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="container">
    <div style="font-size:3rem;margin-bottom:1rem">🕋</div>
    <h2>Wujudkan Kurban yang<br><span>Lebih Tertib & Bermakna</span></h2>
    <p>Bergabunglah dengan panitia masjid lainnya. Daftar akun gratis dan mulai kelola distribusi kupon kurban secara digital hari ini.</p>
    <div class="hero-btns">
      <a href="{{ route('register') }}" class="btn-hero-primary" style="font-size:1.05rem;padding:1.1rem 2.5rem">Daftar Panitia — Gratis</a>
      <a href="{{ route('login') }}" class="btn-hero-secondary">Sudah punya akun? Masuk</a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-logo">🕌 SI Qurban</div>
  <p>Sistem Distribusi Kupon Kurban Digital &mdash; Magister Teknik Informatika 12</p>
  <p style="margin-top:0.5rem">&copy; {{ date('Y') }} SI Qurban. Semua hak dilindungi.</p>
</footer>

<script>
function resetSearch(){
  document.getElementById('searchCode').value='';
  document.getElementById('resultArea').style.display='none';
  document.getElementById('resultSuccess').style.display='none';
  document.getElementById('resultNotFound').style.display='none';
  document.getElementById('errorMsg').style.display='none';
  document.getElementById('searchCode').focus();
}
document.getElementById('couponForm').addEventListener('submit',async function(e){
  e.preventDefault();
  const code=document.getElementById('searchCode').value.trim();
  const errorMsg=document.getElementById('errorMsg');
  const submitBtn=document.getElementById('submitBtn');
  document.getElementById('resultArea').style.display='none';
  document.getElementById('resultSuccess').style.display='none';
  document.getElementById('resultNotFound').style.display='none';
  errorMsg.style.display='none';
  if(!code||code.length<4){errorMsg.textContent='Kode kupon minimal 4 karakter.';errorMsg.style.display='block';return;}
  submitBtn.disabled=true;
  document.getElementById('btnText').style.display='none';
  document.getElementById('btnLoading').style.display='inline';
  try{
    const r=await fetch('/api/check-coupon/'+encodeURIComponent(code));
    document.getElementById('resultArea').style.display='block';
    if(r.ok){
      const d=await r.json();
      document.getElementById('resCode').textContent=d.code;
      document.getElementById('resName').textContent=d.sacrificer_name||'Hamba Allah';
      document.getElementById('resType').textContent=d.type||'-';
      document.getElementById('resRegion').textContent=d.region_name||'-';
      if(d.status==='diterima'){
        document.getElementById('badgeDiterima').style.display='inline-flex';
        document.getElementById('badgeBelum').style.display='none';
        document.getElementById('resTimeContainer').style.display='block';
        document.getElementById('resTime').textContent=(d.received_at||'-')+' WIB';
      }else{
        document.getElementById('badgeDiterima').style.display='none';
        document.getElementById('badgeBelum').style.display='inline-flex';
        document.getElementById('resTimeContainer').style.display='none';
      }
      document.getElementById('resultSuccess').style.display='block';
    }else{
      document.getElementById('resultNotFound').style.display='block';
    }
  }catch(err){
    errorMsg.textContent='Koneksi bermasalah. Silakan coba lagi.';
    errorMsg.style.display='block';
  }finally{
    submitBtn.disabled=false;
    document.getElementById('btnText').style.display='inline';
    document.getElementById('btnLoading').style.display='none';
  }
});
</script>
</body>
</html>
