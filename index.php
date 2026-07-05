<?php
/**
 * ============================================================
 *  VURAL AĞ - ANA SAYFA (index.php)
 * ============================================================
 *  Bölümler:
 *    1. Hero          -> Vizyon cümlesi + CTA
 *    2. Referanslar   -> Kurumsal logo grid'i
 *    3. Hizmetler     -> Hizmet kartları
 *    4. Teklif Formu  -> contact-handler.php'ye POST eder
 * ============================================================
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/csrf.php'; // CSRF token üretimi için
$page_title = SITE_NAME . ' — ' . SITE_TAGLINE;
require __DIR__ . '/header.php';
?>

<!-- ============================================================
     1. HERO (Sinematik)
     Tam ekran arka plan görseli + koyu overlay + teknik ızgara.
     GÖRSEL: assets/hero.jpg olarak yüksekte çalışan bir işçi /
     ağ montajı fotoğrafı koy (min 1920px genişlik, WebP tercih).
     Görsel yoksa degrade zemin tek başına da premium durur.
============================================================= -->
<section class="relative min-h-[92vh] flex items-center overflow-hidden bg-abyss"
         style="background-image:
                    linear-gradient(to bottom, rgba(11,14,19,.85) 0%, rgba(11,14,19,.62) 50%, rgba(11,14,19,.96) 100%),
                    url('assets/hero.jpg');
                background-size: cover;
                background-position: center;">
    <div class="absolute inset-0 blueprint-grid" aria-hidden="true"></div>

    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <!-- Teknik etiket (eyebrow) -->
        <p class="font-mono text-xs sm:text-sm tracking-[0.3em] uppercase text-signal mb-8">
            Güvenlik Ağı &middot; File Montajı &middot; Düşüş Koruma Sistemleri
        </p>

        <!-- Vizyon cümlesi: devasa, extrabold -->
        <h1 class="font-display font-extrabold tracking-tight leading-[1.05] text-white
                   text-5xl sm:text-6xl lg:text-7xl xl:text-[5.5rem] max-w-5xl">
            Yüksekte çalışmanın<br>
            <span class="text-signal">güvenli adresi.</span>
        </h1>

        <!-- Alt başlık: ince ve okunur -->
        <p class="mt-8 text-lg lg:text-xl font-light text-gray-300 max-w-2xl leading-relaxed">
            <?php echo SITE_NAME; ?>, fabrikalardan şantiyelere, merdiven boşluklarından depo
            raf sistemlerine kadar her alanda standartlara uygun güvenlik ağı ve file montajını
            planlanan sürede, eksiksiz teslim eder.
        </p>

        <!-- CTA Butonları -->
        <div class="mt-12 flex flex-col sm:flex-row gap-4">
            <a href="#iletisim-form"
               class="btn-glow inline-flex justify-center items-center rounded-lg bg-signal hover:bg-signalDim px-8 py-4 text-base font-bold text-abyss hover:-translate-y-0.5">
                Proje Teklifi Alın
            </a>
            <a href="#hizmetler"
               class="inline-flex justify-center items-center rounded-lg border border-white/20 hover:border-signal/70 bg-white/5 backdrop-blur-sm px-8 py-4 text-base font-semibold text-gray-200 hover:text-white transition-colors">
                Hizmetlerimiz
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     2. KURUMSAL REFERANSLAR
     Kutu yok: geniş boşluklu, şeffaf logolar. Varsayılan %50
     opak + grayscale; hover'da anında renkli %100 (CSS: .ref-logo)
============================================================= -->
<section id="referanslar" class="bg-abyss border-y border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <p class="font-mono text-xs tracking-[0.3em] uppercase text-signal text-center mb-3">Referanslar</p>
        <h2 class="font-display font-bold text-3xl text-white text-center">
            Global markaların çözüm ortağı
        </h2>

        <div class="mt-16 flex flex-wrap items-center justify-center gap-x-16 gap-y-12 sm:gap-x-20">
            <?php foreach ($references as $ref): ?>
                <img src="<?php echo $ref['logo']; ?>"
                     alt="<?php echo htmlspecialchars($ref['name']); ?>"
                     loading="lazy" decoding="async" width="160" height="40"
                     class="ref-logo h-8 sm:h-10 w-auto"
                     onerror="this.outerHTML='<span class=\'ref-logo font-display font-semibold text-lg text-gray-400\'><?php echo htmlspecialchars($ref['name']); ?></span>';">
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     3. HİZMETLER
     Açık gri zemin üzerinde kart grid'i.
============================================================= -->
<section id="hizmetler" class="bg-ink">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <p class="font-mono text-xs tracking-[0.3em] uppercase text-signal mb-3">Hizmetler</p>
        <h2 class="font-display font-bold text-3xl lg:text-4xl text-white max-w-xl">
            Keşiften montaja, her noktada tam koruma
        </h2>

        <div class="mt-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            // Hizmet ikonları: config.php'deki 'icon' anahtarına göre eşleşen inline SVG'ler
            $icons = [
                // Ağ/file deseni (grid)
                'net'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75h16.5v16.5H3.75zM3.75 9.25h16.5M3.75 14.75h16.5M9.25 3.75v16.5M14.75 3.75v16.5"/>',
                // İnşaat / bina iskeleti
                'frame'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>',
                // Kalkan (koruma)
                'shield' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>',
                // Bakım (İngiliz anahtarı)
                'wrench' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>',
            ];
            ?>
            <?php foreach ($services as $i => $service): ?>
                <!-- Glassmorphism kart: yarı şeffaf zemin + blur + ince kenarlık -->
                <article class="service-card bg-white/[0.04] backdrop-blur-sm rounded-2xl border border-white/10 p-8 hover:border-signal/60 flex flex-col">
                    <!-- Büyük ikon: turuncu, hafif ışımalı zemin -->
                    <div class="service-icon h-24 w-24 rounded-2xl bg-signal/10 ring-1 ring-signal/25 flex items-center justify-center mb-8">
                        <svg class="h-14 w-14 text-signal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.25">
                            <?php echo $icons[$service['icon']] ?? $icons['net']; ?>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg text-white mb-3">
                        <?php echo htmlspecialchars($service['title']); ?>
                    </h3>
                    <p class="text-sm text-gray-400 leading-relaxed flex-1">
                        <?php echo htmlspecialchars($service['desc']); ?>
                    </p>
                    <!-- Modal tetikleyici: içerik JS'e data attribute ile taşınır -->
                    <button type="button"
                            class="service-detail-btn mt-7 inline-flex items-center gap-1.5 text-sm font-semibold text-signal hover:text-signalDim transition-colors self-start"
                            data-title="<?php echo htmlspecialchars($service['title']); ?>"
                            data-details="<?php echo htmlspecialchars($service['details']); ?>">
                        Detayları Gör
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </button>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     4. TEKLİF FORMU
     contact-handler.php'ye POST eder. Handler işlem sonrası
     bu sayfaya ?form=success veya ?form=error ile döner.
============================================================= -->
<!-- ============================================================
     4. TEKLİF FORMU (Premium koyu kart)
     Inputlar kenarlıksız; focus'ta turuncu aydınlanma (.premium-input)
============================================================= -->
<section id="iletisim-form" class="bg-abyss border-t border-white/5">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <p class="font-mono text-xs tracking-[0.3em] uppercase text-signal text-center mb-3">Teklif</p>
        <h2 class="font-display font-bold text-3xl lg:text-4xl text-white text-center">
            Projeniz için teklif isteyin
        </h2>
        <p class="mt-4 text-gray-400 text-center">
            Formu doldurun, ekibimiz en kısa sürede size dönüş yapsın.
        </p>

        <!-- Form kartı: koyu, yuvarlatılmış, derin gölgeli kapsayıcı -->
        <div class="mt-12 bg-anthracite/80 backdrop-blur rounded-2xl border border-white/5 shadow-2xl shadow-black/50 p-6 sm:p-10">

            <!-- Dinamik durum mesajı (AJAX yanıtına göre JS doldurur) -->
            <div id="form-status" class="status-hidden mb-8 hidden rounded-lg border px-4 py-3 text-sm" role="alert" aria-live="polite"></div>

            <form id="quote-form" action="contact-handler.php" method="POST" novalidate
                  class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- CSRF koruması -->
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <!-- Bot koruması (honeypot): İnsanlar bu alanı görmez, botlar doldurur -->
                <input type="text" name="website" tabindex="-1" autocomplete="off"
                       class="hidden" aria-hidden="true">

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Ad Soyad *</label>
                    <input type="text" id="name" name="name" required maxlength="100"
                           class="premium-input w-full rounded-lg bg-abyss/70 px-4 py-3 text-sm text-white placeholder-gray-500 outline-none">
                </div>
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-300 mb-2">Firma</label>
                    <input type="text" id="company" name="company" maxlength="100"
                           class="premium-input w-full rounded-lg bg-abyss/70 px-4 py-3 text-sm text-white placeholder-gray-500 outline-none">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">E-posta *</label>
                    <input type="email" id="email" name="email" required maxlength="150"
                           class="premium-input w-full rounded-lg bg-abyss/70 px-4 py-3 text-sm text-white placeholder-gray-500 outline-none">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Telefon</label>
                    <input type="tel" id="phone" name="phone" maxlength="20"
                           class="premium-input w-full rounded-lg bg-abyss/70 px-4 py-3 text-sm text-white placeholder-gray-500 outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Proje Detayı *</label>
                    <textarea id="message" name="message" rows="5" required maxlength="3000"
                              class="premium-input w-full rounded-lg bg-abyss/70 px-4 py-3 text-sm text-white placeholder-gray-500 outline-none resize-y"></textarea>
                </div>
                <div class="sm:col-span-2">
                    <!-- Tam genişlik, kalın, hover'da büyüyen + ışıyan buton -->
                    <button type="submit" id="quote-submit"
                            class="btn-glow w-full inline-flex justify-center items-center gap-2 rounded-lg bg-signal hover:bg-signalDim px-8 py-4 text-base font-bold text-abyss hover:scale-[1.02] disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:scale-100">
                        <span id="quote-submit-text">Teklif Talebi Gönder</span>
                        <!-- Yükleniyor spinner'ı (JS gösterir/gizler) -->
                        <svg id="quote-spinner" class="hidden h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- ============================================================
     HİZMET DETAY MODALI
     Tek bir modal; içerik "Detayları Gör" butonlarındaki
     data attribute'lardan JS ile doldurulur.
============================================================= -->
<div id="service-modal" class="modal-hidden fixed inset-0 z-[60] hidden" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <!-- Arka plan karartması -->
    <div class="modal-backdrop absolute inset-0 bg-abyss/80 backdrop-blur-sm" data-modal-close></div>
    <!-- Panel -->
    <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none">
        <div class="modal-panel pointer-events-auto w-full max-w-lg bg-anthracite rounded-2xl border border-white/10 shadow-2xl shadow-black/60 overflow-hidden">
            <div class="flex items-start justify-between gap-4 px-7 pt-7">
                <h3 id="modal-title" class="font-display font-bold text-xl text-white"></h3>
                <button type="button" data-modal-close aria-label="Kapat"
                        class="shrink-0 rounded-md p-1.5 text-gray-400 hover:text-white hover:bg-white/10 transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div id="modal-body" class="px-7 py-5 text-sm text-gray-300 leading-relaxed whitespace-pre-line max-h-[60vh] overflow-y-auto"></div>
            <div class="px-7 pb-7">
                <a href="#iletisim-form" data-modal-close
                   class="btn-glow inline-flex items-center rounded-lg bg-signal hover:bg-signalDim px-5 py-2.5 text-sm font-bold text-abyss">
                    Bu hizmet için teklif al
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     SAYFA JAVASCRIPT'İ (AJAX form + Modal)
============================================================= -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ---------- 1. AJAX TEKLİF FORMU ---------- */
    const form     = document.getElementById('quote-form');
    const status   = document.getElementById('form-status');
    const btn      = document.getElementById('quote-submit');
    const btnText  = document.getElementById('quote-submit-text');
    const spinner  = document.getElementById('quote-spinner');
    const SITE_KEY = <?php echo json_encode(RECAPTCHA_SITE_KEY); ?>;

    // Durum mesajını yumuşak geçişle göster
    function showStatus(ok, msg) {
        status.textContent = msg;
        status.className = 'mb-8 rounded-lg border px-4 py-3 text-sm ' +
            (ok ? 'border-green-500/40 bg-green-500/10 text-green-300'
                : 'border-red-500/40 bg-red-500/10 text-red-300');
        // Geçiş animasyonu için iki adımda class değişimi
        status.classList.add('status-hidden');
        requestAnimationFrame(() => status.classList.remove('status-hidden'));
        status.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function setLoading(loading) {
        btn.disabled = loading;
        spinner.classList.toggle('hidden', !loading);
        btnText.textContent = loading ? 'Gönderiliyor...' : 'Teklif Talebi Gönder';
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault(); // Sayfa yenilenmesini engelle
        setLoading(true);

        try {
            const data = new FormData(form);

            // reCAPTCHA v3 aktifse token al ve isteğe ekle
            if (SITE_KEY && window.grecaptcha) {
                await new Promise(res => grecaptcha.ready(res));
                const token = await grecaptcha.execute(SITE_KEY, { action: 'quote' });
                data.append('recaptcha_token', token);
            }

            const res  = await fetch(form.action, { method: 'POST', body: data });
            const json = await res.json();

            showStatus(json.success, json.message);
            if (json.success) form.reset();

        } catch (err) {
            showStatus(false, 'Bağlantı hatası oluştu. Lütfen tekrar deneyin.');
        } finally {
            setLoading(false);
        }
    });

    /* ---------- 2. HİZMET DETAY MODALI ---------- */
    const modal      = document.getElementById('service-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalBody  = document.getElementById('modal-body');
    let lastFocused  = null;

    function openModal(title, details) {
        lastFocused = document.activeElement;
        modalTitle.textContent = title;
        modalBody.textContent  = details;
        modal.classList.remove('hidden');
        // Bir frame sonra animasyon class'ını kaldır -> yumuşak açılış
        requestAnimationFrame(() => modal.classList.remove('modal-hidden'));
        document.body.style.overflow = 'hidden'; // Arka plan scroll kilidi
    }

    function closeModal() {
        modal.classList.add('modal-hidden');
        document.body.style.overflow = '';
        // Geçiş bitince tamamen gizle
        setTimeout(() => modal.classList.add('hidden'), 250);
        if (lastFocused) lastFocused.focus();
    }

    document.querySelectorAll('.service-detail-btn').forEach(b =>
        b.addEventListener('click', () => openModal(b.dataset.title, b.dataset.details))
    );
    modal.querySelectorAll('[data-modal-close]').forEach(el =>
        el.addEventListener('click', closeModal)
    );
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });
});
</script>

<?php require 'footer.php'; ?>
