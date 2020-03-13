<?php
return $routes = [
    'tentang' => 'welcome',
    'inbox/*/mail/*' => 'inbox-detail',
    'inbox/*' => 'inbox',
    'nginx/*' => 'nginx',
    'email/fetch' => 'crawl',
    'email/fetch/single' => 'crawl-single',
    'request/get' => 'request',
    'request/post' => 'request',
    'request/put' => 'request',
    'request/patch' => 'request',
    'request/delete' => 'request',
    'coba/*/mail/*' => function () {
        debug(_session());
        return view('welcome');
    },
];
