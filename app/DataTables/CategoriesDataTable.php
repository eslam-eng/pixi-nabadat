<?php

namespace App\DataTables;

use App\Models\Category;
use App\Models\Location;
use App\Services\CategoryService;
use App\Services\LocationService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoriesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function(Category $category){
            return view('dashboard.categories.action',compact('category'))->render();
        })
        ->editColumn('name', function(Category $category){
            return $category->name ;
        })
            ->editColumn('type', function(Category $category){
                return $category->type;
            })
            ->addcolumn('is_active', function(Category $category){
                return  view('dashboard.components.switch-btn',['model'=>$category,'url'=>route('categories.changeStatus')]);
            })->rawColumns(['action','is_active']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\categoriesDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CategoryService $categoryService): QueryBuilder
    {
        return $categoryService->queryGet($this->filters, $this->withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('categoriesdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            
            Column::make('name')
            ->title(trans('lang.name')),

            Column::make('type')
                ->title(trans('lang.type'))
            ->searchable(false)->orderable(false),

            Column::make('created_at')
                ->title(trans('lang.created_at'))
                ->searchable(false)
                ->orderable(false),

            Column::computed('is_active')
                ->title(trans('lang.status'))
                ->searchable(false)
                ->orderable(false),

            Column::computed('action')
                  ->title(trans('lang.action'))
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'categories_' . date('YmdHis');
    }

}
