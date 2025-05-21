<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Debug information
echo "Checking autoloader...<br>";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "Autoloader exists<br>";
} else {
    echo "Autoloader not found<br>";
}

echo "Checking mPDF files...<br>";
if (file_exists(__DIR__ . '/vendor/mpdf/mpdf/mpdf.php')) {
    echo "mPDF main file exists<br>";
    require_once __DIR__ . '/vendor/mpdf/mpdf/mpdf.php';
} else {
    echo "mPDF main file not found<br>";
}

try {
    // Create new PDF instance
    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_left' => 15,
        'margin_right' => 15,
        'margin_top' => 16,
        'margin_bottom' => 16,
        'margin_header' => 9,
        'margin_footer' => 9
    ]);

    // Add some content
    $html = '
    <h1>Welcome to mPDF</h1>
    <p>This is a test PDF generated using mPDF library.</p>
    <p>If you can see this PDF, the installation was successful!</p>
    ';

    // Write HTML to PDF
    $mpdf->WriteHTML($html);

    // Output PDF
    $mpdf->Output('test.pdf', 'D');
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
    echo "Trace: <pre>" . $e->getTraceAsString() . "</pre>";
}
?> 