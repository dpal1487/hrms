<?php

namespace App\Http\Middleware;

use App\Http\Resources\AddressResource;
use App\Http\Resources\MenuListResource;
use App\Models\CompanyAddress;
use App\Models\CompanyEmail;
use App\Models\CompanyUser;
use App\Models\Employee;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{

    protected $rootView = 'app';
    protected $status = [
        [
            'name' => 'All',
            'value' => '',
        ],
        [
            'name' => 'Active',
            'value' => '1',
        ],
        [
            'name' => 'Inactive',
            'value' => '0',
        ],
    ];


    public function version(Request $request)
    {
        return parent::version($request);
    }


    public function share(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            return array_merge(parent::share($request), [
                'ziggy' => function () use ($request) {
                    return array_merge((new Ziggy())->toArray(), [
                        'status' => $this->status,
                        'menus' => MenuListResource::collection(Menu::with(['items' => function ($q) {
                            $q->orderBy('title', 'asc');
                        }])->get()),
                        'flash' => [
                            'message' => fn () => $request->session()->get('message'),
                        ],
                    ]);
                },
            ]);
        }
        if ($user != "null") {
            return array_merge(parent::share($request), [
                'ziggy' => function () use ($request) {
                    return array_merge((new Ziggy())->toArray(), [
                        'status' => $this->status,
                        'flash' => [
                            'message' => fn () => $request->session()->get('message'),
                        ],
                    ]);
                },
            ]);
        }
    }
}
