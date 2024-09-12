<?php

namespace App\DataTables;

use App\Models\Health;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class HealthDataTable extends DataTable
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
            ->editColumn('status_health', function ($health) {
                return getOpportunityHealthBadge($health->id);
            })
            ->addColumn('action', 'health.action')
            ->rawColumns(['action', 'status_health']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Health $healthModel
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Health $health)
    {
        return $this->applyScopes($health->newQuery());
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
            ['data' => 'status_health', 'name' => 'status_health', 'title' => 'Status Health'],
            ['data' => 'day_parameter_value', 'name' => 'day_parameter_value', 'title' => 'Day Parameter Value'],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search'),
        ];
    }
}
