{{--
    Cheksiz aylantirish. Maqolalar va media galereyasi uchun umumiy.

    Kutilgan o'zgaruvchilar:
      $prefix    - element id'lari uchun old qo'shimcha (lg / mg)
      $paginator - joriy sahifalagich

    JavaScript ishlamasa yoki IntersectionObserver bo'lmasa - oddiy
    sahifalagich o'z holicha qolib, hammasi ishlashda davom etadi.
--}}
<script>
(function () {
    var P = @json($prefix);
    var grid     = document.getElementById(P + '-grid');
    var sentinel = document.getElementById(P + '-sentinel');
    var more     = document.getElementById(P + '-more');
    var counter  = document.getElementById(P + '-counter');
    var pager    = document.getElementById(P + '-pagination');

    if (!grid || !sentinel || !('IntersectionObserver' in window) || !window.fetch) { return; }

    var nextPage = {{ $paginator->hasMorePages() ? $paginator->currentPage() + 1 : 'null' }};
    var total    = parseInt(counter ? counter.dataset.total : '0', 10);
    var busy     = false;

    if (pager) { pager.hidden = true; }               // JS bor ekan, sahifalagich kerak emas
    if (nextPage === null && more) { more.remove(); more = null; }

    function nextUrl() {
        var u = new URL(window.location.href);
        u.searchParams.set('page', nextPage);
        u.searchParams.set('partial', '1');
        return u.toString();
    }

    function finish() {
        observer.disconnect();
        window.removeEventListener('scroll', onScroll);
        if (more) { more.innerHTML = 'Hammasi ko\'rsatildi — ' + grid.children.length + ' ta'; }
    }

    function fail() {
        busy = false;
        if (!more) { return; }
        more.hidden = false;
        more.innerHTML = 'Yuklab bo\'lmadi. <a href="#">Qayta urinish</a>';
        more.querySelector('a').addEventListener('click', function (e) {
            e.preventDefault();
            more.innerHTML = '<span class="spin"></span>Yuklanmoqda...';
            load();
        });
    }

    function load() {
        if (busy || nextPage === null) { return; }
        busy = true;
        if (more) { more.hidden = false; }

        fetch(nextUrl(), { headers: { 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
            .then(function (r) { if (!r.ok) { throw new Error(r.status); } return r.json(); })
            .then(function (data) {
                grid.insertAdjacentHTML('beforeend', data.html);
                if (counter) { counter.textContent = grid.children.length + ' / ' + total + ' ta ko\'rsatilmoqda'; }
                nextPage = data.next;
                busy = false;

                if (nextPage === null) { finish(); return; }
                if (more) { more.hidden = true; }

                // IntersectionObserver faqat holat O'ZGARGANDA ishlaydi. Yangi
                // kartochkalardan keyin sentinel hamon ko'rinishda qolsa, hech
                // qanday yangi signal kelmaydi - shuning uchun o'zimiz tekshiramiz.
                setTimeout(check, 60);
            })
            .catch(fail);
    }

    function check() {
        if (nextPage === null) { return; }
        var vh = window.innerHeight || document.documentElement.clientHeight;
        if (sentinel.getBoundingClientRect().top <= vh + 400) { load(); }
    }

    var ticking = false;
    function onScroll() {
        if (ticking) { return; }
        ticking = true;
        window.requestAnimationFrame(function () { ticking = false; check(); });
    }

    var observer = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting) { load(); }
    }, { rootMargin: '400px' });

    observer.observe(sentinel);
    window.addEventListener('scroll', onScroll, { passive: true });  // zaxira yo'l
    setTimeout(check, 100);   // ekran balandligi katta bo'lsa, birinchi sahifadanoq
})();
</script>
