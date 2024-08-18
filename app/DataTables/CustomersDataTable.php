<?php

namespace App\DataTables;

use App\Models\Customer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CustomersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('description', function ($query) {
                return $query->description ?? '-';
            })
            ->editColumn('created_at', function ($query) {
                return date('Y/m/d h.i', strtotime($query->created_at));
            })
            ->addColumn('action', 'customers.action')
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Customer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Customer::query();
        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('dataTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"row align-items-center"<"col-md-2" l><"col-md-6" B><"col-md-4"f>><"table-responsive my-3" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">')
            ->parameters([
                "processing" => true,
                "autoWidth" => false,
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
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['data' => 'company_name', 'name' => 'company_name', 'title' => 'Company Name'],
            ['data' => 'company_address', 'name' => 'company_address', 'title' => 'Company Address'],
            ['data' => 'company_email', 'name' => 'company_email', 'title' => 'Company Email'],
            ['data' => 'company_phone', 'name' => 'company_phone', 'title' => 'Company Phone'],
            ['data' => 'company_pic_name', 'name' => 'company_pic_name', 'title' => 'Company PIC Name'],
            ['data' => 'company_pic_phone', 'name' => 'company_pic_phone', 'title' => 'Company PIC Phone'],
            ['data' => 'description', 'name' => 'description', 'title' => 'Description'],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search'),
        ];
    }
}