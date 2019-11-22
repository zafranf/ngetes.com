<?php

/* function generateFlashMessages()
{
if (checkFlashMessages()) {
echo '<div class="notification">';
$messages = getFlashMessages();
foreach ($messages as $key => $message) {
$class = $messages['type_message'] == 'failed' ? 'has-text-danger' : 'has-text-link';
if ($key != 'type_message') {
echo '<span class="' . $class . '"><small>' . $message . '</small></span><br>';
}
}
echo '</div>';
}
} */

function validateCaptcha($response)
{
    $client = new \GuzzleHttp\Client();
    $res = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
        'form_params' => [
            'secret' => config('recaptcha')['secret_key'],
            'response' => $response,
            'remoteip' => _server('REMOTE_ADDR'),
        ],
    ]);
    $response = json_decode($res->getBody()->getContents());

    return $response->success;
}

function getImapAttachments($imap, $uid)
{
    $structure = imap_fetchstructure($imap, $uid, FT_UID);
    debug($structure);

    $attachments = array();
    if (isset($structure->parts) && count($structure->parts)) {
        for ($i = 0; $i < count($structure->parts); $i++) {
            /* $attachments[$i] = array(
            'is_attachment' => false,
            'filename' => '',
            'name' => '',
            'attachment' => ''); */

            if ($structure->parts[$i]->ifdparameters) {
                foreach ($structure->parts[$i]->dparameters as $object) {
                    if (strtolower($object->attribute) == 'filename') {
                        $attachments[$i]['is_attachment'] = true;
                        $attachments[$i]['filename'] = $object->value;
                    }
                }
            }

            if ($structure->parts[$i]->ifparameters) {
                foreach ($structure->parts[$i]->parameters as $object) {
                    if (strtolower($object->attribute) == 'name') {
                        $attachments[$i]['is_attachment'] = true;
                        $attachments[$i]['name'] = $object->value;
                    }
                }
            }

            /* if (isset($attachments[$i]['is_attachment'])) {
        $attachments[$i]['attachment'] = imap_fetchbody($imap, $uid, $i + 1, FT_UID);
        if ($structure->parts[$i]->encoding == 3) { // 3 = BASE64
        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
        } elseif ($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
        }
        } */
        } // for($i = 0; $i < count($structure->parts); $i++)
    } // if(isset($structure->parts) && count($structure->parts))

    return $attachments;
}

function mdsort($array, $key, $sort = 'asc')
{
    $data = usort($array, function ($a, $b) use ($key, $sort) {
        if ($sort == 'desc') {
            return strtotime($b[$key]) <=> strtotime($a[$key]);
        } else {
            return strtotime($a[$key]) <=> strtotime($b[$key]);
        }
    });

    return $data;
}
