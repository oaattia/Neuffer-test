<?php
declare(strict_types=1);

namespace Unit;

use App\Actions\MultiplyAction;
use PHPUnit\Framework\TestCase;

class MultiplyActionTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            'testExecuteMultiplyTwoNumbers' => [
                'tests/fixtures/two.csv',
                "5,2,10\n",
                ""
            ],
            'testExecuteMultiplyNegativeNumbers' => [
                'tests/fixtures/negative.csv',
                "-2,-55,110\n",
                ''
            ],
            'testExecuteMultiplyZero' => [
                'tests/fixtures/zero.csv',
                "",
                "Error: Multiply of row 1,0 is less than or equal to zero.\n"
            ],
            'testExecuteLessThanZero' => [
                'tests/fixtures/less-zero.csv',
                '',
                "Error: Multiply of row -2,55 is less than or equal to zero.\n"
            ]
        ];
    }

    /** @dataProvider dataProvider */
    public function testExecuteMultiplyTwoNumbers($inputFile, $expectedOutput, $expectedLog)
    {
        $outputFile = 'tests/fixtures/output.csv';
        $logFile = 'tests/fixtures/error.log';

        $action = new MultiplyAction($inputFile, $outputFile, $logFile);
        $action->execute();

        $this->assertFileExists($outputFile);
        $this->assertEquals($expectedOutput, file_get_contents($outputFile));

        $this->assertFileExists($logFile);
        $this->assertEquals($expectedLog, file_get_contents($logFile));

        unlink($outputFile);
        unlink($logFile);
    }
}
