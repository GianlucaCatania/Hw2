@extends('layouts.app')

@section('title', 'I Prodotti')

@section('styles')
<link rel="stylesheet" href="{{ url('style_home.css') }}">
@endsection

@section('scripts')
    <script src="{{ url('script_home.js') }}" defer></script>
    <script>
        const load_database_url = "{{ url('api/products') }}";
        const macro_api_url = "{{ url('api/macro') }}";
        const add_cart_url = "{{ url('api/cart/add') }}";
    </script>
@endsection

@section('content')
    <div class="main-container">

        <nav class="navigation-menu">
            <a href="#">Home</a>
            <span class="separator"> > </span>
            <span class="current-page">I Prodotti</span>
        </nav>

        <h2 id="products-title">I Prodotti</h2>

        <div class="content-flex">
            <nav class="sidebar">
                <div class="sidebar-menu">
                    <a href="#">Menù</a>
                    <a href="#">Snack</a>
                    <a href="#">Drink</a>
                    <a href="#">Pollo</a>
                    <a href="#">Panini e Twist</a>
                    <a href="#">Box Meal</a>
                    <a href="#">Kids&Family</a>
                    <a href="#">Veggie</a>
                    <a href="#">Insalatone</a>
                    <a href="#">Snack e contorni</a>
                    <a href="#">Dolci</a>
                    <a href="#">Bibite</a>
                    <a href="#">Prezzi Smart</a>
                    <a href="#">Offerte</a>
                </div>
            </nav>

            <article id="article">

                <section class="menu-category first-category" data-category="menu">
                    <h2 class="category-title">Menù</h2>
                </section>
                
                <section class="menu-category" data-category="snack">
                    <h2 class="category-title">Snack</h2>
                </section>

                <section class="menu-category" data-category="drink">
                    <h2 class="category-title">Drink</h2>
                </section>

                <section id="sezione-extra" class="menu-category last-category hidden" data-category="extra">
                    <h2 class="category-title">Varie</h2>
                </section>

                <div id="carica-altre-categorie">
                    <a href="#" id="carica-altri">Carica altri</a>
                </div>

            </article>
        </div>
    </div>

    <section id="modale-risultati" class="hidden"></section>
@endsection