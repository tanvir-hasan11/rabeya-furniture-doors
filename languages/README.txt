Bengali (bn_BD) translation
================================

Files:
  bn_BD.po  - source translation (editable)
  bn_BD.mo  - compiled binary (generated on the server)

This folder ships with the .po source only. WordPress needs the compiled
.mo file to actually display the translations.

How to generate bn_BD.mo (pick one):

1) Poedit (easiest, no server access needed)
   - Open bn_BD.po in Poedit
   - File -> Save (Poedit auto-creates bn_BD.mo next to it)
   - Upload both files into wp-content/themes/rabeya-furniture-doors/languages/

2) Online converter
   - Visit https://pofile.net or https://localise.biz/free/converter/po-to-mo
   - Upload bn_BD.po, download bn_BD.mo

3) WP-CLI on the server (if available)
   wp i18n make-mo languages/

Activating Bengali on the site
------------------------------
- WordPress admin -> Settings -> General -> Site Language -> Bengali
  (this loads bn_BD for the whole site, including the theme)

If only the theme should be Bengali, keep the site language as-is and
add to wp-config.php:
  define( 'WPLANG', 'bn_BD' );
