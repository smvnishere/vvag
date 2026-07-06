<?php
/**
 * ============================================================
 *  SEO HİZMET SAYFASI ŞABLONU (hizmet.php)
 * ============================================================
 *  config.php'deki $seo_pages dizisinden beslenir.
 *  Çağrım: /hizmet.php?slug=balkon-filesi
 *  (.htaccess aktifse: /balkon-filesi)
 *
 *  Her sayfa kendi title, meta description, H1 ve içeriğiyle
 *  render edilir -> her anahtar kelime için ayrı indexlenebilir
 *  sayfa. Google'da jenerik kelimelerde sıralamanın temeli bu.
 * ============================================================
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/csrf.php';
$csrf = csrf_token(); // Session, çıktı başlamadan önce

// Slug'ı al ve doğrula; tanımsızsa 404
$slug = (string)($_GET['slug'] ?? '');
if (!isset($seo_pages[$slug])) {
    http_response_code(404);
    $page_title = 'Sayfa Bulunamadı | ' . SITE_NAME;
    require __DIR__ . '/header.php';
    echo '<section class="max-w-3xl mx-auto px-4 py-40 text-center">
            <h1 class="font-display font-bold text-4xl text-white">404</h1>
            <p class="mt-4 text-gray-400">Aradığınız sayfa bulunamadı.</p>
            <a href="index.php" class="btn-glow inline-flex mt-8 rounded-lg bg-signal px-6 py-3 font-bold text-abyss">Ana Sayfaya Dön</a>
          </section>';
    require __DIR__ . '/footer.php';
    exit;
}

$page       = $seo_pages[$slug];
$page_title = $page['title'];
$meta_desc  = $page['meta_desc'];
$canonical  = SITE_URL . '/' . $slug; // .htaccess'siz kurulumda da canonical temiz URL'yi göstersin

require __DIR__ . '/header.php';
?>

<!-- Sayfa başlığı (koyu hero şeridi) -->
<section class="relative bg-gradient-to-br from-ink to-midnight overflow-hidden border-b border-white/5">
    <div class="absolute inset-0 blueprint-grid" aria-hidden="true"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <p class="font-mono text-xs tracking-[0.3em] uppercase text-signal mb-5">
            <?php echo SITE_NAME; ?> Hizmetleri
        </p>
        <h1 class="font-display font-extrabold tracking-tight text-4xl sm:text-5xl text-white">
            <?php echo htmlspecialchars($page['h1']); ?>
        </h1>
        <p class="mt-6 text-lg text-gray-300 leading-relaxed">
            <?php echo htmlspecialchars($page['intro']); ?>
        </p>
        <a href="index.php#iletisim-form"
           class="btn-glow inline-flex mt-10 rounded-lg bg-signal hover:bg-signalDim px-7 py-3.5 font-bold text-abyss">
            Ücretsiz Keşif ve Teklif
        </a>
    </div>
</section>

<!-- İçerik bölümleri -->
<section class="bg-abyss">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-14">
        <?php foreach ($page['sections'] as $heading => $text): ?>
            <div>
                <h2 class="font-display font-bold text-2xl text-white mb-4">
                    <?php echo htmlspecialchars($heading); ?>
                </h2>
                <p class="text-gray-400 leading-relaxed">
                    <?php echo htmlspecialchars($text); ?>
                </p>
            </div>
        <?php endforeach; ?>

        <!-- Diğer hizmetlere iç bağlantılar (SEO: internal linking) -->
        <div class="pt-10 border-t border-white/5">
            <h2 class="font-mono text-xs tracking-[0.3em] uppercase text-signal mb-6">Diğer Hizmetlerimiz</h2>
            <div class="flex flex-wrap gap-3">
                <?php foreach ($seo_pages as $s => $p): if ($s === $slug) continue; ?>
                    <a href="hizmet.php?slug=<?php echo $s; ?>"
                       class="rounded-lg border border-white/10 hover:border-signal/60 bg-white/[0.04] px-4 py-2 text-sm text-gray-300 hover:text-white transition-colors">
                        <?php echo htmlspecialchars($p['h1']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Kapanış CTA -->
<section class="bg-ink border-t border-white/5">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <h2 class="font-display font-bold text-2xl sm:text-3xl text-white">
            Projeniz için ücretsiz keşif isteyin
        </h2>
        <p class="mt-3 text-gray-400">Aynı gün dönüş, net fiyat, garantili montaj.</p>
        <a href="index.php#iletisim-form"
           class="btn-glow inline-flex mt-8 rounded-lg bg-signal hover:bg-signalDim px-8 py-4 font-bold text-abyss">
            Teklif Al
        </a>
    </div>
</section>

<?php require __DIR__ . '/footer.php'; ?>
