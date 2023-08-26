<?php

namespace App\DataTables;

use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Storage;

class AdvertisementDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
   
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        // Eager-load images relationship for performance
        $query->with('images');
    
        return (new EloquentDataTable($query))
            ->addColumn('image', function($advertisement) {
                // Using the preloaded images relationship
                $firstImage = $advertisement->images->first();
                $imagePath = $firstImage ? $firstImage->path : 'path/to/default/image.jpg'; // Default image if no image exists
                return '<img src="'. Storage::url($imagePath) .'" alt="Advertisement Image" width="60" height="60">';
            })
            ->addColumn('user.name', function($advertisement) {
                return $advertisement->user ? $advertisement->user->name : '-';
            })
            
            ->addColumn('subcategory.name', function($advertisement) {
                return $advertisement->subcategory ? $advertisement->subcategory->name : '-';
            })
            
            ->addColumn('action', function($advertisement) {
                $editRoute = route('admin.advertisements.edit', $advertisement->id);
                $deleteRoute = route('admin.advertisements.destroy', $advertisement->id);
                
                return '<a href="'.$editRoute.'" class="btn btn-sm btn-primary mr-2" title="Edit"><i class="fas fa-edit"></i></a>
                <button data-id="'.$advertisement->id.'" data-route="'.$deleteRoute.'" class=" delete-adv btn btn-sm btn-danger " title="Delete"><i class="fas fa-trash"></i></button>';
            })
            ->rawColumns(['action', 'image','subcategory.name','user.name']);  // Removed 'status' as it's not added in the columns directly in this method
    }
    

    /**
     * Get the query source of dataTable.
     */
    public function query(Advertisement $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('advertisement-table')
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
            
            Column::make('id')->title('ID')->addClass('text-center'),
            Column::make('title')->title('Title')->addClass('text-center'),
            Column::computed('image')->title('Image')->addClass('text-center'),
            Column::make('description')->title('Description')->width(70)->addClass('text-center'),
            Column::make('price')->title('Price')->addClass('text-center'),
            Column::make('user.name')->title('User')->addClass('text-center'),
            Column::make('subcategory.name')->title('Subcategory')->addClass('text-center'),
            Column::make('updated_at')->title('Updated At')->addClass('text-center'),
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
        return 'Advertisement_' . date('YmdHis');
    }
}
