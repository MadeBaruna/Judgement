var _t;

$(function () {
    hljs.initHighlightingOnLoad();

    $('.ui.dropdown').dropdown({
        action: 'hide'
    });

    $('.ui.dropdown.submit_source').dropdown();

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
        },
        messageStyle: "none"
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
                $(this).html('ENDED');
            });
    }

    $('.submit_problem').click(function () {
        $('.submit_loading').addClass('active');
    });

    var clarificationModal = $('.ui.modal.clarification_modal');

    $('button.clarification').click(function () {
        if (clarificationModal.length) {
            $.get('/contest/' + $(this).data('contest') + '/clarification/' + $(this).data('clarification'),
                function (data) {
                    $('.clarification_title').text(data.title);
                    $('.clarification_modal .problem').text(data.problem);
                    $('.clarification_modal .question').text(data.question);
                    $('.clarification_modal .answer').text(data.answer);
                });
            clarificationModal.modal('show');
        }
    });
});

function updateTime() {
    _t.add(1, 's');

    $(".servertime .time").text(_t.format("HH:mm:ss"));
}
