<?php
if (_server('REQUEST_METHOD') != 'POST') {
    return view_error(404);
}

$name = strtolower(_post('email_name'));
// $_POST['email'] = $name; // . '@ngetes.com';
// unset($_POST['email_name']);
$path = rtrim(parse_url(_server('HTTP_REFERER'))['path'], '/');
activityLog('open inbox via ' . $path);

$valid = validation([
    'requests' => _post(),
    'rules' => [
        'email_name' => 'required|regex:/^[a-zA-Z0-9_.]*$/',
    ],
    'aliases' => [
        'email_name' => 'Email',
    ],
    /* 'messages' => [
    'regex' => 'etdah salah',
    ], */
    'redirect' => $path ?? url('/'),
]);
$_SESSION['email_name'] = _post('email_name');

$table = db()->table('names');
$q = $table->where('name', $name)->where('via', $path);
$find = $q->first();

if (!$find) {
    $save = $table->insert([
        'name' => $name,
        'via' => $path,
        'count' => db()->raw('count+1'),
        'created_at' => date("Y-m-d H:i:s"),
    ]);
} else {
    $save = $q->update([
        'count' => db()->raw('count+1'),
    ]);
}

return _goto(url('/inbox?name=' . $name));
