<?php

namespace App\Http\Controllers\Web;


use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
        }
        $menu = Menu::create([
            'name' => $request->name,
        ]);
        if ($menu) {
            return redirect()->back()->with('flash', ['message' => CreateMessage('Menu ')]);
        }
        return redirect()->back()->withErrors(['Opps something went wrong!']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }
        $menu = Menu::where('id', $id)->update([
            'name' => $request->name,

        ]);
        if ($menu) {
            return redirect()->back()->with('flash', ['message' => 'Menu updated successfully.']);
        }
        return redirect()->back()->withErrors(['Opps something went wrong!']);
    }


    public function destroy($id)
    {
        $menu = Menu::where('id', $id)->first();
        if ($menu->delete()) {
            return response()->json(['success' => true, 'message' => 'Menu has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
