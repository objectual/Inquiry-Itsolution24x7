<?php

namespace App\DataTables\Admin;

use App\Models\Invoice;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

/**
 * Class InvoiceDataTable
 * @package App\DataTables\Admin
 */
class InvoiceDataTable extends DataTable
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
        $dataTable->editColumn('order_id', function ($invoice) {
            return $invoice->order->name;
        });

        $dataTable->editColumn('status', function ($invoice) {
            if ($invoice->status == Invoice::PAID) {
                return 'Paid';
            } elseif ($invoice->status == Invoice::DUE) {
                return 'Due';
            } else {
                return 'Partial ';
            }
        });
        $dataTable->editColumn('from', function ($invoice) {
            return date('d-m-Y', strtotime($invoice->from));
        });
        $dataTable->editColumn('to', function ($invoice) {
            return date('d-m-Y', strtotime($invoice->to));
        });
        return $dataTable->addColumn('action', 'admin.invoices.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Invoice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Invoice $model)
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
        if (\Entrust::can('invoices.create') || \Entrust::hasRole('super-admin')) {
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
            'number'   => [
                'title' => 'Invoice Number'
            ],
            'order_id' => [
                'title' => 'Order'
            ],
            'from',
            'to',
            'status',
            'amount',
//            'description'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'invoicesdatatable_' . time();
    }
}