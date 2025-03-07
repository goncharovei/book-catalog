$(document).ready(function()
{
    new DataTable('#example', {
        responsive: true,
        layout: {
            topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            }
        }
    });

})
