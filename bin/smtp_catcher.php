#!/usr/bin/php
<?php

/**
 * Script stores all emails in local directory.
 * 
 * Set in php.ini:
 * sendmail_path = /path/to/smtp_catcher.php
 */

// set directory for emails
$mailPath = __DIR__ . '/maillog';

// create a filename for the eml file
list($usec, $time) = explode(' ', microtime());
$filename = rtrim($mailPath, '/') . '/' . date('Y-m-d H.i.s.', $time) . substr($usec, 2, 3) . '.eml';

if (!file_exists($mailPath)) {
    mkdir($mailPath, 0777, true);
}

// write the email contents to the file
$contents = fopen('php://stdin', 'r');
file_put_contents($filename, $contents, FILE_APPEND);
