<?php

namespace App\Http\Controllers\Web\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\OptionResource;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SettingIconController extends Controller
{
    public function index(Request $request)
    {
        $options = Option::all();
        return Inertia::render('Setting/Icons/Index', [
            'options' => $options
        ]);
    }

    public function create()
    {
        return Inertia::render('Setting/Icons/Form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'option_name' => 'required',
            'option_value' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $option = Option::create([
            'option_name' => $request->option_name,
            'option_value' => json_encode($request->option_value),
            'auto_load' => $request->auto_load ? 1 : 0,
        ]);
        if ($option) {
            return redirect('setting-icons')->with('flash', [
                'success' => true,
                'message' => CreateMessage('Setting'),
            ]);
        } else {
            return redirect('setting-icons')->with('flash', [
                'success' => false,
                'message' => ErrorMessage(),
            ]);
        }
    }


    public function edit($id)
    {
        $option = Option::find($id);
        return Inertia::render('Setting/Images/Form', [
            'option' => new OptionResource($option)
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'option_name' => 'required',
            'option_value' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $setting = Option::find($id);
        if ($setting) {
            $setting = Option::where(['id' => $setting->id])->update([
                'option_name' => $request->option_name,
                'option_value' => json_encode($request->option_value),
                'auto_load' => $request->auto_load ? 1 : 0,
            ]);
            return redirect('setting-icons')->with('flash', [
                'success' => true,
                'message' => UpdateMessage('Setting'),
            ]);
        }
        return redirect('setting-icons')->with('flash', [
            'success' => false,
            'message' => ErrorMessage(),
        ]);
    }
    public function destroy($id)
    {
        $option = Option::find($id);
        if ($option->delete()) {
            return response()->json(['success' => true, 'message' =>    DeleteMessage('Option')]);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
    public function statusUdate(Request $request)
    {
        if (Option::where(['id' => $request->id])->update(['auto_load' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Banner Auto Load', $status), 'success' => true]);
        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }
}
