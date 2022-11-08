<?php

namespace App\DataTables;

use App\Models\Device;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DevicesDataTable extends DataTable
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
        ->addColumn('action', function(Device $device){
            return view('dashboard.Devices.action',compact('device'))->render();
        })
        ->addcolumn('name', function(Device $device){
            return $device->name ;
        })
        ->addcolumn('description', function(Device $device){
            return $device->description ;
        })
        ->addcolumn('is_active', function(Device $device){
            return  view('dashboard.components.status-btn',['model'=>$device,'url'=>route('devices.changeStatus')]);
    })->rawColumns(['action','is_active']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DevicesDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Device $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('devicesdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('name'),
            Column::make('description'),
            Column::make('is_active'),
            Column::make('created_at'),
            Column::computed('action')
                  ->width(60)
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
        return 'Devices_' . date('YmdHis');
    }
}
