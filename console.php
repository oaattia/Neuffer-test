<?php

use App\Exceptions\ActionNotFoundException;
use App\Exceptions\FileNotFoundException;
use App\Script;
use App\ScriptInterface;

require __DIR__.'/vendor/autoload.php';

class ScriptRunner
{
    private $action;
    private $file;
    private $script;

    public function __construct($options, ScriptInterface $script) {
        $this->action = $options['a'] ?? $options['action'];
        $this->file = $options['f'] ?? $options['file'];

        $this->script = $script;
    }

    public function runScript() {
        $this->clearFileCreated(Script::OUTPUT_FILE_CSV);
        $this->clearFileCreated(Script::INFO_LOG);

        try {
            $this->script->run($this->action, $this->file);
        } catch (FileNotFoundException $exception) {
            echo "File not found: " . $exception->getMessage();
        } catch (ActionNotFoundException $exception) {
            echo "Action not found: " . $exception->getMessage();
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    private function clearFileCreated(string $fileName): void
    {
        if (file_exists($fileName)) {
            unlink($fileName);
        }
    }
}

$options = getopt("a:f:", ["action:", "file:"]);
$runner = new ScriptRunner($options, new Script());
$runner->runScript();
