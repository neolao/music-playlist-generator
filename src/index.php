<?php
function rglob($pattern, $path)
{
    $paths = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
    $files = glob($path.$pattern, GLOB_MARK|GLOB_BRACE);
    foreach ($paths as $path) {
        $files = array_merge($files, rglob($pattern, $path));
    }
    return $files;
}

// Environment
$currentDirectory = $_SERVER['PWD'];

// Requirement
require_once(__DIR__ . '/classes/Util/Cli.php');
require_once(__DIR__ . '/classes/Generator.php');

use Playlist\Util\Cli;

// Get parameters
$arguments = $_SERVER['argv'];
$script = array_shift($arguments);
if (empty($arguments)) {
    echo Cli::getColoredString("Usage: $script configuration.json\n\n", 'white', 'red');
    exit;
}
$configurationPath = array_shift($arguments);
if ($configurationPath[0] !== '/') {
    $configurationPath = $currentDirectory . '/' . $configurationPath;
}
if (!is_file($configurationPath)) {
    echo Cli::getColoredString("File not found : $configurationPath\n\n", 'white', 'red');
    exit;
}

// Initialize the generator
try {
    $generator              = new Playlist\Generator();
    $generator->generate($configurationPath);
} catch (\Exception $error) {
    $message = $error->getMessage();
    echo Cli::getColoredString($message, 'white', 'red');
}
