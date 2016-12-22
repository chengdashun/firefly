<?php

namespace App\Task;

use Fly\Core\Task;

class TestTask extends Task
{
    public function handle()
    {
        file_put_contents(ROOT_PATH. '/storage/test.task', '1223456789', FILE_APPEND);
    }
}