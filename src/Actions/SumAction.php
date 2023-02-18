<?php
declare(strict_types=1);

namespace App\Actions;

class SumAction extends ArithmeticAction
{
    protected $operation = "Sum";

    protected function performOperation(array $intData)
    {
        return array_sum($intData);
    }
}
