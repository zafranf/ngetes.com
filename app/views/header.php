<?php
$path = str_replace("?" . _server('QUERY_STRING'), "", _server('REQUEST_URI'));
$path = trim($path, '/');
$active = 'class="is-active"';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width,initial-scale=1" name="viewport">
  <title>Subdomain dan inbox email gratis - ngetes.com</title>
  <!-- <link rel="shortcut icon" href="/images/fav_icon.png" type="image/x-icon"> -->
  <?=load_css('/css/bulma.min.css')?>
  <?=load_css('/css/tabs.css')?>
</head>

<body>
  <section class="hero is-info">
    <div class="hero-body">
      <div class="container">
        <a href="<?=url()?>">
          <h1 class="title">
            <b>ngetes.com</b>
          </h1>
          <h2 class="subtitle">
            subdomain gratis buat <i>ngetes</i> aplikasi localhost
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
        <li data-target="apache" id="li-apache" <?=$path == 'apache' ? $active : '';?>>
            <a href="<?=url('/apache')?>">
            <span>Apache</span>
            </a>
        </li>
        <li data-target="nginx" id="li-nginx" <?=$path == 'nginx' ? $active : '';?>>
            <a href="<?=url('/nginx')?>">
            <span>Nginx</span>
            </a>
        </li>
        <li data-target="email" id="li-email" <?=$path == 'email' || strpos($path, 'inbox') !== false ? $active : '';?>>
            <a href="<?=url('/email')?>">
            <span>Email</span>
            </a>
        </li>
        <li data-target="krisar" id="li-krisar" <?=$path == 'krisar' ? $active : '';?>>
            <a href="<?=url('/krisar')?>">
            <span>Krisar</span>
            </a>
        </li>
        <li data-target="bantu-tes" id="li-bantu-tes" <?=$path == 'bantu-tes' ? $active : '';?>>
            <a href="<?=url('/bantu-tes')?>">
            <span>Bantu ngetes?</span>
            </a>
        </li>
      </ul>
    </div>