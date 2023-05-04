<?php

namespace App\Http\Middleware;

use App\Http\Resources\NotificationResource;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';
    protected $company = [];
    protected $employee = [];
    protected $notificationCount = [];
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

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $user = Auth::user();
        $this->company = CompanyUser::where(['user_id' => $user->id])->first();
        // $this->employee = Employee::where(['user_id' => $user->id])->first();
        return array_merge(parent::share($request), [
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'status' => $this->status,
                    'company' => $this->company['company'],
                    // 'employee' => $this->employee['employee'],
                    'flash' => [
                        'message' => fn () => $request->session()->get('message'),
                    ],
                ]);
            },
        ]);
    }
}
