<?php
title('Inscription');
head();
?>



<form action="inscription" method="post">
    <div class="row"><?php
if (!empty($_SESSION['errors']['inscription'])) {
    if (!empty($_SESSION['errors']['inscription']['pseudo'])) {
        if ($_SESSION['errors']['inscription']['pseudo'] == 'invalid') {
            echo '<div data-alert="" class="alert-box alert radius">Pseudo invalide</div>';
        } else {
            echo '<div data-alert="" class="alert-box alert radius">Pseudo déjà utilisé</div>';
        }
        unset($_SESSION['errors']['inscription']['pseudo']);
    }
    if (!empty($_SESSION['errors']['inscription']['email'])) {
        if ($_SESSION['errors']['inscription']['email'] == 'invalid') {
            echo '<div data-alert="" class="alert-box alert radius">Mail invalide</div>';
        } else {
            echo '<div data-alert="" class="alert-box alert radius">Mail déjà utilisé : seul un compte par adresse mail est autorisé</div>';
        }
        unset($_SESSION['errors']['inscription']['email']);
    }

    if (!empty($_SESSION['errors']['inscription']['key'])) {
         echo '<div data-alert="" class="alert-box alert radius">Clef alpha incorrecte.</div>';
         unset($_SESSION['errors']['inscription']['key']);
    }
    ?>
    
    <?php
}
?>
        <div class="columns large-8">
        <h3>Inscription</h3>
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
                    <?php echo Form::label('email', 'Adresse mail', 'right inline');?>
                </div>
                <div class="small-6 columns">
                    <?php echo Form::input('email', 'email');?>
                </div>
            </div>
            <div class="row">
                <div class="small-6 columns">
                    <?php echo Form::label('clef', 'Clef alpha', 'right inline');?>
                </div>
                <div class="small-6 columns">
                    <?php echo Form::input('clef');?>
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
