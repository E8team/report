<?php
namespace App\Repositories;

use App\Models\Student;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class StudentRepository
{
    /**
     * 搜索学生(支持拼音和中文)
     * @param $studentNamePart
     * @return array|\Illuminate\Database\Eloquent\Builder
     */
    private function searchStudents($studentNamePart){
        //删除字符串中的空格
        $studentNamePart = str_replace(' ', '', $studentNamePart);

        //拆分中文和拼音
        $chinese = [];
        $pinyin = [];
        //匹配中文
        preg_match('/^[\x{4e00}-\x{9fa5}]+/u', $studentNamePart, $chinese);
        //匹配拼音
        preg_match('/[a-zA-Z]+$/', $studentNamePart, $pinyin);
        if(empty($chinese) && empty($pinyin)){
            throw new InvalidParameterException('输入有误');
        }
        $chinese = isset($chinese[0]) ? $chinese[0] : '';
        $pinyins = isset($pinyin[0]) ? [$pinyin[0], $pinyin[0]] : [];

        $query = Student::query();
        //获取拼音处理类
        $pinyinObj = app('pinyin');
        if('' !== $chinese){
            $query->where('student_name', 'like', $chinese.'%');
            if(!empty($pinyin)){
                $temp = $pinyinObj->name($chinese);

                $pinyins = [
                    implode('', array_map(function ($item){
                        return $item[0];
                    },$temp)).$pinyins[0],
                    implode('',$temp).$pinyins[1]
                ];
            }
        }
        if(!empty($pinyins)){
            $query->where(function ($query) use($pinyins){
                $query->where('abbreviation_pinyin1', 'like', $pinyins[0].'%')//是简拼?
                ->orWhere('abbreviation_pinyin2', 'like', $pinyins[0].'%')//是简拼？
                ->orWhere('full_pinyin1', 'like', $pinyins[1].'%')//是全拼？
                ->orWhere('full_pinyin2', 'like', $pinyins[1].'%');//是全拼？
            });
        }
        $query->orderBy('report_time');
        return $query;
    }

}