<?php
/**
 * ============================================================
 *  VURAL AĞ - FOOTER (footer.php)
 * ============================================================
 *  İletişim bilgileri, harita yer tutucusu, alt bilgi ve
 *  HTML kapanış tag'leri. Her sayfanın en sonunda çağrılır:
 *
 *      require 'footer.php';
 * ============================================================
 */
?>

<!-- ============================================================
     FOOTER
============================================================= -->
<footer id="iletisim" class="bg-ink text-gray-300 border-t border-steel">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12">

            <!-- Sütun 1: Firma Kimliği -->
            <div>
                <img src="<?php echo LOGO_PATH; ?>" alt="<?php echo SITE_NAME; ?>"
                     class="h-12 w-auto mb-5"
                     onerror="this.outerHTML='<p class=\'font-display font-bold text-2xl text-white uppercase mb-5\'>Vural<span class=\'text-signal\'>Ağ</span></p>';">
                <p class="text-sm leading-relaxed text-gray-400 max-w-xs">
                    <?php echo SITE_TAGLINE; ?>. Fabrikalardan şantiyelere, güvenilir ve standartlara uygun ağ montajı.
                </p>
                <?php if (!empty($social_links['linkedin'])): ?>
                <a href="<?php echo $social_links['linkedin']; ?>" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 mt-6 text-sm text-signal hover:text-white transition-colors">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-5c0-2.76-2.24-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.27c-.97 0-1.75-.79-1.75-1.76s.78-1.75 1.75-1.75 1.75.78 1.75 1.75-.78 1.76-1.75 1.76zm13.5 12.27h-3v-5.6c0-3.37-4-3.11-4 0v5.6h-3v-11h3v1.77c1.4-2.59 7-2.78 7 2.47v6.76z"/></svg>
                    LinkedIn
                </a>
                <?php endif; ?>
            </div>

            <!-- Sütun 2: Hizmet Sayfaları (SEO iç bağlantı) -->
            <div>
                <h3 class="font-mono text-xs uppercase tracking-[0.2em] text-signal mb-6">Hizmetler</h3>
                <ul class="space-y-3 text-sm">
                    <?php if (!empty($seo_pages)): foreach ($seo_pages as $s => $p): ?>
                    <li>
                        <a href="hizmet.php?slug=<?php echo $s; ?>" class="text-gray-400 hover:text-white transition-colors">
                            <?php echo htmlspecialchars($p['h1']); ?>
                        </a>
                    </li>
                    <?php endforeach; endif; ?>
                </ul>
            </div>

            <!-- Sütun 3: İletişim Bilgileri -->
            <div>
                <h3 class="font-mono text-xs uppercase tracking-[0.2em] text-signal mb-6">İletişim</h3>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <svg class="h-5 w-5 text-signal shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <span><?php echo CONTACT_ADDRESS; ?></span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-signal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        <a href="tel:<?php echo CONTACT_PHONE_RAW; ?>" class="hover:text-white transition-colors"><?php echo CONTACT_PHONE; ?></a>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-signal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        <a href="mailto:<?php echo CONTACT_EMAIL; ?>" class="hover:text-white transition-colors"><?php echo CONTACT_EMAIL; ?></a>
                    </li>
                </ul>
            </div>

            <!-- Sütun 4: Harita Yer Tutucusu -->
            <div>
                <h3 class="font-mono text-xs uppercase tracking-[0.2em] text-signal mb-6">Konum</h3>
                <!--
                    HARİTA: Google Maps > Paylaş > Harita Yerleştir'den aldığın
                    iframe kodunu aşağıdaki div'in İÇİNE yapıştır ve
                    yer tutucu içeriği sil. iframe'e class="w-full h-full rounded-lg" ver.
                -->
                <div class="w-full h-48 rounded-lg border border-steel bg-anthracite flex flex-col items-center justify-center gap-2 text-gray-500">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                    <span class="font-mono text-xs">Google Maps iframe buraya</span>
                </div>
            </div>
        </div>

        <!-- Alt Şerit -->
        <div class="mt-14 pt-6 border-t border-steel flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-500">
                &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Tüm hakları saklıdır.
            </p>
            <p class="font-mono text-[11px] tracking-wider text-gray-600 uppercase">
                Güvenlik Ağı & File Montajı / Ankara
            </p>
        </div>
    </div>
</footer>

<!-- ============================================================
     GLOBAL JAVASCRIPT
============================================================= -->
<script>
    // Mobil menü aç/kapat
    const menuBtn  = document.getElementById('mobile-menu-btn');
    const menu     = document.getElementById('mobile-menu');
    if (menuBtn && menu) {
        menuBtn.addEventListener('click', () => {
            const isOpen = !menu.classList.contains('hidden');
            menu.classList.toggle('hidden');
            menuBtn.setAttribute('aria-expanded', String(!isOpen));
        });
        // Menüde bir linke tıklanınca menüyü kapat
        menu.querySelectorAll('a').forEach(link =>
            link.addEventListener('click', () => menu.classList.add('hidden'))
        );
    }
</script>

</body>
</html>
