<?php

namespace App\Http\Controllers;


use App\Models\DepartmentClass;
use App\Models\Dormitory;
use App\Transformers\DormitoryInclassTransformer;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function admin()
    {
        return view('admin');
    }

    public function showImportDormitoryForm()
    {
        $departmentClassRepository = app(\App\Repositories\DepartmentClassRepositoryInterface::class);
        $grade = $departmentClassRepository->grades(1)->where('title', date('Y'))->first();
        $majors = $departmentClassRepository->majors($grade);
        $classes = collect();
        foreach ($majors as $major) {
            $classes = $classes->merge($departmentClassRepository->classes($major));
        }
        return view('import_dormitory', ['classes' => $classes]);
    }

    public function importDormitory()
    {

        $request = app('request');
        $this->validate($request, [
            'department_class_id' => 'required|integer',
            'gender' => 'required|in:0,1',
            'dorm_num' => 'required|string',
            'type' => 'required|in:normal,hesu,chasu',
            // 'hesu_people_num' => '',
            // 'chasu_people_num' => 'required|in:hesu,chasu',
        ]);
        $dormNum = $request->get('dorm_num');
        if (strlen($dormNum) == 5) {
            $dormNum = '0' . $dormNum;
        }
        $dormNum = strtoupper($dormNum);
        $departmentClass = DepartmentClass::findOrFail($request->get('department_class_id'));
        $type = $request->get('type');
        switch ($type) {
            case 'normal':
                if($this->hasDormitory($dormNum)){
                    return redirect()->back()->withInput()->withErrors(['dorm_num' => '该宿舍号已存在']);
                }
                $dormitory = Dormitory::create([
                    'galleryful' => 6,
                    'dorm_num' => $dormNum,
                    'insert_dormitory_num' => 0,
                    'is_together_dormitory' => 0,
                    'gender' => (bool)$request->get('gender')
                ]);
                $departmentClass->dormitories()->attach($dormitory->id, [
                    'galleryful' => 6,
                    'already_selected_num' => 0,
                ]);
                break;
            case 'hesu':
                $hesuPeopleNum = $request->get('hesu_people_num');
                if (!$hesuPeopleNum) {
                    return redirect()->back()->withInput()->withErrors(['hesu_people_num' => '请输入合宿人数']);
                }
                $dormitory = Dormitory::firstOrCreate(['dorm_num' => $dormNum], [
                    'galleryful' => 6,
                    'dorm_num' => $dormNum,
                    'insert_dormitory_num' => 0,
                    'is_together_dormitory' => 1,
                    'gender' => (bool)$request->get('gender')
                ]);
                $departmentClass->dormitories()->attach($dormitory->id, [
                    'galleryful' => $hesuPeopleNum,
                    'already_selected_num' => 0,
                ]);
                break;
            case 'chasu':
                if($this->hasDormitory($dormNum)){
                    return redirect()->back()->withInput()->withErrors(['dorm_num' => '该宿舍号已存在']);
                }
                $chasuPeopleNum = $request->get('chasu_people_num');
                if (!$chasuPeopleNum) {
                    return redirect()->back()->withInput()->withErrors(['chasu_people_num' => '请输入插宿人数']);
                }
                $dormitory = Dormitory::create([
                    'galleryful' => 6,
                    'dorm_num' => $dormNum,
                    'insert_dormitory_num' => $chasuPeopleNum,
                    'is_together_dormitory' => 0,
                    'gender' => (bool)$request->get('gender')
                ]);
                $departmentClass->dormitories()->attach($dormitory->id, [
                    'galleryful' => $chasuPeopleNum,
                    'already_selected_num' => 0,
                ]);
                break;
        }
        $request->session()->flash('status', '插入宿舍成功');
        return redirect()->back();

    }

    private function hasDormitory($dormNum)
    {
        return Dormitory::where('dorm_num', $dormNum)->count() > 0;
    }
}
