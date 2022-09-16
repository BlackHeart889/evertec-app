<div>
    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <button wire:click='comprar' type="button" class="btn btn-primary">Comprar producto</button>
        </div>         
    </div>
    @if(count($orders) > 0)
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <th scope="row">{{$order->id}}</th>
                        <td>{{$order->name}}</td>
                        <td>{{$order->email}}</td>
                        <td>{{$order->mobile}}</td>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->status}}</td>
                        @if($order->payment_orders_status == null)
                            <td>
                                <button wire:click='pagar({{$order->id}})' type="button" class="btn btn-primary">Pagar</button>
                            </td>
                        @elseif($order->payment_orders_status == 'PENDING')
                            <td>
                                <button wire:click='verificarPago({{$order->id}})' type="button" class="btn btn-info">Verificar</button>
                                <button wire:click='pagar({{$order->id}})' type="button" class="btn btn-primary">Pasarela</button>
                            </td>
                        @elseif($order->status == 'REJECTED')
                            <td>
                                <button wire:click='comprar({{$order->id}})' type="button" class="btn btn-warning">Reintentar pago</button>
                            </td>
                        @else
                            <td>
                                N/A
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$orders->links()}}
    @else
        <div class="container">
            <div class="d-flex justify-content-center">
                <h1>No tiene ordenes.</h1>
            </div>
        </div>
    @endif
   
</div>
