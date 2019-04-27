<?php include 'header.php';?>
  <style>
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
        <p class="control">
          <button onclick="backToInbox()" type="button" class="button" id="btn-go">&laquo; Inbox</button>
        </p>
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
    function backToInbox() {
      location.href = '<?=url('/inbox?name=' . $name)?>';
    }

    function getEmail() {
      let token = '<?=generateToken($name . _session('token_time'))?>';
      let id = parseInt('<?=$id?>');
      let name = '<?=$name?>';
      if (name.length && id > 0) {
        var request = new XMLHttpRequest();
        request.open('POST', '<?=url('/crawl/single')?>', true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

        request.onload = function() {
          if (request.status >= 200 && request.status < 400) {
            // Success!
            let res = JSON.parse(request.responseText);
            console.log(res);
            let html = '';
            let data = res.data
            /* data.forEach((mail, n) => {
              let read = mail.read ? 'read' : 'unread';
              let sender = mail.from.name ? mail.from.name + ' ('+mail.from.email+')' : mail.from.email;
              let attachments = mail.attachments > 0 ? '<span style="float:right;">'+ mail.attachments +' lampiran</span>' : '';
              html += '<tr onclick="location.href=\'<?=url('/inbox/mail/')?>'+mail.id+'\'" class="'+read+'">';
              html += '<td><div>'+sender+''+attachments+'<br>'+ mail.subject +'<br>'+mail.message+'</div></td>';
              html += '<td>'+ mail.date +'</td>';
              html += '</tr>';
            });
            let tbody = document.getElementsByTagName('tbody')[0];
            tbody.innerHTML = html; */
          } else {
            // We reached our target server, but it returned an error

          }
        };

        request.onerror = function() {
          // There was a connection error of some sort
        };

        request.send('name=' + name + '&id=' + id + '&token=' + token);
      }
    }

    getEmail()
  </script>
<?php include 'footer.php';?>
