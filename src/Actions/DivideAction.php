<?php
declare(strict_types=1);

namespace App\Actions;

use Exception;

class DivideAction extends ArithmeticAction
{
    protected $operation = "Division";

    protected function performOperation(array $intData)
    {
        $result = $intData[0];

        for ($i = 1; $i < count($intData); $i++) {
            if ($intData[$i] === 0) {
                // Log an error if attempting to divide by zero
                return 0;
            }

            $result /= $intData[$i];
        }

        return $result;
    }
}
