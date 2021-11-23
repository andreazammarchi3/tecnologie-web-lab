function newCurrent(element){
    $("div.slider-image > img")
        .removeClass("current")
        .hide();
    element.addClass("current");
    element.prev().show();
    element.show();
    element.next().show();
}

$(document).ready(function(){
    newCurrent($("div.slider-image > img").first());

    $("div.slider-image > img").click(function(){
        if (!$(this).hasClass("current")) {
            newCurrent($(this));
        }
    });
});