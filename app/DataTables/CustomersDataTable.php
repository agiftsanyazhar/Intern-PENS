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
            ->editColumn('company_address', function ($query) {
                $companyAddress = $query->company_address;
                if (strlen($companyAddress) > 25) {
                    $tooltipCompanyAddress = $companyAddress;
                    $companyAddress = substr($companyAddress, 0, 25) . '...';
                    return '<span title="' . $tooltipCompanyAddress . '" style="color: #3a57e8;">' . $companyAddress . '</span>';
                }
                return $companyAddress;
            })
            ->editColumn('description', function ($query) {
                $description = $query->description ?? '-';
                if (strlen($description) > 25) {
                    $tooltipDescription = $description;
                    $description = substr($description, 0, 25) . '...';
                    return '<span title="' . $tooltipDescription . '" style="color: #3a57e8;">' . $description . '</span>';
                }
                return $description;
            })
            ->addColumn('action', 'customers.action')
            ->rawColumns(['action', 'company_address', 'description']);
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
