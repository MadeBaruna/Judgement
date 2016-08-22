$(function() {
    $('.ui.dropdown.type').dropdown();

    $('.ui.dropdown.language').dropdown();

    $('.ui.dropdown.category').dropdown();

    $('.ui.dropdown.allowed_user').dropdown({
        allowAdditions: true
    });

    $('.start_date').on('change keyup paste', function() {
        updateDateTime('.start')
    });

    $('.end_date').on('change keyup paste', function() {
        updateDateTime('.end')
    });

    updateDateTime('.start');
    updateDateTime('.end');

    var deleteContestModal = $('.ui.modal.delete_contest_modal');
    if(deleteContestModal.length) {
        deleteContestModal.modal('attach events', '.delete_contest', 'show');
    }

    var deleteProblemModal = $('.ui.modal.delete_problem_modal');
    if(deleteProblemModal.length) {
        deleteProblemModal.modal('attach events', '.delete_problem', 'show');
    }
});

function updateDateTime(type) {
    var date = $(type + '_date .date').val() || 0;
    var month = $(type + '_date .month').val() || 0;
    var year = $(type + '_date .year').val() || 0;
    var hour = $(type + '_date .hour').val() || 0;
    var minute = $(type + '_date .minute').val() || 0;
    var second = $(type + '_date .second').val() || 0;

    var combined = year + "-" + month + "-" + date + "T" + hour + ":" + minute + ":" + second;
    var datetime = moment(combined, 'YYYY-M-DTH:m:s');

    $(type + '_time_input').val(combined);

    $(type + '_time_parsed').val(datetime.format('ddd DD-MMM-YYYY HH:mm:ss'));
}