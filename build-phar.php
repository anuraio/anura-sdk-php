<?php
$pharFile = 'anura-sdk.phar';

if (!extension_loaded('phar')) {
    die('PHAR extension must be enabled.');
}

if (file_exists($pharFile)) {
    unlink($pharFile);
}

try {
    $phar = new \Phar($pharFile);

    $phar->startBuffering();
    
    $phar->buildFromDirectory(__DIR__ . '/src/Anura');
    // $phar->buildFromDirectory(__DIR__ . '/vendor');
    
    $phar->addFile('stub.php', 'stub.php');
    
    $phar->setStub($phar->createDefaultStub('stub.php'));
    $phar->stopBuffering();
    echo "PHAR successfully created at " . $pharFile;
} catch (Exception $e) {
    echo "error: " . $e->getMessage();
}
