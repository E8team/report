<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Excel;
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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fileName = $this->argument('file') . '.xlsx';
        $filesystem = Storage::disk('local');
        if (!$filesystem->exists($fileName)) {
            return $this->error($fileName . '文件不存在');
        }
        Excel::load(config('filesystems.disks.local.root') . DIRECTORY_SEPARATOR . $fileName, function ($reader) {
            dd($reader->toArray());
        });
    }
}
