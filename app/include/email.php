<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../..');
$dotenv->load();
$email_settings = [
    'host' => $_ENV['SMTP_HOST'],
    'username' => $_ENV['SMTP_USERNAME'],
    'password' => $_ENV['SMTP_PASSWORD'],
    'smtpAuth' => filter_var($_ENV['SMTP_AUTH'], FILTER_VALIDATE_BOOLEAN),
    'smtpSecure' => $_ENV['SMTP_SECURE'],
    'port' => (int)$_ENV['SMTP_PORT'],
    'fromAddress' => $_ENV['SMTP_FROM_ADDRESS'],
];
function getEmailSettings()
{
    global $email_settings;
    return $email_settings;
}

?>