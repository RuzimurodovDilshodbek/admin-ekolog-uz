# Eski sayt arxivi (ekolog.uz 2015–2025)

Eski, **buzib kirilgan** WordPress saytining kontenti shu bo'limga ko'chirilgan.
Asosiy sayt bazasiga umuman tegilmagan — arxiv **alohida bazada** turadi va
admin panelda **faqat o'qish** uchun ochiladi.

## Nima ko'chirildi

| | Miqdor |
|---|---|
| Maqola / sahifa | **980** (`old` 725 + `old2` 255) |
| Media yozuvlari | **2 793** (rasm 2 778, video 10) |
| Media fayllari diskda | **2 169** (~430 MB, `public/legacy-uploads/`) |
| Rukn va teglar | **741** |
| Post↔rukn bog'lanishi | **38 717** |
| Tashlangan qimor spam | **116** post + 2 zararli `.zip` biriktirma |

Tashlanganlar ro'yxati: `storage/app/legacy-import/skipped-spam.txt`

### Yetishmayotgan media

Eski hostingda **820 ta media fayl yo'q edi** — deyarli hammasi `old2`
manbasidan, 2023-10 dan 2025-10 gacha bo'lgan davr. Internet arxividan
**223 tasi tiklandi**, hozir yetishmayotgani — **624 ta**.

Sabab: bu fayllar serverdan o'chirilgan (hujum yoki tozalash paytida). Tekshirildi:

- `public_html/wp-content/uploads` da faqat 2023, 2025, 2026 papkalari qolgan (2024 umuman yo'q)
- `old2.ekolog.uz` docroot'i bo'sh, `.cpanel/…/uploads` bo'sh
- yangi saytda (161.97.88.95) ham bu manzillar 404 qaytaradi

Natijada `old` manbasidagi 725 postdan **596 tasining** bosh rasmi ishlaydi,
`old2` dagi 255 postdan **90 tasining** (arxivdan tiklashdan oldin 43 ta edi).
Matn esa hamma postda to'liq.

**Bir qismi internet arxividan tiklandi.** `web.archive.org` da ekolog.uz ning
`wp-content/uploads` papkasidan 2437 ta yo'l saqlanib qolgan. Ulardan
yetishmayotgan fayllar bilan mos keladiganlari yuklab olindi.

Tiklash vositalari (loyihadan tashqarida, `D:\work\ekolog-old-migration\`):

```bash
# 1. Arxiv indeksini olish
curl "http://web.archive.org/cdx/search/cdx?url=ekolog.uz/wp-content/uploads*\
&output=text&fl=original,timestamp,statuscode&collapse=urlkey&filter=statuscode:200" -o cdx-all.txt

# 2. Yetishmayotganlar bilan solishtirish -> wayback-todo.json
node wayback-match.js cdx-all.txt

# 3. Yuklab olish (har bir fayl rasm ekanligi tekshiriladi)
node wayback-fetch.js

# 4. Bazani yangilash
php artisan legacy:import
```

Qolganlari (arxivda ham yo'q) — maqola matnida "Rasm eski saytda saqlanmagan"
izohi ko'rinadi.

Manbalar:
- `old` — old.ekolog.uz, 2015-01-13 … 2023-10-02 (MySQL bazasi `ekolog_db`)
- `old2` — old2.ekolog.uz, 2020-04-20 … 2025-10-29 (MySQL bazasi `ekolog_database`)

## Xavfsizlik

Eski sayt 2026-yil boshidan buzib kirilgan edi (webshell'lar, backdoor'lar,
DKB bank fishing kiti, 502 ta postga in'ektsiya qilingan zararli JavaScript).
Shuning uchun ko'chirishda quyidagilar qilindi:

1. **Hech qanday PHP fayl ko'chirilmadi.** Faqat baza matni va rasm fayllari.
2. **SQL bajarilmadi** — mysqldump matn sifatida o'qilib JSON'ga o'girildi.
3. **Har bir post HTML'i tozalandi** (`App\Support\LegacyHtmlSanitizer`) — oq
   ro'yxat asosida: `<script>`, `<iframe>`, `<style>`, `<svg>`, `<form>`,
   `on*=` hodisalari, `javascript:` va `data:` manzillari butunlay olib
   tashlanadi. 262 ta postdan 277 ta zararli element chiqarib tashlangan.
4. **Rasm manzillari qayta yozildi** — kontentdagi `old.ekolog.uz/wp-content/...`
   havolalari mahalliy `/legacy-uploads/...` ga o'zgartirildi, shunda admin
   panel zararlangan hostga so'rov yubormaydi.
5. **Qimor/kazino spam** (`App\Support\LegacySpamDetector`) import qilinmadi.

Sanitizer 17 ta hujum stsenariysi ustida sinalgan
(`legacy:render-check` va import keyingi tekshiruv 0 ta xavfli element ko'rsatadi).

## Fayllar

```
config/legacy.php                              sozlamalar (manbalar, media papka, spam oynasi)
config/database.php                            "legacy" ulanishi (sqlite, .env orqali pgsql ham mumkin)
database/migrations/legacy/…                   arxiv jadvallari
app/Support/LegacyHtmlSanitizer.php            HTML tozalagich
app/Support/LegacySpamDetector.php             spam aniqlagich
app/Console/Commands/LegacyImportCommand.php   import buyrug'i
app/Console/Commands/LegacyRenderCheckCommand.php  sahifalarni offline tekshirish
app/Models/Legacy/…                            LegacyPost, LegacyMedia, LegacyTerm
app/Http/Controllers/Admin/LegacyArchiveController.php
resources/views/admin/legacy/{index,show,media}.blade.php
```

Marshrutlar (admin, `post_access` ruxsati bilan):

- `GET /admin/arxiv` — maqolalar ro'yxati (qidiruv, manba/yil/til/tur filtri)
- `GET /admin/arxiv/media` — media galereya (sukut bo'yicha fayli mavjudlari)
- `GET /admin/arxiv/{source}/{wpId}` — bitta maqola, masalan `/admin/arxiv/old/1716`

> Manzil **manba + WordPress ID** bo'yicha qurilgan (jadval `id` si emas),
> shuning uchun `legacy:import --fresh` qayta bajarilganda ham havolalar
> ishlashda davom etadi.

## Production holati (161.97.88.95 / admin-ekolog.uz)

O'rnatilgan. Muhim jihatlar:

- Serverda **`pdo_sqlite` yo'q**, shuning uchun arxiv o'sha yerda alohida
  **MySQL** bazasida: `ekolog_legacy` (asosiy `admin-ekolog` bazasiga tegilmagan).
  `.env` da `LEGACY_DB_*` o'zgaruvchilari; eski `.env` nusxasi `.env.bak-*` da.
- Media: `public/legacy-uploads/` — 451 MB, 7 603 fayl.
- **nginx himoyasi**: `/legacy-uploads/` ostida `.php/.phtml/.phar/.cgi/.pl/.py/.sh/.htm(l)/.svg`
  bajarilishi ham, ochilishi ham bloklangan (`deny all`). Konfig nusxasi
  `/etc/nginx/sites-available/admin.ekolog.uz.bak-*` da.
- PHP-FPM 8.1 ishlatiladi (CLI 8.2) — kod 8.1 bilan mos.

Qayta o'rnatish yoki boshqa serverga ko'chirish uchun quyidagi tartib.

## Serverga o'rnatish (161.97.88.95)

Arxiv bazasi va media fayllar **git orqali yuborilmaydi** (`.gitignore`da).

```bash
# 1. Kodni chiqarish
git pull

# 2. Arxiv bazasini ko'chirish (lokal mashinadan)
scp database/legacy.sqlite user@161.97.88.95:/path/to/app/database/legacy.sqlite

# 3. Media fayllarni ko'chirish (jami ~408 MB)
#    public/legacy-uploads/old/…   (old.ekolog.uz uploads, 360 MB)
#    public/legacy-uploads/old2/…  (public_html uploads, 49 MB)
rsync -av public/legacy-uploads/ user@161.97.88.95:/path/to/app/public/legacy-uploads/

#    MUQOBIL (tavsiya): zip arxivlarni serverga yuklab, o'sha yerda ochish.
#    Linux fayl tizimi katta-kichik harfni farqlaydi, shuning uchun
#    "Буча-300x200.jpg" va "буча-300x200.jpg" kabi 2 ta fayl saqlanib qoladi
#    (Windows'da ular ustma-ust tushib, 2 tasi yo'qolgan).
#    scp D:/work/ekolog-old-migration/uploads/*.zip user@161.97.88.95:/tmp/arxiv/
#    cd /path/to/app/public/legacy-uploads && mkdir -p old old2
#    for z in /tmp/arxiv/old_*.zip; do unzip -qo "$z" -d /tmp/x && cp -r /tmp/x/uploads/* old/; done
#    unzip -qo /tmp/arxiv/new_all.zip -d /tmp/y && cp -r /tmp/y/uploads/* old2/

# 4. Fayl mavjudligini bazada yangilash
php artisan legacy:import          # --fresh shart emas, upsert qiladi
php artisan config:clear && php artisan view:clear && php artisan route:clear
```

Agar sqlite o'rniga alohida PostgreSQL bazasi kerak bo'lsa, `.env` ga:

```
LEGACY_DB_DRIVER=pgsql
LEGACY_DB_HOST=127.0.0.1
LEGACY_DB_PORT=5432
LEGACY_DB_DATABASE=ekolog_legacy
LEGACY_DB_USERNAME=...
LEGACY_DB_PASSWORD=...
```

so'ng `php artisan migrate --database=legacy --path=database/migrations/legacy`
va `php artisan legacy:import --fresh`.

## Qayta import qilish

```bash
php artisan legacy:import            # yangilash (upsert)
php artisan legacy:import --fresh    # tozalab, qaytadan
php artisan legacy:import --keep-spam # spamni ham import qilish (odatda kerak emas)
php artisan legacy:render-check      # sahifalarni veb-serversiz render qilib tekshirish
```

Manba JSON fayllari: `storage/app/legacy-import/{ekolog_db,ekolog_database}/*.json`
