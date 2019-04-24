<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width,initial-scale=1" name="viewport">
  <title>Subdomain dan inbox email gratis - ngetes.com</title>
  <!-- <link rel="shortcut icon" href="/images/fav_icon.png" type="image/x-icon"> -->
  <?=load_css('/css/bulma.min.css')?>
  <?=load_css('/css/tabs.css')?>
  <!-- <?=load_css('/css/prism.css')?> -->
</head>

<body>
  <section class="hero is-info">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          <b>ngetes.com</b>
        </h1>
        <h2 class="subtitle">
          subdomain gratis buat <i>ngetes</i> aplikasi localhost
        </h2>
      </div>
    </div>
    <div class="tabs is-boxed is-centered main-menu" id="nav">
      <ul>
        <li data-target="pane-1" id="1" class="is-active">
          <a>
            <!-- <span class="icon is-small"><i class="fa fa-image"></i></span> -->
            <span>Tentang</span>
          </a>
        </li>
        <li data-target="pane-2" id="2">
          <a>
            <!-- <span class="icon is-small"><i class="fab fa-empire"></i></span> -->
            <span>Apache</span>
          </a>
        </li>
        <li data-target="pane-3" id="3">
          <a>
            <!-- <span class="icon is-small"><i class="fab fa-superpowers"></i></span> -->
            <span>Nginx</span>
          </a>
        </li>
        <li data-target="pane-4" id="4">
          <a>
            <!-- <span class="icon is-small"><i class="fa fa-envelope"></i></span> -->
            <span>Email</span>
          </a>
        </li>
        <li data-target="pane-5" id="5">
          <a>
            <!-- <span class="icon is-small"><i class="fa fa-envelope"></i></span> -->
            <span>Krisan</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="tab-content">
      <div class="tab-pane is-active" id="pane-1">
        <div class="content">
            <h1>Duh,</h1>
            <p>apa ya? pake aja deh, gratis. serius.</p>
            <hr>
            <p>
              <small style="font-size:smallest">Semua projek mesti ada folder public-nya kayak framework2 kekinian. Soalnya subdomain-nya langsung ngarah ke folder. Kalo gak ada, bisa diatur kayak gini:<br>
              <br>
            misal, <br>
            sebelum: <code>C:/xampp/htdocs/gratis/index.php</code><br>
          sesudah: <code>C:/xampp/htdocs/gratis/public/index.php</code><br>
          jadi nanti aksesnya gini <code>http://gratis.ngetes.com</code><br>
          <br>
        punya dan mau pake cara lain? silakan, bebas kita mah.. :D</small>
            </p>
        </div>
      </div>
      <div class="tab-pane" id="pane-2">
        <div class="content">
          <h1>Atur virtual host Apache</h1>
          <p>
            <pre>&lt;VirtualHost *:80&gt;
  ServerAlias *.ngetes.com
  VirtualDocumentRoot /folder/root/projek/%1/public
&lt;/VirtualHost&gt;</pre>
</p>
          <p><small>*tutorial lengkapnya googling aja yaa di youtube :p</small></p>
        </div>
      </div>
      <div class="tab-pane" id="pane-3">
        <div class="content">
          <h1>Atur virtual host Nginx</h1>
          <p><pre>server {
    listen 80;

    server_name "~^(?&lt;sub&gt;.*)\.ngetes\.com";
    root  /folder/root/projek/$sub/public;
    index index.php index.html;

    access_log off;
    error_log  /folder/root/projek/$sub/error_log;

    ...
}</pre></p>
          <p><small>*tutorial lengkapnya googling aja yaa di youtube :p</small></p>
        </div>
      </div>
      <div class="tab-pane" id="pane-4">
        <div class="content">
          <h1>Inbox email</h1>
          <p>Mau nyobain kirim email dari aplikasi tapi gak mau nyepam ke email pribadi? monggo ketik nama emailnya di sini biar bisa pake <b>&lt;nama&gt;@ngetes.com</b>..</p>
          <div class="field has-addons">
            <p class="control">
              <input class="input" type="text" name="email" placeholder="nama">
            </p>
            <p class="control">
              <a class="button is-static">
                @ngetes.com
              </a>
            </p>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="pane-5">
        <div class="content">
          <h1>Kritik? Saran? Kritik & saran? sok atuh isi formulir,</h1>
          <form>
            <div class="field">
              <label class="label">Yang mengisi formulir di bawah ini:</label>
              <div class="control">
                <input class="input" type="text" placeholder="nama..">
              </div>
            </div>

            <div class="field">
              <div class="control">
                <input class="input" type="text" placeholder="email..">
              </div>
            </div>

            <div class="field">
              <label class="label">Ingin menyampaikan bahwa:</label>
              <div class="control">
                <textarea class="textarea" placeholder="pesan.."></textarea>
              </div>
            </div>

            <div class="field">
              <div class="control">
                <label class="checkbox">
                  <input type="checkbox" checked>
                  Terima kasih.
                </label>
              </div>
            </div>

            <div class="field is-grouped">
              <div class="control">
                <button class="button is-link">Kirim</button>
              </div>
              <div class="control">
                <button class="button is-text">Gak jadi</button>
              </div>
            </div>
          </form>
          <!-- <form>
            <div class="field is-horizontal">
              <div class="field-label is-normal">
                <label class="label">Siapa</label>
              </div>
              <div class="field-body">
                <div class="field">
                  <p class="control is-expanded">
                    <input class="input" type="text" placeholder="Nama*">
                  </p>
                </div>
                <div class="field">
                  <p class="control is-expanded">
                    <input class="input" type="email" placeholder="Email*">
                  </p>
                </div>
              </div>
            </div>

            <div class="field is-horizontal">
              <div class="field-label"></div>
              <div class="field-body">
                <div class="field">
                  <p class="control is-expanded">
                    <input class="input" type="text" placeholder="Website">
                  </p>
                </div>
                <div class="field">
                  <p class="control is-expanded">
                    <input class="input" type="text" placeholder="No. Telepon">
                  </p>
                </div>
              </div>
            </div>

            <div class="field is-horizontal">
              <div class="field-label is-normal">
                <label class="label">Pesan</label>
              </div>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <textarea class="textarea" placeholder="Apa tuh?"></textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="field is-horizontal">
              <div class="field-label">
              </div>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <button class="button is-primary">
                      Kirim
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form> -->
        </div>
      </div>
    </div>
  </section>
  <?=load_js('/js/tabs.js')?>
<!-- </body>
</html> -->

</body>
</html>
