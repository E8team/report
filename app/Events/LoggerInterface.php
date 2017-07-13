<?php

namespace App\Events;

use App\Models\Log;

interface LoggerInterface
{
    const NORMAL_LOG = Log::NORMAL_LOG;
    const NEED_SHOW_LOG = Log::NEED_SHOW_LOG;

    public function logLevel();

    /**
     * 获取日志
     * @return string|false 如果返回 false 则此log不记录
     */
    public function log();
}
