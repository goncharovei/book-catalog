<?php

namespace App\Front\Book\Http\DataTables;

use App\Common\Models\Book;
use App\Front\Book\Service\BookDataTable\BookDataTableFilterDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class BookDataTable extends DataTable
{
    private BookDataTableFilterDto $filter;

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
            ->filter(callback: [$this, 'filter'], globalSearch: true)
            ->only($this->displayColumnNames())
            ->rawColumns(['name']);
    }

    public function setFilterData(BookDataTableFilterDto $filter): static
    {
        $this->filter = $filter;

        return $this;
    }

    public function filter(QueryBuilder $query): void
    {
        $query->when(!empty($this->filter->searchText), function (Builder $query)
        {
            $likeVal = '"%' . strtolower($this->filter->searchText) . '%"';
            $query->orWhere(function (Builder $query) use ($likeVal)
            {
                $query->whereHas('publisher', function (Builder $query) use ($likeVal) {
                    $query->whereRaw('LOWER(name) LIKE ' . $likeVal);
                });

            });

            $query->orWhereRaw('LOWER(authors_text) LIKE ' . $likeVal);
            
        });

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
