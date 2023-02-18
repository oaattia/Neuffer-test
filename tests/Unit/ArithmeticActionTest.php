<?php
declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Actions\ArithmeticAction;
use App\Exceptions\FileNotFoundException;
class ArithmeticActionTest extends TestCase
{
    /**
     * @var string
     */
    private $inputFile;
    /**
     * @var string
     */
    private $outputFile;
    /**
     * @var string
     */
    private $logFile;

    protected function setUp(): void
    {
        $this->inputFile = 'tests/fixtures/input.csv';
        $this->outputFile = 'tests/fixtures/output.csv';
        $this->logFile = 'tests/fixtures/log.txt';
    }

    protected function tearDown(): void
    {
        unlink($this->inputFile);
        unlink($this->outputFile);
        unlink($this->logFile);
    }


    public function testException(): void
    {
        $mockAction = $this->getMockForAbstractClass(ArithmeticAction::class, [$this->inputFile, $this->outputFile, $this->logFile]);

        $this->expectException(FileNotFoundException::class);
        $mockAction->execute();
    }

    public function testExecute(): void
    {
        $mockAction = $this->getMockForAbstractClass(ArithmeticAction::class, [$this->inputFile, $this->outputFile, $this->logFile]);

        // Test that the output file and log file are created if the input file exists
        touch($this->inputFile);
        $mockAction->execute();
        $this->assertFileExists($this->outputFile);
        $this->assertFileExists($this->logFile);
        unlink($this->inputFile);
        unlink($this->outputFile);
        unlink($this->logFile);

        // Test that the operation is performed correctly and the result is written to the output file
        $mockAction = $this->getMockForAbstractClass(ArithmeticAction::class, [$this->inputFile, $this->outputFile, $this->logFile]);
        $mockAction->method('performOperation')->willReturnOnConsecutiveCalls(3, 9);
        file_put_contents($this->inputFile, "1;2\n4;5\n");
        $mockAction->execute();
        $this->assertFileExists($this->outputFile);
        $this->assertFileEquals('tests/fixtures/output.csv', $this->outputFile);
        $this->assertFileExists($this->logFile);
    }
}