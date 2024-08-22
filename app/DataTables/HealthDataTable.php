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
            ->editColumn('status_health', function ($query) {
                return $query->health ? $query->health->status_health : '-';
            })
            ->editColumn('created_by', function ($query) {
                return $query->createdByUser ? $query->createdByUser->name : '-';
            })
            ->editColumn('updated_by', function ($query) {
                return $query->updatedByUser ? $query->updatedByUser->name : '-';
            })
            ->editColumn('deleted_by', function ($query) {
                return $query->deletedByUser ? $query->deletedByUser->name : '-';
            })
            ->editColumn('created_at', function ($query) {
                return date('Y/m/d H:i', strtotime($query->created_at));
            })
            ->editColumn('updated_at', function ($query) {
                return date('Y/m/d H:i', strtotime($query->updated_at));
            })
            ->editColumn('deleted_at', function ($query) {
                return $query->deleted_at ? date('Y/m/d H:i', strtotime($query->deleted_at)) : '-';
            })
            ->addColumn('action', 'health.action')
            ->rawColumns(['action', 'status_health']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Health $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Health::query();
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
            ['data' => 'status_health', 'name' => 'status_health', 'title' => 'Status Health'],
            ['data' => 'level_health', 'name' => 'level_health', 'title' => 'Level Health'],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search'),
        ];
    }
}
