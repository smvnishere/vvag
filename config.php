<?php
/**
 * ============================================================
 *  VURAL AĞ - GLOBAL AYAR DOSYASI (config.php)
 * ============================================================
 *  Sitenin tüm sayfalarında kullanılan global değişkenler.
 *  Firma bilgisi değiştiğinde SADECE bu dosyayı güncelle,
 *  tüm site otomatik olarak yeni bilgiyi kullanır.
 * ============================================================
 */

// --- Hata raporlama (Canlıya alırken 0 yap) ---
error_reporting(E_ALL);
ini_set('display_errors', '1');

// --- Temel Site Bilgileri ---
define('SITE_NAME',    'Vural Ağ');
define('SITE_TAGLINE', 'Endüstriyel Montaj & Mühendislik Çözümleri');
define('SITE_URL',     'https://www.vuralag.com'); // Kendi domainini yaz
define('LOGO_PATH',    'assets/logo.png');          // Transparan PNG logo yolu

// --- İletişim Bilgileri ---
define('CONTACT_PHONE',   '+90 (312) 000 00 00');
define('CONTACT_PHONE_RAW', '+903120000000'); // tel: linki için boşluksuz format
define('CONTACT_EMAIL',   'info@vuralag.com');
define('CONTACT_ADDRESS', 'Organize Sanayi Bölgesi, 1. Cadde No: 00, Sincan / Ankara');

// --- Form gönderimlerinin ulaşacağı e-posta ---
define('FORM_RECIPIENT', 'teklif@vuralag.com');

// --- Sosyal Medya (boş bırakılan gösterilmez) ---
$social_links = [
    'linkedin'  => 'https://www.linkedin.com/company/vuralag',
    'instagram' => '',
];

// --- Navigasyon Menüsü ---
// Yeni sayfa eklemek istediğinde buraya satır eklemen yeterli.
$nav_links = [
    'Ana Sayfa'    => 'index.php',
    'Hizmetler'    => 'index.php#hizmetler',
    'Referanslar'  => 'index.php#referanslar',
    'İletişim'     => 'index.php#iletisim',
];

// --- Kurumsal Referanslar ---
// Logo dosyalarını assets/refs/ klasörüne at, buraya yolunu yaz.
$references = [
    ['name' => 'Volvo',    'logo' => 'assets/refs/volvo.png'],
    ['name' => 'Aviagen',  'logo' => 'assets/refs/aviagen.png'],
    ['name' => 'Referans 3', 'logo' => 'assets/refs/ref3.png'],
    ['name' => 'Referans 4', 'logo' => 'assets/refs/ref4.png'],
    ['name' => 'Referans 5', 'logo' => 'assets/refs/ref5.png'],
    ['name' => 'Referans 6', 'logo' => 'assets/refs/ref6.png'],
];

// --- Hizmetler ---
// 'icon' alanı inline SVG anahtarıdır (index.php içinde eşleşir).
$services = [
    [
        'title' => 'Endüstriyel Montaj',
        'desc'  => 'Üretim hatları, konveyör sistemleri ve ağır makine montajında anahtar teslim uygulama.',
        'icon'  => 'bolt',
    ],
    [
        'title' => 'Çelik Konstrüksiyon',
        'desc'  => 'Fabrika binaları, platformlar ve taşıyıcı sistemler için projelendirme ve saha kurulumu.',
        'icon'  => 'frame',
    ],
    [
        'title' => 'Mekanik Tesisat',
        'desc'  => 'Basınçlı hava, hidrolik ve proses boru hatlarının kurulumu, testi ve devreye alınması.',
        'icon'  => 'pipe',
    ],
    [
        'title' => 'Bakım & Revizyon',
        'desc'  => 'Planlı duruşlarda hat revizyonu, periyodik bakım ve acil müdahale hizmetleri.',
        'icon'  => 'wrench',
    ],
];
