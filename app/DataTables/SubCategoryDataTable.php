<?php

namespace App\DataTables;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubCategoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        
        ->addColumn('status', function($query) {

            $toggleStatusRoute = route('admin.subcategory.status', $query->id);
        
            $checked = $query->status ? 'checked' : '';
            return '<div class="form-check form-switch form-switch-right form-switch-md">
                <input type="checkbox" class="form-check-input code-switcher status-subcategory" id="customSwitch'.$query->id.'" data-id="'.$query->id.'" data-route="'.$toggleStatusRoute.'" '.$checked.'>
            </div>';
        })
     
        ->addColumn('action', function($query) {
            $editRoute = route('admin.subcategory.edit', $query->id);
            $deleteRoute = route('admin.subcategory.destroy', $query->id);
            
            return '<a href="'.$editRoute.'" class="btn btn-sm btn-primary mr-2" title="Edit"><i class="fas fa-edit"></i></a>
            <button data-id="'.$query->id.'" data-route="'.$deleteRoute.'" class="btn btn-sm btn-danger delete-sub" title="Delete"><i class="fas fa-trash"></i></button>';

        })->rawColumns(['action','icon','status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SubCategory $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('subcategory-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
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
            
            Column::make('id')->addClass('text-center'),
            Column::make('name')->addClass('text-center'),
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
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SubCategory_' . date('YmdHis');
    }
}
