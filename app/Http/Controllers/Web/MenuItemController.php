<?php

namespace App\Http\Controllers\Web;


use App\Http\Resources\Web\MenuItemListResource;
use App\Http\Resources\Web\MenuListResource;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $menuLists = new MenuItem();
        if (!empty($request->q)) {
            $menuLists = $menuLists->where('title', 'like', "%$request->q%");
        }
        return Inertia::render('Menu/Index', [
            'menu_lists' => MenuItemListResource::collection($menuLists->orderBy('title', 'asc')->paginate(5)->appends($request->all())),
        ]);
    }
    public function create(Request $request)
    {
        $menuLists = new Menu();
        return Inertia::render('Menu/Create', [
            'menu_lists' => MenuListResource::collection($menuLists->get()),
            'parents' => MenuItem::where(['parent_id' => null])->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu' => 'required',
            'title' => 'required|unique:menu_items,title',
            'url' => 'required',
            'icon' => 'required',
            'color' => 'required',
            'order_by' => 'required',
            'route' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
        }
        $menu = MenuItem::create([
            'menu_id' => $request->menu,
            'title' => $request->title,
            'url' => $request->url,
            'target' => $request->target,
            'icon_class' => $request->icon,
            'color' => $request->color,
            'parent_id' => $request->parent,
            'order_by' => $request->order_by,
            'route' => $request->route,
            'parameters' => $request->parameters,
        ]);
        if ($menu) {
            return redirect('/menu-items')->with('flash', ['message' => 'Menu successfully added.']);
        }
        return redirect()->back()->withErrors(['Opps something went wrong!']);
    }

    public function edit(Request $request, $id)
    {
        $menuLists = new Menu();
        return Inertia::render('Menu/Edit', [
            'menu_lists' => MenuListResource::collection($menuLists->get()),
            'parents' => MenuItem::where(['parent_id' => null])->get(),
            'item' => MenuItem::find($id),
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'menu' => 'required',
            'title' => 'required',
            'url' => 'required',
            'icon' => 'required',
            'color' => 'required',
            'order_by' => 'required',
            'route' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
        }
        $menu = MenuItem::where(['id' => $id])->update([
            'menu_id' => $request->menu,
            'title' => $request->title,
            'url' => $request->url,
            'target' => $request->target,
            'icon_class' => $request->icon,
            'color' => $request->color,
            'parent_id' => $request->parent,
            'order_by' => $request->order_by,
            'route' => $request->route,
            'parameters' => $request->parameters,
        ]);
        if ($menu) {
            return redirect('/menu-items')->with('flash', ['message' => 'Menu successfully updated.']);
        }
        return redirect()->back()->withErrors(['Opps something went wrong!']);
    }


    public function destroy($id)
    {
        $permission = MenuItem::where('id', $id)->first();
        if ($permission->delete()) {
            return response()->json(['success' => true, 'message' => DeleteMessage('Permission')]);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
