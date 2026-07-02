<?php
/**
 * ============================================================
 *  VURAL AĞ - HEADER (header.php)
 * ============================================================
 *  HTML başlangıcı, <head> bölümü ve responsive navbar.
 *  Her sayfanın en üstünde şu şekilde çağrılır:
 *
 *      require_once 'config.php';
 *      $page_title = 'Sayfa Adı';   // (opsiyonel)
 *      require 'header.php';
 * ============================================================
 */

// config.php dahil edilmeden header çağrılırsa hata vermesin diye güvence:
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/config.php';
}

// Sayfa başlığı tanımlanmadıysa varsayılanı kullan
$page_title = $page_title ?? SITE_NAME . ' — ' . SITE_TAGLINE;
?>
<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo SITE_NAME . ' - ' . SITE_TAGLINE; ?>. Volvo, Aviagen gibi global markaların çözüm ortağı.">

    <!-- Google Fonts: Saira (başlık) + Inter (metin) + IBM Plex Mono (teknik etiketler) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@500;600;700;800&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN) -->
    <!-- NOT: Trafik arttığında CDN yerine Tailwind CLI ile derlenmiş -->
    <!-- statik css dosyasına geçmen önerilir (performans + prod uyarısı için). -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Kurumsal renk paleti ve fontlar burada Tailwind'e tanıtılıyor.
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Antrasit / koyu gri tonları
                        ink:      '#15181D',   // En koyu zemin (footer, hero)
                        anthracite:'#1E232B',  // Kart / panel zemini
                        steel:    '#2A3038',   // Kenarlık, ayraç
                        // Gece mavisi tonları
                        midnight: '#0E1A2B',   // Hero degrade ucu
                        signal:   '#3D7DD8',   // Vurgu mavisi (buton, link)
                        signalDim:'#2C5FA8',   // Vurgu hover
                        // Açık alanlar
                        fog:      '#F4F5F7',   // Açık bölüm zemini
                        mist:     '#E6E8EC',   // Açık kenarlık
                    },
                    fontFamily: {
                        display: ['Saira', 'sans-serif'],
                        body:    ['Inter', 'sans-serif'],
                        mono:    ['"IBM Plex Mono"', 'monospace'],
                    },
                },
            },
        };
    </script>

    <style>
        /* Hero'daki teknik çizim hissi veren ince ızgara deseni */
        .blueprint-grid {
            background-image:
                linear-gradient(rgba(61,125,216,0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(61,125,216,0.07) 1px, transparent 1px);
            background-size: 48px 48px;
        }
        /* Hareket azaltma tercihi olan kullanıcılar için animasyonları kapat */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition: none !important; animation: none !important; }
        }
    </style>
</head>

<body class="font-body bg-fog text-ink antialiased">

<!-- ============================================================
     NAVBAR
     Koyu, yarı saydam ve blur'lu; transparan PNG logo koyu
     zeminde net görünür. Scroll'da sayfanın üstüne yapışır.
============================================================= -->
<header class="sticky top-0 z-50 bg-ink/90 backdrop-blur border-b border-steel">
    <nav class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 h-20">

        <!-- Logo -->
        <a href="index.php" class="flex items-center gap-3 shrink-0">
            <img src="<?php echo LOGO_PATH; ?>"
                 alt="<?php echo SITE_NAME; ?> Logo"
                 class="h-11 w-auto"
                 onerror="this.style.display='none'; document.getElementById('logo-fallback').style.display='block';">
            <!-- Logo dosyası henüz yüklenmediyse yazı ile yedek göster -->
            <span id="logo-fallback" style="display:none;"
                  class="font-display font-800 text-xl tracking-wide text-white uppercase">
                Vural<span class="text-signal">Ağ</span>
            </span>
        </a>

        <!-- Masaüstü Menü -->
        <ul class="hidden md:flex items-center gap-8">
            <?php foreach ($nav_links as $label => $url): ?>
                <li>
                    <a href="<?php echo $url; ?>"
                       class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
                        <?php echo $label; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li>
                <a href="index.php#iletisim"
                   class="inline-flex items-center rounded-md bg-signal hover:bg-signalDim px-4 py-2 text-sm font-semibold text-white transition-colors">
                    Teklif Al
                </a>
            </li>
        </ul>

        <!-- Mobil Menü Butonu (hamburger) -->
        <button id="mobile-menu-btn" type="button"
                class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-300 hover:text-white hover:bg-steel transition-colors"
                aria-label="Menüyü aç/kapat" aria-expanded="false">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </nav>

    <!-- Mobil Menü Paneli -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-steel bg-ink">
        <ul class="px-4 py-4 space-y-2">
            <?php foreach ($nav_links as $label => $url): ?>
                <li>
                    <a href="<?php echo $url; ?>"
                       class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-steel transition-colors">
                        <?php echo $label; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li class="pt-2">
                <a href="index.php#iletisim"
                   class="block text-center rounded-md bg-signal hover:bg-signalDim px-3 py-2 text-base font-semibold text-white transition-colors">
                    Teklif Al
                </a>
            </li>
        </ul>
    </div>
</header>
