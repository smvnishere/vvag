<?php
/**
 * ============================================================
 *  MAİL GÖNDERİMİ (includes/mailer.php)
 * ============================================================
 *  Öncelik: PHPMailer + SMTP (spam'e düşmemenin tek sağlam yolu).
 *  PHPMailer kurulu değilse mail() fonksiyonuna düşer.
 *
 *  Kurulum (proje kökünde):
 *      composer require phpmailer/phpmailer
 *
 *  Dockerfile'a eklenecek satır örneği:
 *      RUN composer install --no-dev --optimize-autoloader
 * ============================================================
 */

declare(strict_types=1);

/**
 * Teklif e-postasını gönderir.
 * @return bool  Gönderim başarılı mı?
 */
function send_quote_mail(string $name, string $company, string $email, string $phone, string $message): bool
{
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

    $autoload = dirname(__DIR__) . '/vendor/autoload.php';
    $manual   = __DIR__ . '/phpmailer/PHPMailer.php'; // Composer'sız kurulum yolu

    // PHPMailer'ı yükle: önce composer (vendor/), yoksa elle kopyalanan dosyalar
    $phpmailerReady = false;
    if (file_exists($autoload)) {
        require_once $autoload;
        $phpmailerReady = true;
    } elseif (file_exists($manual)) {
        require_once __DIR__ . '/phpmailer/Exception.php';
        require_once __DIR__ . '/phpmailer/PHPMailer.php';
        require_once __DIR__ . '/phpmailer/SMTP.php';
        $phpmailerReady = true;
    }

    // --- 1. Tercih: PHPMailer + SMTP ---
    if ($phpmailerReady && SMTP_PASS !== '') {
        require_once $autoload;
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = SMTP_SECURE; // 'tls' veya 'ssl'
            $mail->Port       = SMTP_PORT;
            $mail->CharSet    = 'UTF-8';

            // From adresi MUTLAKA SMTP hesabının domain'i olmalı,
            // yoksa DMARC/SPF hizalaması bozulur ve spam'e düşer.
            $mail->setFrom(SMTP_USER, SITE_NAME);
            $mail->addAddress(FORM_RECIPIENT);
            $mail->addReplyTo($email, $name); // "Yanıtla" -> müşteriye gider

            $mail->Subject = $subject;
            $mail->Body    = $body;

            return $mail->send();
        } catch (Throwable $e) {
            error_log('PHPMailer hata: ' . $e->getMessage());
            return false;
        }
    }

    // --- 2. Fallback: yerleşik mail() ---
    $host    = parse_url(SITE_URL, PHP_URL_HOST) ?: 'localhost';
    $headers  = "From: " . SITE_NAME . " <no-reply@{$host}>\r\n";
    $headers .= "Reply-To: {$name} <{$email}>\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    return @mail(FORM_RECIPIENT, $subject, $body, $headers);
}
