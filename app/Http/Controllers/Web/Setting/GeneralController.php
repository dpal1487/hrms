<?php

namespace App\Http\Controllers\Web\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\OptionResource;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class GeneralController extends Controller
{
    public function index(Request $request)
    {
        $generals = new Option();
        if (!empty($request->q)) {
            $generals = $generals->where('general', 'like', "%{$request->q}%")->orWhere('value', 'like', "%{$request->q}%")->orWhere('message', 'like', "%{$request->q}%");
        }
        return Inertia::render('Setting/Generals/Index', [
            'generals' => OptionResource::collection($generals->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }
    public function create()
    {
        return Inertia::render('Setting/Generals/Form');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }
        $general = Option::create([
            'option_name' => $request->name,
            'option_value' => $request->value,
            'auto_load' => $request->auto_load,
        ]);
        if ($general) {
            return redirect()->route('generals.index')->with('flash', ['success' => true, 'message' => CreateMessage('General')]);
        }
        return redirect()->route('generals.index')->with('flash', ['success' => false, 'message' => ErrorMessage()]);
    }

    public function edit(string $id)
    {
        return Inertia::render('Setting/Generals/Form', [
            'general' => new OptionResource(Option::find($id))
        ]);
    }
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'value' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }
        $general = Option::find($id);
        if ($general) {
            $general = Option::where(['id' => $id])->update([
                'option_name' => $request->name,
                'option_value' => $request->value,
                'auto_load' => $request->auto_load,
            ]);
            return redirect()->route('generals.index')->with('flash', ['success' => true, 'message' => UpdateMessage('General')]);
        }
        return redirect()->back()->withErrors(['success' => false, 'message' => ErrorMessage()]);
    }

    public function destroy($id)
    {
        $general = Option::find($id);
        if ($general->delete()) {
            return response()->json(['success' => true, 'message' => DeleteMessage('General')]);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
