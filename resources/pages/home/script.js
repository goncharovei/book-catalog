$(document).ready(function()
{
    const Catalog = function () {
        let dataTable = null;

        let datatableCreate = function () {
            dataTable = new DataTable('#catalog', {
                ajax: window.bookDataTableUrl,
                processing: true,
                serverSide: true,
                responsive: true,
                layout: {
                    topStart: {
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                    },
                    bottom2Start: {
                        buttons: ['pageLength']
                    }
                },
                pageLength: 10,
                lengthMenu: [10, 100, 300, 500],
                columns: [
                    {data: 'name'},
                    {data: 'author_names', orderable: false},
                    {data: 'isbn'},
                    {data: 'year_publication'},
                    {data: 'publisher_name', orderable: false}
                ],
                order: [[0, 'asc']]
            });
        }

        return {
            init: function (){
                datatableCreate();
            }
        }
    }();
    Catalog.init();

})
