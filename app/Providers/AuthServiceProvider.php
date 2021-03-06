<?php

namespace App\Providers;

use App\Auth\StudentProvider;
use App\Exceptions\NotAllowReportException;
use App\Hashing\IdCardHasher;
use App\Models\Dormitory;
use App\Models\Student;
use App\Policies\DormitoryPolicy;
use App\Policies\StudentPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
use Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Dormitory::class => DormitoryPolicy::class,
        Student::class => StudentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //注册provider
        Auth::provider(
            'e8', function ($app) {
            return new StudentProvider(
                new IdCardHasher(),
                Student::class
            );
        }
        );

        Gate::define('set-report', function (Student $student) {
            if(!$student->isAllowReport())
                throw new NotAllowReportException();
            if ($student->hasBeenReport())
                throw new AuthorizationException('您已经完成报到了！');
            return true;
        });

        Gate::define('cancel-dorm', function (Student $student) {
            if(!$student->isAllowReport())
                throw new NotAllowReportException();
            if (!$student->hasBeenReport())
                throw new AuthorizationException('您还没有报到！');
            if ($student->hasBeenArriveDorm())
                throw new AuthorizationException('到达宿舍后无法自行更改宿舍！如需更改请联系迎新服务站！');
            return true;
        });
    }
}
