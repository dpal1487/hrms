<?php

namespace App\Http\Controllers\Web\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\OptionResource;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SettingImageController extends Controller
{
    public function index(Request $request)
    {
        $options = new Option();
        if (!empty($request->q)) {
            $options = $options->where('option_name', 'like', "%{$request->q}%")->orWhere('option_value', 'like', "%{$request->q}%");
        }
        if (!empty($request->s) || $request->s != '') {
            $options = $options->where('auto_load', $request->s);
        }
        return Inertia::render('Setting/Images/Index', [
            'options' => OptionResource::collection($options->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }

    public function create()
    {
        return Inertia::render('Setting/Images/Form');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'option_name' => 'required',
            // 'option_value' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        foreach ($request->option as $value) {
            $option = Option::create([
                'option_name' => $value['option_name'],
                'option_value' => json_encode($value['option_value']),
                'auto_load' => $value['auto_load'] ? 1 : 0,
            ]);
        }
        if ($option) {
            return response()->json([
                'success' => true,
                'message' => CreateMessage('Setting Image'),
            ]);
        } else {

            return response()->json([
                'success' => true,
                'message' => ErrorMessage(),
            ]);

            // return redirect('option-images')->with('flash', [
            //     'success' => false,
            //     'message' => ErrorMessage(),
            // ]);
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
            return redirect('option-images')->with('flash', [
                'success' => true,
                'message' => UpdateMessage('Setting'),
            ]);
        }
        return redirect('option-images')->with('flash', [
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
