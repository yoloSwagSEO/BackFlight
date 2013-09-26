var countdowns;

function updateCompteurs()
{
    var counting = 0;
    countdowns.each(function() {
        var time = $(this).data('time');
        if (time !== 0) {
            var timeLeft = (parseInt(time) - 1);
            $(this).html(transformerTime(timeLeft));
            $(this).data('time', timeLeft);
            counting++;
        } else {
            $(this).html('Terminé');
        }
    });

    if (counting !== '0') {
        setTimeout('updateCompteurs()', 1000);
    }
}

function transformerTime(time)
{
    if (time === 0) {
        return 'Terminé';
    }
    var jours = Math.floor(time / (3600 *24));
    var restant = time % (3600 * 24);
    var heures = Math.floor(restant / 3600);
    restant = restant % 3600;
    var minutes = Math.floor(restant / 60);
    restant = restant % 60;
    var secondes = restant;
    var retour = '';
    if (jours !== 0) {
        retour += jours+'j ';
    }
    if (heures !== 0) {
        retour += heures+'h ';
    }
    if (minutes !== 0) {
        retour += minutes+'m ';
    }
    if (secondes !== 0) {
        retour += secondes+'s ';
    }
    return retour+' restant';
}

$(function () {
    countdowns = $('.countdown');   

    setTimeout(function () {
        updateCompteurs();
    }, 1000);
});