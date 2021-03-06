var T;

function updateCompteurs()
{
    var countdowns = $('.countdown');
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
            setTimeout(function () {
                window.location.reload();
            }, 1000);
        }
    });

    T = setTimeout('updateCompteurs()', 1000);
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
    T = setTimeout(function () {
        updateCompteurs();
    }, 1000);

    // Module building
    $('.module_link').on('click', function () {
        var link = $(this);
        $.post('modules/build', {moduleId: $(this).data('module-id')}, function(data) {
            if (data !== 'err') {
                link.find('.icon_big').attr('data-icon', '');
                link.find('.module_time').html(data);
            }
        });
        return false;
    });

    // Module activation
    $('.module_enable').on('click', function () {
        $.post('modules/enable', {moduleId: $(this).data('module-id')}, function (data) {
            if (data !== 'err') {
                window.location.reload();
            }
        });
        return false;
    });

    // Module disactivation
    $('.module_disable').on('click', function () {
        $.post('modules/disable', {moduleId: $(this).data('module-id')}, function (data) {
            if (data !== 'err') {
                window.location.reload();
            }
        });
        return false;
    });

    // Weapon building
    $('.weapon_link').click(function () {
        var link = $(this);
        $.post('weapons/build', {weaponId: $(this).data('weapon-id')}, function (data) {
            if (data !== 'err') {
                link.find('.icon_big').attr('data-icon', '');
                link.find('.weapon_time').html(data);
            }
        });
        return false;
    });

    // Chat read
    $(document).on('mouseenter', '.message[data-unread]', function () {
        var message = $(this);
        var messageUnread = $(this).find('.message_unread');
        if (messageUnread) {
            message.removeAttr('data-unread');
            $.post('messages/read', {messageId: $(this).data('message-id')}, function () {
                messageUnread.fadeOut(function () {
                    $(this).detach();
                });
            });
        }
    });

});