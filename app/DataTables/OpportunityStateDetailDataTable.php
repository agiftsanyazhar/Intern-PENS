<?php

namespace App\DataTables;

use App\Models\OpportunityStateDetail;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OpportunityStateDetailDataTable extends DataTable
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
            ->editColumn('opportunity_status_id', function ($opportunityStateDetail) {
                return getOpportunityStatus($opportunityStateDetail->opportunity_status_id);
            })
            ->editColumn('description', function ($opportunityStateDetail) {
                $description = $opportunityStateDetail->description ?? '-';
                if (strlen($description) > 25) {
                    $tooltipDescription = $description;
                    $description = substr($description, 0, 25) . '...';
                    return '<span title="' . $tooltipDescription . '" style="color: #3a57e8;">' . $description . '</span>';
                }
                return $description;
            })
            ->editColumn('created_by', fn($opportunityStateDetail) => $opportunityStateDetail->createdByUser ? $opportunityStateDetail->createdByUser->name . '<br><small>' . date('Y/m/d H:i', strtotime($opportunityStateDetail->created_at)) . '</small>' : '-')
            ->addColumn('action', 'opportunity-state.opportunity-state-detail.action')
            ->rawColumns(['action', 'description', 'created_by']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\OpportunityStateDetail $opportunityStateDetail
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OpportunityStateDetail $opportunityStateDetail)
    {
        return $this->applyScopes(
            $opportunityStateDetail->newQuery()
                ->with('createdByUser')
                ->where('opportunity_state_id', $this->id)
        );
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
            ['data' => 'opportunity_status_id', 'name' => 'opportunity_status_id', 'title' => 'Opportunity Status'],
            ['data' => 'description', 'name' => 'description', 'title' => 'Description'],
            ['data' => 'created_by', 'name' => 'createdByUser.name', 'title' => 'Created By'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At', 'visible' => false],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search'),
        ];
    }
}
