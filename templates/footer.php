    <!--<script src="js/foundation.min.js"></script>-->

    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation/foundation.js"></script>
    <script src="js/foundation/foundation.alerts.js"></script>
    <script src="js/foundation/foundation.clearing.js"></script>
    <script src="js/foundation/foundation.cookie.js"></script>
    <script src="js/foundation/foundation.dropdown.js"></script>
    <script src="js/foundation/foundation.forms.js"></script>
    <script src="js/foundation/foundation.joyride.js"></script>
    <script src="js/foundation/foundation.magellan.js"></script>
    <script src="js/foundation/foundation.orbit.js"></script>
    <script src="js/foundation/foundation.placeholder.js"></script>
    <script src="js/foundation/foundation.reveal.js"></script>
    <script src="js/foundation/foundation.section.js"></script>
    <script src="js/foundation/foundation.tooltips.js"></script>
    <script src="js/foundation/foundation.topbar.js"></script>

    <script src="js/init.js"></script>

    <script>
      $(document).foundation();
    </script>
<?php
    $array_scripts = script();
    foreach ($array_scripts as $src => $script)
    {
        if ($script) {
            $src = '';
        } else {
            $src = ' src="js/'.$src.'.js"';
        }
        echo '    <script'.$src.'>'.$script.'</script>'."\n";
    }
    ?>
</body>
</html>