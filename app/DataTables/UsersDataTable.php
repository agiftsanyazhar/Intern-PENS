<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->editColumn('name', function ($user) {
                return $user->name .
                    '<br><small>' . $user->email . '</small>' .
                    '<br><small>' . $user->phone . '</small>';
            })
            ->editColumn('role_id', function ($user) {
                $role = $user->role->title;
                $roleBadge = match ($role) {
                    'Admin' => 'primary',
                    'Division Head' => 'success',
                    'Sales Head' => 'info',
                    'Sales' => 'gray',
                };

                return '<span class="badge bg-' . $roleBadge . '">' . $role . '</span>';
            })
            ->editColumn('note', function ($user) {
                $note = $user->note ?? '-';
                if (strlen($note) > 25) {
                    $tooltipNote = $note;
                    $note = substr($note, 0, 25) . '...';
                    return '<span title="' . $tooltipNote . '" style="color: #3a57e8;">' . $note . '</span>';
                }
                return $note;
            })
            ->addColumn('action', 'users.action')
            ->rawColumns(['action', 'name', 'role_id', 'note']);
    }

    public function query(User $user)
    {
        return $this->applyScopes($user->newQuery());
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
    protected function getColumns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email', 'visible' => false],
            ['data' => 'role_id', 'name' => 'role_id', 'title' => 'Role'],
            ['data' => 'note', 'name' => 'note', 'title' => 'Note'],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search'),
        ];
    }
}
