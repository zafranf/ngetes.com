<?php
return $routes = [
    'tentang' => 'welcome',
    'inbox/*/mail/*' => 'inbox-detail',
    'inbox/*' => 'inbox',
    'nginx/*' => 'nginx',
    'crawl/single' => 'crawl-single',
    'coba/*/mail/*' => function () {
        debug(_session());
        return view('welcome');
    },
];
