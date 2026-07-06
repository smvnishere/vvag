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
    <meta name="description" content="<?php echo htmlspecialchars($meta_desc ?? SITE_NAME . ' — ' . SITE_TAGLINE . '. Ankara merkezli; fabrika, şantiye ve bina içi güvenlik ağı, file montajı ve düşüş koruma sistemleri.'); ?>">

    <!-- SEO: Canonical (kopya içerik sinyalini önler) -->
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical ?? SITE_URL . '/'); ?>">

    <!-- SEO: Open Graph (WhatsApp/sosyal medya paylaşım kartı) -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo SITE_TAGLINE; ?>. Fabrika, şantiye ve bina içi güvenlik ağı montajı.">
    <meta property="og:url" content="<?php echo SITE_URL; ?>/">
    <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/og-image.jpg">
    <meta property="og:locale" content="tr_TR">

    <!-- SEO: JSON-LD Yapısal Veri (Google'ın işletmeyi tanıması için) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "<?php echo SITE_NAME; ?>",
        "description": "<?php echo SITE_TAGLINE; ?>",
        "url": "<?php echo SITE_URL; ?>",
        "telephone": "<?php echo CONTACT_PHONE_RAW; ?>",
        "email": "<?php echo CONTACT_EMAIL; ?>",
        "image": "<?php echo SITE_URL; ?>/assets/og-image.jpg",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?php echo CONTACT_ADDRESS; ?>",
            "addressLocality": "Ankara",
            "addressCountry": "TR"
        },
        "areaServed": "TR",
        "knowsAbout": ["güvenlik ağı montajı", "file montajı", "inşaat güvenlik ağı", "düşüş koruma sistemleri"]
    }
    </script>

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
                        // Derin füme / slate tonları (siyah değil, derinlikli koyu gri)
                        abyss:     '#0B0E13',   // Sayfa zemini (en derin ton)
                        ink:       '#12161D',   // Nav, footer, ara bölümler
                        anthracite:'#1B212B',   // Kart / panel / form zemini
                        steel:     '#2B333F',   // Kenarlık, ayraç
                        midnight:  '#0E141D',   // Degrade ucu
                        // Vurgu: Güvenlik Turuncusu (Safety Orange)
                        signal:    '#FF7A00',   // Buton, link, ikon
                        signalDim: '#FF9633',   // Hover (daha parlak varyant)
                        // Açık tonlar (nadiren, kontrast gereken yerlerde)
                        fog:       '#F4F5F7',
                        mist:      '#E6E8EC',
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

    <?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY !== ''): ?>
    <!-- Google reCAPTCHA v3 (görünmez) - key config'te tanımlıysa yüklenir -->
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_SITE_KEY; ?>" defer></script>
    <?php endif; ?>

    <style>
        /* Hero'daki teknik çizim hissi veren ince ızgara deseni (turuncu tint) */
        .blueprint-grid {
            background-image:
                linear-gradient(rgba(255,122,0,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,122,0,0.05) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* --- Vurgu butonu: hover'da turuncu dış ışıma (glow) --- */
        .btn-glow {
            transition: transform .3s cubic-bezier(.22,.61,.36,1),
                        box-shadow .3s ease, background-color .3s ease;
        }
        .btn-glow:hover {
            box-shadow: 0 0 30px rgba(255,122,0,.45), 0 4px 16px rgba(0,0,0,.4);
        }

        /* --- Hizmet kartı: kalkma + turuncu dış ışıma --- */
        .service-card {
            transition: transform .35s cubic-bezier(.22,.61,.36,1),
                        box-shadow .35s ease, border-color .35s ease,
                        background-color .35s ease;
            will-change: transform;
        }
        .service-card:hover {
            transform: translateY(-8px); /* -translate-y-2 */
            box-shadow: 0 24px 48px -16px rgba(0,0,0,.65),
                        0 0 28px rgba(255,122,0,.14);
        }
        .service-card .service-icon {
            transition: transform .35s cubic-bezier(.34,1.56,.64,1), background-color .35s ease;
        }
        .service-card:hover .service-icon {
            transform: scale(1.06) rotate(-3deg);
        }

        /* --- Referans logoları: her zaman beyaz silüet ---
           Hover'da orijinal renge dönmüyoruz çünkü siyah logolar
           (Altaş gibi) koyu zeminde kaybolur. Hover = tam parlaklık. */
        .ref-logo {
            filter: brightness(0) invert(1);
            opacity: .55;
            transition: opacity .35s ease, transform .35s ease;
        }
        .ref-logo:hover {
            opacity: 1;
            transform: scale(1.05);
        }

        /* --- Premium form inputları: kenarlıksız, focus'ta turuncu aydınlanma --- */
        .premium-input {
            border: 2px solid transparent; /* Layout shift olmasın diye şeffaf tutulur */
            transition: border-color .25s ease, box-shadow .25s ease, background-color .25s ease;
        }
        .premium-input:focus {
            border-color: #FF7A00;
            box-shadow: 0 0 0 4px rgba(255,122,0,.12), 0 0 20px rgba(255,122,0,.10);
        }

        /* --- Modal geçişleri --- */
        .modal-backdrop { transition: opacity .25s ease; }
        .modal-panel {
            transition: opacity .25s ease, transform .25s cubic-bezier(.22,.61,.36,1);
        }
        .modal-hidden .modal-backdrop { opacity: 0; }
        .modal-hidden .modal-panel   { opacity: 0; transform: translateY(16px) scale(.98); }

        /* --- Form durum mesajı geçişi --- */
        #form-status { transition: opacity .3s ease, transform .3s ease; }
        #form-status.status-hidden { opacity: 0; transform: translateY(-4px); }

        /* Hareket azaltma tercihi olan kullanıcılar için animasyonları kapat */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition: none !important; animation: none !important; }
        }
    </style>
</head>

<body class="font-body bg-abyss text-gray-200 antialiased">

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
                   class="btn-glow inline-flex items-center rounded-md bg-signal hover:bg-signalDim px-4 py-2 text-sm font-bold text-abyss">
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
                   class="btn-glow block text-center rounded-md bg-signal hover:bg-signalDim px-3 py-2 text-base font-bold text-abyss">
                    Teklif Al
                </a>
            </li>
        </ul>
    </div>
</header>
