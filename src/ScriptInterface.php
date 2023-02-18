<?php
declare(strict_types=1);

namespace App;

use App\Exceptions\ActionNotFoundException;
use App\Exceptions\FileNotFoundException;

interface ScriptInterface
{
    /**
     * @throws ActionNotFoundException
     * @throws FileNotFoundException
     */
    public function run($action, $file): void;
}