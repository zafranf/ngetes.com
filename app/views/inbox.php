<?php
$title = 'Isi kotak surelnya ' . ($name ?? _session('email_name'));
$follow = false;
$keywords = 'ngetes email, ngetes email masuk, ngetes kirim email gratis, buka email di ngetes.com';
$description = 'Daftar email ' . ($name ?? _session('email_name')) . ' di kotak masuk ngetes.com';
include 'header.php';
?>
  <style>
    #btn-go {
      color: #369cee;
    }
    #table-wrapper {
      border: 1px solid #dbdbdb;
      border-radius: 4px;
    }
    #table-email {
      border-radius: 4px;
      border-style: hidden;
    }
    #table-email tbody {
      font-size: 14px;
    }
    #table-email tbody tr {
      cursor: pointer;
    }
    #table-email tbody tr:last-child {
      word-wrap: break-word;
    }
    /* #table-email tr.unread {
      font-weight: 500;
    } */
    #table-email tr.unread td:first-child {
      padding: 0;
    }
    #table-email tr.unread td:last-child {
      padding: 0 .5em;
    }
    #table-email tr.unread td div {
      padding-left: 3px;
      border-left: 5px solid #369cee;
    }
    #table-email tr.spam td div {
      padding-left: 3px;
      border-left: 2px solid #ff3860;
    }
    #table-email tr.read {
      padding: 0;
      font-weight: 300;
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
        <div class="columns">
          <div class="column">
            <h2>Isi kotak surelnya</h2>
          </div>
          <div class="column">
            <form id="form-email" action="<?=url('/inbox-open')?>" method="post" style="float:right;">
              <div class="field has-addons">
                <!-- Inbox:&nbsp; -->
                <p class="control">
                  <input id="input-name" class="input" type="text" name="email_name" placeholder="nama" value="<?=($name ?? _session('email_name'))?>">
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
          </div>
        </div>
        <div id="table-wrapper">
          <table id="table-email" class="table is-bordered is-narrow is-hoverable is-fullwidth">
            <thead>
              <tr>
                <th>Email</th>
                <th width="90">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="2" style="text-align:center">
                <?php if ($name || _session('email_name')) {?>
                  Masih kosong. Coba kirim email ke <u><a href="mailto:<?=($name ?? _session('email_name'))?>@ngetes.com"><?=($name ?? _session('email_name'))?>@ngetes.com</a></u>.
                <?php } else {?>
                  Diisi dulu dong nama emailnya ;)
                <?php }?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <p style="margin-top:10px;">
          <small>
            Catetan:<br>
            - <b>data</b> 30 email terakhir diambil tiap menit<br>
            - <b>unread</b> dihapus tiap 60 menit<br>
            - <b>read</b> dihapus tiap 30 menit<br>
            - <b>tanpa</b> file lampiran<br>
          </small>
        </p>
      </div>
    </div>
  </div>
  <script>
    <?php if ($name) {?>
    let name = '<?=$name?>';
    <?php } else {?>
    let name = localStorage.email_name;
    <?php }?>
    let token = '<?=generateToken(($name ?? _session('email_name')) . _session('token_time'))?>';
    let is_loading = false;
    let repeat = 0;
    let name_session = '<?=($name ?? _session('email_name'))?>';

    let formEmail = document.getElementById('form-email');
    formEmail.addEventListener('submit', function(e) {
      let el = document.querySelectorAll('input[name=email_name]')[0];
      let val = el.value;

      let validEmail = checkEmail(el);
      if (!validEmail) {
        e.preventDefault();
      }
      /* if (val == name) {
        e.preventDefault();
        if (is_loading) {
          console.log('masih loading kak, sabar ya 😉');
          return;
        } else {
          fetchEmails();
        }
      } */

      /* localStorage.setItem("email_name", val); */
    });

    function checkEmail(el = null) {
      let val = el.value;

      let valid = validateEmail(val);
      if (!valid) {
        el.classList.add('is-danger');
      } else {
        el.classList.remove('is-danger');
      }

      return valid;
    }

    function validateEmail(email) {
      let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

      return re.test(String(email + '@ngetes.com').toLowerCase());
    }

    function loading(start = true) {
      is_loading = start;
      let span = '<span class="loader"></span>';
      if (!start) {
        span = '<span>✓</span>';
      }

      let load = document.getElementById('btn-go');
      load.innerHTML = span;
    }

    function generateEmails(data) {
      let tbody = document.getElementsByTagName('tbody')[0];
      let html = '';
      if (data.length) {
        data.forEach((mail, n) => {
          /* let sender = mail.from.name ? mail.from.name + ' ('+mail.from.email+')' : mail.from.email;
          if (typeof sender == 'undefined') {
            sender = mail.from;
          } */
          let read = mail.read ? 'read' : 'unread';
          let spam = mail.spam ? ' spam' : '';
          html += '<tr onclick="location.href=\'/inbox/'+name+'/mail/'+mail.id+'\'" class="'+read+spam+'">';
          html += '<td><div>'+ (spam ? '[spam]' : '') + mail.subject +'<br><small>'+mail.from+'</small></div></td>';
          html += '<td>'+ mail.date +'</td>';
          html += '</tr>';
        });
        tbody.innerHTML = html;
      } else {
        if (repeat == 1) {
          let html = '<tr>'+
                '<td colspan="2" style="text-align:center">'+
                  'Masih kosong. Coba kirim email ke <u><a href="mailto:'+name_session+'@ngetes.com">'+name_session+'@ngetes.com</a></u>.'+
                '</td>'+
              '</tr>';
          tbody.innerHTML = html;
        }
      }
    }

    function fetchEmails() {
      repeat++;
      loading();

      if (name.length) {
        let request = new XMLHttpRequest();
        request.open('POST', '/email/fetch', true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

        request.onload = function() {
          let res = JSON.parse(request.responseText);
          /*  console.log(res); */
          if (request.status >= 200 && request.status < 400) {
            /* Success! */
            let data = res.data;
            if (data.length > 0) {
              generateEmails(data);
            }

            loading(false);
            localStorage.setItem('email_name', name);
            localStorage.setItem("the_emails", JSON.stringify(data));
            setTimeout(function() {
              fetchEmails();
            }, 1000 * 60);
          } else {
            /* We reached our target server, but it returned an error */
            loading(false);
            let tbody = document.getElementsByTagName('tbody')[0];
            let html = '<tr>'+
                  '<td colspan="2" style="text-align:center;color:#ff3860">'+
                    res.message+
                  '</td>'+
                '</tr>';
            tbody.innerHTML = html;

            setTimeout(function() {
              fetchEmails();
            }, 1000 * 60);
          }
        };

        request.onerror = function(err) {
          /* There was a connection error of some sort */
          loading(false);
          setTimeout(function() {
            fetchEmails();
          }, 1000 * 60);
        };

        request.send('name=' + name + '&token=' + token);
      }
    }

    fetchEmails();
    if (localStorage.the_emails && localStorage.email_name == name) {
      let data = JSON.parse(localStorage.the_emails);
      generateEmails(data);
    }
  </script>
<?php include 'footer.php';?>
