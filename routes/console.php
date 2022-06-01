<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('env:rollback', function () {
    $projectPath = base_path();
    $cmd = 'find ' . $projectPath .' -type f ! -name "helpers.php" -print0 | xargs -0 -n 1 sed -i "s/envFromDB/env/g"';
    $this->comment(shell_exec($cmd));
    $this->comment('Done');
})->describe('Revert env system change');
