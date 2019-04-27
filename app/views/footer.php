  </section>
  <footer class="footer">
    <div class="container">
      <div class="content has-text-grey has-text-centered">
        <small class="has-text-grey">
          Template by <a href="//github.com/dansup/bulma-templates" target="_blank" class="has-text-grey-darker">dansup</a>.<br>
          &copy; April 2019. Dibuat dengan hati-hati.
        </small>
      </div>
    </div>
  </footer>
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
