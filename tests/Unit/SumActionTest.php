<?php
declare(strict_types=1);

namespace Unit;

use App\Actions\DifferenceAction;
use App\Actions\SumAction;
use PHPUnit\Framework\TestCase;

class SumActionTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            'testExecuteSumTwoNumbers' => [
                'tests/fixtures/two.csv',
                "5,2,7\n",
                ""
            ],
            'testExecuteSumNegativeNumbers' => [
                'tests/fixtures/negative.csv',
                '',
                "Error: Sum of row -2,-55 is less than or equal to zero.\n"
            ],
            'testExecuteSumZero' => [
                'tests/fixtures/zero.csv',
                "1,0,1\n",
                ""
            ],
            'testExecuteLessThanZero' => [
                'tests/fixtures/less-zero.csv',
                "-2,55,53\n",
                ''
            ]
        ];
    }

    /** @dataProvider dataProvider */
    public function testExecuteSubtractingTwoNumbers($inputFile, $expectedOutput, $expectedLog)
    {
        $outputFile = 'tests/fixtures/output.csv';
        $logFile = 'tests/fixtures/error.log';

        $action = new SumAction($inputFile, $outputFile, $logFile);
        $action->execute();

        $this->assertFileExists($outputFile);
        $this->assertEquals($expectedOutput, file_get_contents($outputFile));

        $this->assertFileExists($logFile);
        $this->assertEquals($expectedLog, file_get_contents($logFile));

        unlink($outputFile);
        unlink($logFile);
    }
}
