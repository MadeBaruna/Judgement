var _t;

$(function () {
    $('.ui.dropdown').dropdown({
        action: 'hide'
    });

    $('.servertime').popup();

    $.get("/time", function (time) {
        $(".servertime .time").text(time.time);
        _t = moment(time.date + " " + time.time);
        setInterval(function() {
            updateTime();
        }, 1000);
    });

    MathJax.Hub.Config({
        displayAlign: "left",
        asciimath2jax: {
            delimiters: [['$$','$$']]
        }
    });

    countdown.setLabels('ms|s|m|h|D|W|M|Y', 'ms|s|m|h|D|W|M|Y', ' ', ' ', 'START', null);
    $('.start_time_index').each(function() {
        $id = $(this).data('id');
        $datetime = $(this).data('datetime');
        setInterval(updateCountdown, 1000, $id, $datetime);
    });
});

function updateTime() {
    _t.add(1, 's');

    $(".servertime .time").text(_t.format("HH:mm:ss"));
}

function updateCountdown($id, $datetime) {
    var cd = countdown(null, new Date($datetime), null, 2);
    var str = cd.toString();
    if(str == 'START') {
        setTimeout(function() {
            location.reload();
        }, 1000);
    }
    $('.time_button[data-id="' + $id + '"]').html(str);
}