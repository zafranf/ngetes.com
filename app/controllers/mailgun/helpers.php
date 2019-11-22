<?php
function parseFrom($from)
{
    $exFrom = explode(" ", $from);
    $email = end($exFrom);

    return [
        'name' => str_replace($email, "", $from),
        'email' => str_replace(['<', '>'], "", $email),
    ];
};

function parseTo($to)
{
    if (count(explode(', ', $to)) > 1) {
        $to = json_encode($to);
    }

    return $to;
}

function processFiles($files)
{
    $uploads = [];
    foreach ($files as $n => $file) {
        $file = _file($n);
        $upload = uploadFile($file['tmp'], STORAGE_PATH . 'attachments/', md5(time().rand(100,1000)) . $file['ext']);
        $uploads[] = array_merge($file, $upload);
    }

    return $uploads;
}
