<?php
/* Define Application Path */
require_once dirname(__DIR__) . '/../public/index.php';

/* connect to gmail */
$hostname = config('imap')['hostname'];
$username = config('imap')['username'];
$password = config('imap')['password'];

$execute_time = date("Y-m-d H:i:s");
$read = 0;
$unread = 0;

$mailbox = new \PhpImap\Mailbox($hostname, $username, $password);

$ids = $mailbox->searchMailbox('ALL');
if (!empty($ids)) {
    foreach ($ids as $id) {
        $info = $mailbox->getMailsInfo([$id])[0];
        $is_read = $info->seen;
        if ($is_read) {
            $read++;
        } else {
            $unread++;
        }

        $exists = db()->table('emails')->where('id', $id)->first();
        if (!$exists) {
            $mail = $mailbox->getMail($id, false);
            // debug($info, $mail);

            $content = $mail->textHtml ?? nl2br($mail->textPlain);
            $content = trim($content);

            $cssToInlineStyles = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();
            $html = $cssToInlineStyles->convert($content);

            $doc = new \DOMDocument('1.0', 'UTF-8');
            @$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            $links = $doc->getElementsByTagName('a');
            foreach ($links as $link) {
                $link->setAttribute('target', '_blank');
            }

            $bodyContent = $doc->getElementsByTagName('body');
            if ($bodyContent && $bodyContent->length > 0) {
                $bodyContent = $bodyContent->item(0);
                $content = $doc->saveHTML($bodyContent);
            } else {
                $content = $doc->saveHTML();
            }

            $content = preg_replace('/(<(script|style)\b[^>]*>).*?(<\/\2>)/s', "", $content);
            $content = preg_replace('/\ class="(.*?)"/', "", $content);
            $content = str_replace(['<body>', '</body>'], "", $content);

            $is_plain = empty($mail->textPlain) && !empty($content);

            $data = [
                'id' => $mail->id,
                'message_id' => str_replace(['<', '>'], "", $mail->messageId),
                'date' => date("Y-m-d H:i:s", strtotime($mail->date)),
                'from' => json_encode([
                    $mail->fromAddress => $mail->fromName,
                ]),
                'to' => json_encode($mail->to),
                'cc' => json_encode($mail->cc),
                'bcc' => json_encode($mail->bcc),
                'reply_to' => json_encode($mail->replyTo),
                'subject' => $mail->subject,
                'text' => $is_plain ? strip_tags($content) : $mail->textPlain,
                'html' => $content,
                'attachments' => count($mail->getAttachments()),
                'headers' => json_encode($mail->headers),
                'headers_raw' => $mail->headersRaw,
                'size' => $info->size,
                'is_read' => $info->seen,
                'is_deleted' => 0,
                'created_at' => date("Y-m-d H:i:s"),
            ];

            db()->table('emails')->insert($data);

            $mailbox->moveMail($mail->id, '[Gmail]/Trash');
        }
    }
}

$mailbox->disconnect();
$finish_time = date("Y-m-d H:i:s");

$params = [
    'messages' => count($ids),
    'read' => $read,
    'unread' => $unread,
    'deleted_read' => 0,
    'deleted_unread' => 0,
    'deleted_total' => 0,
    'job' => 'get',
    'executed_time' => $execute_time,
    'finished_time' => $finish_time,
    'created_at' => date("Y-m-d H:i:s"),
];
db()->table('cron_logs')->insert($params);

debug($params);
