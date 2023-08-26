<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        
            ->addColumn('icon', function($query) {
                return '<i style="font-size:23px" class="'.$query->icon.'"></i>';  // Using the e() function to escape the data
            })
            ->addColumn('status', function($query) {
                $toggleStatusRoute = route('admin.category.toggleStatus', $query->id);
            
                $checked = $query->status ? 'checked' : '';
                return '<div class="form-check form-switch form-switch-right form-switch-md">
                    <input type="checkbox" class="form-check-input code-switcher status-toggle" id="customSwitch'.$query->id.'" data-id="'.$query->id.'" data-route="'.$toggleStatusRoute.'" '.$checked.'>
                </div>';
            })
         
            ->addColumn('action', function($query) {
                $editRoute = route('admin.category.edit', $query->id);
                $deleteRoute = route('admin.category.destroy', $query->id);
                
                return '<a href="'.$editRoute.'" class="btn btn-sm btn-primary mr-2" title="Edit"><i class="fas fa-edit"></i></a>
                <button data-id="'.$query->id.'" data-route="'.$deleteRoute.'" class="btn btn-sm btn-danger delete-category" title="Delete"><i class="fas fa-trash"></i></button>';

            })->rawColumns(['action','icon','status']);
    }


    /**
     * Get the query source for the dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Define the HTML attributes for the dataTable.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('category-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0)
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
     * Get the column definitions for the dataTable.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id')->addClass('text-center'),
            Column::make('name')->addClass('text-center'),
            Column::make('icon')->addClass('text-center'),
            Column::make('status')->addClass('text-center'),
            Column::make('created_at')->addClass('text-center'),
            Column::make('updated_at')->addClass('text-center'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(80)
                  ->addClass('text-center'),
            
          
           
        ];
    }

    /**
     * Get the filename for exported files.
     */
    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
    }
}