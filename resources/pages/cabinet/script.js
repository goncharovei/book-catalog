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

        let tokenToggleDisplay = function () {
            $('#js-token-show-btn').click(function (){
                let inputType = $('#token').attr('type') === 'password' ? 'text' : 'password';
                $('#token').attr('type', inputType);
            })
        }

        let onRefresh = function () {
            $('#js-token-refresh').on('click', function(){
                onConfirm(function (){
                    $.alert('onRefresh');
                })
            });
        }

        let onRevoke = function () {
            $('#js-token-revoke').on('click', function(){
                onConfirm(function (){
                    $.alert('onRevoke');
                })
            });
        }

        let onConfirm = function (callback) {
            $.confirm({
                title: 'Confirm',
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
                tokenToggleDisplay();
                onRevoke();
                onRefresh();
            }
        }
    }();
    Cabinet.init();

})
