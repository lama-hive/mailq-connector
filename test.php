<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$notificationId = 0;
$companyId = 0;
$apiKey = '';
$mq = new \LamaHive\MailqConnector\MailQ($apiKey, $companyId);

try {
    $mq->sendNotification(
        $notificationId,
        'email@address.com'
    );
} catch (\LamaHive\MailqConnector\MailQException $e) {
    var_dump($e);
}
