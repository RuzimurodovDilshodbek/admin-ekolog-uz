# Telegram Bot Setup Guide

## 📋 Umumiy Ma'lumot

Ushbu Telegram bot Ekolog.uz CMS tizimi uchun mo'ljallangan bo'lib, Telegram orqali to'g'ridan-to'g'ri postlar yaratish imkoniyatini beradi.

### Asosiy Imkoniyatlar:
- ✅ Qo'lda post kiritish (qadam-ma-qadam)
- ✅ Avtomatik post kiritish (smart parsing)
- ✅ Foydalanuvchi nazorati
- ✅ Inline keyboard bilan bo'lim tanlash
- ✅ Avtomatik tarjima (uz, kr, ru, en)
- ✅ Rasm yuklash
- ✅ Preview va tasdiqlash

---

## 🚀 O'rnatish

### 1. Database Migratsiya

```bash
# Migratsiyalarni ishga tushirish
php artisan migrate

# Seeder orqali birinchi bot foydalanuvchini qo'shish
php artisan db:seed --class=BotUsersTableSeeder
```

**MUHIM:** `database/seeders/BotUsersTableSeeder.php` faylida `telegram_id` ni o'z Telegram ID ingizga o'zgartiring.

### 2. Telegram ID ni Aniqlash

Telegram ID ni topish uchun:
1. [@userinfobot](https://t.me/userinfobot) botiga yozing
2. `/start` yuboring
3. Bot sizga ID ni yuboradi

### 3. Webhook O'rnatish

Botni webhook bilan bog'lash uchun:

```bash
curl -X POST "https://api.telegram.org/bot<BOT_TOKEN>/setWebhook?url=https://your-domain.uz/api/telegram/webhook"
```

Yoki kod orqali:

```php
use App\Social\Telegram;

$telegram = new Telegram();
$telegram->setWebhook();
```

**URL Format:**
```
https://ekolog.uz/api/telegram/webhook
```

### 4. Bot Token

Bot token `app/Social/TelegramBot.php` faylida saqlanadi:
```php
const BOT_TOKEN = '8271074734:AAEf5xeK4wK0BU-tXaxfAq595WEPTwqMlgo';
```

---

## 👥 Foydalanuvchilarni Boshqarish

### Admin Panel Orqali

1. Admin panelga kiring: `https://ekolog.uz/admin/bot-users`
2. "Create Bot User" tugmasini bosing
3. Quyidagi ma'lumotlarni kiriting:
   - **Telegram ID** (majburiy)
   - **Username** (ixtiyoriy)
   - **First Name** (ixtiyoriy)
   - **Last Name** (ixtiyoriy)
   - **Is Active** - faol/nofaol
   - **Is Admin** - admin huquqlari

### Manual Qo'shish (Database)

```php
use App\Models\BotUser;

BotUser::create([
    'telegram_id' => 123456789,
    'username' => 'username',
    'first_name' => 'Ism',
    'last_name' => 'Familiya',
    'is_active' => true,
    'is_admin' => false,
]);
```

---

## 🤖 Bot Buyruqlari

### Asosiy Buyruqlar

| Buyruq | Tavsif |
|--------|--------|
| `/start` | Botni ishga tushirish va asosiy menyuni ko'rsatish |
| `/help` | Yordam va buyruqlar ro'yxati |
| `/newpost` | Yangi post yaratish (qo'lda) |
| `/autopost` | Avtomatik post yaratish |
| `/myposts` | Oxirgi postlarni ko'rish |
| `/cancel` | Joriy amaliyotni bekor qilish |

---

## 📝 Qo'lda Post Kiritish

### Ish Jarayoni:

1. `/newpost` buyrug'ini yuboring
2. Bot sizdan ketma-ket so'raydi:

**1-qadam: Sarlavha**
```
📰 Sarlavha: Ekologiya yangiliklari
```

**2-qadam: Qisqacha Tavsif**
```
📝 Tavsif: Muhit muhofazasi haqida yangi qonunlar
```

**3-qadam: To'liq Kontent**
```
📄 Kontent: Batafsil ma'lumot...
```

**4-qadam: Rasm**
- Rasm yuboring yoki "o'tkazib yuborish" deb yozing

**5-qadam: Bo'lim**
- Inline keyboard orqali bo'lim tanlang

**6-qadam: Teglar**
```
🏷 Teglar: ekologiya, yangiliklar, qonun
```
(Vergul bilan ajrating yoki "o'tkazib yuborish")

**7-qadam: Nashr Sanasi**
```
📅 Sana: 25.12.2025 14:30
```
Yoki "hozir" deb yozing

**8-qadam: Preview va Tasdiqlash**
- Bot preview ko'rsatadi
- ✅ Tasdiqlash yoki ❌ Bekor qilish

---

## 🤖 Avtomatik Post Kiritish

### Format 1: Strukturali Xabar

```
Sarlavha: Ekologiya yangiliklari
Tavsif: Qisqacha ma'lumot
Kontent: To'liq matn batafsil...
```

### Format 2: Rasm + Caption

Rasmga quyidagi caption bilan yuboring:
```
Sarlavha: Post nomi
Tavsif: Qisqa tavsif
Kontent: To'liq kontent...
```

### Format 3: Oddiy Matn

Shunchaki matn yuboring, bot uni avtomatik parse qiladi:
```
Birinchi qator sarlavha bo'ladi
Ikkinchi qator tavsif bo'ladi
Qolgan barcha matn kontent bo'ladi
```

Bot parse qilib, preview ko'rsatadi. Tasdiqlasangiz, post yaratiladi.

---

## 🔧 Texnik Tafsilotlar

### Database Strukturasi

**bot_users jadval:**
- `id` - Primary key
- `telegram_id` - Telegram foydalanuvchi ID (unique)
- `username` - Telegram username
- `first_name` - Ism
- `last_name` - Familiya
- `is_active` - Aktiv holati
- `is_admin` - Admin huquqi
- `created_at`, `updated_at`, `deleted_at`

**conversation_states jadval:**
- `id` - Primary key
- `telegram_id` - Foydalanuvchi ID
- `state` - Joriy holat (awaiting_title, awaiting_description, etc.)
- `mode` - Rejim (manual/auto)
- `data` - JSON (vaqtinchalik ma'lumotlar)
- `message_id` - Xabar ID
- `created_at`, `updated_at`

### State Machine

Bot quyidagi holatlar orqali ishlaydi:

**Manual Mode:**
1. `awaiting_title` - Sarlavha kutilmoqda
2. `awaiting_description` - Tavsif kutilmoqda
3. `awaiting_content` - Kontent kutilmoqda
4. `awaiting_image` - Rasm kutilmoqda
5. `awaiting_section` - Bo'lim tanlanmoqda
6. `awaiting_tags` - Teglar kutilmoqda
7. `awaiting_publish_date` - Nashr sanasi kutilmoqda

**Auto Mode:**
1. `awaiting_auto_content` - Avtomatik kontent kutilmoqda
2. `awaiting_image` - Rasm kutilmoqda (ixtiyoriy)

### Avtomatik Tarjima

Post yaratilganda avtomatik tarjima qilinadi:
- Uzbek Latin (uz) → asosiy
- Uzbek Cyrillic (kr) → Google Translate
- Russian (ru) → Google Translate
- English (en) → Google Translate

Tarjima `app/Helpers/UrlHelper.php` dagi `trs()` va `trsTitle()` funksiyalari orqali amalga oshiriladi.

---

## 🔒 Xavfsizlik

### Foydalanuvchi Nazorati

Faqat `bot_users` jadvalida mavjud va `is_active = 1` bo'lgan foydalanuvchilar botdan foydalana oladi.

```php
// Tekshirish
if (!$botUser->hasAccess()) {
    return "❌ Sizda dostup yo'q";
}
```

### Webhook Validation

Webhook URLni faqat sizning serveringiz bilan bog'lang. HTTPS talab qilinadi.

---

## 🐛 Troubleshooting

### Bot javob bermayapti

1. Webhook to'g'ri o'rnatilganini tekshiring:
```bash
curl "https://api.telegram.org/bot<BOT_TOKEN>/getWebhookInfo"
```

2. Loglarni tekshiring:
```bash
tail -f storage/logs/laravel.log
```

3. Bot user `is_active = 1` ekanligini tekshiring

### Rasm yuklanmayapti

1. Spatie Media Library to'g'ri ishlayotganini tekshiring
2. `storage/app/public` papkasi mavjudligini va yozish huquqi borligini tekshiring
3. Symbolic link mavjudligini tekshiring:
```bash
php artisan storage:link
```

### Tarjima ishlamayapti

1. Google Translate API kaliti `app/Helpers/UrlHelper.php` da to'g'ri sozlanganini tekshiring
2. Internet ulanishi borligini tekshiring

---

## 📊 Monitoring

### Statistika

Admin panelda:
- Jami bot foydalanuvchilari
- Faol/nofaol foydalanuvchilar
- Oxirgi suhbatlar
- Yaratilgan postlar

### Loglar

Barcha bot faoliyati loglanadi:
```php
Log::info('Telegram webhook received:', $update);
Log::error('Telegram webhook error: ' . $e->getMessage());
```

---

## 🔄 Yangilash va Backup

### Yangi Funksional Qo'shish

1. `TelegramBotController` ga yangi metodlar qo'shing
2. Yangi holatlar qo'shing
3. Testdan o'tkazing

### Database Backup

```bash
php artisan backup:run
```

---

## 📞 Qo'llab-quvvatlash

Muammolar yuzaga kelsa:
1. `storage/logs/laravel.log` ni tekshiring
2. Telegram bot API dokumentatsiyasini ko'ring: https://core.telegram.org/bots/api
3. Admin bilan bog'laning

---

## ✨ Kelajakdagi Rejalar

- [ ] Draft sifatida saqlash
- [ ] Post tahrirlash
- [ ] Ko'p rasmli postlar
- [ ] Video qo'llab-quvvatlash
- [ ] Jadvalga qo'yish (scheduling)
- [ ] Post statistikasi
- [ ] Export/Import
- [ ] Telegram Channel'ga avtomatik yuborish

---

**Versiya:** 1.0
**Sana:** 25.12.2025
**Muallif:** Claude Code
