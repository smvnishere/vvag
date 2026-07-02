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
            Endüstriyel Montaj &middot; Çelik Konstrüksiyon &middot; Mekanik Tesisat
        </p>

        <!-- Vizyon cümlesi -->
        <h1 class="font-display font-800 text-4xl sm:text-5xl lg:text-6xl leading-tight text-white max-w-4xl">
            Global üretimin sahadaki
            <span class="text-signal">güvenilir gücü.</span>
        </h1>

        <p class="mt-6 text-lg text-gray-400 max-w-2xl leading-relaxed">
            <?php echo SITE_NAME; ?>, dünya standartlarında üretim yapan tesisler için montaj,
            konstrüksiyon ve tesisat projelerini planlanan sürede, tam uyumla teslim eder.
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
            Projeden devreye almaya, uçtan uca uygulama
        </h2>

        <div class="mt-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            // Hizmet ikonları: config.php'deki 'icon' anahtarına göre eşleşen inline SVG'ler
            $icons = [
                'bolt'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>',
                'frame'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>',
                'pipe'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 01-.657.643 48.39 48.39 0 01-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 01-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 00-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 01-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 00.657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 01-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 005.427-.63 48.05 48.05 0 00.582-4.717.532.532 0 00-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 00.658-.663 48.422 48.422 0 00-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 01-.61-.58v0z"/>',
                'wrench' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>',
            ];
            ?>
            <?php foreach ($services as $service): ?>
                <article class="bg-white rounded-xl border border-mist p-7 hover:border-signal hover:shadow-lg hover:shadow-signal/5 transition duration-300">
                    <div class="h-12 w-12 rounded-lg bg-midnight flex items-center justify-center mb-6">
                        <svg class="h-6 w-6 text-signal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <?php echo $icons[$service['icon']] ?? $icons['bolt']; ?>
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
