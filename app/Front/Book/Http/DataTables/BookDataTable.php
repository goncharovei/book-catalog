<?php

namespace App\Front\Book\Http\DataTables;

use App\Common\Models\Book;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class BookDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addColumn('author_names', function (Book $book){
                return $book->author_names;
            })
            ->addColumn('publisher_name', function (Book $book){
                return $book->publisher->name;
            })
            ->editColumn('name', function (Book $book){
                return view('book.link', [
                    'url' => $book->detail_link,
                    'name' => $book->name
                ])->render();
            })
            ->only($this->displayColumnNames())
            ->rawColumns(['name']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Book $model): QueryBuilder
    {
        return $model->newQuery()->with('publisher');
    }

    private function displayColumnNames(): array
    {
        return [
          'isbn', 'name', 'author_names', 'year_publication', 'publisher_name'
        ];
    }
}
