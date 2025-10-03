<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sections')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Asosiy bo'limlar
        $xabarlar = Section::create([
            'title_uz' => 'Xabarlar',
            'title_ru' => 'Сообщения',
            'title_en' => 'Messages',
            'slug_uz' => 'xabarlar',
            'slug_ru' => 'soobsheniya',
            'slug_en' => 'messages',
            'parent_id' => null,
            'sort' => 1,
        ]);

        Section::create([
            'title_uz' => 'Xorijiy xabarlar',
            'title_ru' => 'Зарубежные сообщения',
            'title_en' => 'Foreign messages',
            'slug_uz' => 'xorijiy-xabarlar',
            'slug_ru' => 'zarubezhnye-soobsheniya',
            'slug_en' => 'foreign-messages',
            'parent_id' => $xabarlar->id,
            'sort' => 2,
        ]);

        Section::create([
            'title_uz' => 'Mahalliy xabarlar',
            'title_ru' => 'Местные сообщения',
            'title_en' => 'Local messages',
            'slug_uz' => 'mahalliy-xabarlar',
            'slug_ru' => 'mestnye-soobsheniya',
            'slug_en' => 'local-messages',
            'parent_id' => $xabarlar->id,
            'sort' => 3,
        ]);

        Section::create([
            'title_uz' => 'Intervyular',
            'title_ru' => 'Интервью',
            'title_en' => 'Interviews',
            'slug_uz' => 'intervyular',
            'slug_ru' => 'intervyu',
            'slug_en' => 'interviews',
            'parent_id' => $xabarlar->id,
            'sort' => 4,
        ]);

        $eko = Section::create([
            'title_uz' => 'Eko muammo',
            'title_ru' => 'Экологическая проблема',
            'title_en' => 'Eco problem',
            'slug_uz' => 'eko-muammo',
            'slug_ru' => 'eko-problema',
            'slug_en' => 'eco-problem',
            'parent_id' => null,
            'sort' => 5,
        ]);

        Section::create([
            'title_uz' => 'Iqlim o‘zgarishi',
            'title_ru' => 'Изменение климата',
            'title_en' => 'Climate change',
            'slug_uz' => 'iqlim-ozgarishi',
            'slug_ru' => 'izmenenie-klimata',
            'slug_en' => 'climate-change',
            'parent_id' => $eko->id,
            'sort' => 6,
        ]);

        Section::create([
            'title_uz' => 'Havo ifloslanishi',
            'title_ru' => 'Загрязнение воздуха',
            'title_en' => 'Air pollution',
            'slug_uz' => 'havo-ifloslanishi',
            'slug_ru' => 'zagryaznenie-vozdukha',
            'slug_en' => 'air-pollution',
            'parent_id' => $eko->id,
            'sort' => 7,
        ]);

        Section::create([
            'title_uz' => 'Bioxilma-xillik',
            'title_ru' => 'Биоразнообразие',
            'title_en' => 'Biodiversity',
            'slug_uz' => 'bioxilmaxillik',
            'slug_ru' => 'bioraznoobrazie',
            'slug_en' => 'biodiversity',
            'parent_id' => $eko->id,
            'sort' => 8,
        ]);

        Section::create([
            'title_uz' => 'Suv',
            'title_ru' => 'Вода',
            'title_en' => 'Water',
            'slug_uz' => 'suv',
            'slug_ru' => 'voda',
            'slug_en' => 'water',
            'parent_id' => $eko->id,
            'sort' => 9,
        ]);

        Section::create([
            'title_uz' => 'Cho‘llanish',
            'title_ru' => 'Опустынивание',
            'title_en' => 'Desertification',
            'slug_uz' => 'chollanish',
            'slug_ru' => 'opustynivanie',
            'slug_en' => 'desertification',
            'parent_id' => $eko->id,
            'sort' => 10,
        ]);

        Section::create([
            'title_uz' => 'Chiqindi',
            'title_ru' => 'Отходы',
            'title_en' => 'Waste',
            'slug_uz' => 'chiqindi',
            'slug_ru' => 'otkhody',
            'slug_en' => 'waste',
            'parent_id' => $eko->id,
            'sort' => 11,
        ]);

        Section::create([
            'title_uz' => 'Gender va ekologiya',
            'title_ru' => 'Гендер и экология',
            'title_en' => 'Gender and ecology',
            'slug_uz' => 'gender-va-ekologiya',
            'slug_ru' => 'gender-i-ekologiya',
            'slug_en' => 'gender-and-ecology',
            'parent_id' => $eko->id,
            'sort' => 12,
        ]);

        Section::create([
            'title_uz' => 'Din va ekologiya',
            'title_ru' => 'Религия и экология',
            'title_en' => 'Religion and ecology',
            'slug_uz' => 'din-va-ekologiya',
            'slug_ru' => 'religiya-i-ekologiya',
            'slug_en' => 'religion-and-ecology',
            'parent_id' => $eko->id,
            'sort' => 13,
        ]);

        $volontyor = Section::create([
            'title_uz' => 'Eko volontyorlik',
            'title_ru' => 'Экологическое волонтёрство',
            'title_en' => 'Eco volunteering',
            'slug_uz' => 'eko-volontyorlik',
            'slug_ru' => 'eko-volonterstvo',
            'slug_en' => 'eco-volunteering',
            'parent_id' => null,
            'sort' => 14,
        ]);

        Section::create([
            'title_uz' => 'Yashil maktab',
            'title_ru' => 'Зелёная школа',
            'title_en' => 'Green school',
            'slug_uz' => 'yashil-maktab',
            'slug_ru' => 'zelenaya-shkola',
            'slug_en' => 'green-school',
            'parent_id' => $volontyor->id,
            'sort' => 15,
        ]);

        Section::create([
            'title_uz' => 'Zoovolontyorlik',
            'title_ru' => 'Зооволонтёрство',
            'title_en' => 'Zoo volunteering',
            'slug_uz' => 'zoovolontyorlik',
            'slug_ru' => 'zoovolonterstvo',
            'slug_en' => 'zoo-volunteering',
            'parent_id' => $volontyor->id,
            'sort' => 16,
        ]);

        Section::create([
            'title_uz' => 'Ta’lim resurslari',
            'title_ru' => 'Образовательные ресурсы',
            'title_en' => 'Educational resources',
            'slug_uz' => 'talim-resurslari',
            'slug_ru' => 'obrazovatelnye-resursy',
            'slug_en' => 'educational-resources',
            'parent_id' => $volontyor->id,
            'sort' => 17,
        ]);

        Section::create([
            'title_uz' => 'Tanlov va grantlar',
            'title_ru' => 'Конкурсы и гранты',
            'title_en' => 'Contests and grants',
            'slug_uz' => 'tanlov-va-grantlar',
            'slug_ru' => 'konkursy-i-granty',
            'slug_en' => 'contests-and-grants',
            'parent_id' => $volontyor->id,
            'sort' => 18,
        ]);

        $murojaat = Section::create([
            'title_uz' => 'Murojaatlar',
            'title_ru' => 'Обращения',
            'title_en' => 'Applications',
            'slug_uz' => 'murojaatlar',
            'slug_ru' => 'obrasheniya',
            'slug_en' => 'applications',
            'parent_id' => null,
            'sort' => 19,
        ]);

        Section::create([
            'title_uz' => 'Rasmiy javob',
            'title_ru' => 'Официальный ответ',
            'title_en' => 'Official response',
            'slug_uz' => 'rasmiy-javob',
            'slug_ru' => 'ofitsialnyy-otvet',
            'slug_en' => 'official-response',
            'parent_id' => $murojaat->id,
            'sort' => 20,
        ]);

        Section::create([
            'title_uz' => 'Eko huquq',
            'title_ru' => 'Экологическое право',
            'title_en' => 'Eco law',
            'slug_uz' => 'eko-huquq',
            'slug_ru' => 'eko-pravo',
            'slug_en' => 'eco-law',
            'parent_id' => $murojaat->id,
            'sort' => 21,
        ]);

        $about = Section::create([
            'title_uz' => 'Biz haqimizda',
            'title_ru' => 'О нас',
            'title_en' => 'About us',
            'slug_uz' => 'biz-haqimizda',
            'slug_ru' => 'o-nas',
            'slug_en' => 'about-us',
            'parent_id' => null,
            'sort' => 22,
        ]);

        Section::create([
            'title_uz' => 'Ma’lumot',
            'title_ru' => 'Информация',
            'title_en' => 'Information',
            'slug_uz' => 'malumot',
            'slug_ru' => 'informatsiya',
            'slug_en' => 'information',
            'parent_id' => $about->id,
            'sort' => 23,
        ]);

        Section::create([
            'title_uz' => 'Xodimlar haqida ma’lumot',
            'title_ru' => 'Информация о сотрудниках',
            'title_en' => 'Staff information',
            'slug_uz' => 'xodimlar-haqida-malumot',
            'slug_ru' => 'informatsiya-o-sotrudnikakh',
            'slug_en' => 'staff-information',
            'parent_id' => $about->id,
            'sort' => 24,
        ]);

        Section::create([
            'title_uz' => 'Qayta aloqa',
            'title_ru' => 'Обратная связь',
            'title_en' => 'Feedback',
            'slug_uz' => 'qayta-aloqa',
            'slug_ru' => 'obratnaya-svyaz',
            'slug_en' => 'feedback',
            'parent_id' => $about->id,
            'sort' => 25,
        ]);
    }
}
