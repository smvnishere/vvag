#!/usr/bin/env bash
# ============================================================
#  FORM API SMOKE TESTLERİ (tests/test_form.sh)
# ============================================================
#  contact-handler.php'nin güvenlik ve doğrulama akışını
#  uçtan uca test eder. Sunucunda ya da lokalinde çalıştır:
#
#      bash tests/test_form.sh https://vvag.onrender.com
#      bash tests/test_form.sh http://localhost:8000
#
#  Lokal test için önce:  php -S localhost:8000
# ============================================================
set -uo pipefail

BASE="${1:?Kullanım: bash tests/test_form.sh <site-url>}"
JAR="$(mktemp)"          # Session cookie'si için çerez kavanozu
PASS=0; FAIL=0

check() { # check <test adı> <beklenen> <gerçekleşen>
    if [ "$2" = "$3" ]; then
        echo "  ✔ PASS: $1"; PASS=$((PASS+1))
    else
        echo "  ✘ FAIL: $1 (beklenen: $2, gelen: $3)"; FAIL=$((FAIL+1))
    fi
}

echo "==> Hedef: $BASE"

# --- 0. Sayfayı çek: session başlat + CSRF token'ı sök ---
TOKEN=$(curl -s -c "$JAR" "$BASE/index.php" \
        | grep -o 'name="csrf_token" value="[a-f0-9]*"' \
        | grep -o '[a-f0-9]\{64\}')
if [ -z "${TOKEN:-}" ]; then
    echo "✘ CSRF token sayfadan okunamadı, testler durduruldu."; exit 1
fi
echo "==> CSRF token alındı: ${TOKEN:0:8}..."

# --- 1. GET isteği reddedilmeli (405) ---
CODE=$(curl -s -o /dev/null -w '%{http_code}' "$BASE/contact-handler.php")
check "GET istegi reddedilir" "405" "$CODE"

# --- 2. CSRF token'sız POST reddedilmeli (403) ---
CODE=$(curl -s -o /dev/null -w '%{http_code}' -b "$JAR" -X POST \
       -d "name=Test&email=t@t.com&message=deneme" "$BASE/contact-handler.php")
check "CSRF'siz POST reddedilir" "403" "$CODE"

# --- 3. Honeypot dolu -> sahte başarı (200) ama kayıt yok ---
CODE=$(curl -s -o /dev/null -w '%{http_code}' -b "$JAR" -X POST \
       -d "csrf_token=$TOKEN&website=spam&name=Bot&email=b@b.com&message=spam" \
       "$BASE/contact-handler.php")
check "Honeypot bot yakalanir" "200" "$CODE"

# --- 4. Geçersiz e-posta reddedilmeli (422) ---
CODE=$(curl -s -o /dev/null -w '%{http_code}' -b "$JAR" -X POST \
       -d "csrf_token=$TOKEN&name=Test&email=gecersiz&message=deneme" \
       "$BASE/contact-handler.php")
check "Gecersiz e-posta reddedilir" "422" "$CODE"

# --- 5. Zorunlu alan eksik reddedilmeli (422) ---
CODE=$(curl -s -o /dev/null -w '%{http_code}' -b "$JAR" -X POST \
       -d "csrf_token=$TOKEN&name=&email=t@t.com&message=" \
       "$BASE/contact-handler.php")
check "Bos zorunlu alan reddedilir" "422" "$CODE"

# --- 6. Geçerli gönderim başarılı olmalı (200 + success:true) ---
BODY=$(curl -s -b "$JAR" -X POST \
       -d "csrf_token=$TOKEN&name=Smoke Test&company=TestCo&email=test@example.com&phone=+90 555 000 0000&message=Otomatik test gönderimi." \
       "$BASE/contact-handler.php")
echo "$BODY" | grep -q '"success":true' && R=ok || R=fail
check "Gecerli form kabul edilir" "ok" "$R"

# --- 7. SQL injection payload'ı sistemi bozmamalı ---
BODY=$(curl -s -b "$JAR" -X POST \
       --data-urlencode "csrf_token=$TOKEN" \
       --data-urlencode "name=Robert'); DROP TABLE quotes;--" \
       --data-urlencode "email=inj@test.com" \
       --data-urlencode "message=1' OR '1'='1" \
       "$BASE/contact-handler.php")
echo "$BODY" | grep -q '"success":true' && R=ok || R=fail
check "SQLi payload guvenle kaydedilir (prepared stmt)" "ok" "$R"

rm -f "$JAR"
echo ""
echo "============================"
echo " SONUÇ: $PASS başarılı / $FAIL başarısız"
echo "============================"
[ "$FAIL" -eq 0 ]
