<?php include 'header.php';?>
  <div class="tab-content">
    <div class="tab-pane is-active" id="tentang">
      <div class="content">
          <h1>Duh,</h1>
          <p>apa ya? Udah ada di slogan sih 😜 <!-- Pake aja deh, gratis. Serius. --></p>
          <hr>
          <p>
            <small style="font-size:smallest"><p>Hehehe,</p>
            <p>Itu yang utamanya sih, buat ngetes aplikasi localhost pake domain beneran. Berguna banget buat yang mau develop aplikasi di localhost pake API pihak ketiga tapi butuh domain asli. Ada juga buat ngetes kiriman email. Biar gak nyepam email pribadi. Ntaps kan? 😉👍</p>
            <p>Kalo mau pake yang subdomain, semua projek mesti ada folder <u>public</u> dan di dalamnya ada <u>index.php</u>-nya, kayak framework2 kekinian. Soalnya subdomain-nya langsung ngarah ke folder. Kalo gak ada, bisa diatur kayak gini:</p>
          <p>misal sebelumnya kayak gini,
            <pre>
              /gratis
                ├── css
                |<?=spaces(3)?>└── app.css
                ├── js
                |<?=spaces(3)?>└── app.js
                └── index.php
            </pre>
            trus diubah jadi kayak gini,
            <pre>
              /gratis
                └── public
                <?=spaces(4)?>├── css
                <?=spaces(4)?>|<?=spaces(3)?>└── app.css
                <?=spaces(4)?>├── js
                <?=spaces(4)?>|<?=spaces(3)?>└── app.js
                <?=spaces(4)?>└── index.php
            </pre>
        jadi nanti aksesnya gini <code>http://gratis.ngetes.com</code>. Cara atur vhostnya ada di page sebelah.<br>
        &raquo; <a title="atur virtual host apache" href="<?=url('/apache')?>" class="has-text-link">apache</a> | <a title="atur virtual host nginx" href="<?=url('/nginx')?>" class="has-text-link">nginx</a>.</p>
        <p>punya dan mau pake cara lain? silakan, bebas kita mah.. 😄</p></small>
          </p>
      </div>
    </div>
  </div>
<?php include 'footer.php';?>
