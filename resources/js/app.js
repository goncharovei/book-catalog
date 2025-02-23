import './bootstrap';

$(document).ready(function()
{
    function tooltipInit()
    {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            tooltipTriggerEl.addEventListener(
                'mouseout',
                (event) => {
                    event.target.blur();
                }
            );
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    }
    tooltipInit();

})
