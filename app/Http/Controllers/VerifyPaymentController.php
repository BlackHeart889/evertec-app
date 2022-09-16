<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Models
use App\Models\PaymentOrder;
use App\Models\Order;
use Dnetix\Redirection\PlacetoPay;

class VerifyPaymentController extends Controller
{
    public function result($id){
        $pasarela = new PlacetoPay([
            'login' => env('PCT_LOGIN'), // Provided by PlacetoPay
            'tranKey' => env('PCT_SECRET_KEY'), // Provided by PlacetoPay
            'baseUrl' => env('PCT_BASE_URL'),
        ]);
        $paymentOrder = PaymentOrder::where('order_id', $id)->first();
        $response = $pasarela->query($paymentOrder->request_id);
        $paymentOrder->status = $response->status()->status();
        $order = Order::find($id);

        if($response->isSuccessful()){
            if ($response->status()->isApproved()) {
                // The payment has been payed
                $order->status = 'PAYED';
            }else if ($response->status()->isRejected()) {
                // The payment has been rejected
                $order->status = 'REJECTED';
            }
            try {
                DB::beginTransaction();
                $paymentOrder->save();
                $order->save();
                DB::commit();
                return redirect()->route('dashboard');
            } catch (\Throwable $th) {
                report($th);
                DB::rollBack();
            }
        }
        /*else{
            dd($response->status()->message() . "\n");
        }*/
        return redirect()->route('dashboard');
    }
}
