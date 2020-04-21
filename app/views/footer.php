  </section>
  <footer class="footer">
    <div class="container">
      <div class="content has-text-grey has-text-centered">
        <small class="has-text-grey">
          <!--Template by <a href="//github.com/dansup/bulma-templates" target="_blank" class="has-text-grey-darker">dansup</a>.<br>-->
          &copy; April 2019. Hak cipta dilindungi Yang Maha Kuasa.<br>
          Dibuat dengan <span id="hati2">❤-❤</span>.
        </small>

        <?php if (_server('SERVER_NAME') == "ngetes.com" || _server('SERVER_NAME') == "www.ngetes.com") {?>
          <br>
          <script type="text/javascript" data-cfasync="false" src="//uprimp.com/bnr.php?section=General&pub=521431&format=728x90&ga=g"></script>
          <noscript><a href="https://yllix.com/publishers/521431" target="_blank"><img src="//ylx-aff.advertica-cdn.com/pub/728x90.png" style="border:none;margin:0;padding:0;vertical-align:baseline;" alt="ylliX - Online Advertising Network" /></a></noscript>
        <?php }?>
      </div>
    </div>
  </footer>
  <script>
    var hati2 = document.getElementById('hati2');
    hati2.addEventListener('mouseover', function() {
      hati2.innerHTML = 'hati-hati';
    });
    hati2.addEventListener('mouseout', function() {
      hati2.innerHTML = '❤-❤';
    });
  </script>
  <?php if (_server('SERVER_NAME') == "ngetes.com" || _server('SERVER_NAME') == "www.ngetes.com") {?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?=config('ga_code')?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?=config('ga_code')?>');
    </script>
  <?php }?>
<!-- </body>
</html> -->

</body>
</html>
