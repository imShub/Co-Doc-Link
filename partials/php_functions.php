<?php
    // Convert file byter size in different formats 
 function formatFileSize($sizeInBytes) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $unitIndex = 0;

    while ($sizeInBytes >= 1024 && $unitIndex < count($units) - 1) {
        $sizeInBytes /= 1024;
        $unitIndex++;
    }

    $formattedSize = round($sizeInBytes, 2) . ' ' . $units[$unitIndex];

    // Optionally, you can add logic to convert to MB or GB as needed
    if ($units[$unitIndex] == 'KB') {
        $formattedSize = round($sizeInBytes, 2) . ' ' . $units[$unitIndex];
    } elseif ($units[$unitIndex] == 'MB') {
        $formattedSize = round($sizeInBytes, 2) . ' ' . $units[$unitIndex];
    } elseif ($units[$unitIndex] == 'GB') {
        $formattedSize = round($sizeInBytes, 2) . ' ' . $units[$unitIndex];
    }

    return $formattedSize;
}?>