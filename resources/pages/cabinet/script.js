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
                var inputType = $('#token').attr('type') === 'password' ? 'text' : 'password';
                $('#token').attr('type', inputType);
            })
        }

        return {
            init: function (){
                onClipboard();
                tokenToggleDisplay();
            }
        }
    }();
    Cabinet.init();

})
