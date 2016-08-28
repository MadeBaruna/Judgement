$(function () {
    var box = $('.box');

    box.on("click", ".register", function() {
        $('.dimmer').addClass('active');
        $.get("/register", function (data) {
            box.html(data);
            $('.dimmer').removeClass('active');
            $('title').text($(data).filter('title').text());
            window.history.pushState("", "", "/register");
        });
    });

    box.on("click", ".login", function() {
        $('.dimmer').addClass('active');
        $.get("/login", function (data) {
            box.html(data);
            $('.dimmer').removeClass('active');
            $('title').text($(data).filter('title').text());
            window.history.pushState("", "", "/login");
        });
    });

    box.on("click", ".forgot", function () {
        $('.dimmer').addClass('active');
        $.get("/password/reset", function (data) {
            box.html(data);
            $('.dimmer').removeClass('active');
            $('title').text($(data).filter('title').text());
            window.history.pushState("", "", "/password/reset");
        });
    });
});