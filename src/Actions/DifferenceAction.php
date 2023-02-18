<?php
declare(strict_types=1);

namespace App\Actions;


class DifferenceAction extends ArithmeticAction
{
    protected $operation = "Difference";

    protected function performOperation(array $intData)
    {
        $result = $intData[0];

        for ($i = 1; $i < count($intData); $i++) {
            $result -= $intData[$i];
        }

        return $result;
    }
}
