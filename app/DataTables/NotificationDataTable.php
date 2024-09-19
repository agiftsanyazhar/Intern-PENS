<?php

namespace App\DataTables;

use App\Helpers\AuthHelper;
use App\Models\Notification;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NotificationDataTable extends DataTable
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
            ->editColumn('opportunity_state_id', function ($notification) {
                $date = '';
                if ($notification->created_at->format('Y-m-d') == now()->format('Y-m-d')) {
                    $date = $notification->created_at->diffForHumans();
                } elseif ($notification->created_at->diffInDays(now()) < 7) {
                    $date = $notification->created_at->format('l');
                } else {
                    $date = $notification->created_at->format('Y/m/d');
                }

                $title =  $notification->opportunityState->title;
                $is_read = $notification->is_read;
                $readBadge = match ($is_read) {
                    0 => 'danger',
                    default => '',
                };

                $span = '<span class="badge bg-' . $readBadge . ' ms-2">Unread</span>';

                return '<small class="mb-1">' . $date . '</small><br>' . $title . $span;
            })
            ->editColumn('health_id', function ($notification) {
                return getOpportunityHealthBadge($notification->opportunityState->health_id);
            })
            ->editColumn('opportunity_status_id', function ($notification) {
                return getOpportunityStatus($notification->opportunityState->opportunityStateDetail->last()->opportunity_status_id);
            })
            ->editColumn('sender_id', function ($notification) {
                return $notification->sender->name;
            })
            ->editColumn('description', function ($notification) {
                $description = $notification->opportunityState->opportunityStateDetail->last()->description ?? '-';
                $url = route('opportunity-state.show', $notification->opportunity_state_id);

                if (strlen($description) > 25) {
                    $tooltipDescription = $description;
                    $description = substr($description, 0, 25) . '...';
                    return '<a href="' . $url . '" onclick="event.preventDefault(); document.getElementById(\'read-notification-' . $notification->id . '\').submit();" title="' . $tooltipDescription . '">' . $description . '</a>
                <form action="' . route('notification.mark-as-read', $notification->id) . '" method="post" id="read-notification-' . $notification->id . '" style="display: none;">
                    ' . csrf_field() . '
                    ' . method_field('PUT') . '
                </form>';
                }

                return '<a href="' . $url . '" onclick="event.preventDefault(); document.getElementById(\'read-notification-' . $notification->id . '\').submit();">' . $description . '</a>
            <form action="' . route('notification.mark-as-read', $notification->id) . '" method="post" id="read-notification-' . $notification->id . '" style="display: none;">
                ' . csrf_field() . '
                ' . method_field('PUT') . '
            </form>';
            })
            ->rawColumns(['health_id', 'opportunity_state_id', 'opportunity_status_id', 'description']);
    }

    public function query(Notification $notification)
    {
        return $this->applyScopes(
            $notification->newQuery()
                ->with('opportunityState', 'opportunityState.health', 'sender', 'opportunityState.opportunityStateDetail')
                ->where('receiver_id', AuthHelper::authSession()->id)
                ->orderBy('is_read', 'asc')
                ->orderBy('created_at', 'desc')
        );
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
            ->dom('<"row align-items-center"<"col-md-6" l><"col-md-6"f>><"row my-3"<"col-md-12"B>><"table-responsive" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">')
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
    protected function getColumns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['data' => 'opportunity_state_id', 'name' => 'opportunityState.title', 'title' => 'Opportunity Name'],
            ['data' => 'health_id', 'name' => 'opportunityState.health.status_health', 'title' => 'Health'],
            ['data' => 'opportunity_status_id', 'name' => 'opportunityState.opportunityStateDetail.opportunity_status_id', 'title' => 'Opportunity Status'],
            ['data' => 'sender_id', 'name' => 'sender.name', 'title' => 'From'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Date', 'visible' => false],
            ['data' => 'description', 'name' => 'opportunityState.opportunityStateDetail.description', 'title' => 'Description'],
        ];
    }
}
