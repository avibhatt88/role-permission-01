<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFpcRequest;
use App\Http\Requests\StoreFpcRequest;
use App\Http\Requests\UpdateFpcRequest;
use App\Models\District;
use App\Models\Fpc;
use App\Models\State;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FpcController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fpc_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fpcs = Fpc::with(['state', 'district'])->get();

        return view('admin.fpcs.index', compact('fpcs'));
    }

    public function create()
    {
        abort_if(Gate::denies('fpc_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $states = State::pluck('state', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::pluck('district', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.fpcs.create', compact('districts', 'states'));
    }

    public function store(StoreFpcRequest $request)
    {
        $fpc = Fpc::create($request->all());

        return redirect()->route('admin.fpcs.index');
    }

    public function edit(Fpc $fpc)
    {
        abort_if(Gate::denies('fpc_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $states = State::pluck('state', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::pluck('district', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fpc->load('state', 'district');

        return view('admin.fpcs.edit', compact('districts', 'fpc', 'states'));
    }

    public function update(UpdateFpcRequest $request, Fpc $fpc)
    {
        $fpc->update($request->all());

        return redirect()->route('admin.fpcs.index');
    }

    public function show(Fpc $fpc)
    {
        abort_if(Gate::denies('fpc_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fpc->load('state', 'district');

        return view('admin.fpcs.show', compact('fpc'));
    }

    public function destroy(Fpc $fpc)
    {
        abort_if(Gate::denies('fpc_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fpc->delete();

        return back();
    }

    public function massDestroy(MassDestroyFpcRequest $request)
    {
        $fpcs = Fpc::find(request('ids'));

        foreach ($fpcs as $fpc) {
            $fpc->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
