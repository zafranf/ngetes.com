<?php
/* Define Application Path */
require dirname(__DIR__) . '/autoload.php';

/* connect to gmail */
$hostname = config('imap')['hostname'];
$username = config('imap')['username'];
$password = config('imap')['password'];

$min20menit = strtotime('-20 minutes');
$min60menit = strtotime('-60 minutes');
$tomorrow = date("Y-m-d", strtotime('+1 day'));
$deleted = 0;

$mailbox = new \PhpImap\Mailbox($hostname, $username, $password);
$ids = $mailbox->searchMailbox('BEFORE ' . $tomorrow);
$mails = $mailbox->getMailsInfo($ids);
foreach ($mails as $n => $mail) {
    $mailtime = strtotime($mail->date);
    $is_read = $mail->seen;
    $delete20 = $is_read && ($mailtime <= $min20menit);
    $delete60 = !$is_read && ($mailtime <= $min60menit);
    if ($delete20 || $delete60) {
        // $mailbox->deleteMail($mail->uid);
        $deleted++;
    }
}
$mailbox->disconnect();

debug([
    'crawled' => count($ids),
    'deleted' => $deleted,
]);
