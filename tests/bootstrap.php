<?php

require __DIR__ . '/../vendor/nette/nette/Nette/loader.php';

require __DIR__ . '/Mockista/MockistaInterface.php';
require __DIR__ . '/Mockista/Mockista.php';

$baseDir = __DIR__ . '/../NFormBuilder';
require $baseDir . '/Meta/Field.php';
require $baseDir . '/Meta/Metadata.php';
require $baseDir . '/Meta/Loader/ILoader.php';
require $baseDir . '/Meta/Loader/NetteDatabaseLoader.php';
require $baseDir . '/Builder.php';