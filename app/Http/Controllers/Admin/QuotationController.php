<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\Post;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Gate;


class QuotationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $quotations = Quotation::query()->get();

        return view('admin.quotation.index', compact('quotations'));
    }
    public function create(Request $request)
    {
        $catTab = 0;

        $locales = config('app.locales');

        return view('admin.quotation.create', compact('catTab', 'locales'));
    }
    public function store(StoreQuotationRequest $request)
    {
        if ($request->image_base64) {
            $imageName= $this->storeBase64($request->image_base64);
        }

        $quotation = Quotation::create([
            'status' => $request->status,
            'title_uz' => $request->title_uz,
            'title_kr' => $request->title_kr,
            'title_ru' => $request->title_ru,
            'title_en' => $request->title_en,
            'author_name_uz' => $request->author_name_uz,
            'author_name_kr' => $request->author_name_kr,
            'author_name_ru' => $request->author_name_ru,
            'author_name_en' => $request->author_name_en,
        ]);

        if ($imageName) {
            $quotation->addMedia(storage_path('tmp/uploads/' . $imageName))->toMediaCollection('main_image');
        }

        return redirect()->route('admin.quotations.index');
    }
    public function edit(Quotation $quotation)
    {
        $catTab = 0;

        $locales = config('app.locales');

        return view('admin.quotation.edit',compact('quotation','catTab','locales') );
    }
    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {
        $imageName = null;
        if ($request->image_base64) {
            $imageName= $this->storeBase64($request->image_base64);
        }

        $quotation->update($request->all());

        if ($imageName) {
            $quotation->addMedia(storage_path('tmp/uploads/' . $imageName))->toMediaCollection('main_image');
        }
        return redirect()->route('admin.quotations.index');

    }

    public function show(Quotation $quotation)
    {
        return view('admin.quotation.show', compact('quotation'));
    }

    public function destroy(Quotation $quotation)
    {
        $quotation->delete();

        return back();
    }

    private function storeBase64($imageBase64)
    {
        list($type, $imageBase64) = explode(';', $imageBase64);
        list(, $imageBase64)      = explode(',', $imageBase64);
        $imageBase64 = base64_decode($imageBase64);
        $imageName= time().'.png';
        $path =  storage_path('tmp/uploads/' . $imageName);
        file_put_contents($path, $imageBase64);

        return $imageName;
    }
}
