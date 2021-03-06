<?php

namespace App\DataTables;

//use App\MyBid;
use App\Model\WarehouseAdBid;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;
use Auth;
use App\User;

class MyBidDataTable extends DataTable
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
            ->editColumn('warehouse_ad_id', function($id){
                return Helper::warehouseadIdToTitle($id->warehouse_ad_id);
            })
            ->escapeColumns([])
            ->addColumn('action', 'mybid.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\MyBid $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WarehouseAdBid $model)
    {
        if(Auth::user()->type == 'super_admin')
        {
            return $model->newQuery();
        }
        if(Auth::user()->type == 'tenant')
        {
            $model = WarehouseAdBid::where('tenant_id',Auth::user()->id);
            return $model->newQuery();            
        }

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('mybid-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('warehouse_ad_id'),
            Column::make('bid_amount'),
            Column::make('status'),
            Column::make('created_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'MyBid_' . date('YmdHis');
    }
}
