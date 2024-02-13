@extends('layouts.app')

@section('content')
        <div class="container">

            <div class="row">
                @foreach ($products as $product)
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        @if ($product->discountable === 1)
                        <article class="card mt-5 overflow-hidden border-primary">
                        @else
                        <article class="card mt-5 overflow-hidden">
                        @endif
                            <div class="img-wrap">
                                <img class="w-100" src="{{ asset($product->image_path) }}" alt="Изображение товара">
                            </div>
                            <div class="p-3">
                                <h3 class="fs-6 mb-3">{{ $product->name }}</h3>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="fw-bold fs-5 m-0">{{ $product->price }} ₽</p>
                                    @if(isset($session[$username][$product->id]['quantity']) && $session[$username][$product->id]['quantity'] > 0)
                                        <div class="d-flex align-items-center gap-3">
                                            <form action="{{ route('decrease.quantity', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary">-</button>
                                            </form>
                                            <span>{{ $session[$username][$product->id]['quantity'] }}</span>
                                            <form action="{{ route('increase.quantity', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary">+</button>
                                            </form>
                                        </div>
                                    @else
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">В корзину</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <nav aria-label="Page navigation">
                <ul class="pagination my-5 d-flex justify-content-center">
                    {{-- Кнопка "Предыдущая страница" --}}
                    @if ($products->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link" aria-hidden="true">«</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                            </a>
                        </li>
                    @endif

                    {{-- Ссылки на страницы --}}
                    @for ($i = 1; $i <= ceil($products->total() / $products->perPage()); $i++)
                        <li class="page-item"><a class="page-link" href="?page={{ $i }}">{{ $i }}</a></li>
                    @endfor

                    {{-- Кнопка "Следующая страница" --}}
                    @if ($products->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">»</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link" aria-hidden="true">»</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
@endsection
