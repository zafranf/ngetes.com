<?php include 'header.php';?>
  <style>
    #table-email tbody {
      font-size: 14px;
    }
    #table-email tr {
      cursor: pointer;
    }
    #table-email tr.unread td:first-child {
      padding: 0;
    }
    #table-email tr.unread td:last-child {
      padding: 0 .5em;
    }
    #table-email tr.unread td div {
      /* font-weight: bold; */
      padding-left: 3px;
      border-left:5px solid #369cee;
    }
    #table-email tr.read {
      font-weight: lighter;
    }
    @media screen and (min-width: 769px) {
      .tab-pane.is-active {
        width: 80%;
      }
    }
  </style>
  <div class="tab-content">
    <div class="tab-pane is-active" id="email">
      <div class="content">
        <?php generateFlashMessages();?>
        <form id="form-email" action="<?=url('/inbox-open')?>" method="post">
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
            <p class="control">
              <button class="button" id="btn-go">✓</button>
            </p>
          </div>
        </form>
        <table id="table-email" class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
          <thead>
            <tr>
              <th>Email</th>
              <th width="105">Tanggal</th>
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
        <p>
          <small>
            Catetan:<br>
            - <b>data</b> 30 email terakhir diambil tiap menit<br>
            - <b>unread</b> dihapus tiap 60 menit<br>
            - <b>read</b> dihapus tiap 20 menit<br>
            - <b>tanpa</b> file lampiran<br>
          </small>
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

    function crawlEmails() {
      let token = '<?=generateToken(_get('name') . _session('token_time'))?>';
      let name = '<?=_get('name')?>';
      if (name.length) {
        localStorage.setItem("email_name", name);

        var request = new XMLHttpRequest();
        request.open('POST', '<?=url('/crawl')?>', true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

        request.onload = function() {
          if (request.status >= 200 && request.status < 400) {
            // Success!
            let res = JSON.parse(request.responseText);
            console.log(res);
            let html = '';
            let data = res.data
            data.forEach((mail, n) => {
              let read = mail.read ? 'read' : 'unread';
              // let sender = mail.from.name ? mail.from.name + ' ('+mail.from.email+')' : mail.from.email;
              let sender = mail.from;
              let attachments = mail.attachments > 0 ? '<span style="float:right;">'+ mail.attachments +' lampiran</span>' : '';
              html += '<tr onclick="location.href=\'<?=url('/inbox/mail/')?>'+mail.id+'\'" class="'+read+'">';
              // html += '<td><div>'+sender+''+attachments+'<br>'+ mail.subject +'<br>'+mail.message+'</div></td>';
              html += '<td><div>'+sender+''+attachments+'<br>'+ mail.subject +'</div></td>';
              html += '<td>'+ mail.date +'</td>';
              html += '</tr>';
            });
            let tbody = document.getElementsByTagName('tbody')[0];
            tbody.innerHTML = html;

            setTimeout(function() {
              crawlEmails();
            }, 1000 * 60)
          } else {
            // We reached our target server, but it returned an error

          }
        };

        request.onerror = function() {
          // There was a connection error of some sort
        };

        request.send('name=' + name + '&token=' + token);
      }
    }

    crawlEmails()
  </script>
<?php include 'footer.php';?>
