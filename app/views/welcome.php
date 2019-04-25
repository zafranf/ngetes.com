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
        <li data-target="tentang" id="li-tentang" class="is-active">
          <a>
            <span>Tentang</span>
          </a>
        </li>
        <li data-target="apache" id="li-apache">
          <a>
            <span>Apache</span>
          </a>
        </li>
        <li data-target="nginx" id="li-nginx">
          <a>
            <span>Nginx</span>
          </a>
        </li>
        <li data-target="email" id="li-email">
          <a>
            <span>Email</span>
          </a>
        </li>
        <li data-target="krisan" id="li-krisan">
          <a>
            <span>Krisan</span>
          </a>
        </li>
        <li data-target="tes" id="li-tes">
          <a>
            <span>Bantu ngetes?</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="tab-content">
      <div class="tab-pane is-active" id="tentang">
        <div class="content">
            <h1>Duh,</h1>
            <p>apa ya? pake aja deh, gratis. serius.</p>
            <hr>
            <p>
              <small style="font-size:smallest"><p>Hehehe,</p>
              <p>Jadi gini, semua projek mesti ada folder <u>public</u> dan di dalamnya ada <u>index.php</u>-nya, kayak framework2 kekinian. Soalnya subdomain-nya langsung ngarah ke folder. Kalo gak ada, bisa diatur kayak gini:</p>
            <p>misal, <br>
            sebelum: <code>C:/xampp/htdocs/gratis/index.php</code><br>
          sesudah: <code>C:/xampp/htdocs/gratis/public/index.php</code><br>
          jadi nanti aksesnya gini <code>http://gratis.ngetes.com</code></p>
          <p>punya dan mau pake cara lain? silakan, bebas kita mah.. :D</p></small>
            </p>
        </div>
      </div>
      <div class="tab-pane" id="apache">
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
          <p><small>*tutorial lengkapnya googling aja yaa di youtube :p</small></p>
        </div>
      </div>
      <div class="tab-pane" id="nginx">
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
          <p><small>*tutorial lengkapnya googling aja yaa di youtube :p</small></p>
        </div>
      </div>
      <div class="tab-pane" id="email">
        <div class="content">
          <h1>Inbox email</h1>
          <p>Mau nyobain kirim email dari aplikasi tapi gak mau nyepam ke email pribadi? monggo ketik nama emailnya di sini biar bisa pake <b>&lt;nama&gt;@ngetes.com</b>..</p>
          <div class="field has-addons">
            <p class="control">
              <input class="input" type="text" name="email_name" placeholder="nama">
            </p>
            <p class="control">
              <a class="button is-static">
                @ngetes.com
              </a>
            </p>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="krisan" style="overflow-y:hidden">
        <div class="content">
          <h1>Kritik? Saran? Kritik & saran? sok atuh isi formulir..</h1>
          <form id="form-krisan" action="<?=url('/krisan')?>" method="post">
            <div class="field">
              <label class="label">Yang mengisi formulir di bawah ini:</label>
              <div class="control">
                <input type="text" name="name" class="input" placeholder="nama.." onblur="checkName(this)">
              </div>
            </div>

            <div class="field">
              <div class="control">
                <input type="text" name="email" class="input" placeholder="email.." onblur="checkEmail(this)">
              </div>
            </div>

            <div class="field">
              <label class="label">Ingin menyampaikan bahwa:</label>
              <div class="control">
                <textarea name="message" class="textarea" placeholder="pesan.." onblur="checkMessage(this)"></textarea>
              </div>
            </div>

            <div class="field">
              <div class="control">
                <label class="checkbox">
                  <input type="checkbox" name="thankyou" checked>
                  Terima kasih.
                </label>
              </div>
            </div>

            <div class="field is-grouped">
              <div class="control">
                <button class="button is-link">Kirim</button>
              </div>
              <div class="control">
                <button type="reset" class="button is-text">Gak jadi</button>
              </div>
            </div>
            <div class="g-recaptcha"
                  data-sitekey="<?=config('recaptcha')['site_key']?>"
                  data-callback="onSubmit"
                  data-size="invisible">
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
      <div class="tab-pane" id="tes">
        <div class="content">
          <h1>Perlu bantuan untuk <i>ngetes</i> sesuatu?</h1>
        </div>
      </div>
    </div>
  </section>
  <?=load_js('/js/tabs.js')?>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>
    function onSubmit(token) {
      document.getElementById("form-krisan").submit();
    }

    function checkName(el = null) {
      el = el ? el : document.querySelectorAll('input[name=name]')[0];
      let val = el.value;

      let valid = (val != "");
      if (!valid) {
        el.classList.add('is-danger');
      } else {
        el.classList.remove('is-danger');
      }

      return (val)
    }

    function checkEmail(el = null) {
      el = el ? el : document.querySelectorAll('input[name=email]')[0];
      let val = el.value;

      let valid = validateEmail(val);
      if (!valid) {
        el.classList.add('is-danger');
      } else {
        el.classList.remove('is-danger');
      }

      return valid;
    }

    function checkMessage(el = null) {
      el = el ? el : document.querySelectorAll('textarea[name=message]')[0];
      let val = el.value;

      let valid = (val != "");
      if (!valid) {
        el.classList.add('is-danger');
      } else {
        el.classList.remove('is-danger');
      }

      return (val)
    }

    let formKrisan = document.getElementById('form-krisan');
    formKrisan.addEventListener('submit', function(e) {
      e.preventDefault();
      let validName = checkName();
      let validEmail = checkEmail();
      let validMessage = checkMessage();
      if (!validName || !validEmail || !validMessage) {
        e.preventDefault();
      } else {
        grecaptcha.execute();
      }
    });
  </script>
<!-- </body>
</html> -->

</body>
</html>
