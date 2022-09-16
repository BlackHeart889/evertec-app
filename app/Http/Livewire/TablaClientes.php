<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

//Models
use App\Models\Order;
use App\Models\PaymentOrder;
use Dnetix\Redirection\PlacetoPay;


class TablaClientes extends Component
{
    /**
     * CREATED
     * PAYED
     * REJECTED
     */
    use WithPagination;

    public function mount(){
        $user = Auth::user();
        $this->nombre = $user->name;
        $this->email = $user->email;
        $this->celular = $user->mobile;
    }
    public function render()
    {
        $orders = DB::table('orders')
                        ->join('users', 'users.id', '=', 'orders.customer_id')
                        ->join('payment_orders', 'payment_orders.order_id', '=', 'orders.id')
                        ->select('users.name', 'users.email', 'users.mobile', 'orders.*', 'payment_orders.status as payment_orders_status')
                        ->where('orders.customer_id', '=', Auth::user()->id)
                        ->paginate(10);
        return view('livewire.tabla-clientes', ['orders' => $orders]);
    }

    public function comprar($id = null){
        $pasarela = new PlacetoPay([
            'login' => env('PCT_LOGIN'), // Provided by PlacetoPay
            'tranKey' => env('PCT_SECRET_KEY'), // Provided by PlacetoPay
            'baseUrl' => env('PCT_BASE_URL'),
        ]);

        try {
            DB::beginTransaction();
            $order = Order::find($id);
            if(!isset($order)){
                $order = Order::create([
                    'customer_id' => Auth::user()->id,
                    'status' => 'CREATED',
                ]);
            }else{
                $order = Order::find($id);
                $order->status = 'CREATED';
                $order->save();
            }
            
            $reference = $order->id;
            $request = [
                'payment' => [
                    'reference' => $reference,
                    'description' => 'Testing payment',
                    'amount' => [
                        'currency' => 'COP',
                        'total' => 1500,
                    ],
                ],
                'expiration' => date('c', strtotime('+2 days')),
                'returnUrl' => 'http://localhost:8000/verify-payment/' . $reference,
                'ipAddress' => '127.0.0.1',
                'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
            ];
            $response = $pasarela->request($request);
            if ($response->isSuccessful()) {
                $paymentOrder = PaymentOrder::where('order_id', $order->id)->first();
                if(!isset($paymentOrder)){
                    PaymentOrder::create([
                        'order_id' => $order->id,
                        'request_id' => $response->requestId(),
                        'process_url' => $response->processUrl(),
                    ]);
                } else{
                    $paymentOrder->request_id = $response->requestId();
                    $paymentOrder->process_url = $response->processUrl();
                    $paymentOrder->status = null;
                    $paymentOrder->save();
                }

                DB::commit();
                // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
                // Redirect the client to the processUrl or display it on the JS extension
                return redirect()->away($response->processUrl());
            } else {
                DB::rollBack();
                // There was some error so check the message and log it
                $response->status()->message();
            }
        } catch (\Throwable $th) {
            report($th);
            DB::rollBack();
            return redirect()->route('dashboard');
        }
    }

    public function verificarPago($id){
        return redirect()->route('verify-payment', $id);
    }

    public function pagar($id){
        $paymentOrder = PaymentOrder::where('order_id', $id)->first();
        if(isset($paymentOrder)){
            return redirect()->away($paymentOrder->process_url);
        }
    }

    public function modificarPerfil(){
        return redirect()->route('profile.show');
    }
}
