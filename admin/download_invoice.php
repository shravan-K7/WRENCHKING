<?php
if (!isset($_GET['file']) || empty($_GET['file'])) {
    die("Invalid invoice file.");
}

$invoiceFile = basename($_GET['file']);
$invoicePath = __DIR__ . "/invoices/" . $invoiceFile;

// Check if the file exists
if (!file_exists($invoicePath)) {
    die("Invoice not found.");
}

// Serve the PDF for viewing
header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=\"$invoiceFile\""); // Opens the file instead of downloading
header("Content-Length: " . filesize($invoicePath));
readfile($invoicePath);
exit;