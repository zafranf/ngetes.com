<?php
$title = 'Atur virtualhost apache';
$keywords = 'ngetes apache, aplikasi localhost pake apache, virtual host apache';
$description = 'Ngatur virtualhost buat pake apache';
include 'header.php';
?>
  <div class="tab-content">
    <div class="tab-pane is-active" id="apache">
      <div class="content">

        <h1>Localhost</h1>
        <p>Subdomain langsung ngarah ke localhost, semua projek mesti ada folder <u>public</u> dan di dalemnya ada <u>index.php</u>-nya, kayak framework2 kekinian lah. Soalnya subdomain-nya langsung ngarah ke folder. Kalo gak ada, bisa diatur kayak gini:</p>
        <p>misal sebelumnya kayak gini,</p>
        <pre>
          /gratis
            ├── css
            |<?=spaces(3)?>└── app.css
            ├── js
            |<?=spaces(3)?>└── app.js
            └── index.php
        </pre>
        <p>trus diubah jadi kayak gini,</p>
        <pre>
          /gratis
            └── public
            <?=spaces(4)?>├── css
            <?=spaces(4)?>|<?=spaces(3)?>└── app.css
            <?=spaces(4)?>├── js
            <?=spaces(4)?>|<?=spaces(3)?>└── app.js
            <?=spaces(4)?>└── index.php
        </pre>
        <p>jadi nanti aksesnya gini <code>http://gratis.ngetes.com</code>. <!-- Cara atur vhostnya ada di page sebelah.<br>
        &raquo; <a title="atur virtual host apache" href="<?=url('/apache')?>" class="has-text-link">apache</a> | <a title="atur virtual host nginx" href="<?=url('/nginx')?>" class="has-text-link">nginx</a>. --></p>

        <h1>Atur virtual host Apache</h1>
        <p>
          <pre>
            &lt;VirtualHost *:80&gt;
              <?=spaces()?>ServerAlias *.ngetes.com
              <?=spaces()?>DocumentRoot /folder/root/projek/%1/public
            &lt;/VirtualHost&gt;
          </pre>
        </p>
        <p><small class="note">* tutorial lengkapnya googling aja yaa di youtube 😜</small></p>

        <h1>Atur virtual host Nginx</h1>
        <p>
          <pre>
            server {
              <?=spaces()?>listen 80;

              <?=spaces()?>server_name "~^(?&lt;sub&gt;.*)\.ngetes\.com";
              <?=spaces()?>root  /folder/root/projek/$sub/public;
              <?=spaces()?>index index.php index.html;

              <?=spaces()?>access_log off;
              <?=spaces()?>error_log  /folder/root/projek/$sub/error_log;

              <?=spaces()?>...
            }
          </pre>
        </p>
        <p><small class="note">* tutorial lengkapnya googling aja yaa di youtube 😜</small></p>

        <p>Punya dan mau pake cara lain? Silakan, bebas kita mah. 😄</p>
      </div>
    </div>
  </div>
<?php include 'footer.php';?>
