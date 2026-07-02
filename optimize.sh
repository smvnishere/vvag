#!/usr/bin/env bash
# ============================================================
#  VARLIK OPTİMİZASYON SCRIPT'İ (optimize.sh)
# ============================================================
#  Ne yapar:
#    1. assets/ altındaki PNG/JPG'leri WebP'ye çevirir
#    2. Tailwind'i CDN yerine derlenmiş+minify CSS'e çevirir
#
#  Gereksinimler (bir kere kur):
#    sudo apt install webp          # cwebp için
#    npm  install tailwindcss       # Tailwind CLI için
#
#  Kullanım: proje kökünde  ->  bash optimize.sh
# ============================================================
set -euo pipefail

echo "==> 1/2 Görseller WebP'ye çevriliyor..."
find assets -type f \( -iname '*.png' -o -iname '*.jpg' -o -iname '*.jpeg' \) | while read -r img; do
    out="${img%.*}.webp"
    # -q 82: görsel kalite/boyut dengesi için tatlı nokta
    cwebp -q 82 "$img" -o "$out" >/dev/null 2>&1 \
        && echo "    OK  $img -> $out" \
        || echo "    ATLA $img (cwebp hatası)"
done
echo "    NOT: HTML'de <picture> ile webp + png fallback kullan (README'de örnek var)."

echo "==> 2/2 Tailwind derleniyor (minify)..."
# input.css yoksa oluştur
if [ ! -f assets/input.css ]; then
    printf '@tailwind base;\n@tailwind components;\n@tailwind utilities;\n' > assets/input.css
fi
npx tailwindcss -i assets/input.css -o assets/site.min.css --minify \
    --content "./*.php,./includes/*.php" \
    && echo "    OK  assets/site.min.css üretildi."

cat << 'NOTE'

============================================================
SON ADIM (elle, 1 dakika):
header.php içindeki şu iki satırı SİL:
    <script src="https://cdn.tailwindcss.com"></script>
    <script> tailwind.config = {...} </script>
Yerine şunu EKLE:
    <link rel="stylesheet" href="assets/site.min.css">
ve renk/font tanımlarını tailwind.config.js dosyasına taşı.
CDN script'i Lighthouse'ta en büyük puan kaybettiren kalemdi;
bu değişiklik +95 skorun anahtarı.
============================================================
NOTE
