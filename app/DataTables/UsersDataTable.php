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
            ->editColumn('role_id', function ($query) {
                $roleBadge = 'secondary';
                switch ($query->role_id) {
                    case '1':
                        $roleBadge = 'primary';
                        $roleName = $query->role->title;
                        break;
                    case '2':
                        $roleBadge = 'success';
                        $roleName = $query->role->title;
                        break;
                    case '3':
                        $roleBadge = 'info';
                        $roleName = $query->role->title;
                        break;
                    case '4':
                        $roleBadge = 'gray';
                        $roleName = $query->role->title;
                        break;
                }
                return '<span class="badge bg-' . $roleBadge . '">' . $roleName . '</span>';
            })
            ->editColumn('note', function ($query) {
                $note = $query->note ?? '-';
                if (strlen($note) > 25) {
                    $tooltipNote = $note;
                    $note = substr($note, 0, 25) . '...';
                    return '<span title="' . $tooltipNote . '" style="color: #3a57e8;">' . $note . '</span>';
                }
                return $note;
            })
            ->addColumn('action', 'users.action')
            ->rawColumns(['action', 'role_id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = User::query();
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
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'phone', 'name' => 'phone', 'title' => 'Phone'],
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
