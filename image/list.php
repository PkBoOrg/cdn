<?php

define('BASE_URL', 'https://cdn.hey.onylab.com/image/');

$directoryIterator = new RecursiveDirectoryIterator('./', FilesystemIterator::SKIP_DOTS);
$directories = array();
foreach ($directoryIterator as $directory) {
    if ($directory->isDir()){
        $directories[] = (object)['path' => $directory->getPathname(), 'files' => []];
    }
}

foreach ($directories as $directory) {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory->path));

    $files = array();
    foreach ($rii as $file) {
        if ($file->isDir()){
            continue;
        }
        $directory->files[] = $file->getPathname();
    }
}

$content = '';
foreach ($directories as $directory) {
    if (count($directory->files) > 0) {
        $content .= '<h1 id="' . basename($directory->path) . '">' . basename($directory->path) . '</h1>';
        $content .= '<ul>';
        foreach($directory->files as $file) {
            $filePath = str_replace('\\', '/', $file);
            $filePath = ltrim($filePath, './');
            $content .= '<li><a href="' . BASE_URL . $filePath . '" target="_blank">' . $filePath . '</a></li>';
        }
        $content .= '</ul>';
    }
    echo $directory->path . ': ' . count($directory->files) . ' files' . PHP_EOL;
}

$page = '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Content</title>
  </head>
  <body>
    ' . $content . '
  </body>
</html>';

file_put_contents('index.html', $page);
