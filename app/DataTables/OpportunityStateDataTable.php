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
            ->editColumn('customer_id', function ($query) {
                return $query->customer ? $query->customer->company_name : '-';
            })
            ->editColumn('health_id', function ($query) {
                $statusBadge = 'secondary';
                switch ($query->health_id) {
                    case '1':
                        $statusBadge = 'success';
                        $statusName = $query->health->status_health;
                        break;
                    case '2':
                        $statusBadge = 'warning';
                        $statusName = $query->health->status_health;
                        break;
                    case '3':
                        $statusBadge = 'danger';
                        $statusName = $query->health->status_health;
                        break;
                    case '4':
                        $statusBadge = 'dark';
                        $statusName = $query->health->status_health;
                        break;
                }
                return '<span class="badge bg-' . $statusBadge . '">' . $statusName . '</span>';
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
                return $query->createdByUser ? $query->createdByUser->name . '<br><small>' . date('Y/m/d H:i', strtotime($query->created_at)) . '</small>' : '-';
            })
            ->editColumn('updated_by', function ($query) {
                return $query->updatedByUser ? $query->updatedByUser->name . '<br><small>' . date('Y/m/d H:i', strtotime($query->updated_at)) . '</small>' : '-';
            })
            // ->editColumn('deleted_by', function ($query) {
            //     return $query->deletedByUser ? $query->deletedByUser->name . '<br><small>' . ($query->deleted_at ? date('Y/m/d H:i', strtotime($query->deleted_at)) : '-') . '</small>' : '-';
            // })
            ->addColumn('action', 'opportunity-state.action')
            ->rawColumns(['action', 'health_id', 'title', 'description', 'created_by', 'updated_by', 'deleted_by']);
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
            ['data' => 'customer_id', 'name' => 'customer_id', 'title' => 'Customer Name'],
            ['data' => 'health_id', 'name' => 'health_id', 'title' => 'Status Health'],
            ['data' => 'opportunity_status_id', 'name' => 'opportunity_status_id', 'title' => 'Opportunity Status'],
            ['data' => 'opportunity_value', 'name' => 'opportunity_value', 'title' => 'Opportunity Value'],
            ['data' => 'title', 'name' => 'title', 'title' => 'Title'],
            ['data' => 'description', 'name' => 'description', 'title' => 'Description'],
            ['data' => 'created_by', 'name' => 'created_by', 'title' => 'Created By'],
            ['data' => 'updated_by', 'name' => 'updated_by', 'title' => 'Updated By'],
            // ['data' => 'deleted_by', 'name' => 'deleted_by', 'title' => 'Deleted By'],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search'),
        ];
    }
}
