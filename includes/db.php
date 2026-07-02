<?php
/**
 * ============================================================
 *  VERİTABANI BAĞLANTISI (includes/db.php)
 * ============================================================
 *  SQLite + PDO. İlk çalıştırmada dosyayı ve tabloyu otomatik
 *  oluşturur; ekstra kurulum gerektirmez.
 *
 *  Kullanım:
 *      require_once __DIR__ . '/includes/db.php';
 *      $pdo = get_db();
 * ============================================================
 */

declare(strict_types=1);

function get_db(): PDO
{
    static $pdo = null;

    // Aynı istek içinde tekrar tekrar bağlanma (singleton)
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    // data/ klasörü yoksa oluştur
    if (!is_dir(DB_DIR)) {
        mkdir(DB_DIR, 0775, true);
    }

    $pdo = new PDO('sqlite:' . DB_PATH, null, null, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Hatalarda exception fırlat
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Eşzamanlı yazmalarda kilitlenmeyi azaltır
    $pdo->exec('PRAGMA journal_mode = WAL;');
    $pdo->exec('PRAGMA busy_timeout = 5000;');

    // Tablo yoksa oluştur (idempotent)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS quotes (
            id         INTEGER PRIMARY KEY AUTOINCREMENT,
            name       TEXT    NOT NULL,
            company    TEXT,
            email      TEXT    NOT NULL,
            phone      TEXT,
            message    TEXT    NOT NULL,
            ip         TEXT,
            user_agent TEXT,
            created_at TEXT    NOT NULL DEFAULT (datetime('now', 'localtime'))
        );
    ");

    return $pdo;
}
