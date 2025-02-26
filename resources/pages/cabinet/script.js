$(document).ready(function()
{
    const Cabinet = function () {
        let onClipboard = function () {
            const clipboardJs = new ClipboardJS('.js-clipboard-btn');
            clipboardJs.on('success', function (e) {
                successShow('Copied to clipboard');
            });
            clipboardJs.on('error', function (e) {
                if (!e.text)
                {
                    return;
                }

                alertShow('Fail to clipboard');
            });
        }

        let onCopyClick = function () {
            $('.js-clipboard-btn').click(function (){
                tokenShow();
            });
        }

        let tokenShow = function () {
            $('#token').attr('type', 'text');
        }

        let tokenToggleDisplay = function () {
            $('#js-token-show-btn').click(function (){
                let inputType = $('#token').attr('type') === 'password' ? 'text' : 'password';
                $('#token').attr('type', inputType);
            })
        }

        let onRefresh = function () {
            $('#js-token-refresh').on('click', function(){
                onConfirm(function (){
                    refreshRequest();
                }, 'Refresh')
            });
        }

        let refreshRequest = function () {
            LoadingSpinner.show();
            $.ajax({
                method: 'post',
                url: $('#js-token-refresh').data('token-refresh-url'),
                dataType: 'json',
                success: function (response)
                {
                    LoadingSpinner.hide();
                    if ('exception' in response)
                    {
                        alertShow(response.exception);
                        return;
                    }

                    $('#token').val(response.token);
                    tokenShow();

                    successShow('Success');
                },
                error: function (jqXHR, exception)
                {
                    LoadingSpinner.hide();
                    ajaxErrorMessage(jqXHR, exception);
                }
            });
        }

        let onRevoke = function () {
            $('#js-token-revoke').on('click', function(){
                onConfirm(function ()
                {
                    revokeRequest();
                }, 'Revoke')
            });
        }

        let revokeRequest = function () {
            LoadingSpinner.show();
            $.ajax({
                method: 'delete',
                url: $('#js-token-revoke').data('token-revoke-url'),
                dataType: 'json',
                success: function (response)
                {
                    LoadingSpinner.hide();
                    if ('exception' in response)
                    {
                        alertShow(response.exception);
                        return;
                    }

                    $('#token').val('');

                    successShow('Success');
                },
                error: function (jqXHR, exception)
                {
                    LoadingSpinner.hide();
                    ajaxErrorMessage(jqXHR, exception);
                }
            });
        }

        let onConfirm = function (callback, title = 'Confirm', message = 'Are you sure to continue?') {

            $.confirm({
                title: title,
                content: message,
                icon: 'fa fa-question',
                theme: 'bootstrap',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                buttons: {
                    yes: {
                        text: 'Yes',
                        action: callback
                    },
                    no: {
                        text: 'No'
                    }
                }
            });
        }

        return {
            init: function (){
                onClipboard();
                onCopyClick();
                tokenToggleDisplay();
                onRevoke();
                onRefresh();
            }
        }
    }();
    Cabinet.init();

})
