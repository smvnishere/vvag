# Vural Ağ — v2 Kurulum ve Yapılandırma

## Dosya Yapısı
```
/
├── config.php              # Tüm ayarlar (DB, SMTP, reCAPTCHA dahil)
├── header.php / footer.php # Şablon parçaları
├── index.php               # Ana sayfa (AJAX form + modal)
├── contact-handler.php     # JSON API (CSRF + reCAPTCHA + DB + mail)
├── includes/
│   ├── db.php              # PDO SQLite bağlantısı (otomatik şema)
│   ├── csrf.php            # CSRF token üretim/doğrulama
│   └── mailer.php          # PHPMailer + mail() fallback
├── data/                   # SQLite dosyası (web erişimi .htaccess ile kapalı)
├── tests/test_form.sh      # Otomatik API smoke testleri
├── optimize.sh             # WebP dönüşümü + Tailwind minify
├── tailwind.config.js      # CLI derlemesi için config
└── composer.json           # PHPMailer bağımlılığı
```

## 1. Kurulum
```bash
composer install          # PHPMailer'ı kurar (vendor/ oluşur)
php -S localhost:8000     # Lokal test sunucusu
bash tests/test_form.sh http://localhost:8000
```

## 2. Render'a Özel KRİTİK Notlar
- **Dosya sistemi ephemeral'dır**: her deploy'da `data/quotes.sqlite` SİLİNİR.
  Kalıcılık için: Dashboard > Disks > Add Disk (örn. mount path `/var/data`),
  sonra Environment'a `DB_DIR=/var/data` ekle. Kod bunu otomatik kullanır.
- SMTP/reCAPTCHA bilgilerini koda değil **Environment Variables**'a gir:
  `SMTP_HOST, SMTP_PORT, SMTP_USER, SMTP_PASS, SMTP_SECURE,
   RECAPTCHA_SITE_KEY, RECAPTCHA_SECRET_KEY, DB_DIR`
- Dockerfile'ında composer varsa: `RUN composer install --no-dev --optimize-autoloader`

## 3. Mailin Spam'e Düşmemesi (SMTP + SPF + DKIM + DMARC)
`mail()` yerine SMTP kullanmak tek başına yetmez; DNS kayıtları şart.
Domain'inin (vuralag.com) DNS paneline şu kayıtları ekle:

**SPF (TXT kaydı, host: @):**
```
v=spf1 include:_spf.mail-saglayicin.com ~all
```
`include:` kısmı SMTP sağlayıcına göre değişir (ör. Google Workspace:
`include:_spf.google.com`, Yandex: `include:spf.yandex.net`).

**DKIM (TXT kaydı):** SMTP sağlayıcın sana `selector._domainkey` formatında
bir host adı ve `v=DKIM1; k=rsa; p=...` değeri verir; birebir yapıştır.
DKIM anahtarı sağlayıcı panelinden üretilir, elle yazılmaz.

**DMARC (TXT kaydı, host: _dmarc):**
```
v=DMARC1; p=quarantine; rua=mailto:postmaster@vuralag.com; adkim=s; aspf=s
```

**Altın kural:** `From` adresi mutlaka SMTP hesabıyla aynı domain olmalı
(kod bunu zaten `SMTP_USER` üzerinden yapıyor). Doğrulama için
https://www.mail-tester.com adresine test maili at; 10/10 hedefle.

## 4. Lighthouse +95 için Yol Haritası
1. `bash optimize.sh` çalıştır (WebP + minify CSS üretir).
2. header.php'den Tailwind CDN script'ini kaldırıp
   `<link rel="stylesheet" href="assets/site.min.css">` koy.
   (En büyük puan kaybı CDN'in runtime JIT derleyicisidir.)
3. Logo ve referans görsellerini WebP olarak kullan:
   ```html
   <picture>
     <source srcset="assets/refs/volvo.webp" type="image/webp">
     <img src="assets/refs/volvo.png" alt="Volvo" loading="lazy" width="160" height="48">
   </picture>
   ```
4. `width`/`height` attribute'ları layout shift'i (CLS) önler — ref
   logolarına eklendi, kendi görsellerinde de koru.

## 5. Kayıtları Görüntüleme
Sunucuda:
```bash
sqlite3 data/quotes.sqlite "SELECT id, name, email, created_at FROM quotes ORDER BY id DESC LIMIT 20;"
```
İstersen bir sonraki adımda basit, şifre korumalı bir `admin.php`
paneli ekleyebiliriz.
