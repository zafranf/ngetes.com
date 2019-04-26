<?php include 'header.php';?>
  <div class="tab-content">
    <div class="tab-pane is-active" id="krisar" style="overflow-y:hidden">
      <div class="content">
        <h1>Kritik? Saran? Kritik & saran? sok atuh isi formulir..</h1>
        <?php generateFlashMessages();?>
        <form id="form-krisar" action="<?=url('/krisar-save')?>" method="post">
          <div class="field">
            <label class="label">Yang mengisi formulir di bawah ini:</label>
          </div>

          <div class="field-body">
            <div class="field">
              <p class="control is-expanded">
              <input type="text" name="name" class="input" placeholder="nama..*" onblur="checkName(this)">
              </p>
            </div>
            <div class="field">
              <p class="control is-expanded">
              <input type="text" name="email" class="input" placeholder="email..*" onblur="checkEmail(this)">
              </p>
            </div>
          </div>

          <div class="field-body" style="margin-top:5px;">
            <div class="field">
              <p class="control is-expanded">
              <input type="text" name="phone" class="input" placeholder="no. telepon..">
              </p>
            </div>
            <div class="field">
              <p class="control is-expanded">
              <input type="text" name="website" class="input" placeholder="website..">
              </p>
            </div>
          </div>

          <div class="field">
            <label class="label">Ingin menyampaikan bahwa:</label>
            <div class="control">
              <textarea name="message" class="textarea" placeholder="pesan..*" onblur="checkMessage(this)"></textarea>
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
          <div class="g-recaptcha" data-sitekey="<?=config('recaptcha')['site_key']?>" data-callback="onSubmit" data-size="invisible">
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>
    function onSubmit(token) {
      document.getElementById("form-krisar").submit();
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

    let formKrisar = document.getElementById('form-krisar');
    formKrisar.addEventListener('submit', function(e) {
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

    function validateEmail(email) {
      let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

      return re.test(String(email).toLowerCase());
    }
  </script>
<?php include 'footer.php';?>
