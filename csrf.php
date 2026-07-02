<?php
/**
 * ============================================================
 *  CSRF KORUMASI (includes/csrf.php)
 * ============================================================
 *  Session tabanlı token üretimi ve doğrulaması.
 *
 *  Formda:   <input type="hidden" name="csrf_token"
 *                   value="<?php echo csrf_token(); ?>">
 *  Handler:  if (!csrf_verify($_POST['csrf_token'] ?? '')) { reddet }
 * ============================================================
 */

declare(strict_types=1);

/** Session'ı güvenli parametrelerle başlat (bir kez). */
function ensure_session(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start([
            'cookie_httponly' => true,   // JS cookie'yi okuyamaz
            'cookie_samesite' => 'Lax',  // Cross-site POST'ları engeller
            // HTTPS'de çalışıyorsan (Render zaten HTTPS) secure flag'i aç:
            'cookie_secure'   => !empty($_SERVER['HTTPS']),
        ]);
    }
}

/** Mevcut token'ı döndürür; yoksa üretir. */
function csrf_token(): string
{
    ensure_session();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Gelen token'ı zamanlama saldırısına dayanıklı şekilde karşılaştırır. */
function csrf_verify(string $token): bool
{
    ensure_session();
    return isset($_SESSION['csrf_token'])
        && $token !== ''
        && hash_equals($_SESSION['csrf_token'], $token);
}
