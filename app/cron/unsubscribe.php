<?php
/* Define Application Path */
require_once dirname(__DIR__) . '/../public/index.php';

function doUnsub($date = 'now', $page = 1, $urls = [], $mail_ids = [], $last_id = null)
{
    echo 'Page: ' . $page . "\n";
    $perpage = 20;
    $offset = ($page - 1) * $perpage;

    $mail_ids = array_merge($mail_ids, []);
    $urls = array_merge($urls, []);

    /* get the emails */
    $mails = db()->table('emails')
        ->where(function ($q) {
            $q->where('html', 'like', '%unsubscribe%')
                ->orWhere('html', 'like', '%langganan%')
                ->orWhere('html', 'like', '%henti%langgan%');
        });
    if (!empty($mail_ids)) {
        $mails = $mails->whereNotIn('id', $mail_ids);
    }
    if (!is_null($last_id)) {
        $mails = $mails->where('id', '>', $last_id);
    }
    $mails = $mails->where('created_at', '<=', $date)
        ->orderBy('created_at', 'asc')
        ->limit($perpage)
        ->offset($offset)
        ->get();
    if (count($mails)) {
        foreach ($mails as $mail) {
            echo $mail->id . "\n";

            $cssToInlineStyles = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();
            $html = $cssToInlineStyles->convert($mail->html);

            $doc = new \DOMDocument('1.0', 'UTF-8');
            @$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            $links = $doc->getElementsByTagName('a');
            foreach ($links as $link) {
                // debug($link->getAttribute('href'), $link->textContent, $link->nodeValue, $link);
                // $link->setAttribute('target', '_blank');
                $match = false;
                $texts = ['unsubscribe', 'here', 'sini'];
                foreach ($texts as $text) {
                    if (str_contains(strtolower($link->nodeValue), $text)) {
                        $match = true;
                    }
                }
                if ($match) {
                    $url = $link->getAttribute('href');
                    echo '-> ' . $link->nodeValue . ' : ' . $url . "\n";
                    $unsub = 'Already unsubscribed';

                    /* cek url exists */ /* db based on link */
                    $exists = in_array($url, $urls); //db()->table('unsubs')->where('url', $url)->first();
                    if (!$exists) {
                        try {
                            /* do unsub */
                            $client = new \GuzzleHttp\Client();
                            $res = $client->request('GET', $url, [
                                'timeout' => 5,
                                'connect_timeout' => 5
                            ]);
                            if ($res->getStatusCode() == 200) {
                                $unsub = 'SUCCESS';

                                /* input ke db, from to link */
                                $from = $mail->from_email;
                                $to = $mail->to;
                                db()->table('unsubs')->insert([
                                    'from' => $from,
                                    'to' => $to,
                                    'url' => $url,
                                    'email_id' => $mail->id,
                                    'status' => 1,
                                    'updated_at' => date('Y-m-d H:i:s'),
                                    'created_at' => date('Y-m-d H:i:s'),
                                ]);

                                /* attach to urls */
                                $urls[] = $url;
                                $mail_ids[] = $mail->id;
                            } else {
                                $unsub = 'Failed!';
                            }
                        } catch (\Exception $e) {
                            $unsub = 'Failed! | ' . $e->getMessage();
                        }
                    }
                    echo "     unsub: " . $unsub . "\n";
                    echo "========================================" . "\n";
                }
            }

            $last_id = $mail->id;
        }

        doUnsub($date, $page + 1, $urls, $mail_ids, $last_id);
    } else {
        echo "FINISH!";
        exit();
    }
}


/* get all unsubscribed emails */
$urls = [];
$mail_ids = [];
/* $unsubs = db()->table('unsubs')->get();
foreach ($unsubs as $unsub) {
    $mail_ids[] = $unsub->email_id;
    $urls[] = $unsub->url;
} */

/* get latest id */
$unsubs = db()->table('unsubs')->orderBy('email_id', 'desc')->first();
$last_id = $unsubs->email_id;

/* do it */
$date = date('Y-m-d H:i:s', strtotime('-7 days'));
doUnsub($date, 1, $urls, $mail_ids, $last_id);
