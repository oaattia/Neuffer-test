<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\DifferenceAction;
use PHPUnit\Framework\TestCase;

class DifferenceActionTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            'testExecuteSubtractingTwoNumbers' => [
                'tests/fixtures/two.csv',
                "5,2,3\n",
                ""
            ],
            'testExecuteSubtractingNegativeNumbers' => [
                'tests/fixtures/negative.csv',
                "-2,-55,53\n",
                ''
            ],
            'testExecuteSubtractingZero' => [
                'tests/fixtures/zero.csv',
                "1,0,1\n",
                ""
            ],
            'testExecuteLessThanZero' => [
                'tests/fixtures/less-zero.csv',
                '',
                "Error: Difference of row -2,55 is less than or equal to zero.\n"
            ]
        ];
    }

    /** @dataProvider dataProvider */
    public function testExecuteSubtractingTwoNumbers($inputFile, $expectedOutput, $expectedLog)
    {
        $outputFile = 'tests/fixtures/output.csv';
        $logFile = 'tests/fixtures/error.log';

        $action = new DifferenceAction($inputFile, $outputFile, $logFile);
        $action->execute();

        $this->assertFileExists($outputFile);
        $this->assertEquals($expectedOutput, file_get_contents($outputFile));

        $this->assertFileExists($logFile);
        $this->assertEquals($expectedLog, file_get_contents($logFile));

        unlink($outputFile);
        unlink($logFile);
    }
}
