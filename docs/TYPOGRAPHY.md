# Maqola tipografikasi

## Muammo

Maqolalar Word / Google Docs / boshqa saytlardan nusxa ko'chirib
joylashtiriladi. Summernote hujjatdagi barcha inline uslublarni saqlab
qoladi, front esa uni `v-html` bilan xom holda chiqaradi — inline uslub
esa saytning har qanday CSS'idan kuchli.

Natijada (tuzatishdan oldingi holat, 137 post bo'yicha):

| | |
|---|---|
| Turli shrift o'lchami | **37 xil** (`12,0000pt`, `18px`, `16.0pt`, `14pt`, `16px !important`…) |
| Turli shrift oilasi | **20 xil** (SimSun, Georgia, Calibri, Arial, Roboto, Aptos, sohne…) |
| Inline `font-size` bor postlar | 78 ta (57%) |
| Inline `font-family` bor postlar | 69 ta (50%) |
| Word'ning `MsoNormal` klassi | 28 ta (20%) |
| Bitta maqola ichida bir nechta o'lcham | **31 ta** — "tepasi yirik, pasti mayda" shu |

## Yechim — 3 qatlam

### 1. Front: yagona tipografika

`ekologuz-fronts` (Nuxt) loyihasida:

- `assets/main.css` ga `.article-body` bloki qo'shildi: `PT Serif`, 18px,
  `line-height: 1.8`, `hyphens: auto`
- Ichkaridagi `p/span/div/li/td/a/b/strong/em` uchun
  `font-family|font-size|line-height: inherit !important` — qolgan yoki
  kelajakda qo'shiladigan inline uslubni zararsizlantiradi
- Sarlavhalar (`h1…h6`), `sup`, `sub`, `small` tegilmaydi
- `pages/[id]/index.vue` va `pages/info.vue` da `prose` o'rniga
  `article-body` klassi (`@tailwindcss/typography` o'rnatilmagani uchun
  `prose` klassi hech narsa qilmayotgan edi)

> Front repo boshqa dasturchiga tegishli (`Abdurahmon086/ekologuz-fronts`),
> shuning uchun o'zgarish serverda qilingan va GitHub'ga push qilinmagan.
> Zaxira: `assets/main.css.bak`, `pages/[id]/index.vue.bak`,
> `pages/info.vue.bak`, `.output.bak-<sana>`.

### 2. Baza: mavjud postlarni tozalash

```bash
php artisan posts:clean-typography --dry-run    # ko'rsatadi, o'zgartirmaydi
php artisan posts:clean-typography              # tozalaydi
php artisan posts:clean-typography --sample=116 # bitta postning oldin/keyini
php artisan posts:restore-typography <fayl>     # zaxiradan qaytarish
```

`App\Support\TypographyCleaner` olib tashlaydi: `font`, `font-family`,
`font-size`, `line-height`, `letter-spacing`, `word-spacing`,
`text-indent`, `mso-*`, `Mso*`/`Xl*`/`Char*` klasslari, `<font>` tegi,
Word'ning `<o:p>` teglari, atributsiz qolgan `<span>`lar.

Saqlanadi: matn, `<b>/<i>/<u>`, ro'yxatlar, havolalar, rasmlar,
jadvallar, `font-weight`, rang va `text-align`
(`--with-color` / `--with-align` bilan ularni ham olib tashlash mumkin).

Faqat haqiqatan uslub olib tashlangan postlar qayta yoziladi — aks holda
HTML bekorga qayta seriyalanardi.

**2026-08-21 dagi natija:** 137 postdan 85 tasi tozalandi —
3841 `font-family`, 3337 `font-size`, 2934 `line-height`, 5812 boshqa
uslub, 765 Word klassi, 154 `<font>` tegi olib tashlandi.
Zaxiralar: `storage/app/typography-backup-*.json` va
`storage/app/backups/posts-*.sql`.

### 3. Muharrir: takrorlanmasligi uchun

`public/js/summernote-clean-paste.js` — Summernote'ning standart
`onPaste` callback'iga ulanadi (har bir init'ni o'zgartirish shart emas)
va clipboard HTML'ini yuqoridagi qoidalar bo'yicha tozalab joylashtiradi.

Shuningdek:
- panelidan shrift o'lchami tanlagichi (`fontsizeunit`) olib tashlandi
- avtomatik `summernote('justifyFull')` chaqiruvi olib tashlandi
- muharrir maydoni saytdagidek: PT Serif, 18px, `line-height: 1.8`

## Qayta tekshirish

```bash
# Bazada inline shrift uslubi qolmaganini tekshirish
php artisan posts:clean-typography --dry-run     # "O'zgaradigan: 0" bo'lishi kerak
```
