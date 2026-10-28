<?php

// Define valid entry point
define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
chdir(__DIR__);

// Load bootstrap
require __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));
