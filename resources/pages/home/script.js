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
                lengthMenu: [10, 25, 50, 100, { label: 'All', value: -1 }],
                columns: [
                    {data: 'name'},
                    {data: 'author_names'},
                    {data: 'isbn'},
                    {data: 'year_publication'},
                    {data: 'publisher_name'}
                ]
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
