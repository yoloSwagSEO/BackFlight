<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <base href="http://localhost/BackFlight/" />
    <title><?php echo title()?></title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/foundation.css" />
<?php
    $array_styles = css();
    foreach ($array_styles as $src => $null)
    {
        echo '    <link rel="stylesheet" href="css/'.$src.'.css" />'."\n";
    }
    ?>
    <script src="js/vendor/custom.modernizr.js"></script>
</head>
<body>
    <div class="row">
        <div class="large-12 columns">
            <h1><a href="#">LastFly</a></h1>
            <hr />
        </div>
    </div>