<?php
$title = 'Atur virtualhost nginx';
$keywords = 'ngetes nginx, aplikasi localhost pake nginx, virtual host nginx';
$description = 'Ngatur virtualhost buat pake nginx';
include 'header.php';
?>
  <div class="tab-content">
    <div class="tab-pane is-active" id="nginx">
      <div class="content">
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
      </div>
    </div>
  </div>
<?php include 'footer.php';?>
