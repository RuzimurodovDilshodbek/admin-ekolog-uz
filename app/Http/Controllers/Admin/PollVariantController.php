<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPollVariantRequest;
use App\Http\Requests\StorePollVariantRequest;
use App\Http\Requests\UpdatePollVariantRequest;
use App\Models\Poll;
use App\Models\PollVariant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PollVariantController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('poll_variant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollVariants = PollVariant::with(['poll'])->get();

        return view('admin.pollVariants.index', compact('pollVariants'));
    }

    public function create()
    {
        abort_if(Gate::denies('poll_variant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $polls = Poll::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.pollVariants.create', compact('polls'));
    }

    public function store(StorePollVariantRequest $request)
    {
        $pollVariant = PollVariant::create($request->all());

        return redirect()->route('admin.poll-variants.index');
    }

    public function edit(PollVariant $pollVariant)
    {
        abort_if(Gate::denies('poll_variant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $polls = Poll::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pollVariant->load('poll');

        return view('admin.pollVariants.edit', compact('pollVariant', 'polls'));
    }

    public function update(UpdatePollVariantRequest $request, PollVariant $pollVariant)
    {
        $pollVariant->update($request->all());

        return redirect()->route('admin.poll-variants.index');
    }

    public function show(PollVariant $pollVariant)
    {
        abort_if(Gate::denies('poll_variant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollVariant->load('poll');

        return view('admin.pollVariants.show', compact('pollVariant'));
    }

    public function destroy(PollVariant $pollVariant)
    {
        abort_if(Gate::denies('poll_variant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollVariant->delete();

        return back();
    }

    public function massDestroy(MassDestroyPollVariantRequest $request)
    {
        $pollVariants = PollVariant::find(request('ids'));

        foreach ($pollVariants as $pollVariant) {
            $pollVariant->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
