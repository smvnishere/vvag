<?php
/**
 * ============================================================
 *  TEKLİF FORMU API (contact-handler.php)  [v2]
 * ============================================================
 *  AJAX (fetch) ile çağrılır, JSON döner. Akış:
 *    1. Yalnızca POST kabul et
 *    2. CSRF token doğrula
 *    3. Honeypot bot kontrolü
 *    4. reCAPTCHA v3 doğrula (key tanımlıysa)
 *    5. Girdileri doğrula + temizle
 *    6. Veritabanına kaydet (prepared statement)
 *    7. E-posta gönder (PHPMailer / fallback mail())
 *    8. JSON yanıt döndür
 *
 *  Yanıt formatı: { "success": bool, "message": string }
 * ============================================================
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/csrf.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/mailer.php';

header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');

/** JSON yanıt gönderip çık. */
function respond(bool $success, string $message, int $httpCode = 200): void
{
    http_response_code($httpCode);
    echo json_encode(['success' => $success, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

// --- 1. Sadece POST ---
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    respond(false, 'Geçersiz istek yöntemi.', 405);
}

// --- 2. CSRF ---
if (!csrf_verify((string)($_POST['csrf_token'] ?? ''))) {
    respond(false, 'Oturum doğrulaması başarısız. Sayfayı yenileyip tekrar deneyin.', 403);
}

// --- 3. Honeypot (gizli alan doluysa bot) ---
if (!empty($_POST['website'])) {
    // Bota gerçek durumu belli etme
    respond(true, 'Talebiniz alındı.');
}

// --- 4. reCAPTCHA v3 (yalnızca key tanımlıysa) ---
if (RECAPTCHA_SECRET_KEY !== '') {
    $recaptchaToken = (string)($_POST['recaptcha_token'] ?? '');
    if ($recaptchaToken === '') {
        respond(false, 'Güvenlik doğrulaması eksik. Sayfayı yenileyin.', 400);
    }

    $verify = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt_array($verify, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query([
            'secret'   => RECAPTCHA_SECRET_KEY,
            'response' => $recaptchaToken,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
        ]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 8,
    ]);
    $result = json_decode((string)curl_exec($verify), true);
    curl_close($verify);

    $ok    = (bool)($result['success'] ?? false);
    $score = (float)($result['score'] ?? 0);
    if (!$ok || $score < RECAPTCHA_MIN_SCORE) {
        respond(false, 'Güvenlik doğrulaması başarısız oldu. Lütfen tekrar deneyin.', 403);
    }
}

// --- 5. Doğrulama + Temizlik ---
/** Kırp + satır sonu karakterlerini sök (header injection önlemi). */
function clean_line(string $v): string
{
    return str_replace(["\r", "\n", "%0a", "%0d"], '', trim($v));
}

$name    = clean_line((string)($_POST['name']    ?? ''));
$company = clean_line((string)($_POST['company'] ?? ''));
$email   = clean_line((string)($_POST['email']   ?? ''));
$phone   = clean_line((string)($_POST['phone']   ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

$errors = [];
if ($name === '' || mb_strlen($name) > 100)          $errors[] = 'Ad Soyad zorunludur (en fazla 100 karakter).';
if (!filter_var($email, FILTER_VALIDATE_EMAIL))       $errors[] = 'Geçerli bir e-posta adresi girin.';
if ($message === '' || mb_strlen($message) > 3000)    $errors[] = 'Proje detayı zorunludur (en fazla 3000 karakter).';
if (mb_strlen($company) > 100)                        $errors[] = 'Firma adı en fazla 100 karakter olabilir.';
if ($phone !== '' && !preg_match('/^[0-9+()\s-]{7,20}$/', $phone)) $errors[] = 'Telefon numarası geçersiz.';

if ($errors) {
    respond(false, implode(' ', $errors), 422);
}

// NOT (XSS): Veri DB'ye ham (temiz metin) kaydedilir; kaçış işlemi
// (htmlspecialchars) verinin EKRANA BASILDIĞI yerde yapılır.
// Bu, "sanitize on output" prensibidir ve verinin bozulmasını önler.

// --- 6. Veritabanına kaydet ---
try {
    $pdo  = get_db();
    $stmt = $pdo->prepare("
        INSERT INTO quotes (name, company, email, phone, message, ip, user_agent)
        VALUES (:name, :company, :email, :phone, :message, :ip, :ua)
    ");
    $stmt->execute([
        ':name'    => $name,
        ':company' => $company,
        ':email'   => $email,
        ':phone'   => $phone,
        ':message' => $message,
        ':ip'      => $_SERVER['REMOTE_ADDR'] ?? null,
        ':ua'      => mb_substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
    ]);
} catch (Throwable $e) {
    error_log('DB hata: ' . $e->getMessage());
    respond(false, 'Talebiniz şu an kaydedilemedi. Lütfen daha sonra tekrar deneyin.', 500);
}

// --- 7. E-posta gönder ---
// DB kaydı başarılıysa mail hatası kullanıcıya "hata" olarak dönmez;
// talep zaten güvende, mail sadece bildirimdir.
$mailSent = send_quote_mail($name, $company, $email, $phone, $message);
if (!$mailSent) {
    error_log('Mail gönderilemedi; talep DB kaydı ID ile güvende.');
}

// --- 8. Başarı ---
respond(true, 'Talebiniz başarıyla alındı. En kısa sürede size dönüş yapacağız.');
