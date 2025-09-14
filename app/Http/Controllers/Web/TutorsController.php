<?php
/**
 * Full name: Isxoqjon Axmedov
 * Email: isaakahmedov@gmail.com
 * Phone: +998936448111
 * Date: 30.08.2023
 */


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use App\Models\TutorOpinion;

class TutorsController extends Controller
{
    public function tutors()
    {

        $tutors = Tutor::query()
            ->orderBy("sort")
            ->get();


        return view("web.pages.tutors.tutors", compact("tutors"));

    }

    public function tutor($slug)
    {

        $tutor = Tutor::where("slug", $slug)->first();
//        $opinions = TutorOpinion::where("slug", $slug)->first();
//        dd($opinions);
        $opinions = $tutor->opinions()->paginate(10);
        if (!$tutor) {
            abort(404);
        }

        return view("web.pages.tutors.tutor", compact("tutor","opinions"));
    }

    public function opinion()
    {
        return view("web.pages.tutors.opinion");

    }
}
