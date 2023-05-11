<?php

namespace App\Http\Middleware;


use App\Models\CompanyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{

    protected $rootView = 'app';
    protected $company = [];
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
            $this->company = CompanyUser::where(['user_id' => $user->id])->first();
            return array_merge(parent::share($request), [
                'ziggy' => function () use ($request) {
                    return array_merge((new Ziggy())->toArray(), [
                        'status' => $this->status,
                        'company' => $this->company['company'],
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
