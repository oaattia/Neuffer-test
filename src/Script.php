<?php
declare(strict_types=1);

namespace App;

use App\Actions\ArithmeticAction;
use App\Actions\DifferenceAction;
use App\Actions\DivideAction;
use App\Actions\MultiplyAction;
use App\Actions\SumAction;
use App\Exceptions\ActionNotFoundException;

class Script implements ScriptInterface
{
    public const OUTPUT_FILE_CSV = 'outputfile.csv';
    public const INFO_LOG = 'log.txt';
    private $actions = [
        'sum' => SumAction::class,
        'difference' => DifferenceAction::class,
        'multiply' => MultiplyAction::class,
        'division' => DivideAction::class,
    ];


    public function run($action, $file): void
    {
        if (!array_key_exists($action, $this->actions)) {
            throw new ActionNotFoundException("Invalid action selected");
        }
        $actionClass = $this->actions[$action];
        /** @var ArithmeticAction $actionObject */
        $actionObject = new $actionClass($file, self::OUTPUT_FILE_CSV,self::INFO_LOG);
        $actionObject->execute();
    }
}
