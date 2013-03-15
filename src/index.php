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

// Get parameters
$arguments = $_SERVER['argv'];
array_shift($arguments);
if (empty($arguments)) {
    die("Configuration path is undefined\n");
}
$configurationPath = array_shift($arguments);
if ($configurationPath[0] !== '/') {
    $configurationPath = $currentDirectory . '/' . $configurationPath;
}
if (!is_file($configurationPath)) {
    die("File not found : $configurationPath\n");
}


// Parse the configuration file
$configurationContent   = file_get_contents($configurationPath);
$configuration          = json_decode($configurationContent);
$mediaDirectoryPath     = $configuration->mediaDirectoryPath;
$playlistPath           = $configuration->playlistPath;

// Get the exiftool path
$exiftoolPath           = 'exiftool';
if (isset($configuration->exiftoolPath)) {
    $exiftoolPath       = $configuration->exiftoolPath;
    if ($exiftoolPath[0] !== '/') {
        $exiftoolPath   = pathinfo($configurationPath, PATHINFO_DIRNAME) . '/' . $exiftoolPath;
    }
}

// Initialize the temporary file
$temporaryOutputPath    = tempnam(sys_get_temp_dir(), 'generator-temp.txt');
$temporaryOutput        = fopen($temporaryOutputPath, 'w+');

$filePaths = rglob('*.mp3', $mediaDirectoryPath);
echo 'Files: ', count($filePaths), "\n";
foreach ($filePaths as $filePath) {
    $command = $exiftoolPath . ' -json "' . $filePath . '" > "' . $temporaryOutputPath . '"';
    passthru($command, $output);

    // An error occurred
    if ($output !== 0) {
        continue;
    }

    // Get content of the exiftool result
    $content = '';
    fseek($temporaryOutput, 0);
    while (($buffer = fgets($temporaryOutput, 4096)) !== false) {
        $content .= $buffer;
    }

    $json = json_decode($content);
    $json = $json[0];

    $artist = null;
    $title = null;
    $note = null;
    if (isset($json->Artist)) {
        $artist = $json->Artist;
    }
    if (isset($json->Title)) {
        $title = $json->Title;
    }
    if (isset($json->Popularimeter)) {
        $note = $json->Popularimeter;
    }

    if (empty($artist) || empty($title)) {
        continue;
    }
    echo $artist, ' - ', $title, "\n";
}
echo "\n";
