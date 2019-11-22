<?php
/* Define Application Path */
require_once dirname(__DIR__) . '/../public/index.php';

/* connect to gmail */
// $hostname = config('imap')['hostname'];
// // $hostname = str_replace("INBOX", '[Gmail]/Trash', $hostname);
// $username = config('imap')['username'];
// $password = config('imap')['password'];

$execute_time = date("Y-m-d H:i:s");
$min20menit = strtotime('-30 minutes');
$min60menit = strtotime('-60 minutes');
$tomorrow = date("Y-m-d", strtotime('+1 day'));
$deleted = 0;
$read = 0;
$unread = 0;
$deleted_read = 0;
$deleted_unread = 0;
$deleteIds = [];

// $mailbox = new \PhpImap\Mailbox($hostname, $username, $password);

// $ids = $mailbox->searchMailbox('BEFORE ' . $tomorrow);
// if (!empty($ids)) {
// $mails = $mailbox->getMailsInfo($ids);
$mails = db()->table('emails')->where('is_deleted', 0)->get();
foreach ($mails as $n => $mail) {
    $mailtime = strtotime($mail->date);

    $is_read = $mail->is_read;
    if ($is_read) {
        $read++;
    } else {
        $unread++;
    }

    $delete_read = $is_read && ($mailtime <= $min20menit);
    $delete_unread = !$is_read && ($mailtime <= $min60menit);
    if ($delete_read || $delete_unread) {
        $attachments = json_decode($mail->attachments);
        // $mailbox->deleteMail($mail->uid);

        $deleted++;
        if ($is_read) {
            $deleted_read++;
        } else {
            $deleted_unread++;
        }
        $deleteIds[] = $mail->id;

        /* flag delete */
        $table = db()->table('emails');
        $q = $table->where('id', $mail->id);
        $find = $q->first();
        if ($find) {
            $q->update([
                'is_deleted' => 1,
            ]);

            /* delete attachments */
            if (count($attachments) > 0 && $mail->attachment_count > 0) {
                foreach ($attachments as $attachment) {
                    $file = $attachment->folder . $attachment->filename;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }
        }

        // $mailbox->moveMail($mail->uid, '[Gmail]/Trash');
    }
}

/* if (!empty($deleteIds)) {
$mailbox->imap('mail_move', [implode(',', $deleteIds), '[Gmail]/Trash', CP_UID]);
$mailbox->expungeDeletedMails();
} */
// }

// $mailbox->disconnect();
$finish_time = date("Y-m-d H:i:s");

$data = [
    'messages' => count($mails),
    'read' => $read,
    'unread' => $unread,
    'deleted_read' => $deleted_read,
    'deleted_unread' => $deleted_unread,
    'deleted_total' => $deleted,
    'job' => 'delete',
    'executed_time' => $execute_time,
    'finished_time' => $finish_time,
    'created_at' => date("Y-m-d H:i:s"),
];
db()->table('cron_logs')->insert($data);

debug($data);
