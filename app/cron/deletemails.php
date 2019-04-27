<?php
/* connect to gmail */
$hostname = config('imap')['hostname'];
$username = config('imap')['username'];
$password = config('imap')['password'];

$min20menit = strtotime('-20 minutes');
$min60menit = strtotime('-60 minutes');

$mailbox = new \PhpImap\Mailbox($hostname, $username, $password);
$date = date("Y-m-d", strtotime('+1 day'));
$ids = $mailbox->searchMailbox('BEFORE ' . $date);

$mails = $mailbox->getMailsInfo($ids);
foreach ($mails as $n => $mail) {
    $mailtime = strtotime($mail->date);
    $is_read = $mail->seen;
    $delete20 = $is_read && ($mailtime <= $min20menit);
    $delete60 = !$is_read && ($mailtime <= $min60menit);
    if ($delete20 || $delete60) {
        $mailbox->deleteMail($mail->uid);
    }
}
$mailbox->disconnect();
