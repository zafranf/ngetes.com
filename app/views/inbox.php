<?php include 'header.php';?>
  <style>
  .tab-pane.is-active {
    width: 80%;
  }
  </style>
  <div class="tabs is-boxed is-centered main-menu" id="nav">
    <ul>
      <li data-target="tentang" id="li-tentang">
        <a href="<?=url('/#tentang')?>">
          <span>Tentang</span>
        </a>
      </li>
      <li data-target="apache" id="li-apache">
        <a href="<?=url('/#apache')?>">
          <span>Apache</span>
        </a>
      </li>
      <li data-target="nginx" id="li-nginx">
        <a href="<?=url('/#nginx')?>">
          <span>Nginx</span>
        </a>
      </li>
      <li data-target="email" id="li-email" class="is-active">
        <a href="<?=url('/#email')?>">
          <span>Email</span>
        </a>
      </li>
      <li data-target="krisan" id="li-krisan">
        <a href="<?=url('/#krisan')?>">
          <span>Krisan</span>
        </a>
      </li>
      <li data-target="tes" id="li-tes">
        <a href="<?=url('/#tes')?>">
          <span>Bantu ngetes?</span>
        </a>
      </li>
    </ul>
  </div>
  <div class="tab-content">
    <div class="tab-pane is-active" id="email">
      <div class="content">
        <?php generateFlashMessages();?>
        <form action="<?=url('/openinbox')?>" method="post">
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
