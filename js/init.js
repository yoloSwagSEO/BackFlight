$(function () {
    $(".countdown").kkcountdown({
        dayText : 'day ',
        daysText : 'days ',
        hoursText : 'h ',
        minutesText : 'm ',
        secondsText : 's',
        displayZeroDays : false,
        oneDayClass : 'one-day'
    });
});