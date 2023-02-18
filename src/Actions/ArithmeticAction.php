<?php
declare(strict_types=1);

namespace App\Actions;

use App\Exceptions\FileNotFoundException;

abstract class ArithmeticAction
{
    protected $inputFile;
    protected $outputFile;
    protected $logFile;
    protected $operation;

    public function __construct($inputFile, $outputFile, $logFile)
    {
        $this->inputFile = $inputFile;
        $this->outputFile = $outputFile;
        $this->logFile = $logFile;
    }

    /**
     * @throws FileNotFoundException
     */
    public function execute()
    {
        [$handle, $outputHandle, $logHandle] = $this->openFiles();

        while (($data = fgetcsv($handle, null, ';')) !== false) {
            $intData = array_map('intval', $data);

            $result = $this->performOperation($intData);

            if ($result > 0) {
                fputcsv($outputHandle, array_merge($intData, [$result]));
            } else {
                fwrite($logHandle,
                    "Error: ".$this->operation." of row ".implode(",", $intData)
                    ." is less than or equal to zero.\n");
            }
        }

        fclose($handle);
        fclose($outputHandle);
        fclose($logHandle);
    }

    private function openFiles(): array
    {
        $handle = fopen($this->inputFile, "r");
        if ($handle === false) {
            throw new FileNotFoundException("Failed to open input file: ".$this->inputFile);
        }

        $outputHandle = fopen($this->outputFile, "w");
        if ($outputHandle === false) {
            fclose($handle);
            throw new FileNotFoundException("Failed to open output file: ".$this->outputFile);
        }

        $logHandle = fopen($this->logFile, "w");
        if ($logHandle === false) {
            fclose($handle);
            fclose($outputHandle);
            throw new FileNotFoundException("Failed to open log file: ".$this->logFile);
        }

        return [$handle, $outputHandle, $logHandle];
    }

    abstract protected function performOperation(array $intData);
}