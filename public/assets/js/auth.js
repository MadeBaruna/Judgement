$(function () {
    var box = $('.box');

    box.on("click", ".register", function() {
        console.log('register btn');
        $('.dimmer').addClass('active');
        $.get( "register", function( data ) {
            box.html(data);
            $('.dimmer').removeClass('active');
            $('title').text($(data).filter('title').text());
            window.history.pushState("", "", "/register");
        });
    });

    box.on("click", ".login", function() {
        console.log('login btn');
        $('.dimmer').addClass('active');
        $.get( "login", function( data ) {
            box.html(data);
            $('.dimmer').removeClass('active');
            $('title').text($(data).filter('title').text());
            window.history.pushState("", "", "/login");
        });
    });
});