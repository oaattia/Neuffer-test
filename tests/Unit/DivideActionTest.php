<?php
declare(strict_types=1);

namespace Unit;

use App\Actions\DivideAction;
use PHPUnit\Framework\TestCase;

class DivideActionTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            'testExecuteDivideTwoNumbers' => [
                'tests/fixtures/two.csv',
                "5,2,2.5\n",
                ""
            ],
            'testExecuteDivideNegativeNumbers' => [
                'tests/fixtures/negative.csv',
                "-2,-55,0.036363636363636\n",
                ''
            ],
            'testExecuteDivideZero' => [
                'tests/fixtures/zero.csv',
                '',
                "Error: Division of row 1,0 is less than or equal to zero.\n"
            ],
            'testExecuteLessThanZero' => [
                'tests/fixtures/less-zero.csv',
                '',
                "Error: Division of row -2,55 is less than or equal to zero.\n"
            ]
        ];
    }

    /** @dataProvider dataProvider */
    public function testExecuteSubtractingTwoNumbers($inputFile, $expectedOutput, $expectedLog)
    {
        $outputFile = 'tests/fixtures/output.csv';
        $logFile = 'tests/fixtures/error.log';

        $action = new DivideAction($inputFile, $outputFile, $logFile);
        $action->execute();

        $this->assertFileExists($outputFile);
        $this->assertEquals($expectedOutput, file_get_contents($outputFile));

        $this->assertFileExists($logFile);
        $this->assertEquals($expectedLog, file_get_contents($logFile));

        unlink($outputFile);
        unlink($logFile);
    }
}
