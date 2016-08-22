$(function () {
    $('.profile .image').dimmer({
        on: 'hover'
    });

    var profileModal = $('.ui.modal.profile_modal');
    if(profileModal.length) {
        profileModal.modal({
            onDeny: function () {
                confirm(0);
                var current_pic = $('.current_picture').attr('src') + '?' + Math.random();
                $('.profile_modal .image').attr('src', current_pic);
                $('.profile_picture input:text').val('');
            },
            onApprove: function () {
                confirm(1);
            }
        }).modal('attach events', '.profile .image', 'show');
    }

    $('input:text, .ui.button', '.ui.action.input').on('click', function(e) {
        $('input:file', $(e.target).parents()).click();
    });

    var ajaxUpload;
    $('input:file', '.ui.action.input').on('change', function(e) {
        var name = e.target.files[0].name;
        $('input:text', $(e.target).parent()).val(name);
        var form = $('.profile_picture')[0];
        var form_data = new FormData(form);

        $('.profile_modal .progress').css('visibility', 'visible');

        if($.active > 0) {
            ajaxUpload.abort();
        }

        ajaxUpload = $.ajax({
            async: true,
            url: 'profile',
            type: "POST",
            contentType: false,
            data: form_data,
            processData: false,
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress', uploadPictureProgress, false);
                }
                return myXhr;
            },
            success: function (data) {
                var form = $('.profile_picture');
                form.removeClass('error');
                if(data.image != null) {
                    form.addClass('error');
                    var p = $('.profile_modal .error p');
                    p.css('display', 'inline');
                    p.text(data.image[0]);
                } else {
                    $('.profile_modal .image').attr('src', data + '?' + Math.random());
                }
            },
            error: function(xhr, textStatus, error) {
                $('.profile_picture').addClass('error');
                var p = $('.profile_modal .error p');
                p.css('display', 'inline');
                p.text('The image may not be greater than 2000 kilobytes.');
            }
        });
        event.preventDefault();
    });
});

function confirm(confirm) {
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'profile/confirm',
        data: {confirm: confirm},
        success: function(data) {
            if(data != '') {
                $('.profile .image').attr('src', data + '?' + Math.random());
                $('.avatar').attr('src', data + '?' + Math.random());
            }
        }
    });
}

function uploadPictureProgress(progress) {
    var percent = (progress.loaded/progress.total)*100;
    $('.profile_modal .progress').progress({percent: percent});
}