<?php
$config = config();
$path = str_replace("?" . _server('QUERY_STRING'), "", _server('REQUEST_URI'));
$path = trim($path, '/');
$active = 'class="is-active"';
$title = isset($title) ? $title : 'Buat ngetes yang bisa dites';
$follow = isset($follow) ? $follow : true;
$robots = $follow ? 'index, follow' : 'noindex, nofollow';
$keywords = isset($keywords) ? $keywords : 'ngetes, ngetes aplikasi, coba aplikasi, aplikasi localhost, ngetes email, email gratis, subdomain gratis';
$description = isset($description) ? $description : 'Buat ngetes yang bisa dites';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <title><?=$title?> | <?=config('app')['name']?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="robots" content="<?=$robots?>">
  <meta name="keywords" content="<?=$keywords?>">
  <meta name="description" content="<?=$description?>">
  <meta property="og:title" content="<?=$title?> | <?=config('app')['name']?>">
  <meta property="og:description" content="<?=$description?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?=url(_server('REQUEST_URI'))?>">
  <meta property="og:site_name" content="<?=config('app')['name']?>">
  <meta property="og:locale" content="id_ID">
  <meta property="og:image" content="<?=url('/images/logo.png')?>">
  <link href="<?=url('/images/icon.png')?>" rel="shortcut icon">
  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,500,600,700,900" rel="stylesheet">
  <?=load_css('/css/bulma.min.css')?>
  <?=load_css('/css/tabs.css')?>
  <?php if (isset(config('adsense')['status']) && config('adsense')['status']) {?>
  <!-- <script data-ad-client="<?=config('adsense')['code']?>" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
  <?php }?>
</head>

<body>
  <section class="hero is-info">
    <div class="hero-body">
      <div class="container">
        <a href="<?=url('/')?>">
          <h1 class="title">
            <b>ngetes.com</b>
          </h1>
          <h2 class="subtitle">
            buat ngetes yang bisa dites di <i>ngetes.com</i>
          </h2>
        </a>
      </div>
    </div>

    <div class="tabs is-boxed is-centered main-menu" id="nav">
      <ul>
        <li data-target="tentang" id="li-tentang" <?=$path == 'tentang' || $path == '' ? $active : '';?>>
            <a href="<?=url('/tentang')?>">
              <span>Tentang</span>
            </a>
        </li>
        <li data-target="subdomain" id="li-subdomain" <?=$path == 'subdomain' ? $active : '';?>>
            <a href="<?=url('/subdomain')?>">
              <span>Subdomain</span>
            </a>
        </li>
        <!-- <li data-target="apach" id="li-apach" <?=$path == 'apach' ? $active : '';?>>
            <a href="<?=url('/apach')?>">
              <span>Apache</span>
            </a>
        </li>
        <li data-target="nginx" id="li-nginx" <?=$path == 'nginx' ? $active : '';?>>
            <a href="<?=url('/nginx')?>">
              <span>Nginx</span>
            </a>
        </li> -->
        <li data-target="koneksi" id="li-koneksi" <?=$path == 'koneksi' ? $active : '';?>>
            <a href="<?=url('/koneksi')?>">
              <span>Koneksi</span>
            </a>
        </li>
        <li data-target="email" id="li-email" <?=$path == 'email' || strpos($path, 'inbox') !== false ? $active : '';?>>
            <a href="<?=url('/email')?>">
              <span>Surel</span>
            </a>
        </li>
        <li data-target="krisar" id="li-krisar" <?=$path == 'krisar' ? $active : '';?>>
            <a href="<?=url('/krisar')?>">
              <span>Krisar</span>
            </a>
        </li>
        <li data-target="bantu-tes" id="li-bantu-tes" <?=$path == 'bantu-tes' ? $active : '';?> class="is-hidden">
            <a href="<?=url('/bantu-tes')?>" rel="noindex,nofollow">
              <span>Bantu ngetes?</span>
            </a>
        </li>
      </ul>
    </div>