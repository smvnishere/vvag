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

require_once 'config.php';
$page_title = SITE_NAME . ' — ' . SITE_TAGLINE;
require 'header.php';

// Form gönderimi sonrası contact-handler.php buraya ?form=... ile yönlendirir
$form_status = $_GET['form'] ?? null;
?>

<!-- ============================================================
     1. HERO
     Antrasit -> gece mavisi degrade zemin + teknik ızgara deseni
============================================================= -->
<section class="relative bg-gradient-to-br from-ink via-anthracite to-midnight overflow-hidden">
    <div class="absolute inset-0 blueprint-grid" aria-hidden="true"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28 lg:py-40">
        <!-- Teknik etiket (eyebrow) -->
        <p class="font-mono text-xs sm:text-sm tracking-[0.25em] uppercase text-signal mb-6">
            Güvenlik Ağı &middot; File Montajı &middot; Düşüş Koruma Sistemleri
        </p>

        <!-- Vizyon cümlesi -->
        <h1 class="font-display font-800 text-4xl sm:text-5xl lg:text-6xl leading-tight text-white max-w-4xl">
            Yüksekte çalışmanın
            <span class="text-signal">güvenli adresi.</span>
        </h1>

        <p class="mt-6 text-lg text-gray-400 max-w-2xl leading-relaxed">
            <?php echo SITE_NAME; ?>, fabrikalardan şantiyelere, merdiven boşluklarından depo
            raf sistemlerine kadar her alanda standartlara uygun güvenlik ağı ve file montajını
            planlanan sürede, eksiksiz teslim eder.
        </p>

        <!-- CTA Butonları -->
        <div class="mt-10 flex flex-col sm:flex-row gap-4">
            <a href="#iletisim-form"
               class="inline-flex justify-center items-center rounded-md bg-signal hover:bg-signalDim px-7 py-3.5 text-base font-semibold text-white transition-colors">
                Proje Teklifi Alın
            </a>
            <a href="#hizmetler"
               class="inline-flex justify-center items-center rounded-md border border-steel hover:border-signal px-7 py-3.5 text-base font-semibold text-gray-200 hover:text-white transition-colors">
                Hizmetlerimiz
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     2. KURUMSAL REFERANSLAR
     Açık zemin üzerinde logo grid'i. Logolar gri başlar,
     hover'da renklenir (kurumsal ve temiz bir görünüm).
============================================================= -->
<section id="referanslar" class="bg-white border-b border-mist">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <p class="font-mono text-xs tracking-[0.25em] uppercase text-signal text-center mb-3">Referanslar</p>
        <h2 class="font-display font-bold text-3xl text-ink text-center">
            Global markaların çözüm ortağı
        </h2>

        <div class="mt-14 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-px bg-mist border border-mist rounded-xl overflow-hidden">
            <?php foreach ($references as $ref): ?>
                <div class="bg-white flex items-center justify-center h-32 px-6 group">
                    <img src="<?php echo $ref['logo']; ?>"
                         alt="<?php echo htmlspecialchars($ref['name']); ?>"
                         class="max-h-12 w-auto grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition duration-300"
                         onerror="this.outerHTML='<span class=\'font-display font-semibold text-gray-400 group-hover:text-ink transition-colors\'><?php echo htmlspecialchars($ref['name']); ?></span>';">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     3. HİZMETLER
     Açık gri zemin üzerinde kart grid'i.
============================================================= -->
<section id="hizmetler" class="bg-fog">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <p class="font-mono text-xs tracking-[0.25em] uppercase text-signal mb-3">Hizmetler</p>
        <h2 class="font-display font-bold text-3xl text-ink max-w-xl">
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
            <?php foreach ($services as $service): ?>
                <article class="bg-white rounded-xl border border-mist p-7 hover:border-signal hover:shadow-lg hover:shadow-signal/5 transition duration-300">
                    <div class="h-12 w-12 rounded-lg bg-midnight flex items-center justify-center mb-6">
                        <svg class="h-6 w-6 text-signal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <?php echo $icons[$service['icon']] ?? $icons['net']; ?>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg text-ink mb-2">
                        <?php echo htmlspecialchars($service['title']); ?>
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        <?php echo htmlspecialchars($service['desc']); ?>
                    </p>
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
<section id="iletisim-form" class="bg-white border-t border-mist">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <p class="font-mono text-xs tracking-[0.25em] uppercase text-signal text-center mb-3">Teklif</p>
        <h2 class="font-display font-bold text-3xl text-ink text-center">
            Projeniz için teklif isteyin
        </h2>
        <p class="mt-4 text-gray-600 text-center">
            Formu doldurun, ekibimiz en kısa sürede size dönüş yapsın.
        </p>

        <?php if ($form_status === 'success'): ?>
            <div class="mt-8 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-800">
                Talebiniz alındı. En kısa sürede size dönüş yapacağız.
            </div>
        <?php elseif ($form_status === 'error'): ?>
            <div class="mt-8 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-800">
                Form gönderilemedi. Lütfen tüm alanları kontrol edip tekrar deneyin.
            </div>
        <?php endif; ?>

        <form action="contact-handler.php" method="POST" class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Bot koruması (honeypot): İnsanlar bu alanı görmez, botlar doldurur -->
            <input type="text" name="website" tabindex="-1" autocomplete="off"
                   class="hidden" aria-hidden="true">

            <div>
                <label for="name" class="block text-sm font-medium text-ink mb-1.5">Ad Soyad *</label>
                <input type="text" id="name" name="name" required maxlength="100"
                       class="w-full rounded-md border border-mist bg-fog px-4 py-2.5 text-sm focus:border-signal focus:ring-1 focus:ring-signal outline-none transition">
            </div>
            <div>
                <label for="company" class="block text-sm font-medium text-ink mb-1.5">Firma</label>
                <input type="text" id="company" name="company" maxlength="100"
                       class="w-full rounded-md border border-mist bg-fog px-4 py-2.5 text-sm focus:border-signal focus:ring-1 focus:ring-signal outline-none transition">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-ink mb-1.5">E-posta *</label>
                <input type="email" id="email" name="email" required maxlength="150"
                       class="w-full rounded-md border border-mist bg-fog px-4 py-2.5 text-sm focus:border-signal focus:ring-1 focus:ring-signal outline-none transition">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-ink mb-1.5">Telefon</label>
                <input type="tel" id="phone" name="phone" maxlength="20"
                       class="w-full rounded-md border border-mist bg-fog px-4 py-2.5 text-sm focus:border-signal focus:ring-1 focus:ring-signal outline-none transition">
            </div>
            <div class="sm:col-span-2">
                <label for="message" class="block text-sm font-medium text-ink mb-1.5">Proje Detayı *</label>
                <textarea id="message" name="message" rows="5" required maxlength="3000"
                          class="w-full rounded-md border border-mist bg-fog px-4 py-2.5 text-sm focus:border-signal focus:ring-1 focus:ring-signal outline-none transition resize-y"></textarea>
            </div>
            <div class="sm:col-span-2">
                <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center items-center rounded-md bg-signal hover:bg-signalDim px-8 py-3 text-base font-semibold text-white transition-colors">
                    Teklif Talebi Gönder
                </button>
            </div>
        </form>
    </div>
</section>

<?php require 'footer.php'; ?>
