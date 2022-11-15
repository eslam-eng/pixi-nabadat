<?php

namespace App\DataTables;

use App\Models\Center;
use App\Services\CenterService;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CentresDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn(
                'action', function (Center $center) {
                return view('dashboard.centers.action', compact('center'))->render();
            })
            ->addcolumn('name', function (Center $center) {
                return $center->name;
            })
            ->addcolumn('address', function (Center $center) {
                return $center->address;
            })
            ->addcolumn('location', function (Center $center) {
                return $center->location->title;
            })
            ->addcolumn('is_active', function (Center $center) {
                return  view('dashboard.components.switch-btn',['model'=>$center,'url'=>route('centers.changeStatus')]);
            })->rawColumns(['action','is_active']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param CenterService $locationService
     */
    public function query(CenterService $centerService)
    {
        return $centerService->queryGet($this->filters, $this->withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'dom' => 'Blfrtip',
                'order' => [[0, 'desc']],
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                'responsive' => true,
                "bSort" => false
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('address'),
            Column::make('phone'),
            Column::make('location'),
            Column::make('is_active'),
            Column::computed('action')
                ->width(60)
                ->addClass('text-center'),
        ];
    }

}
