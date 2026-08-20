<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Legacy\LegacyMedia;
use App\Models\Legacy\LegacyPost;
use App\Models\Legacy\LegacyTerm;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Eski ekolog.uz (2015-2025) arxivini KO'RISH uchun bo'lim.
 *
 * Faqat o'qish: bu yerdan hech narsa tahrirlanmaydi va asosiy saytga
 * ko'chirilmaydi. Ma'lumot alohida "legacy" bazasidan olinadi.
 */
class LegacyArchiveController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = LegacyPost::query();

        if ($source = $request->input('source')) {
            $query->where('source', $source);
        }

        if ($type = $request->input('type')) {
            $query->where('post_type', $type);
        }

        if ($lang = $request->input('lang')) {
            $query->where('lang', $lang);
        }

        if ($year = $request->input('year')) {
            $query->whereYear('published_at', $year);
        }

        if ($term = $request->input('term')) {
            $query->whereIn('wp_id', function ($sub) use ($term) {
                $sub->select('wp_post_id')
                    ->from('legacy_post_term')
                    ->where('wp_term_id', $term);
            });
        }

        if ($q = trim((string) $request->input('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%");
            });
        }

        $sort = $request->input('sort') === 'asc' ? 'asc' : 'desc';

        $posts = $query->orderBy('published_at', $sort)
            ->paginate(24)
            ->withQueryString();

        // Ko'rsatiladigan postlar uchun rasm va ruknlarni bir so'rovda olamiz
        $this->attachThumbnails($posts->getCollection());

        return view('admin.legacy.index', [
            'posts'      => $posts,
            'years'      => $this->years(),
            'categories' => LegacyTerm::categories()->orderBy('name')->get(),
            'stats'      => $this->stats(),
            'filters'    => $request->only(['source', 'type', 'lang', 'year', 'term', 'q', 'sort']),
        ]);
    }

    public function show(string $source, int $wpId)
    {
        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post = LegacyPost::where('source', $source)
            ->where('wp_id', $wpId)
            ->firstOrFail();

        $thumbnail = $post->thumbnail();

        $attachments = $post->attachments();

        $prev = LegacyPost::where('source', $post->source)
            ->where('published_at', '<', $post->published_at)
            ->orderByDesc('published_at')->first();

        $next = LegacyPost::where('source', $post->source)
            ->where('published_at', '>', $post->published_at)
            ->orderBy('published_at')->first();

        return view('admin.legacy.show', compact('post', 'thumbnail', 'attachments', 'prev', 'next'));
    }

    public function media(Request $request)
    {
        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = LegacyMedia::query();

        // Sukut bo'yicha faqat fayli mavjud bo'lganlar ko'rsatiladi.
        // "all" tanlansa - eski saytda o'chirib yuborilganlar ham chiqadi.
        $presence = $request->input('presence', 'present');
        if ($presence === 'present') {
            $query->where('file_exists', true);
        } elseif ($presence === 'missing') {
            $query->where('file_exists', false);
        }

        if ($source = $request->input('source')) {
            $query->where('source', $source);
        }

        if ($request->input('kind') === 'video') {
            $query->where('mime', 'like', 'video/%');
        } elseif ($request->input('kind') === 'image') {
            $query->where('mime', 'like', 'image/%');
        }

        if ($year = $request->input('year')) {
            $query->where('file_path', 'like', $year . '/%');
        }

        if ($q = trim((string) $request->input('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                    ->orWhere('file_path', 'like', "%{$q}%");
            });
        }

        $media = $query->orderByDesc('published_at')
            ->paginate(60)
            ->withQueryString();

        $mediaYears = LegacyMedia::query()
            ->selectRaw("substr(file_path, 1, 4) as y")
            ->whereNotNull('file_path')
            ->groupBy('y')
            ->orderByDesc('y')
            ->pluck('y')
            ->filter(fn ($y) => preg_match('/^\d{4}$/', (string) $y))
            ->values();

        return view('admin.legacy.media', [
            'media'      => $media,
            'mediaYears' => $mediaYears,
            'stats'      => $this->stats(),
            'filters'    => $request->only(['source', 'kind', 'year', 'q']),
            'presence'   => $presence,
        ]);
    }

    /** Postlar to'plamiga bosh rasmni biriktiradi (N+1 so'rovsiz) */
    private function attachThumbnails($posts): void
    {
        $ids = [];
        foreach ($posts as $p) {
            if ($p->thumbnail_wp_id) {
                $ids[$p->source][] = $p->thumbnail_wp_id;
            }
        }

        if (! $ids) {
            return;
        }

        $media = LegacyMedia::query()
            ->where(function ($w) use ($ids) {
                foreach ($ids as $source => $list) {
                    $w->orWhere(fn ($x) => $x->where('source', $source)->whereIn('wp_id', $list));
                }
            })
            ->get()
            ->keyBy(fn ($m) => $m->source . ':' . $m->wp_id);

        foreach ($posts as $p) {
            $p->setAttribute('thumb', $media->get($p->source . ':' . $p->thumbnail_wp_id));
        }
    }

    private function years(): array
    {
        return LegacyPost::query()
            ->selectRaw("strftime('%Y', published_at) as y, COUNT(*) as c")
            ->whereNotNull('published_at')
            ->groupBy('y')
            ->orderByDesc('y')
            ->get()
            ->filter(fn ($r) => $r->y)
            ->mapWithKeys(fn ($r) => [$r->y => $r->c])
            ->toArray();
    }

    private function stats(): array
    {
        return [
            'posts'  => LegacyPost::where('post_type', 'post')->count(),
            'pages'  => LegacyPost::where('post_type', 'page')->count(),
            'media'  => LegacyMedia::count(),
            'images' => LegacyMedia::where('mime', 'like', 'image/%')->count(),
            'videos' => LegacyMedia::where('mime', 'like', 'video/%')->count(),
            'terms'  => LegacyTerm::count(),
            'files_present' => LegacyMedia::where('file_exists', true)->count(),
        ];
    }
}
