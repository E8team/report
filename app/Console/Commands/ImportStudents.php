<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Models\StudentProfile;
use App\Repositories\DepartmentClassRepositoryInterface;
use Illuminate\Console\Command;
use Excel;
use Overtrue\Pinyin\Pinyin;
use Storage;

class ImportStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:students {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导入学生数据';

    protected $departmentClassRepository;

    protected $pinyin;

    /**
     * Create a new command instance.
     * ImportStudents constructor.
     * @param DepartmentClassRepositoryInterface $departmentClassRepository
     */
    public function __construct(DepartmentClassRepositoryInterface $departmentClassRepository, Pinyin $pinyin)
    {
        parent::__construct();
        $this->departmentClassRepository = $departmentClassRepository;
        $this->pinyin = $pinyin;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        /**
         * 字段列表
         * department class major student_num name gender birthday birthplace id_card
         */
        $fileName = $this->argument('file') . '.xlsx';
        $filesystem = Storage::disk('local');
        if (!$filesystem->exists($fileName)) {
            return $this->error($fileName . '文件不存在');
        }
        Excel::load(config('filesystems.disks.local.root') . DIRECTORY_SEPARATOR . $fileName, function ($reader) {
            $data = $reader->get();
            $data = $data->filter(function ($item){
                foreach ($item->all() as $v){
                    return !is_null($v);
                }
                return true;
            });
            $bar = $this->output->createProgressBar($data->count());
            $data->map(function ($item) use ($bar) {

                $departmentClassId = $this->getDepartmentClassId($item->department, $item->class, $item->major);

                $fullPinyin1 = $this->pinyin->name($item->name);
                $fullPinyin2 = $this->pinyin->convert($item->name);


                $abbreviationPinyin1 = implode('', array_map(function ($item) {
                    return $item[0];
                }, $fullPinyin1));

                $abbreviationPinyin2 = implode('', array_map(function ($item) {
                    return $item[0];
                }, $fullPinyin2));

                $needTwoPinyin = $abbreviationPinyin1 !== $abbreviationPinyin2;
                $fullPinyin1 = implode('', $fullPinyin1);
                $fullPinyin2 = implode('', $fullPinyin2);

                $student = Student::create([
                    'student_num' => $item->student_num,
                    'student_name' => $item->name,
                    'abbreviation_pinyin1' => $abbreviationPinyin1,
                    'abbreviation_pinyin2' => $needTwoPinyin ? $abbreviationPinyin2 : '',
                    'full_pinyin1' => $fullPinyin1,
                    'full_pinyin2' => $needTwoPinyin ? $fullPinyin2 : '',
                    'department_class_id' => $departmentClassId['department_class_id'],
                    'department_id' => $departmentClassId['department_id'],
                    'gender' => $item->gender == '女',
                    'id_card' => $item->id_card
                ]);

                StudentProfile::create([
                    'student_id' => $student->id,
                    'place_of_student' => $item->birthplace,
                ]);
                $bar->advance();
            });
            $bar->finish();
        });
    }


    protected function getDepartmentClassId($department, $className, $major)
    {
        $gradeAndClassNum = $this->parseClassName($className);
        return $this->departmentClassRepository->getId($department, $gradeAndClassNum['grade'], $major, $gradeAndClassNum['classNum']);
    }

    protected function parseClassName($className)
    {
        static $year = null;
        if (is_null($year)) $year = substr(date('Y'), 0, 2);
        $m = [];
        preg_match('/.*(\d\d)\((\d+)\)/', $className, $m);
        return [
            'grade' => strlen($m[1]) == 2 ? $year . $m[1] : $m[1],
            'classNum' => $m[2],
        ];
    }
}
