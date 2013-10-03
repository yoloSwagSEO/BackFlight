var countdowns;
var T;

function updateCompteurs()
{
    countdowns = $('.countdown');   
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
        T = setTimeout('updateCompteurs()', 1000);
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

    T = setTimeout(function () {
        updateCompteurs();
    }, 1000);

    // Module building
    $('.module_link').on('click', function () {
        var link = $(this);
        $.post('modules/build', {moduleId: $(this).data('module-id')}, function(data) {
            if (data !== 'err') {
                console.log(link.find('.icon_big'));
                link.find('.icon_big').attr('data-icon', '');
                link.find('.module_time').html(data);
            }
        });
        return false;
    });

    // Module enabling
    $('.module_enable').on('click', function () {
        $.post('modules/enable', {moduleId: $(this).data('module-id')}, function (data) {
            if (data !== 'err') {
                window.location.reload();
            }
        });
        return false;
    });
});