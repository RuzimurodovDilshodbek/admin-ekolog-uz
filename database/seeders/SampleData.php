<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DailiyVerse;
use App\Models\Poll;
use App\Models\PollVariant;
use App\Models\PollVote;
use App\Models\Post;
use App\Models\Section;
use App\Models\Tag;
use App\Models\Tutor;
use App\Models\TutorOpinion;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

// Import Faker

class SampleData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();


//        Category::query()->truncate();
        // Create parent categories
        $parentCategories = [];
        for ($i = 0; $i < 5; $i++) { // Create 5 parent categories
            $parentCategories[] = Category::create([
                'title' => $faker->sentence(1), // Generate a fake product name
                'slug' => $faker->slug(), // Generate a fake description
                "status"=>1
            ]);
        }

        // Create child categories with random parent_id
        for ($i = 0; $i < 10; $i++) { // Create 10 child categories
            Category::create([
                'title' => $faker->sentence(1), // Generate a fake product name
                'slug' => $faker->slug(), // Generate a fake description
                'parent_id' => $faker->randomElement($parentCategories)->id,
                "status"=>1
            ]);
        }


//        Section::query()->truncate();
        // Create parent categories
        $parentSections = [];
        for ($i = 0; $i < 5; $i++) { // Create 5 parent categories
            $parentSections[] = Section::create([
                'title' => $faker->sentence(1), // Generate a fake product name
                'slug' => $faker->slug(), // Generate a fake description
                'status' => 1, // Generate a fake description
            ]);
        }

        // Create child categories with random parent_id
        for ($i = 0; $i < 10; $i++) { // Create 10 child categories
            Section::create([
                'title' => $faker->sentence(1), // Generate a fake product name
                'slug' => $faker->slug(), // Generate a fake description
                'parent_id' => $faker->randomElement($parentSections)->id,
                'status' => 1, // Generate a fake description
            ]);
        }


//        Post::query()->truncate();
        // Create child categories with random parent_id
        for ($i = 0; $i < 350; $i++) { // Create 10 child categories
            Post::create([
                'title_uz' => $faker->sentence(5),
                'title_kr' => $faker->sentence(5),
                'title_ru' => $faker->sentence(5),
                'title_en' => $faker->sentence(5),
                'content_uz' => $faker->sentence(500),
                'content_ru' => $faker->sentence(500),
                'content_en' => $faker->sentence(500),
                'content_kr' => $faker->sentence(500),
                'slug_uz' => $faker->slug(),
                'slug_ru' => $faker->slug(),
                'slug_en' => $faker->slug(),
                'slug_kr' => $faker->slug(),
                'status' => 1,
                'section_ids' => [$faker->randomElement($parentSections)->id],
                'category_ids' => [$faker->randomElement($parentCategories)->id],
            ]);
        }

        $tutors = [];
//        Tutor::query()->truncate();
        for ($i = 0; $i < 4; $i++) { // Create 10 child categories
            $tutors[] = Tutor::create([
                "slug" => $faker->slug,
                "firstname" => $faker->firstNameMale,
                "lastname" => $faker->lastName,
                "about" => $faker->sentence(10),
                "facebook" => $faker->url,
                "twitter" => $faker->url,
                "gmail" => $faker->url,
                "rss" => $faker->url,
                "youtube" => $faker->url,
                "linkedin" => $faker->url,
                "telegram" => $faker->url,
                "instagram" => $faker->url
            ]);
        }

        $opinions = [];

        for ($i = 0; $i < 500; $i++) { // Create 10 child categories
            $opinions[] = Post::create([
                'title' => $faker->sentence(5),
                'meta_title' => $faker->sentence(5),
                'meta_description' => $faker->sentence(5),
                'meta_keywords' => $faker->sentence(5),
                'content' => $faker->sentence(500),
                'slug' => $faker->slug(),
                'status' => 1,
                'tutor_id' => $faker->randomElement($tutors)->id,
            ]);
        }

        foreach ($opinions as $opinion) {
            TutorOpinion::create([
                "post_id" => $opinion->id,
                "short_title" => $faker->sentence(3),
            ]);
        }
//        DailiyVerse::query()->truncate();
        DailiyVerse::create([
            "text" => 'Ayting: "(Qur’on) imon keltirgan zotlar uchun hidoyat va shifodir" (Fussilat surasi, 44-oyat) ',
            "status" => 1
        ]);
        DailiyVerse::create([
            "text" => 'Kasal bo‘lgan vaqtimda Uning O‘zi menga shifo beradi (Shuaro surasi, 80-oyat) ',
            "status" => 1
        ]);
        DailiyVerse::create([
            "text" => ' Biz mo‘minlar uchun shifo va rahmat bo‘lgan Qur’on oyatlarini nozil qilamiz. (Isro surasi, 82-oyat) ',
            "status" => 1
        ]);
        DailiyVerse::create([
            "text" => ' Unda odamlar uchun shifo bordir. (Nahl surasi, 69-oyat) ',
            "status" => 1
        ]);
        DailiyVerse::create([
            "text" => ' Dillaridagi narsalarga shifo. (Yunus surasi, 57-oyat) ',
            "status" => 1
        ]);
        DailiyVerse::create([
            "text" => ' Mo‘min qavm dillariga shifo - orom beradi. (Tavba surasi, 14-oyat) ',
            "status" => 1
        ]);


//        PollVote::query()->truncate();
//        PollVariant::query()->truncate();
//        Poll::query()->truncate();

        $poll1 = Poll::create([
            "title" => "Dunyodagi eng uzun daryo?",
            "type" => "radio",
            "status" => 1,
            "sort" => 1
        ]);

        $poll2 = Poll::create([
            "title" => "Dunyodagi eng chuqur ko’l?",
            "type" => "radio",
            "status" => 1,
            "sort" => 2
        ]);


        $poll1Variants = [];
        $poll2Variants = [];

        $poll1Variants[] = PollVariant::create([
            'poll_id' => $poll1->id,
            'title' => "Nil",
            'sort' => 1,
            'is_coccect' => 1,
        ]);
        $poll1Variants[] = PollVariant::create([
            'poll_id' => $poll1->id,
            'title' => "Amazonka daryosi",
            'sort' => 2,
            'is_coccect' => 0,
        ]);
        $poll1Variants[] = PollVariant::create([
            'poll_id' => $poll1->id,
            'title' => "Ganga daryosi",
            'sort' => 3,
            'is_coccect' => 1,
        ]);

        $poll2Variants[] = PollVariant::create([
            'poll_id' => $poll2->id,
            'title' => "Kaspiy ko’li",
            'sort' => 1,
            'is_coccect' => 0,
        ]);
        $poll2Variants[] = PollVariant::create([
            'poll_id' => $poll2->id,
            'title' => "Baykal ko’li",
            'sort' => 2,
            'is_coccect' => 1,
        ]);
        $poll2Variants[] = PollVariant::create([
            'poll_id' => $poll2->id,
            'title' => "Chad ko’li",
            'sort' => 3,
            'is_coccect' => 0,
        ]);


        for ($i = 0; $i < 50; $i++) { // Create 10 child categories
            PollVote::create([
                'poll_id' => $poll1->id,
                'poll_variant_id' => $faker->randomElement($poll1Variants)->id,
                'client_ip' => $faker->ipv4()
            ]);

            PollVote::create([
                'poll_id' => $poll2->id,
                'poll_variant_id' => $faker->randomElement($poll2Variants)->id,
                'client_ip' => $faker->ipv4()
            ]);
        }

//        Tag::query()->truncate();

        for ($i = 0; $i < 15; $i++) { // Create 10 child categories

            Tag::create([
                'slug'=>$faker->slug,
                'title'=>$faker->title,
                'status'=>1,
            ]);
        }




    }
}
