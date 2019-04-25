<?php
activityLog('open inbox');
$name = strtolower(_post('email_name'));
$_POST['email'] = $name; // . '@ngetes.com';
unset($_POST['email_name']);
$redirect = (strpos(_server('HTTP_REFERER'), 'inbox') !== false) ? url('/inbox') : url('/#email');

$valid = validation([
    'requests' => _post(),
    'rules' => [
        'email' => 'required|regex:/^[a-zA-Z0-9_.]*$/',
    ],
    'redirect' => $redirect,
]);

$table = db()->table('names');
$q = $table->where('name', $name);
$find = $q->first();

if (!$find) {
    $save = $table->insert([
        'name' => $name,
        'count' => db()->raw('count+1'),
        'created_at' => date("Y-m-d H:i:s"),
    ]);
} else {
    $save = $q->update([
        'count' => db()->raw('count+1'),
    ]);
}

return _goto(url('/inbox/?name=' . $name));
