<?php

namespace App\Providers;

use App\Auth\UserProvider;
use App\Hashing\IdCardHasher;
use App\Models\Dormitory;
use App\Models\DormitorySelection;
use App\Models\Student;
use App\Policies\StudentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
use Gate;
use DB;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

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
            return new UserProvider(
                new IdCardHasher(),
                Student::class
            );
        }
        );

        Gate::define('set-report', function (Student $student) {
            return !$student->hasReport();
        });

        Gate::define('select-dorm', function (Student $student, Dormitory $dormitory) {
            if(!$student->hasReport())
                return false;
            if(DormitorySelection::where('student_id', $student->id)->count()>0)
                return false;

            $departmentClassDormitory = DB::table('department_class_dormitory')
                ->where('department_class_id', $student->department_class_id)
                ->where('dormitory_id', $dormitory->id)
                ->first();
            if(is_null($departmentClassDormitory))
                return false;
            return $departmentClassDormitory->galleryful > $departmentClassDormitory->already_selected_num;
        });
    }
}
