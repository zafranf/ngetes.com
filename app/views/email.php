<?php include 'header.php';?>
  <div class="tab-content">
    <div class="tab-pane is-active" id="email">
      <div class="content">
        <h1>Inbox email</h1>
        <?php generateFlashMessages();?>
        <p>Mau nyobain kirim email dari aplikasi tapi gak mau nyepam ke email pribadi? monggo ketik nama emailnya di sini biar bisa pake <b>&lt;nama&gt;@ngetes.com</b>..</p>
        <form id="form-email" action="<?=url('/inbox-open')?>" method="post">
          <div class="field has-addons">
            <p class="control">
              <input class="input" type="text" name="email_name" placeholder="nama" value="<?=_get('name')?>" onblur="checkEmail(this)">
            </p>
            <p class="control">
              <a class="button is-static">
                @ngetes.com
              </a>
            </p>
            <p class="control">
              <button class="button" id="btn-go">✓</button>
            </p>
          </div>
        </form>
        <p>
          <small class="small">*catet, penting nih:</small><br>
          <code><small>inboxnya untuk umum, jadi siapapun bisa pake nama yang sama.</small></code>
        </p>
      </div>
    </div>
  </div>
  <script>
    function checkEmail(el = null) {
      el = el ? el : document.querySelectorAll('input[name=email_name]')[0];
      let val = el.value;

      let valid = validateEmail(val);
      if (!valid) {
        el.classList.add('is-danger');
      } else {
        el.classList.remove('is-danger');
      }

      return valid;
    }

    let formEmail = document.getElementById('form-email');
    formEmail.addEventListener('submit', function(e) {
      let validEmail = checkEmail();
      if (!validEmail) {
        e.preventDefault();
      }
    });

    function validateEmail(email) {
      let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

      return re.test(String(email + '@ngetes.com').toLowerCase());
    }
  </script>
<?php include 'footer.php';?>
