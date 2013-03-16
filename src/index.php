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

// Autoload classes
function defaultAutoload($className)
{
    $className = ltrim($className, '\\');
    $filePath  = '';
    $lastNamespacePosition = strripos($className, '\\');
    if ($lastNamespacePosition) {
        $namespace = substr($className, 0, $lastNamespacePosition);
        $className = substr($className, $lastNamespacePosition + 1);
        $filePath  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
    }
    $filePath .= str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';

    require_once $filePath;
}
spl_autoload_register('defaultAutoload');
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . DIRECTORY_SEPARATOR . 'classes');

// Requirement
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
