<?php

namespace App\DataTables;

use App\Models\OpportunityState;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OpportunityStateDataTable extends DataTable
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
            ->editColumn('company_name', function ($query) {
                return $query->customer ? $query->customer->company_name : '-';
            })
            ->editColumn('opportunity_status_id', function ($query) {
                switch ($query->opportunity_status_id) {
                    case 1:
                        return 'Inquiry';
                    case 2:
                        return 'Follow Up';
                    case 3:
                        return 'Stale';
                    case 4:
                        return 'Completed';
                    case 5:
                        return 'Failed';
                    default:
                        return '-';
                }
                return $query->opportunity_status_id ? $query->customer->company_name : '-';
            })
            ->editColumn('opportunity_value', function ($query) {
                return 'Rp' . number_format($query->opportunity_value, 0, ',', '.');
            })
            ->editColumn('title', function ($query) {
                $title = $query->title;
                if (strlen($title) > 10) {
                    $tooltipTitle = $title;
                    $title = substr($title, 0, 10) . '...';
                    return '<span title="' . $tooltipTitle . '" style="color: #3a57e8;">' . $title . '</span>';
                }
                return $title;
            })
            ->editColumn('description', function ($query) {
                $description = $query->description;
                if (strlen($description) > 25) {
                    $tooltipDescription = $description;
                    $description = substr($description, 0, 25) . '...';
                    return '<span title="' . $tooltipDescription . '" style="color: #3a57e8;">' . $description . '</span>';
                }
                return $description;
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
                return date('Y/m/d h.i', strtotime($query->created_at));
            })
            ->editColumn('updated_at', function ($query) {
                return date('Y/m/d h.i', strtotime($query->updated_at));
            })

            ->addColumn('action', 'opportunity-state.action')
            ->rawColumns(['action', 'title', 'description']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\OpportunityState $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return OpportunityState::query();
    }

    /**
     * Optional method if you want to use HTML builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('opportunityStateTable')
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
            ['data' => 'company_name', 'name' => 'company.name', 'title' => 'Customer Name'],
            ['data' => 'opportunity_status_id', 'name' => 'opportunity_status_id', 'title' => 'Opportunity Status Name'],
            ['data' => 'opportunity_value', 'name' => 'opportunity_value', 'title' => 'Opportunity Value'],
            ['data' => 'title', 'name' => 'title', 'title' => 'Title'],
            ['data' => 'description', 'name' => 'description', 'title' => 'Description'],
            ['data' => 'created_by', 'name' => 'user.name', 'title' => 'Created By'],
            ['data' => 'updated_by', 'name' => 'user.name', 'title' => 'Updated By'],
            ['data' => 'deleted_by', 'name' => 'user.name', 'title' => 'Deleted By'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated At'],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search'),
        ];
    }
}
