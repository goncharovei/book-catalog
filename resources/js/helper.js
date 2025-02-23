window.alertShow = function (text)
{
    'toastr' in window ? toastr.error(text) : alert(text);
}
window.successShow = function (text)
{
    'toastr' in window ? toastr.success(text) : alert(text);
}
window.infoShow = function (text)
{
    'toastr' in window ? toastr.info(text) : alert(text);
}

window.ajaxErrorMessage = function (jqXHR, exception)
{
    var msg = '';
    if (jqXHR.status === 0) {

    } else if (jqXHR.status === 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status === 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }

    alertShow(msg);
}

window.ajaxErrorValidationMessage = function (validator, errors)
{
    if (!validator || !('showErrors' in validator))
    {
        alertShow('The validator is not found.');
        return;
    }

    var errorNotShown = '';
    $.each(errors, function(errorKey, errors) {
        var errorText = '';
        $.each(errors, function(key, error) {
            errorText += error + ' ';
        });

        try {
            validator.showErrors({[errorKey]: errorText});
        } catch (err) {
            errorNotShown += errorText + "\n";
        }
    });
    if (errorNotShown)
    {
        alertShow(errorNotShown);
    }
}
