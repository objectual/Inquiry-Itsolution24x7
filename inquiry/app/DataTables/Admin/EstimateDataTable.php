<?php

namespace App\DataTables\Admin;

use App\Models\Estimate;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

/**
 * Class EstimateDataTable
 * @package App\DataTables\Admin
 */
class EstimateDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $dataTable->editColumn('currency_id', function ($estimate) {
            return ($estimate->currency_id == 0) ? 'Pkr' : 'DOLLAR';
        });
        $dataTable->editColumn('customer_id', function ($estimate) {
            return $estimate->customer->name;
        });
        $dataTable->editColumn('date', function ($estimate) {
            return date('d-m-Y', strtotime($estimate->date));
        });
        $dataTable->editColumn('expiry', function ($estimate) {
            return date('d-m-Y', strtotime($estimate->expiry));
        });
        $dataTable->rawColumns(['action', 'currency_id','customer_id','date','expiry']);
        return $dataTable->addColumn('action', 'admin.estimates.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Estimate $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Estimate $model)
    {
        return $model->newQuery()->orderBy('updated_at', SORT_DESC);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [];
        if (\Entrust::can('estimates.create') || \Entrust::hasRole('super-admin')) {
            $buttons = ['create'];
        }
        $buttons = array_merge($buttons, [
            'export',
            'print',
            'reset',
            'reload',
        ]);
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'printable' => false])
            ->parameters([
                'dom'     => 'Bfrtip',
                'order'   => [[0, 'desc']],
                'buttons' => $buttons,
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'customer_id' => [
                'title' => 'Customer'
            ],
            'currency_id' => [
                'title' => 'Currency'
            ],
            'date',
            'expiry',
            'subheading',
            'footer',
            'memo'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'estimatesdatatable_' . time();
    }
}