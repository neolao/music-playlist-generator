#!/usr/bin/env php5
<?php
$source = realpath(__DIR__ . '/../src');
$bin    = realpath(__DIR__ . '/../bin');

// Create the PHAR archive
$phar = new Phar(
    $bin . '/music-playlist-generator.phar',
    Phar::CURRENT_AS_FILEINFO | Phar::KEY_AS_FILENAME,
    'music-playlist-generator.phar'
);

// Start buffering
$phar->startBuffering();

// Add files of the source
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source));
while ($iterator->valid()) {
    if (!$iterator->isDot()) {
        $filePath = $iterator->key();
        $localePath = substr($filePath, strlen($source) + 1);
        echo "Add $localePath \n";
        $phar->addFile($filePath, $localePath);
    }
    $iterator->next();
}

// Set the default stub
$defaultStub = $phar->createDefaultStub('index.php');

// The default stub is executable
$phar->setStub("#!/usr/bin/php \n".$defaultStub);

// Stop buffering
$phar->stopBuffering();
