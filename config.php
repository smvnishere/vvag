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
// Render > Environment'tan FORM_RECIPIENT ile değiştirilebilir.
define('FORM_RECIPIENT', getenv('FORM_RECIPIENT') ?: 'smvnhere@gmail.com');

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
    ['name' => 'Volvo',          'logo' => 'assets/refs/volvo.png'],
    ['name' => 'Aviagen',        'logo' => 'assets/refs/aviagen.png'],
    ['name' => 'Altaş Elektrik', 'logo' => 'assets/refs/altas.png'],
    ['name' => 'Optimum AVM',    'logo' => 'assets/refs/optimum.png'],
    ['name' => 'Caesar',         'logo' => 'assets/refs/Caesar.png'],
    ['name' => 'Muradiye',       'logo' => 'assets/refs/muradiye.png'],
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

// ============================================================
//  SEO HİZMET SAYFALARI
// ============================================================
// Her anahtar kelime grubu için ayrı bir sayfa üretilir:
//   site.com/hizmet.php?slug=balkon-filesi
//   (.htaccess aktifse: site.com/balkon-filesi)
// Yeni kelimede sıralama almak için buraya yeni blok ekle,
// sitemap.xml'e URL'sini yaz, bitti.
// ============================================================
$seo_pages = [
    'balkon-filesi' => [
        'title'     => 'Balkon Filesi Montajı Ankara | ' . SITE_NAME,
        'meta_desc' => 'Ankara balkon filesi montajı: kuş ve güvercin önleyici, çocuk güvenlikli balkon ağı. Ücretsiz keşif, garantili montaj. Hemen teklif alın.',
        'h1'        => 'Balkon Filesi Montajı',
        'intro'     => 'Balkonunuzu güvercin ve kuş kirliliğinden koruyan, çocuklarınız ve evcil hayvanlarınız için güvenli hale getiren profesyonel balkon filesi montajı yapıyoruz. Ankara genelinde ücretsiz keşif sonrası balkonunuza özel ölçüyle kurulum tamamlanır.',
        'sections'  => [
            'Neden Balkon Filesi?' => "Açık balkonlar güvercin ve kuşların tünemesi nedeniyle sürekli kirlenir; kuş dışkısı hem görüntü kirliliği yaratır hem sağlık riski taşır. Balkon filesi bu sorunu kalıcı olarak çözer. Aynı zamanda küçük çocuklu ve evcil hayvanlı evlerde düşme riskini ortadan kaldırarak balkonu güvenli bir yaşam alanına çevirir.",
            'Kullandığımız Malzeme' => "UV katkılı, güneşe ve yağmura dayanıklı polietilen file kullanıyoruz; sararma ve çürüme yapmaz. Şeffafa yakın renk seçenekleri sayesinde manzaranızı kapatmaz, binanın dış görünümünü bozmaz. Paslanmaz halka ve çelik gergi teli ile monte edilir, yıllarca sarkma yapmaz.",
            'Montaj Süreci' => "Ücretsiz keşifte balkonunuzun ölçüsü alınır ve net fiyat verilir. Montaj çoğu balkonda kısa sürede, delme-kırma olmadan tamamlanır. İşçilik ve malzeme garantilidir.",
        ],
    ],
    'kedi-filesi' => [
        'title'     => 'Kedi Filesi - Pencere ve Balkon Kedi Güvenlik Ağı | ' . SITE_NAME,
        'meta_desc' => 'Kedi filesi montajı: pencere ve balkonlar için yırtılmaz kedi güvenlik ağı. Kediniz düşmesin, pencereniz açık kalsın. Ankara genelinde montaj.',
        'h1'        => 'Kedi Filesi & Kedi Güvenlik Ağı',
        'intro'     => 'Yüksek kat penceresi ve balkonlar kediler için ciddi düşme riski taşır. Kedi filesi, pencerelerinizi ve balkonunuzu gönül rahatlığıyla açık bırakmanızı sağlar; kediniz özgürce gezer, siz güvende olduğunu bilirsiniz.',
        'sections'  => [
            'Kedi Güvenliği İçin Neden Şart?' => "Veteriner hekimlerin \"yüksek kat sendromu\" olarak adlandırdığı düşme vakaları, özellikle ilkbahar ve yaz aylarında açık pencerelerden kaynaklanır. Kediler dengesine güvenir ama sineklik ve standart pencere onları taşımaz. Kedi filesi bu riski sıfıra indirir.",
            'Standart Fileden Farkı' => "Kedi filesi, normal balkon filesinden daha kalın iplikli ve pençe darbelerine dayanıklı dokuma ile üretilir. Kediniz tırmansa, assa, ısırsa bile yırtılmaz. Gerdirmeli montaj sayesinde kedi ağırlığıyla esneyip boşluk oluşturmaz.",
            'Nerelere Uygulanır?' => "Pencere içleri, balkonlar, teras kenarları ve merdiven korkulukları başlıca uygulama alanlarıdır. Kiracıysanız delmesiz montaj seçeneklerimizi sorabilirsiniz; taşınırken iz bırakmadan sökülür.",
        ],
    ],
    'guvenlik-filesi' => [
        'title'     => 'Güvenlik Filesi ve Güvenlik Ağı Montajı | ' . SITE_NAME,
        'meta_desc' => 'Güvenlik filesi montajı: fabrika, depo, şantiye, merdiven boşluğu ve her alanda TS EN 1263 standardında güvenlik ağı. Keşif ücretsiz.',
        'h1'        => 'Güvenlik Filesi & Güvenlik Ağı Montajı',
        'intro'     => 'Endüstriyel tesislerden konutlara kadar her alanda, insan ve malzeme düşmesine karşı koruma sağlayan güvenlik filesi sistemleri kuruyoruz. Volvo ve Aviagen gibi global üreticilerin tesislerinde edindiğimiz saha tecrübesini her ölçekte projeye taşıyoruz.',
        'sections'  => [
            'Uygulama Alanları' => "Fabrika ve depolarda raf arkası malzeme düşme koruması, şantiyelerde yatay ve dikey iş güvenliği ağları, bina içlerinde merdiven ve asansör boşluğu koruması, spor tesislerinde saha çevresi fileleri başlıca çalışma alanlarımızdır.",
            'Standart ve Sertifikasyon' => "İş güvenliği amaçlı ağlarda TS EN 1263-1 standardına uygun, test sertifikalı malzeme kullanıyoruz. Montaj sonrası talep halinde uygulama raporu düzenlenir; İSG denetimlerinde belgeleriniz hazır olur.",
            'Keşif ve Projelendirme' => "Her alanın yük ve risk profili farklıdır. Ücretsiz keşifte alanınıza uygun ağ tipi, göz aralığı ve bağlantı sistemi belirlenir; size net fiyat ve süre verilir.",
        ],
    ],
    'insaat-guvenlik-agi' => [
        'title'     => 'İnşaat Güvenlik Ağı Montajı | ' . SITE_NAME,
        'meta_desc' => 'İnşaat güvenlik ağı: şantiyelerde cephe, döşeme kenarı ve boşluklar için TS EN 1263 uyumlu yatay-dikey güvenlik ağı montajı ve söküm hizmeti.',
        'h1'        => 'İnşaat Güvenlik Ağı Montajı',
        'intro'     => 'Şantiyelerde yüksekten düşme, iş kazalarının bir numaralı nedenidir. Cephe, döşeme kenarı ve boşluklarda kurduğumuz güvenlik ağı sistemleriyle hem çalışanlarınızı koruyor hem İSG mevzuatı yükümlülüklerinizi karşılıyoruz.',
        'sections'  => [
            'Yatay ve Dikey Sistemler' => "Döşeme kenarlarında ve kat aralarında yatay toplama ağları (catch net), cephelerde dikey koruma ağları uyguluyoruz. Sistem seçimi projenin yapısına ve iş programına göre keşifte belirlenir.",
            'Şantiye Takvimine Uyum' => "Kat ilerledikçe ağların taşınması ve yeniden kurulumu ekibimizce yapılır; kaba inşaat bitiminde söküm hizmeti veriyoruz. Şantiyenizin temposunu yavaşlatmadan çalışırız.",
            'Belgelendirme' => "Kullanılan tüm ağlar TS EN 1263-1 test sertifikalıdır. Montaj sonrası uygulama tutanağı düzenlenir; iş güvenliği uzmanınızın dosyasına hazır belge teslim edilir.",
        ],
    ],
];
