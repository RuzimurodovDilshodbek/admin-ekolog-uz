<?php

namespace App\Http\Controllers;

use App\Models\BotUser;
use App\Models\ConversationState;
use App\Models\Post;
use App\Models\Section;
use App\Models\Tag;
use App\Social\TelegramBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TelegramBotController extends Controller
{
    private $bot;

    public function __construct()
    {
        $this->bot = new TelegramBot();
    }

    /**
     * Handle incoming webhook
     */
    public function webhook(Request $request)
    {
        try {
            $update = $request->all();
            Log::info('Telegram webhook received:', $update);

            // Handle callback queries (inline button clicks)
            if (isset($update['callback_query'])) {
                $this->handleCallbackQuery($update['callback_query']);
                return response()->json(['ok' => true]);
            }

            // Handle regular messages
            if (isset($update['message'])) {
                $this->handleMessage($update['message']);
            }

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('Telegram webhook error: ' . $e->getMessage());
            return response()->json(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Handle incoming message
     */
    private function handleMessage(array $message)
    {
        $chatId = $message['chat']['id'];
        $userId = $message['from']['id'];
        $text = $message['text'] ?? '';

        // Check if user exists and has access (don't auto-create)
        $botUser = BotUser::where('telegram_id', $userId)->first();

        if (!$botUser) {
            // User not in database - no access
            $username = $message['from']['username'] ?? 'Unknown';
            $firstName = $message['from']['first_name'] ?? '';
            $this->bot->sendMessage(
                $chatId,
                "❌ <b>Dostup rad etildi!</b>\n\n"
                . "Siz ro'yxatda yo'qsiz. Botdan foydalanish uchun administrator bilan bog'laning.\n\n"
                . "👤 Username: @{$username}\n"
                . "🆔 Telegram ID: {$userId}\n"
                . "📛 Ism: {$firstName}"
            );
            return;
        }

        if (!$botUser->is_active) {
            // User exists but is deactivated
            $this->bot->sendMessage(
                $chatId,
                "❌ <b>Dostup o'chirilgan!</b>\n\n"
                . "Sizning botdan foydalanish huquqingiz o'chirilgan. "
                . "Administrator bilan bog'laning."
            );
            return;
        }

        if (!$botUser->is_admin) {
            // User exists and active, but not admin
            $this->bot->sendMessage(
                $chatId,
                "❌ <b>Admin huquqi kerak!</b>\n\n"
                . "Botdan foydalanish uchun admin huquqi kerak. "
                . "Administrator bilan bog'laning."
            );
            return;
        }

        // Get conversation state
        $state = ConversationState::getOrCreate($userId);

        // Handle commands
        if (strpos($text, '/') === 0) {
            $this->handleCommand($chatId, $userId, $text, $state);
            return;
        }

        // Handle reply keyboard buttons (map to commands)
        $buttonCommands = [
            '📝 Qo\'lda post kiritish' => '/newpost',
            '🤖 Avtomatik post' => '/autopost',
            '📋 Mening postlarim' => '/myposts',
            '❓ Yordam' => '/help',
        ];

        if (isset($buttonCommands[$text])) {
            $this->handleCommand($chatId, $userId, $buttonCommands[$text], $state);
            return;
        }

        // Handle photo
        if (isset($message['photo'])) {
            $this->handlePhoto($chatId, $userId, $message['photo'], $message['caption'] ?? '', $state);
            return;
        }

        // Handle based on current state
        $this->handleStateMessage($chatId, $userId, $text, $state);
    }

    /**
     * Handle bot commands
     */
    private function handleCommand(int $chatId, int $userId, string $command, ConversationState $state)
    {
        switch ($command) {
            case '/start':
                $this->handleStartCommand($chatId, $userId);
                break;

            case '/help':
                $this->handleHelpCommand($chatId);
                break;

            case '/newpost':
                $this->handleNewPostCommand($chatId, $state);
                break;

            case '/autopost':
                $this->handleAutoPostCommand($chatId, $state);
                break;

            case '/cancel':
                $this->handleCancelCommand($chatId, $state);
                break;

            case '/myposts':
                $this->handleMyPostsCommand($chatId);
                break;

            default:
                $this->bot->sendMessage($chatId, "❓ Noma'lum buyruq. /help dan foydalaning.");
        }
    }

    /**
     * /start command
     */
    private function handleStartCommand(int $chatId, int $userId)
    {
        $keyboard = TelegramBot::replyKeyboard([
            [['text' => '📝 Qo\'lda post kiritish'], ['text' => '🤖 Avtomatik post']],
            [['text' => '📋 Mening postlarim'], ['text' => '❓ Yordam']],
        ]);

        $message = "👋 <b>Ekolog.uz CMS Bot</b>ga xush kelibsiz!\n\n"
            . "Men sizga post yaratishda yordam beraman.\n\n"
            . "<b>Imkoniyatlar:</b>\n"
            . "📝 Qo'lda post kiritish - qadam-ma-qadam yo'riqnoma\n"
            . "🤖 Avtomatik post - tez va oson\n\n"
            . "Quyidagi tugmalardan birini tanlang yoki /help dan foydalaning.";

        $this->bot->sendMessage($chatId, $message, ['reply_markup' => $keyboard]);
    }

    /**
     * /help command
     */
    private function handleHelpCommand(int $chatId)
    {
        $message = "📚 <b>Yordam</b>\n\n"
            . "<b>Buyruqlar:</b>\n"
            . "/start - Botni ishga tushirish\n"
            . "/newpost - Yangi post (qo'lda)\n"
            . "/autopost - Avtomatik post\n"
            . "/myposts - Mening postlarim\n"
            . "/cancel - Bekor qilish\n\n"
            . "<b>Qo'lda post kiritish:</b>\n"
            . "Bot sizdan ketma-ket so'raydi:\n"
            . "1️⃣ Sarlavha\n"
            . "2️⃣ Qisqacha tavsif\n"
            . "3️⃣ To'liq kontent\n"
            . "4️⃣ Rasm\n"
            . "5️⃣ Bo'lim\n"
            . "6️⃣ Teglar\n"
            . "7️⃣ Nashr sanasi\n\n"
            . "<b>Avtomatik post:</b>\n"
            . "Formatlangan xabar yuboring:\n"
            . "<code>Sarlavha: Sizning sarlavha\n"
            . "Tavsif: Qisqacha tavsif\n"
            . "Kontent: To'liq matn...</code>\n\n"
            . "Yoki rasmni caption bilan yuboring.";

        $this->bot->sendMessage($chatId, $message);
    }

    /**
     * /newpost command - Manual mode
     */
    private function handleNewPostCommand(int $chatId, ConversationState $state)
    {
        $state->clearState();
        $state->updateState('awaiting_title', 'manual');

        $this->bot->sendMessage(
            $chatId,
            "📝 <b>Yangi post yaratish (Qo'lda)</b>\n\n"
            . "1️⃣ Iltimos, post <b>sarlavhasini</b> kiriting (o'zbek tilida):\n\n"
            . "Bekor qilish uchun /cancel"
        );
    }

    /**
     * /autopost command - Auto mode
     */
    private function handleAutoPostCommand(int $chatId, ConversationState $state)
    {
        $state->clearState();
        $state->updateState('awaiting_auto_content', 'auto');

        $this->bot->sendMessage(
            $chatId,
            "🤖 <b>Avtomatik post</b>\n\n"
            . "Quyidagi formatda xabar yuboring:\n\n"
            . "<code>Sarlavha: Sizning sarlavha\n"
            . "Tavsif: Qisqacha tavsif\n"
            . "Kontent: To'liq matn...</code>\n\n"
            . "Yoki shunchaki rasm bilan caption yuboring.\n\n"
            . "Bekor qilish: /cancel"
        );
    }

    /**
     * /cancel command
     */
    private function handleCancelCommand(int $chatId, ConversationState $state)
    {
        $state->clearState();
        $this->bot->sendMessage($chatId, "❌ Amaliyot bekor qilindi.", [
            'reply_markup' => TelegramBot::removeKeyboard()
        ]);
        $this->handleStartCommand($chatId, $chatId);
    }

    /**
     * /myposts command
     */
    private function handleMyPostsCommand(int $chatId)
    {
        $posts = Post::orderBy('created_at', 'desc')->take(5)->get();

        if ($posts->isEmpty()) {
            $this->bot->sendMessage($chatId, "📭 Hozircha postlar yo'q.");
            return;
        }

        $message = "📋 <b>Oxirgi 5 ta post:</b>\n\n";

        foreach ($posts as $index => $post) {
            $message .= ($index + 1) . ". " . $post->title_uz . "\n";
            $message .= "   📅 " . $post->date . "\n";
            $message .= "   👁 " . ($post->views_count ?? 0) . " ko'rildi\n\n";
        }

        $this->bot->sendMessage($chatId, $message);
    }

    /**
     * Handle state-based messages
     */
    private function handleStateMessage(int $chatId, int $userId, string $text, ConversationState $state)
    {
        if (!$state->state) {
            // No active state - show help
            $this->bot->sendMessage($chatId, "Buyruq tanlang: /newpost yoki /autopost");
            return;
        }

        if ($state->isManualMode()) {
            $this->handleManualModeMessage($chatId, $userId, $text, $state);
        } elseif ($state->isAutoMode()) {
            $this->handleAutoModeMessage($chatId, $userId, $text, $state);
        }
    }

    /**
     * Handle manual mode messages
     */
    private function handleManualModeMessage(int $chatId, int $userId, string $text, ConversationState $state)
    {
        switch ($state->state) {
            case 'awaiting_title':
                $state->setData('title_uz', $text);
                $state->updateState('awaiting_description');
                $this->bot->sendMessage($chatId, "2️⃣ Qisqacha <b>tavsif</b> kiriting:");
                break;

            case 'awaiting_description':
                $state->setData('description_uz', $text);
                $state->updateState('awaiting_content');
                $this->bot->sendMessage($chatId, "3️⃣ To'liq <b>kontent</b> kiriting:");
                break;

            case 'awaiting_content':
                $state->setData('content_uz', $text);
                $state->updateState('awaiting_image');

                $keyboard = TelegramBot::inlineKeyboard([
                    [TelegramBot::inlineButton('⏭ O\'tkazib yuborish', 'skip_image')]
                ]);

                $this->bot->sendMessage(
                    $chatId,
                    "4️⃣ Rasm yuboring:",
                    ['reply_markup' => $keyboard]
                );
                break;

            case 'awaiting_image':
                // Skip image and go to section selection
                if (strtolower($text) === "o'tkazib yuborish" || strtolower($text) === "skip" || strtolower($text) === "otkazib yuborish") {
                    $this->askSection($chatId, $state);
                } else {
                    $this->bot->sendMessage($chatId, "Rasm yuboring yoki 'o'tkazib yuborish' deb yozing.");
                }
                break;

            case 'awaiting_tags':
                if (strtolower($text) === "o'tkazib yuborish" || strtolower($text) === "skip") {
                    $this->askPublishDate($chatId, $state);
                } else {
                    $tags = array_map('trim', explode(',', $text));
                    $state->setData('tags', $tags);
                    $this->askPublishDate($chatId, $state);
                }
                break;

            case 'awaiting_publish_date':
                if (strtolower($text) === "hozir" || strtolower($text) === "now") {
                    $state->setData('publish_date', Carbon::now()->format('d.m.Y H:i'));
                } else {
                    $state->setData('publish_date', $text);
                }
                $this->showPreview($chatId, $state);
                break;
        }
    }

    /**
     * Handle auto mode messages
     */
    private function handleAutoModeMessage(int $chatId, int $userId, string $text, ConversationState $state)
    {
        if ($state->state === 'awaiting_auto_content') {
            $parsed = $this->parseAutoContent($text);

            if (!$parsed) {
                $this->bot->sendMessage($chatId, "❌ Formatni to'g'ri yoza olmadim. Qaytadan urinib ko'ring.");
                return;
            }

            foreach ($parsed as $key => $value) {
                $state->setData($key, $value);
            }

            $state->updateState('awaiting_image');

            $keyboard = TelegramBot::inlineKeyboard([
                [TelegramBot::inlineButton('⏭ O\'tkazib yuborish', 'skip_image')]
            ]);

            $this->bot->sendMessage(
                $chatId,
                "Rasm yuboring:",
                ['reply_markup' => $keyboard]
            );
        } elseif ($state->state === 'awaiting_image') {
            // Skip image and go to section selection
            if (strtolower($text) === "o'tkazib yuborish" || strtolower($text) === "skip" || strtolower($text) === "otkazib yuborish") {
                $this->askSection($chatId, $state);
            } else {
                $this->bot->sendMessage($chatId, "Rasm yuboring yoki 'o'tkazib yuborish' deb yozing.");
            }
        } elseif ($state->state === 'awaiting_tags') {
            if (strtolower($text) === "o'tkazib yuborish" || strtolower($text) === "skip" || strtolower($text) === "otkazib yuborish") {
                $this->askPublishDate($chatId, $state);
            } else {
                $tags = array_map('trim', explode(',', $text));
                $state->setData('tags', $tags);
                $this->askPublishDate($chatId, $state);
            }
        } elseif ($state->state === 'awaiting_publish_date') {
            if (strtolower($text) === "hozir" || strtolower($text) === "now") {
                $state->setData('publish_date', Carbon::now()->format('d.m.Y H:i'));
            } else {
                $state->setData('publish_date', $text);
            }
            $this->showPreview($chatId, $state);
        }
    }

    /**
     * Parse auto content
     */
    private function parseAutoContent(string $text): ?array
    {
        $lines = explode("\n", $text);
        $data = [];

        foreach ($lines as $line) {
            if (preg_match('/^(Sarlavha|Title):\s*(.+)$/ui', $line, $matches)) {
                $data['title_uz'] = trim($matches[2]);
            } elseif (preg_match('/^(Tavsif|Description):\s*(.+)$/ui', $line, $matches)) {
                $data['description_uz'] = trim($matches[2]);
            } elseif (preg_match('/^(Kontent|Content):\s*(.+)$/ui', $line, $matches)) {
                $data['content_uz'] = trim($matches[2]);
            }
        }

        // If no structured format, try to extract from plain text
        if (empty($data['title_uz'])) {
            $paragraphs = array_filter(array_map('trim', $lines));
            if (count($paragraphs) > 0) {
                $data['title_uz'] = $paragraphs[0];
                $data['description_uz'] = $paragraphs[1] ?? $paragraphs[0];
                $data['content_uz'] = implode("\n", array_slice($paragraphs, 1));
            }
        }

        return !empty($data['title_uz']) ? $data : null;
    }

    /**
     * Handle photo upload
     */
    private function handlePhoto(int $chatId, int $userId, array $photos, string $caption, ConversationState $state)
    {
        if (!$state->state || $state->state !== 'awaiting_image') {
            // Auto mode - parse caption
            if ($caption) {
                $state->clearState();
                $state->updateState('awaiting_auto_content', 'auto');

                $parsed = $this->parseAutoContent($caption);
                if ($parsed) {
                    foreach ($parsed as $key => $value) {
                        $state->setData($key, $value);
                    }
                }
            }
        }

        // Get largest photo
        $photo = end($photos);
        $fileId = $photo['file_id'];

        $state->setData('image_file_id', $fileId);
        $state->updateState('awaiting_section');

        $this->askSection($chatId, $state);
    }

    /**
     * Ask for section selection
     */
    private function askSection(int $chatId, ConversationState $state)
    {
        $sections = Section::whereNull('parent_id')->where('status', 1)->orderBy('sort')->get();

        $buttons = [];
        foreach ($sections as $section) {
            $buttons[] = [
                TelegramBot::inlineButton($section->title_uz, 'section_' . $section->id)
            ];
        }

        $keyboard = TelegramBot::inlineKeyboard($buttons);

        $this->bot->sendMessage(
            $chatId,
            "5️⃣ <b>Bo'limni</b> tanlang:",
            ['reply_markup' => $keyboard]
        );
    }

    /**
     * Show child sections of a parent section
     */
    private function showChildSections(int $chatId, Section $parent, $children, ConversationState $state)
    {
        $buttons = [];

        // Add children buttons
        foreach ($children as $child) {
            $buttons[] = [
                TelegramBot::inlineButton($child->title_uz, 'section_' . $child->id)
            ];
        }

        // Add "Select Parent" button
        $buttons[] = [
            TelegramBot::inlineButton('📁 ' . $parent->title_uz . ' (asosiy)', 'section_' . $parent->id . '_self')
        ];

        // Add "Back" button
        $buttons[] = [
            TelegramBot::inlineButton('◀️ Orqaga', 'section_back')
        ];

        $keyboard = TelegramBot::inlineKeyboard($buttons);

        $this->bot->sendMessage(
            $chatId,
            "📂 <b>" . $parent->title_uz . "</b> bo'limining ichki bo'limlari:\n\nKerakli bo'limni tanlang:",
            ['reply_markup' => $keyboard]
        );
    }

    /**
     * Ask for tags
     */
    private function askTags(int $chatId, ConversationState $state)
    {
        $state->updateState('awaiting_tags');

        $keyboard = TelegramBot::inlineKeyboard([
            [
                TelegramBot::inlineButton('⏭ O\'tkazib yuborish', 'skip_tags'),
            ]
        ]);

        $this->bot->sendMessage(
            $chatId,
            "6️⃣ <b>Teglar</b> kiriting (vergul bilan ajrating):\n\nMasalan: ekologiya, yangilik, tabiat",
            ['reply_markup' => $keyboard]
        );
    }

    /**
     * Ask for publish date
     */
    private function askPublishDate(int $chatId, ConversationState $state)
    {
        $state->updateState('awaiting_publish_date');

        $keyboard = TelegramBot::inlineKeyboard([
            [
                TelegramBot::inlineButton('✅ Hozir', 'publish_now'),
                TelegramBot::inlineButton('📅 Boshqa vaqt', 'publish_custom'),
            ]
        ]);

        $this->bot->sendMessage(
            $chatId,
            "7️⃣ <b>Qachon nashr qilish kerak?</b>",
            ['reply_markup' => $keyboard]
        );
    }

    /**
     * Show preview and confirmation
     */
    private function showPreview(int $chatId, ConversationState $state)
    {
        $data = $state->data;

        $publishDateText = 'Hozir';
        if (isset($data['publish_date']) && $data['publish_date'] !== 'hozir') {
            $publishDateText = $data['publish_date'];
        }

        $message = "👁 <b>PREVIEW</b>\n\n"
            . "📰 <b>Sarlavha:</b> " . ($data['title_uz'] ?? '') . "\n"
            . "📝 <b>Tavsif:</b> " . ($data['description_uz'] ?? '') . "\n"
            . "📄 <b>Kontent:</b> " . mb_substr($data['content_uz'] ?? '', 0, 100) . "...\n"
            . "📂 <b>Bo'lim:</b> " . ($data['section_name'] ?? 'Tanlanmagan') . "\n"
            . "🏷 <b>Teglar:</b> " . (isset($data['tags']) ? implode(', ', $data['tags']) : 'Yo\'q') . "\n"
            . "📅 <b>Nashr:</b> " . $publishDateText . "\n\n"
            . "Tasdiqlaysizmi?";

        $keyboard = TelegramBot::inlineKeyboard([
            [
                TelegramBot::inlineButton('✅ Tasdiqlash', 'confirm_post'),
                TelegramBot::inlineButton('❌ Bekor qilish', 'cancel_post'),
            ]
        ]);

        $this->bot->sendMessage($chatId, $message, ['reply_markup' => $keyboard]);
    }

    /**
     * Handle callback queries (button clicks)
     */
    private function handleCallbackQuery(array $callbackQuery)
    {
        $chatId = $callbackQuery['message']['chat']['id'];
        $userId = $callbackQuery['from']['id'];
        $data = $callbackQuery['data'];
        $queryId = $callbackQuery['id'];

        $state = ConversationState::getOrCreate($userId);

        // Handle section selection
        if (strpos($data, 'section_') === 0) {
            $sectionId = str_replace('section_', '', $data);
            $section = Section::find($sectionId);

            if ($section) {
                // Check if this section has children
                $children = Section::where('parent_id', $sectionId)->where('status', 1)->get();

                if ($children->count() > 0) {
                    // Show children sections
                    $this->bot->answerCallbackQuery($queryId, "📂 " . $section->title_uz);
                    $this->showChildSections($chatId, $section, $children, $state);
                } else {
                    // No children, select this section and continue
                    $state->setData('section_id', $sectionId);
                    $state->setData('section_name', $section->title_uz);
                    $this->bot->answerCallbackQuery($queryId, "✅ " . $section->title_uz . " tanlandi");
                    $this->askTags($chatId, $state);
                }
            }
        }

        // Handle section selection - parent selection (self)
        elseif (strpos($data, '_self') !== false) {
            $sectionId = str_replace(['section_', '_self'], '', $data);
            $section = Section::find($sectionId);

            if ($section) {
                $state->setData('section_id', $sectionId);
                $state->setData('section_name', $section->title_uz);
                $this->bot->answerCallbackQuery($queryId, "✅ " . $section->title_uz . " (asosiy) tanlandi");
                $this->askTags($chatId, $state);
            }
        }

        // Handle back to parent sections
        elseif ($data === 'section_back') {
            $this->bot->answerCallbackQuery($queryId, "◀️ Orqaga");
            $this->askSection($chatId, $state);
        }

        // Handle skip image
        elseif ($data === 'skip_image') {
            $this->bot->answerCallbackQuery($queryId, "⏭ Rasm o'tkazildi");
            $this->askSection($chatId, $state);
        }

        // Handle skip tags
        elseif ($data === 'skip_tags') {
            $this->bot->answerCallbackQuery($queryId, "⏭ Teglar o'tkazildi");
            $this->askPublishDate($chatId, $state);
        }

        // Handle publish now
        elseif ($data === 'publish_now') {
            $state->setData('publish_date', 'hozir');
            $this->bot->answerCallbackQuery($queryId, "✅ Hozir nashr qilinadi");
            $this->showPreview($chatId, $state);
        }

        // Handle custom publish date
        elseif ($data === 'publish_custom') {
            $this->bot->answerCallbackQuery($queryId, "Sana kiriting");
            $this->bot->sendMessage(
                $chatId,
                "📅 Nashr sanasini kiriting (dd.mm.yyyy HH:MM):\n\nMasalan: 25.12.2025 14:30"
            );
            // State already awaiting_publish_date
        }

        // Handle post confirmation
        elseif ($data === 'confirm_post') {
            $this->bot->answerCallbackQuery($queryId, "Post yaratilmoqda...");
            $this->createPost($chatId, $state);
        }

        // Handle post cancellation
        elseif ($data === 'cancel_post') {
            $this->bot->answerCallbackQuery($queryId, "Bekor qilindi");
            $state->clearState();
            $this->bot->sendMessage($chatId, "❌ Post yaratish bekor qilindi.");
            $this->handleStartCommand($chatId, $userId);
        }
    }

    /**
     * Create the post
     */
    private function createPost(int $chatId, ConversationState $state)
    {
        try {
            $data = $state->data;

            // Prepare publish date - convert to database format (Y-m-d H:i:s)
            $publishDateForDb = Carbon::now()->format('Y-m-d H:i:s');

            if (isset($data['publish_date']) && $data['publish_date'] !== 'hozir') {
                try {
                    // Parse user input (d.m.Y H:i) and convert to DB format
                    if (preg_match('/^\d{2}\.\d{2}\.\d{4} \d{2}:\d{2}$/', $data['publish_date'])) {
                        $publishDateForDb = Carbon::createFromFormat('d.m.Y H:i', $data['publish_date'])->format('Y-m-d H:i:s');
                    }
                } catch (\Exception $e) {
                    \Log::error('Telegram bot date parsing error: ' . $e->getMessage() . ' | Input: ' . ($data['publish_date'] ?? 'null'));
                    $publishDateForDb = Carbon::now()->format('Y-m-d H:i:s');
                }
            }

            // Insert post directly using DB to bypass all mutators
            $postId = \DB::table('posts')->insertGetId([
                'title_uz' => $data['title_uz'] ?? '',
                'description_uz' => $data['description_uz'] ?? '',
                'content_uz' => $data['content_uz'] ?? '',
                'section_ids' => implode(',', [$data['section_id'] ?? 1]),
                'langs' => 'uz',
                'status' => 1,
                'publish_date' => $publishDateForDb,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Now load it as a model for relationships
            $post = Post::find($postId);

            // Auto-transliterate to Cyrillic (kr) and translate to other languages
            if (function_exists('transliterate')) {
                // Transliterate to Cyrillic (not translate!)
                $post->title_kr = transliterate(null, $data['title_uz']);
                $post->description_kr = transliterate(null, $data['description_uz']);
                $post->content_kr = transliterate(null, $data['content_uz']);

                // Translate to Russian and English
                if (function_exists('trsTitle') && function_exists('trs')) {
                    $post->title_ru = trsTitle($data['title_uz'], 'ru');
                    $post->title_en = trsTitle($data['title_uz'], 'en');

                    $post->description_ru = trs($data['description_uz'], 'ru');
                    $post->description_en = trs($data['description_uz'], 'en');

                    $post->content_ru = trs($data['content_uz'], 'ru');
                    $post->content_en = trs($data['content_uz'], 'en');
                }

                $post->save();
            }

            // Handle image
            if (isset($data['image_file_id'])) {
                $fileInfo = $this->bot->getFile($data['image_file_id']);

                if ($fileInfo['ok']) {
                    $fileContent = $this->bot->downloadFile($fileInfo['result']['file_path']);

                    if ($fileContent) {
                        $fileName = 'telegram_' . time() . '.jpg';
                        $post->addMediaFromString($fileContent)
                            ->usingFileName($fileName)
                            ->toMediaCollection('detail_image');
                    }
                }
            }

            // Handle tags
            if (isset($data['tags']) && is_array($data['tags'])) {
                $tagIds = [];
                foreach ($data['tags'] as $tagName) {
                    $tag = Tag::firstOrCreate(['title_uz' => $tagName]);
                    $tagIds[] = $tag->id;
                }
                $post->tags()->sync($tagIds);
            }

            $state->clearState();

            $message = "✅ <b>Post muvaffaqiyatli yaratildi!</b>\n\n"
                . "📰 " . $post->title_uz . "\n"
                . "🆔 ID: " . $post->id . "\n\n"
                . "Post admin panelda ko'rish mumkin.";

            $this->bot->sendMessage($chatId, $message);
            $this->handleStartCommand($chatId, $chatId);

        } catch (\Exception $e) {
            Log::error('Error creating post from Telegram: ' . $e->getMessage());
            $this->bot->sendMessage($chatId, "❌ Xatolik yuz berdi: " . $e->getMessage());
        }
    }
}
