@extends('layouts.app')

@section('title', 'Il tuo Carrello')

@section('styles')
    <link rel="stylesheet" href="{{ url('style_home.css') }}">
    <link rel="stylesheet" href="{{ url('style_cart.css') }}">
@endsection

@section('scripts')
    <script>
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const LOAD_CART_URL = '{{ url("api/cart/load") }}';
        const ADD_CART_URL = '{{ url("api/cart/add") }}';
        const REMOVE_CART_URL = '{{ url("api/cart/remove") }}';
        const DELETE_CART_URL = '{{ url("api/cart/delete") }}';
        const ORDER_URL = '{{ url("api/cart/order") }}';
        const PAY_URL = '{{ url("api/cart/pay") }}';
    </script>
    <script src="{{ url('script_cart.js') }}" defer></script>
@endsection

@section('content')
    <div class="contenitore-carrello">
        <h1 class="titolo-carrello">IL TUO CARRELLO</h1>

        <div class="layout-carrello">
            <section class="lista-prodotti"></section>

            <div class="riepilogo-ordine">
                <h2>RIEPILOGO</h2>
                
                <div class="riga-totale">
                    <span>Totale:</span>
                    <span class="cifra-totale">00.00€</span>
                </div>

                <form id="form-pagamento">
                    @csrf
                    <input type="submit" class="bottone-paga" value="CONFERMA ORDINE E PAGA">
                </form>
                
            </div>
        </div>
    </div>
@endsection