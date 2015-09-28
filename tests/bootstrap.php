<?php
define('ZULIP_TEST_DIR', __DIR__);
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    throw new RuntimeException('Please run composer');
}

/** @var \Composer\Autoload\ClassLoader $autoload */
$autoload = include __DIR__ . '/../vendor/autoload.php';
$autoload->addPsr4('ZulipTest\\', __DIR__);