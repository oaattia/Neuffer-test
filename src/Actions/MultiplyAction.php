<?php
declare(strict_types=1);

namespace App\Actions;

use Exception;

class MultiplyAction extends ArithmeticAction
{
    protected $operation = "Multiply";

    protected function performOperation(array $intData)
    {
        return array_product($intData);
    }
}
