<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function getAllFiles($directory) {
    $files = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $files[$file->getRealPath()] = $file->getSize();
        }
    }

    arsort($files); // Sort files by size in descending order
    return $files;
}

function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}

$directory = '/home/path/yourwebsitedirectory/urlgoeshere';
$allFiles = getAllFiles($directory);

$totalSize = array_sum($allFiles);

echo "<h2>All Files Sorted by Size:</h2>";
echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<thead>";
echo "<tr>";
echo "<th style='border: 1px solid black; padding: 8px;'>File Path</th>";
echo "<th style='border: 1px solid black; padding: 8px;'>Size</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

foreach ($allFiles as $file => $size) {
    echo "<tr>";
    echo "<td style='border: 1px solid black; padding: 8px;'>" . htmlspecialchars($file) . "</td>";
    echo "<td style='border: 1px solid black; padding: 8px;'>" . formatBytes($size) . "</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";

echo "<h3>Total Size of All Files: " . formatBytes($totalSize) . "</h3>";
?>
