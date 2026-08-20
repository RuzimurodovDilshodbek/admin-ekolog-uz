<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <div class="brand-link d-flex align-items-center justify-content-between">
        <a href="/admin" style="text-decoration:none; display:flex; align-items:center; gap:10px;">
            <div style="width:32px; height:32px; background:linear-gradient(135deg,#27ae60,#1e8449); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-leaf" style="color:#fff; font-size:15px;"></i>
            </div>
            <span class="brand-text" style="font-size:14px; font-weight:800; color:#fff; letter-spacing:0.2px;">
                {{ trans('panel.site_title') }}
            </span>
        </a>
        @can('post_create')
            <a href="{{ route('admin.posts.create') }}"
               title="Yangi post"
               style="width:28px; height:28px; background:rgba(39,174,96,0.2); border-radius:6px; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none; transition:background 0.2s;">
                <i class="fa fa-plus" style="color:#27ae60; font-size:13px;"></i>
            </a>
        @endcan
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon"></i>
                        <p>Bosh sahifa</p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                               Foydalanuvchilar
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                           Ruxsatlar
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                           Rol
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            Userlar
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 1]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 1 || Request::get('section_id') == 1) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-newspaper"></i>
                            <p>Xabarlar</p>
                        </a>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 5]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 5 || Request::get('section_id') == 5) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-exclamation-triangle"></i>
                            <p>Eko muammo</p>
                        </a>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 14]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 14 || Request::get('section_id') == 14) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-hands-helping"></i>
                            <p>Eko volontiyorlik</p>
                        </a>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 19]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 19 || Request::get('section_id') == 19) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-envelope-open-text"></i>
                            <p>Murojaatlar</p>
                        </a>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 22]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 22 || Request::get('section_id') == 22) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-info-circle"></i>
                            <p>Biz haqimizda</p>
                        </a>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 26]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 26 || Request::get('section_id') == 26) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-shield-alt"></i>
                            <p>Eko korrupsiya</p>
                        </a>
                    </li>
                @endcan

                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.sections.index") }}" class="nav-link {{ request()->is("admin/sections") || request()->is("admin/sections/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-sitemap"></i>
                            <p>{{ trans('cruds.section.title') }}</p>
                        </a>
                    </li>
                @endcan
{{--                @can('tag_access')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.tags.index") }}" class="nav-link {{ request()->is("admin/tags") || request()->is("admin/tags/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs"></i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.tag.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('tutor_access')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.tutors.index") }}" class="nav-link {{ request()->is("admin/tutors") || request()->is("admin/tutors/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs"></i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.tutor.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('tutor_opinion_access')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.tutor-opinions.index") }}" class="nav-link {{ request()->is("admin/tutor-opinions") || request()->is("admin/tutor-opinions/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.tutorOpinion.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('tutor_access')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.quotations.index") }}" class="nav-link {{ request()->is("admin/quotation") || request()->is("admin/quotation/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ 'Цитаталар' }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
                @can('video_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.videos.index") }}" class="nav-link {{ request()->is("admin/vidios") || request()->is("admin/vidios/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-video"></i>
                            <p>Videolar</p>
                        </a>
                    </li>
                @endcan
{{--                @can('banner_post_access')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.banner-posts.index") }}" class="nav-link {{ request()->is("admin/banner-posts") || request()->is("admin/banner-posts/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.bannerPost.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('dailiy_verse_access')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.dailiy-verses.index") }}" class="nav-link {{ request()->is("admin/dailiy-verses") || request()->is("admin/dailiy-verses/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.dailiyVerse.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('poll_ovoz_berish_access')--}}
{{--                    <li class="nav-item has-treeview {{ request()->is("admin/polls*") ? "menu-open" : "" }} {{ request()->is("admin/poll-variants*") ? "menu-open" : "" }} {{ request()->is("admin/poll-votes*") ? "menu-open" : "" }}">--}}
{{--                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/polls*") ? "active" : "" }} {{ request()->is("admin/poll-variants*") ? "active" : "" }} {{ request()->is("admin/poll-votes*") ? "active" : "" }}" href="#">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.pollOvozBerish.title') }}--}}
{{--                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                        <ul class="nav nav-treeview">--}}
{{--                            @can('poll_access')--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="{{ route("admin.polls.index") }}" class="nav-link {{ request()->is("admin/polls") || request()->is("admin/polls/*") ? "active" : "" }}">--}}
{{--                                        <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                                        </i>--}}
{{--                                        <p>--}}
{{--                                            {{ trans('cruds.poll.title') }}--}}
{{--                                        </p>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endcan--}}
{{--                            @can('poll_variant_access')--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="{{ route("admin.poll-variants.index") }}" class="nav-link {{ request()->is("admin/poll-variants") || request()->is("admin/poll-variants/*") ? "active" : "" }}">--}}
{{--                                        <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                                        </i>--}}
{{--                                        <p>--}}
{{--                                            {{ trans('cruds.pollVariant.title') }}--}}
{{--                                        </p>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endcan--}}
{{--                            @can('poll_vote_access')--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="{{ route("admin.poll-votes.index") }}" class="nav-link {{ request()->is("admin/poll-votes") || request()->is("admin/poll-votes/*") ? "active" : "" }}">--}}
{{--                                        <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                                        </i>--}}
{{--                                        <p>--}}
{{--                                            {{ trans('cruds.pollVote.title') }}--}}
{{--                                        </p>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endcan--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('post_comment_access')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.post-comments.index") }}" class="nav-link {{ request()->is("admin/post-comments") || request()->is("admin/post-comments/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.postComment.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('favourite_access')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.favourites.index") }}" class="nav-link {{ request()->is("admin/favourites") || request()->is("admin/favourites/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.favourite.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('ad_access')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.ads.index") }}" class="nav-link {{ request()->is("admin/ads") || request()->is("admin/ads/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.ad.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('newsletter_access')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.newsletters.index") }}" class="nav-link {{ request()->is("admin/newsletters") || request()->is("admin/newsletters/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.newsletter.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('ad_view_access')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.ad-views.index") }}" class="nav-link {{ request()->is("admin/ad-views") || request()->is("admin/ad-views/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.adView.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('post_view_access')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.post-views.index") }}" class="nav-link {{ request()->is("admin/post-views") || request()->is("admin/post-views/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.postView.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.post-views-show.index") }}" class="nav-link {{ request()->is("admin/post-views-show") || request()->is("admin/post-views-show/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.postView.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/site-info') ? 'active' : '' }}" href="{{ route('admin.site-info.edit') }}">
                        <i class="fa-fw nav-icon fas fa-address-card"></i>
                        <p>Aloqa sahifasi</p>
                    </a>
                </li>
                @can('post_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/arxiv*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is('admin/arxiv*') ? 'active' : '' }}" href="#">
                            <i class="fa-fw nav-icon fas fa-archive"></i>
                            <p>
                                Eski sayt arxivi
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.legacy.index') }}"
                                   class="nav-link {{ request()->is('admin/arxiv') ? 'active' : '' }}">
                                    <i class="fa-fw nav-icon fas fa-newspaper"></i>
                                    <p>Eski maqolalar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.legacy.media') }}"
                                   class="nav-link {{ request()->is('admin/arxiv/media') ? 'active' : '' }}">
                                    <i class="fa-fw nav-icon fas fa-images"></i>
                                    <p>Eski medialar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon"></i>
                                <p>Parolni o'zgartirish</p>
                            </a>
                        </li>
                    @endcan
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
