<?php
$title = 'Atur virtualhost apache';
$keywords = 'ngetes apache, aplikasi localhost pake apache, virtual host apache';
$description = 'Ngatur virtualhost buat pake apache';
include 'header.php';
?>
  <div class="tab-content">
    <div class="tab-pane is-active" id="apache">
      <div class="content">
        <h1>Atur virtual host Apache</h1>
        <p>
          <pre>
            &lt;VirtualHost *:80&gt;
              <?=spaces()?>ServerAlias *.ngetes.com
              <?=spaces()?>VirtualDocumentRoot /folder/root/projek/%1/public
            &lt;/VirtualHost&gt;
          </pre>
        </p>
        <p><small class="note">* tutorial lengkapnya googling aja yaa di youtube 😜</small></p>
      </div>
    </div>
  </div>
<?php include 'footer.php';?>
