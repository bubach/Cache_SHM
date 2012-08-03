<?php
$extrafiles = array();
$phpDir = Pyrus\Config::current()->php_dir . DIRECTORY_SEPARATOR;
$packages = array('PEAR2/Autoload');

$oldCwd = getcwd();
chdir($phpDir);
foreach ($packages as $pkg) {
    if (is_dir($pkg)) {
        foreach (
            new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(
                    $pkg,
                    RecursiveDirectoryIterator::UNIX_PATHS
                ),
                RecursiveIteratorIterator::LEAVES_ONLY
            ) as $path
        ) {
            $extrafiles['src/' . $path->getPathname()] = $path->getRealPath();
        }
    }
    
    if (is_file($pkg . '.php')) {
        $extrafiles['src/' . $pkg . '.php']
            = $phpDir . DIRECTORY_SEPARATOR . $pkg . '.php';
    }
}
chdir($oldCwd);