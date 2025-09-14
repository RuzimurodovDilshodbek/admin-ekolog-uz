<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <div class="d-flex align-items-center justify-content-around">
        <a href="/admin" class="brand-link">
            <span class="brand-text font-weight-light">
                {{ trans('panel.site_title') }}
            </span>
        </a>
        @can('post_create')
            <span>
                <a class="" href="{{ route('admin.posts.create') }}">
                    <i class="fa fa-plus-circle" style="transform: scale(2); color: #00b249"></i>
                </a>
            </span>
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
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
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
                                            {{ trans('cruds.permission.title') }}
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
                                            {{ trans('cruds.role.title') }}
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
                                            {{ trans('cruds.user.title') }}
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
                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                            <p>Янгиликлар</p>
                        </a>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 2]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 2 || Request::get('section_id') == 2) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                            <p>Таълим</p>
                        </a>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 3]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 3 || Request::get('section_id') == 3) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                            <p>Саломатлик</p>
                        </a>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 4]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 4 || Request::get('section_id') == 4) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                            <p>Ҳуқуқий клиника</p>
                        </a>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 5]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 5 || Request::get('section_id') == 5) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                            <p>Аччиқтош</p>
                        </a>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 6]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 6 || Request::get('section_id') == 6) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                            <p>Фойдали</p>
                        </a>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 7]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 7  || Request::get('section_id') == 7) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                            <p>Медиа</p>
                        </a>
                    </li>
                @endcan

                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route('admin.postGetSectionId',['id' => 8]) }}" class="nav-link {{ request()->is("admin/post*") && (Request::get('id') == 8  || Request::get('section_id') == 8) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                            <p>Минбар</p>
                        </a>
                    </li>
                @endcan
                @can('section_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.sections.index") }}" class="nav-link {{ request()->is("admin/sections") || request()->is("admin/sections/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs"></i>
                            <p>
                                {{ trans('cruds.section.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('tag_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.tags.index") }}" class="nav-link {{ request()->is("admin/tags") || request()->is("admin/tags/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs"></i>
                            <p>
                                {{ trans('cruds.tag.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('tutor_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.tutors.index") }}" class="nav-link {{ request()->is("admin/tutors") || request()->is("admin/tutors/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs"></i>
                            <p>
                                {{ trans('cruds.tutor.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
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
                @can('tutor_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.quotations.index") }}" class="nav-link {{ request()->is("admin/quotation") || request()->is("admin/quotation/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ 'Цитаталар' }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('video_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.videos.index") }}" class="nav-link {{ request()->is("admin/vidios") || request()->is("admin/vidios/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.video.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('banner_post_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.banner-posts.index") }}" class="nav-link {{ request()->is("admin/banner-posts") || request()->is("admin/banner-posts/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.bannerPost.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
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
                @can('poll_ovoz_berish_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/polls*") ? "menu-open" : "" }} {{ request()->is("admin/poll-variants*") ? "menu-open" : "" }} {{ request()->is("admin/poll-votes*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/polls*") ? "active" : "" }} {{ request()->is("admin/poll-variants*") ? "active" : "" }} {{ request()->is("admin/poll-votes*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.pollOvozBerish.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('poll_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.polls.index") }}" class="nav-link {{ request()->is("admin/polls") || request()->is("admin/polls/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.poll.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('poll_variant_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.poll-variants.index") }}" class="nav-link {{ request()->is("admin/poll-variants") || request()->is("admin/poll-variants/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.pollVariant.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('poll_vote_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.poll-votes.index") }}" class="nav-link {{ request()->is("admin/poll-votes") || request()->is("admin/poll-votes/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.pollVote.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
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
                @can('ad_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.ads.index") }}" class="nav-link {{ request()->is("admin/ads") || request()->is("admin/ads/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.ad.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
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
                @can('ad_view_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.ad-views.index") }}" class="nav-link {{ request()->is("admin/ad-views") || request()->is("admin/ad-views/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.adView.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('post_view_access')
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route("admin.post-views.index") }}" class="nav-link {{ request()->is("admin/post-views") || request()->is("admin/post-views/*") ? "active" : "" }}">--}}
{{--                            <i class="fa-fw nav-icon fas fa-cogs">--}}

{{--                            </i>--}}
{{--                            <p>--}}
{{--                                {{ trans('cruds.postView.title') }}--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="nav-item">
                        <a href="{{ route("admin.post-views-show.index") }}" class="nav-link {{ request()->is("admin/post-views-show") || request()->is("admin/post-views-show/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.postView.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
