<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'section_create',
            ],
            [
                'id'    => 18,
                'title' => 'section_edit',
            ],
            [
                'id'    => 19,
                'title' => 'section_show',
            ],
            [
                'id'    => 20,
                'title' => 'section_delete',
            ],
            [
                'id'    => 21,
                'title' => 'section_access',
            ],
            [
                'id'    => 22,
                'title' => 'category_create',
            ],
            [
                'id'    => 23,
                'title' => 'category_edit',
            ],
            [
                'id'    => 24,
                'title' => 'category_show',
            ],
            [
                'id'    => 25,
                'title' => 'category_delete',
            ],
            [
                'id'    => 26,
                'title' => 'category_access',
            ],
            [
                'id'    => 27,
                'title' => 'tag_create',
            ],
            [
                'id'    => 28,
                'title' => 'tag_edit',
            ],
            [
                'id'    => 29,
                'title' => 'tag_show',
            ],
            [
                'id'    => 30,
                'title' => 'tag_delete',
            ],
            [
                'id'    => 31,
                'title' => 'tag_access',
            ],
            [
                'id'    => 32,
                'title' => 'post_create',
            ],
            [
                'id'    => 33,
                'title' => 'post_edit',
            ],
            [
                'id'    => 34,
                'title' => 'post_show',
            ],
            [
                'id'    => 35,
                'title' => 'post_delete',
            ],
            [
                'id'    => 36,
                'title' => 'post_access',
            ],
            [
                'id'    => 37,
                'title' => 'tutor_create',
            ],
            [
                'id'    => 38,
                'title' => 'tutor_edit',
            ],
            [
                'id'    => 39,
                'title' => 'tutor_show',
            ],
            [
                'id'    => 40,
                'title' => 'tutor_delete',
            ],
            [
                'id'    => 41,
                'title' => 'tutor_access',
            ],
            [
                'id'    => 42,
                'title' => 'banner_post_create',
            ],
            [
                'id'    => 43,
                'title' => 'banner_post_edit',
            ],
            [
                'id'    => 44,
                'title' => 'banner_post_show',
            ],
            [
                'id'    => 45,
                'title' => 'banner_post_delete',
            ],
            [
                'id'    => 46,
                'title' => 'banner_post_access',
            ],
            [
                'id'    => 47,
                'title' => 'dailiy_verse_create',
            ],
            [
                'id'    => 48,
                'title' => 'dailiy_verse_edit',
            ],
            [
                'id'    => 49,
                'title' => 'dailiy_verse_show',
            ],
            [
                'id'    => 50,
                'title' => 'dailiy_verse_delete',
            ],
            [
                'id'    => 51,
                'title' => 'dailiy_verse_access',
            ],
            [
                'id'    => 52,
                'title' => 'tutor_opinion_create',
            ],
            [
                'id'    => 53,
                'title' => 'tutor_opinion_edit',
            ],
            [
                'id'    => 54,
                'title' => 'tutor_opinion_show',
            ],
            [
                'id'    => 55,
                'title' => 'tutor_opinion_delete',
            ],
            [
                'id'    => 56,
                'title' => 'tutor_opinion_access',
            ],
            [
                'id'    => 57,
                'title' => 'post_view_create',
            ],
            [
                'id'    => 58,
                'title' => 'post_view_edit',
            ],
            [
                'id'    => 59,
                'title' => 'post_view_show',
            ],
            [
                'id'    => 60,
                'title' => 'post_view_delete',
            ],
            [
                'id'    => 61,
                'title' => 'post_view_access',
            ],
            [
                'id'    => 62,
                'title' => 'post_comment_create',
            ],
            [
                'id'    => 63,
                'title' => 'post_comment_edit',
            ],
            [
                'id'    => 64,
                'title' => 'post_comment_show',
            ],
            [
                'id'    => 65,
                'title' => 'post_comment_delete',
            ],
            [
                'id'    => 66,
                'title' => 'post_comment_access',
            ],
            [
                'id'    => 67,
                'title' => 'poll_create',
            ],
            [
                'id'    => 68,
                'title' => 'poll_edit',
            ],
            [
                'id'    => 69,
                'title' => 'poll_show',
            ],
            [
                'id'    => 70,
                'title' => 'poll_delete',
            ],
            [
                'id'    => 71,
                'title' => 'poll_access',
            ],
            [
                'id'    => 72,
                'title' => 'poll_variant_create',
            ],
            [
                'id'    => 73,
                'title' => 'poll_variant_edit',
            ],
            [
                'id'    => 74,
                'title' => 'poll_variant_show',
            ],
            [
                'id'    => 75,
                'title' => 'poll_variant_delete',
            ],
            [
                'id'    => 76,
                'title' => 'poll_variant_access',
            ],
            [
                'id'    => 77,
                'title' => 'poll_vote_create',
            ],
            [
                'id'    => 78,
                'title' => 'poll_vote_edit',
            ],
            [
                'id'    => 79,
                'title' => 'poll_vote_show',
            ],
            [
                'id'    => 80,
                'title' => 'poll_vote_delete',
            ],
            [
                'id'    => 81,
                'title' => 'poll_vote_access',
            ],
            [
                'id'    => 82,
                'title' => 'favourite_create',
            ],
            [
                'id'    => 83,
                'title' => 'favourite_edit',
            ],
            [
                'id'    => 84,
                'title' => 'favourite_show',
            ],
            [
                'id'    => 85,
                'title' => 'favourite_delete',
            ],
            [
                'id'    => 86,
                'title' => 'favourite_access',
            ],
            [
                'id'    => 87,
                'title' => 'ad_create',
            ],
            [
                'id'    => 88,
                'title' => 'ad_edit',
            ],
            [
                'id'    => 89,
                'title' => 'ad_show',
            ],
            [
                'id'    => 90,
                'title' => 'ad_delete',
            ],
            [
                'id'    => 91,
                'title' => 'ad_access',
            ],
            [
                'id'    => 92,
                'title' => 'ad_view_create',
            ],
            [
                'id'    => 93,
                'title' => 'ad_view_edit',
            ],
            [
                'id'    => 94,
                'title' => 'ad_view_show',
            ],
            [
                'id'    => 95,
                'title' => 'ad_view_delete',
            ],
            [
                'id'    => 96,
                'title' => 'ad_view_access',
            ],
            [
                'id'    => 97,
                'title' => 'newsletter_create',
            ],
            [
                'id'    => 98,
                'title' => 'newsletter_edit',
            ],
            [
                'id'    => 99,
                'title' => 'newsletter_show',
            ],
            [
                'id'    => 100,
                'title' => 'newsletter_delete',
            ],
            [
                'id'    => 101,
                'title' => 'newsletter_access',
            ],
            [
                'id'    => 102,
                'title' => 'poll_ovoz_berish_access',
            ],
            [
                'id'    => 103,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 104,
                'title' => 'video_create',
            ],
            [
                'id'    => 105,
                'title' => 'video_list',
            ],
            [
                'id'    => 106,
                'title' => 'video_show',
            ],
            [
                'id'    => 107,
                'title' => 'video_delete',
            ],
            [
                'id'    => 108,
                'title' => 'video_access',
            ],
            [
                'id'    => 109,
                'title' => 'video_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
