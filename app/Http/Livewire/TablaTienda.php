<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


class TablaTienda extends Component
{
    use WithPagination;

    public function render()
    {
        $orders = DB::table('orders')
                ->join('users', 'users.id', '=', 'orders.customer_id')
                ->join('payment_orders', 'payment_orders.order_id', '=', 'orders.id')
                ->select('users.name', 'users.email', 'users.mobile', 'orders.*', 'payment_orders.status as payment_orders_status')
                ->paginate(10);

        return view('livewire.tabla-tienda', ['orders' => $orders]);
    }
}
