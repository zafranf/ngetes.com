<?php include 'header.php';?>
  <div class="tab-content">
      <div class="tab-pane is-active" id="email">
      <div class="content">
          <h1>Inbox email</h1>
          <?php generateFlashMessages();?>
          <p>Mau nyobain kirim email dari aplikasi tapi gak mau nyepam ke email pribadi? monggo ketik nama emailnya di sini biar bisa pake <b>&lt;nama&gt;@ngetes.com</b>..</p>
          <form action="<?=url('/inbox-open')?>" method="post">
          <div class="field has-addons">
              <p class="control">
              <input class="input" type="text" name="email_name" placeholder="nama" value="<?=_get('name')?>">
              </p>
              <p class="control">
              <a class="button is-static">
                  @ngetes.com
              </a>
              </p>
          </div>
          </form>
          <p><small class="small">*catet, penting nih:</small><br>
      <code><small>inboxnya untuk umum, jadi siapapun bisa pake nama yang sama.</small></code></p>
      </div>
      </div>
  </div>
<?php include 'footer.php';?>
