$(document).ready(function()
{
    let $dataTable = new DataTable('#catalog', {
        ajax: window.bookDataTableUrl,
        processing: true,
        serverSide: true,
        responsive: true,
        layout: {
            topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            }
        },
        columns: [
            {data: 'name'},
            {data: 'author_names'},
            {data: 'isbn'},
            {data: 'year_publication'},
            {data: 'publisher_name'}
        ]
    });

})
