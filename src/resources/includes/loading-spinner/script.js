window.LoadingSpinner = function (){
    let showTimer = 0;

    let show = function () {
        clearTimeout(showTimer);

        showTimer = setTimeout(function () {
            $("#overlay").fadeIn(300);
        }, 1000);
    }

    let hide = function (){
        clearTimeout(showTimer);
        $("#overlay").fadeOut(300);
    }

    return {
        show: show,
        hide: hide
    };
}();
