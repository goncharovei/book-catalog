import './bootstrap';

$(document).ready(function()
{
    function tooltipInit()
    {
        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
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
