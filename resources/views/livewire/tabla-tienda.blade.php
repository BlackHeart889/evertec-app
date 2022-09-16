<div>
    @if(count($orders) > 0)
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Estado de Orden</th>
                    <th scope="col">Estado de Pago</th>
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
                        <td>{{$order->payment_orders_status}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$orders->links()}}
    @else
        <div class="container">
            <div class="d-flex justify-content-center">
                <h1>No hay ordenes en la tienda.</h1>
            </div>
        </div>
    @endif
   
</div>
