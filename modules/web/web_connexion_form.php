<?php
title('Connexion');
head();
?>



<form action="connexion" method="post">
    <div class="row"><?php
if (!empty($_SESSION['error_connexion'])) {
    ?>
    <div data-alert="" class="alert-box alert radius">Erreur lors de la connexion : pseudo et mot de passe invalides ou joueur inexistant.</div>
    <?php
}
?>
        <div class="columns large-8">
            <div class="row">
                <div class="small-6 columns">
                    <?php echo Form::label('pseudo', 'Pseudo', 'right inline');?>
                </div>
                <div class="small-6 columns">
                    <?php echo Form::input('pseudo');?>
                </div>
            </div>
            <div class="row">
                <div class="small-6 columns">
                    <?php echo Form::label('password', 'Mot de passe', 'right inline');?>
                </div>
                <div class="small-6 columns">
                    <?php echo Form::input('password', 'password');?>
                    <input type="submit" class="button">
                </div>
            </div>
        </div>
    </div>
</form>
<?php foot();
