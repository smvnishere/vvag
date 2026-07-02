<?php
/**
 * ============================================================
 *  VURAL AĞ - FORM İŞLEYİCİ (contact-handler.php)
 * ============================================================
 *  index.php'deki teklif formundan gelen POST verisini:
 *    1. Doğrular (zorunlu alanlar, e-posta formatı)
 *    2. Temizler (header injection ve XSS'e karşı)
 *    3. Honeypot ile bot kontrolü yapar
 *    4. FORM_RECIPIENT adresine e-posta gönderir
 *    5. Sonucu ?form=success|error ile index.php'ye döndürür
 *
 *  NOT: mail() fonksiyonu sunucunun mail yapılandırmasına
 *  bağlıdır. Paylaşımlı hostinglerde genelde çalışır; sorun
 *  yaşarsan PHPMailer + SMTP'ye geçmen en sağlıklısı olur.
 * ============================================================
 */

require_once __DIR__ . '/config.php';

// --- Yardımcı: kullanıcıyı sonuçla birlikte ana sayfaya döndür ---
function redirect_with(string $status): void
{
    header('Location: index.php?form=' . $status . '#iletisim-form');
    exit;
}

// --- 1. Sadece POST isteklerini kabul et ---
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    redirect_with('error');
}

// --- 2. Honeypot kontrolü ---
// 'website' alanı formda gizlidir; doluysa gönderen bir bottur.
if (!empty($_POST['website'])) {
    // Bota hata göstermeden sessizce "başarılı" de, e-posta gönderme.
    redirect_with('success');
}

// --- 3. Veriyi al ve temizle ---
/**
 * Girdiyi kırpar ve e-posta header injection'a yol açabilecek
 * satır sonu karakterlerini temizler.
 */
function clean_input(string $value): string
{
    $value = trim($value);
    return str_replace(["\r", "\n", "%0a", "%0d"], '', $value);
}

$name    = clean_input($_POST['name']    ?? '');
$company = clean_input($_POST['company'] ?? '');
$email   = clean_input($_POST['email']   ?? '');
$phone   = clean_input($_POST['phone']   ?? '');
$message = trim($_POST['message'] ?? ''); // Mesaj gövdesinde satır sonu serbest

// --- 4. Doğrulama ---
if (
    $name === '' || $email === '' || $message === ''      // Zorunlu alanlar
    || !filter_var($email, FILTER_VALIDATE_EMAIL)          // Geçerli e-posta
    || mb_strlen($name) > 100
    || mb_strlen($company) > 100
    || mb_strlen($phone) > 20
    || mb_strlen($message) > 3000
) {
    redirect_with('error');
}

// --- 5. E-postayı hazırla ---
$subject = '[' . SITE_NAME . '] Yeni Teklif Talebi - ' . $name;

$body  = "Web sitesi üzerinden yeni bir teklif talebi alındı.\n";
$body .= "------------------------------------------------\n";
$body .= "Ad Soyad : {$name}\n";
$body .= "Firma    : " . ($company !== '' ? $company : '-') . "\n";
$body .= "E-posta  : {$email}\n";
$body .= "Telefon  : " . ($phone !== '' ? $phone : '-') . "\n";
$body .= "Tarih    : " . date('d.m.Y H:i') . "\n";
$body .= "------------------------------------------------\n\n";
$body .= "Proje Detayı:\n{$message}\n";

// From adresi kendi domaininden olmalı (SPF/DKIM uyumu için).
// Kullanıcının e-postası Reply-To'ya konur; böylece "Yanıtla"
// dediğinde direkt müşteriye yazarsın.
$headers  = "From: " . SITE_NAME . " <no-reply@" . parse_url(SITE_URL, PHP_URL_HOST) . ">\r\n";
$headers .= "Reply-To: {$name} <{$email}>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// --- 6. Gönder ve sonucu bildir ---
$sent = @mail(FORM_RECIPIENT, $subject, $body, $headers);

redirect_with($sent ? 'success' : 'error');
