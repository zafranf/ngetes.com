<?php include 'header.php';?>
  <style>
    .tab-pane.is-active {
      width: 80%;
    }
  </style>
  <div class="tab-content">
    <div class="tab-pane is-active" id="email">
      <div class="content">
        <?php generateFlashMessages();?>
        <form action="<?=url('/inbox-open')?>" method="post">
          <div class="field has-addons">
            <!-- Inbox:&nbsp; -->
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
        <p>
          <small>
            Catet:<br>
            - <b>data</b>, 30 email terakhir diambil tiap menit<br>
            - <b>unread</b>, dihapus tiap 60 menit<br>
            - <b>read</b>, dihapus tiap 20 menit<br>
          </small>
        </p>
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
          <thead>
            <tr>
              <th>Email</th>
              <th width="180">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="2" style="text-align:center">
              <?php if (_get('name')) {?>
                Masih kosong. Coba kirim email ke <u><a href="mailto:<?=_get('name')?>@ngetes.com"><?=_get('name')?>@ngetes.com</a></u>.
              <?php } else {?>
                Diisi dulu dong nama emailnya ;)
              <?php }?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php include 'footer.php';?>
