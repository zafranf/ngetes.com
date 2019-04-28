<?php
/* Define Application Path */
require_once dirname(__DIR__) . '/../public/index.php';

/* connect to gmail */
$hostname = config('imap')['hostname'];
$username = config('imap')['username'];
$password = config('imap')['password'];

$execute_time = date("Y-m-d H:i:s");
$min20menit = strtotime('-20 minutes');
$min60menit = strtotime('-60 minutes');
$tomorrow = date("Y-m-d", strtotime('+1 day'));
$deleted = 0;
$read = 0;
$unread = 0;
$deleted_read = 0;
$deleted_unread = 0;
$deleteIds = [];

// $hostname = '{imap.gmail.com:993/imap/ssl/novalidate-cert}';
$mailbox = new \PhpImap\Mailbox($hostname, $username, $password);
// $mailbox->setExpungeOnDisconnect(true);
// debug($mailbox->getListingFolders());

$ids = $mailbox->searchMailbox('BEFORE ' . $tomorrow);
$mails = $mailbox->getMailsInfo($ids);
foreach ($mails as $n => $mail) {
    $mailtime = strtotime($mail->date);

    $is_read = $mail->seen;
    if ($is_read) {
        $read++;
    } else {
        $unread++;
    }

    $delete20 = $is_read && ($mailtime <= $min20menit);
    $delete60 = !$is_read && ($mailtime <= $min60menit);
    if ($delete20 || $delete60) {
        $deleteIds[] = $mail->uid;
        // $mailbox->deleteMail($mail->uid);

        $deleted++;
        if ($is_read) {
            $deleted_read++;
        } else {
            $deleted_unread++;
        }
    }
}

if (!empty($deleteIds)) {
    // $mailbox->imap('delete', [implode(',', $deleteIds), FT_UID]);
    $mailbox->imap('mail_move', [implode(',', $deleteIds), '[Gmail]/Trash', CP_UID]);
    // $mailbox->setFlag($deleteIds, '[Gmail]\\/Trash');
}

$mailbox->disconnect();
$finish_time = date("Y-m-d H:i:s");

$params = [
    'crawled' => count($ids),
    'read' => $read,
    'unread' => $unread,
    'deleted_read' => $deleted_read,
    'deleted_unread' => $deleted_unread,
    'deleted_total' => $deleted,
    'executed_time' => $execute_time,
    'finished_time' => $finish_time,
    'created_at' => date("Y-m-d H:i:s"),
];
db()->table('cron_logs')->insert($params);

// $params['deleted_ids'] = $deleteIds;
debug($params);
