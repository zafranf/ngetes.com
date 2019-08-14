<?php
$title = 'Baca emailnya ' . $name;
$follow = false;
$keywords = 'baca email kiriman, ngetes email kiriman, buka email kiriman, baca email di ngetes.com';
$description = 'Baca emailnya ' . $name . ' di ngetes.com';
include 'header.php';
?>
<?=load_css('/css/revert.css')?>
  <style>
    #table-wrapper {
      border: 1px solid #dbdbdb;
      border-radius: 4px;
    }
    #table-email {
      border-radius: 4px;
      border-style: hidden;
      font-size: 14px;
    }
    /* #table-email a {
        color: #3273dc;
    } */
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
        <div id="table-wrapper">
          <table id="table-email" class="table is-narrow is-fullwidth">
            <tbody>
              <tr>
                <td id="content" colspan="2">
                  <div style="text-align:center;">Yah, gak ada emailnya 🙁</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script>
    var name = '<?=$name?>';
    var token = '<?=generateToken($name . _session('token_time'))?>';
    var loading_time;

    function backToInbox() {
      location.href = '<?=url('/inbox/' . $name)?>';
    }

    /**
    * Index of Multidimensional Array
    * https://stackoverflow.com/a/16102526/6885956
    * @param arr {?Array} - the input array
    * @param k {object} - the value to search
    * @return {Array}
    */
    getIndexOfK(JSON.parse(localStorage.the_emails), 'id', <?=$id?>);
    function getIndexOfK(arr, key, value){
      if (!arr){
        return [];
      }
      for(var i=0; i<arr.length; i++){
        if (arr[i][key] == value) {
          return i;
        }
      }

      return [];
    }

    function loading(n=1) {
      let dots = '.';
      dots = dots.repeat(n);
      n = (n == 5) ? 0 : n;
      let span = '<div style="text-align:center;"><span style="font-size:30px;line-height:0;">'+dots+'</span></div>';

      let load = document.getElementById('content');
      load.innerHTML = span;

      loading_time = setTimeout(function() {
        n = (n==0) ? n+1 : n+2;
        loading(n);
      }, 500);
    }

    function generateEmail(mail) {
      if (mail) {
        let sender = mail.from.name ? mail.from.name + ' ('+mail.from.email+')' : mail.from.email;
        if (typeof sender == 'undefined') {
          sender = mail.from;
        }
        let attachments = mail.attachments ? mail.attachments : 0;
        let content = mail.content ? mail.content : '<div style="text-align:center;"><span style="font-size:30px;line-height:0;">...</span></div>';

        let html = '<tr>';
        html += '<td style="border-right:0;"><span id="subject">'+mail.subject+'</span><br><span id="sender"><small>'+sender+'</small></span></td>';
        html += '<td width="156" style="border-left:0;text-align:right;">'+mail.date+'<br><small>'+attachments+' lampiran</small></td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td colspan="2" id="content" style="padding:0">'+content+'</td>';
        html += '</tr>';

        let tbody = document.getElementsByTagName('tbody')[0];
        tbody.innerHTML = html;
      }
    }

    function fetchEmail() {
      loading();

      let id = parseInt('<?=$id?>');
      if (name.length && id > 0) {
        let request = new XMLHttpRequest();
        request.open('POST', '<?=url('/email/fetch/single')?>', true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

        request.onload = function() {
          if (request.status >= 200 && request.status < 400) {
            clearTimeout(loading_time);
            // Success!
            let res = JSON.parse(request.responseText);
            console.log(res);
            let data = res.data;
            generateEmail(data);
          } else {
            clearTimeout(loading_time);
            // We reached our target server, but it returned an error
            let load = document.getElementById('content');
            load.innerHTML = '<div style="text-align:center;">Yah, gak ada emailnya 🙁</div>';
          }
        };

        request.onerror = function() {
          clearTimeout(loading_time);
          // There was a connection error of some sort
          let load = document.getElementById('content');
          load.innerHTML = '<div style="text-align:center;">Waduh, herror 😱</div>';
        };

        request.send('name=' + name + '&id=' + id + '&token=' + token);
      }
    }

    fetchEmail();
    if (localStorage.the_emails) {
      let data = JSON.parse(localStorage.the_emails);
      let email = data[getIndexOfK(data, 'id', <?=$id?>)];
      generateEmail(email);
    }
  </script>
<?php include 'footer.php';?>
