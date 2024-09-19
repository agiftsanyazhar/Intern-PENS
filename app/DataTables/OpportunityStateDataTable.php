<?php

namespace App\DataTables;

use App\Models\OpportunityState;
use App\Models\User;
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
            ->editColumn('customer_id', function ($opportunityState) {
                return $opportunityState->customer->company_name;
            })
            ->editColumn('health_id', function ($opportunityState) {
                return getOpportunityHealthBadge($opportunityState->health_id);
            })
            ->editColumn('opportunity_status_id', function ($opportunityStateDetail) {
                return getOpportunityStatus($opportunityStateDetail->opportunity_status_id);
            })
            ->editColumn('opportunity_value', fn($opportunityState) => 'Rp' . number_format($opportunityState->opportunity_value, 0, ',', '.'))
            ->editColumn('created_by', fn($opportunityState) => $opportunityState->createdByUser ? $opportunityState->createdByUser->name . '<br><small>' . date('Y/m/d H:i', strtotime($opportunityState->created_at)) . '</small>' : '-')
            ->editColumn('updated_by', fn($opportunityState) => $opportunityState->updatedByUser ? $opportunityState->updatedByUser->name . '<br><small>' . date('Y/m/d H:i', strtotime($opportunityState->updated_at)) . '</small>' : '-')
            ->addColumn('action', 'opportunity-state.action')
            ->rawColumns(['action', 'health_id', 'created_by', 'updated_by']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\OpportunityState $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OpportunityState $opportunityState)
    {
        return $this->applyScopes(
            $opportunityState->newQuery()
                ->with('customer', 'health', 'createdByUser', 'updatedByUser')
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
            ->dom('<"row align-items-center"<"col-md-6" l><"col-md-6"f>><"row my-3"<"col-md-12"B>><"table-responsive" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">')
            ->buttons(
                [
                    [
                        'text' => 'Reset',
                        'className' => 'btn btn-secondary',
                        'action' => 'function(e, dt, button, config) {
                            dt.columns(3).search("^((?!4|5).)*$", true, false).draw(); // Show all except Completed and Failed
                        }'
                    ],
                    [
                        'text' => 'Completed',
                        'className' => 'btn btn-success',
                        'action' => 'function(e, dt, button, config) {
                            dt.columns(3).search("^4$", true, false).draw(); // Show only Completed
                        }'
                    ],
                    [
                        'text' => 'Failed',
                        'className' => 'btn btn-danger',
                        'action' => 'function(e, dt, button, config) {
                            dt.columns(3).search("^5$", true, false).draw(); // Show only Failed
                        }'
                    ],
                    // [
                    //     'extend' => 'collection',
                    //     'text' => 'Created By',
                    //     'className' => 'btn btn-info dropdown-toggle',
                    //     'buttons' => $this->getCreatedByDropdownOptions() // Fetch dropdown options here
                    // ]
                ]
            )
            ->parameters([
                "processing" => true,
                "autoWidth" => false,
                "initComplete" => 'function() {
                    this.api().columns(3).search("^((?!4|5).)*$", true, false).draw(); // Hide Completed and Failed on load
                }',
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
            ['data' => 'customer_id', 'name' => 'customer.company_name', 'title' => 'Customer Name'],
            ['data' => 'health_id', 'name' => 'health.status_health', 'title' => 'Health Status'],
            ['data' => 'opportunity_status_id', 'name' => 'opportunity_status_id', 'title' => 'Opportunity Status'],
            ['data' => 'opportunity_value', 'name' => 'opportunity_value', 'title' => 'Opportunity Value'],
            ['data' => 'title', 'name' => 'title', 'title' => 'Title'],
            ['data' => 'description', 'name' => 'description', 'title' => 'Description'],
            ['data' => 'created_by', 'name' => 'createdByUser.name', 'title' => 'Created By'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At', 'visible' => false],
            ['data' => 'updated_by', 'name' => 'updatedByUser.name', 'title' => 'Updated By'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated By', 'visible' => false],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search'),
        ];
    }

    protected function getCreatedByDropdownOptions()
    {
        $createdByUsers = User::select('id', 'name')->get();

        $dropdownOptions = [];

        $dropdownOptions[] = [
            'text' => 'All',
            'action' => 'function(e, dt, button, config) {
            dt.columns(7).search("").draw();
        }'
        ];

        foreach ($createdByUsers as $user) {
            $dropdownOptions[] = [
                'text' => $user->name,
                'action' => 'function(e, dt, button, config) {
                dt.columns(7).search("' . $user->name . '").draw();
            }'
            ];
        }

        // Debugging output
        // dd($dropdownOptions); // You can replace this with Log::info($dropdownOptions); to view in the logs

        return $dropdownOptions;
    }
}
