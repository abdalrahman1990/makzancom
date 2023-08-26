<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Storage;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
{
    
    return (new EloquentDataTable($query))
        ->addColumn('image', function(User $user) {
            $imagePath = $user->image ? $user->image : '/users/5Qkvrlo3ZqbTTY3g47VToaVnDyApHGFFainxtQWe.jpg'; // Default image if no image exists
            return '<img src="'. Storage::url($imagePath) .'" alt="User Image" width="40" height="40">';
        })
        ->addColumn('action', function(User $user) {
            $editRoute = route('admin.users.edit', $user->id);
            $deleteRoute = route('admin.users.destroy', $user->id);
            
            return '<a href="'.$editRoute.'" class="btn btn-sm btn-primary mr-2" title="Edit"><i class="fas fa-edit"></i></a>
            <button data-id="'.$user->id.'" data-route="'.$deleteRoute.'" class=" delete-user btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(['action', 'image']);
}


    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->width(40)->addClass('text-center'),
            Column::make('name')->width(60)->addClass('text-center'),
            Column::computed('image')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            // Column::make('username'),
            Column::make('email')->width(60)->addClass('text-center'),
            Column::make('role')->width(50)->addClass('text-center'),
            Column::make('status')->width(50)->addClass('text-center'),
            
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(70)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
