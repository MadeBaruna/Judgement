var _t;

$(function () {
    $('.ui.dropdown').dropdown({
        action: 'hide'
    });

    $('.servertime').popup();

    $.get("/time", function (time) {
        $(".servertime .time").text(time.time);
        _t = moment(time.date + " " + time.time);
        setInterval(function () {
            updateTime();
        }, 1000);
    });

    MathJax.Hub.Config({
        displayAlign: "left",
        asciimath2jax: {
            delimiters: [['$$', '$$']]
        }
    });

    $('.start_time_index').each(function () {
        var id = $(this).data('id');
        var datetime = $(this).data('datetime');

        $('.time_button[data-id="' + id + '"]').countdown(datetime)
            .on('update.countdown', function (event) {
                var format = '%H:%M:%S';
                if (event.offset.totalDays > 0)format = '%-nD %-Hh';
                if (event.offset.months > 0) format = '%-mM %-nD';
                if (event.offset.years > 0) format = '%-YY %-mM';
                $(this).html(event.strftime(format));
            })
            .on('finish.countdown', function (event) {
                $(this).html('STARTED');
            });
    });

    var cd = $('.countdown span');
    if (cd.length) {
        var datetime = cd.text();

        cd.countdown(datetime)
            .on('update.countdown', function (event) {
                var format = '%H:%M:%S';
                if (event.offset.totalDays > 0)format = '%-nD %-Hh';
                if (event.offset.months > 0) format = '%-mM %-nD';
                if (event.offset.years > 0) format = '%-YY %-mM';
                $(this).html(event.strftime(format));
            })
            .on('finish.countdown', function (event) {
                $(this).html('STARTED');
            });
    }
});

function updateTime() {
    _t.add(1, 's');

    $(".servertime .time").text(_t.format("HH:mm:ss"));
}