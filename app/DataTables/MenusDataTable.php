<?php

namespace App\DataTables;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MenusDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addIndexColumn()
            ->editColumn('url', function ($menu) {
                return $menu->url ?? '-';
            })
            ->editColumn('parent_id', function ($menu) {
                return $menu->parent_id ? $menu->getParentNameById($menu->parent_id) : '-';
            })
            ->editColumn('is_active', function ($menu) {
                $color = 'red';
                $message = 'Tidak Aktif';
                if ($menu->is_active) $color = 'blue';
                if ($menu->is_active) $message = 'Aktif';
                return '<span class="badge bg-'. $color .' text-'. $color .'-fg">'. $message .'</span>';
            })
            ->addColumn('actions', function ($menu) {
                return view('pages.menu.actions', compact('menu'));
            })
            ->rawColumns(['is_active', 'actions']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Menu $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('menus-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'paging' => true,
                'searching' => true,
                'info' => true,
                'responsive' => true,
                'autoWidth' => false,
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->orderable(false)->searchable(false)->width(50),
            Column::make('name')->title('Nama')->addClass('text-center'),
            Column::make('url')->title('URL')->addClass('text-center'),
            Column::make('order')->title('Urutan')->addClass('text-center'),
            Column::make('parent_id')->title('Parent')->addClass('text-center'),
            Column::make('is_active')->title('Status')->addClass('text-center'),
            Column::computed('actions')->title('')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Menus_' . date('YmdHis');
    }
}
