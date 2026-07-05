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
define('SITE_TAGLINE', 'Endüstriyel Güvenlik Ağı & File Montaj Sistemleri');
define('SITE_URL',     'https://www.vuralag.com'); // Kendi domainini yaz
define('LOGO_PATH',    'assets/logo.png');          // Transparan PNG logo yolu

// --- İletişim Bilgileri ---
define('CONTACT_PHONE',   '+90 (541) 802 39 38');
define('CONTACT_PHONE_RAW', '+905418023938'); // tel: linki için boşluksuz format
define('CONTACT_EMAIL',   'vural_ag@outlook.com');
define('CONTACT_ADDRESS', 'Fevzi Çakmak, 16. Cadde no:21, 06370 Sincan/Ankara');

// --- Form gönderimlerinin ulaşacağı e-posta ---
define('FORM_RECIPIENT', 'smvnhere@gmail.com');

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
    ['name' => 'Altaş Elektrik', 'logo' => 'assets/refs/altas.png'],
    ['name' => 'Optimum AVM', 'logo' => 'assets/refs/optimum.png'],
    ['name' => 'Caesar', 'logo' => 'assets/refs/Caesar.png'],
    ['name' => 'Muradiye', 'logo' => 'assets/refs/muradiye.png'],
];

// --- Hizmetler ---
// 'icon' alanı inline SVG anahtarıdır (index.php içinde eşleşir).
$services = [
    [
        'title'   => 'Fabrika & Tesis Güvenlik Ağları',
        'desc'    => 'Üretim tesisleri, depolar ve raf sistemleri için düşme ve malzeme düşmesine karşı koruyucu ağ montajı.',
        'icon'    => 'net',
        'details' => "Üretim tesislerinde çalışan güvenliği ve ürün koruması için tavan altı, raf arkası ve platform kenarı ağ sistemleri kuruyoruz. Keşif sonrası tesise özel ölçülendirme yapılır; ağlar TS EN 1263-1 standardına uygun malzeme ile monte edilir.\n\n• Raf arkası malzeme düşme koruma ağları\n• Tavan altı ve asma kat koruma sistemleri\n• Platform ve yürüyüş yolu kenar ağları\n• Makine çevresi ayırıcı file uygulamaları",
    ],
    [
        'title'   => 'İnşaat Güvenlik Ağları',
        'desc'    => 'Şantiyelerde yatay ve dikey güvenlik ağı kurulumu; cephe, döşeme kenarı ve boşluk korumaları.',
        'icon'    => 'frame',
        'details' => "Şantiyelerde yüksekten düşmeye karşı yatay (catch net) ve dikey (cephe) güvenlik ağı sistemleri uyguluyoruz. Kurulum, İSG mevzuatı ve şantiye iş programı ile uyumlu şekilde planlanır.\n\n• Döşeme kenarı ve cephe koruma ağları\n• Kat aralarında yatay güvenlik ağları\n• Şaft ve boşluk kapatma uygulamaları\n• Söküm ve kat ilerledikçe yeniden kurulum hizmeti",
    ],
    [
        'title'   => 'Merdiven & Asansör Boşluğu Ağları',
        'desc'    => 'Bina içi merdiven ve asansör boşluklarında standartlara uygun düşüş önleyici ağ uygulaması.',
        'icon'    => 'shield',
        'details' => "Bina içi merdiven boşlukları ile asansör kuyularında düşme riskini ortadan kaldıran ağ sistemleri kuruyoruz. Konut, ofis ve endüstriyel yapılarda hem geçici (inşaat süreci) hem kalıcı çözümler sunuyoruz.\n\n• Merdiven boşluğu düşüş önleyici ağlar\n• Asansör kuyusu geçici koruma sistemleri\n• Galeri ve atrium boşluğu ağları\n• Estetik, mimariyle uyumlu kalıcı uygulamalar",
    ],
    [
        'title'   => 'Bakım & Periyodik Kontrol',
        'desc'    => 'Mevcut ağ sistemlerinin kontrolü, yıpranan filelerin değişimi ve sezonluk bakım hizmetleri.',
        'icon'    => 'wrench',
        'details' => "Kurulu ağ sistemleri zamanla UV, hava koşulları ve mekanik yük nedeniyle mukavemet kaybeder. Periyodik kontrol programımızla ağlarınızın koruma kapasitesini sürekli standart seviyesinde tutuyoruz.\n\n• Yıllık / 6 aylık periyodik kontrol raporlaması\n• Yıpranan file ve halat değişimi\n• Bağlantı elemanı ve ankraj kontrolü\n• Acil müdahale ve onarım hizmeti",
    ],
];

// ============================================================
//  GELİŞMİŞ AYARLAR (v2 - DB / SMTP / reCAPTCHA)
// ============================================================

// --- Veritabanı (SQLite) ---
// Render'da Persistent Disk kullanıyorsan mount noktasını
// DB_DIR env değişkeni ile ver (örn: /var/data). Verilmezse
// proje içindeki data/ klasörü kullanılır (deploy'da sıfırlanır!).
define('DB_DIR',  getenv('DB_DIR') ?: __DIR__ . '/data');
define('DB_PATH', DB_DIR . '/quotes.sqlite');

// --- SMTP (PHPMailer) ---
// Bilgileri env değişkenlerinden okur; yoksa buradaki varsayılanlar.
// Env kullanmak Render'da en doğru yöntem (Environment > Add Variable).
define('SMTP_HOST',   getenv('SMTP_HOST')   ?: 'smtp.example.com');
define('SMTP_PORT',   (int)(getenv('SMTP_PORT') ?: 587));
define('SMTP_USER',   getenv('SMTP_USER')   ?: 'no-reply@vuralag.com');
define('SMTP_PASS',   getenv('SMTP_PASS')   ?: '');
define('SMTP_SECURE', getenv('SMTP_SECURE') ?: 'tls'); // 'tls' (587) veya 'ssl' (465)

// --- Google reCAPTCHA v3 ---
// Key'ler boşsa sistem otomatik devre dışı kalır, form yine çalışır.
// https://www.google.com/recaptcha/admin adresinden v3 key al.
define('RECAPTCHA_SITE_KEY',   getenv('RECAPTCHA_SITE_KEY')   ?: '');
define('RECAPTCHA_SECRET_KEY', getenv('RECAPTCHA_SECRET_KEY') ?: '');
define('RECAPTCHA_MIN_SCORE',  0.5); // 0-1 arası; düşük skor = bot şüphesi
