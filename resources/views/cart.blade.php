@extends('layouts.app')

@section('content')
    <div class="container">
        @if(empty($cart))
            <h1 class="text-center mt-5">Ваша корзина пуста</h1>
        @else
            <h1 class="text-center mt-5">Корзина</h1>
            <div class="row mb-4">
                <div class="col-12 col-lg-8">
                    @php
                        $totalPrice = 0;
                        $discountableCount = 0;
                        $pointsForEach = 0;
                        $onlyUndiscounted = 0;
                        $onlyDiscounted = 0;
                    @endphp
                    @foreach($cart as $product)
                        @if ($product['discountable'] === 1)
                            @php
                                $discountableCount = $discountableCount + (1 * $product['quantity']);
                                $totalPrice = $totalPrice + ($product['price'] * $product['quantity']);
                            @endphp
                        @else
                            @php
                                $onlyUndiscounted = $onlyUndiscounted + ($product['price'] * $product['quantity']);
                                $totalPrice = $totalPrice + ($product['price'] * $product['quantity']);
                            @endphp
                        @endif
                    @endforeach
                    @php
                    if ($discountableCount > 0){$pointsForEach = floor($points / $discountableCount);}
                    @endphp
                    @foreach($cart as $product)
                        @if ($product['discountable'] === 1)
                            @php
                                $onlyDiscounted = $onlyDiscounted + (($product['price'] - $pointsForEach) * $product['quantity']);
                            @endphp
                        @endif
                    @endforeach
                    @foreach($cart as $product)

                        @if ($product['discountable'] === 1)
                            <article class="card mt-4 overflow-hidden border-primary">
                                @else
                                    <article class="card mt-4 overflow-hidden">
                                        @endif
                                        <div class="row">
                                            <div class="col-12 col-sm-4">
                                                <div class="img-wrap">
                                                    <img class="w-100" src="{{ $product['image_path'] }}"
                                                         alt="Изображение товара">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-8 d-flex align-items-center">
                                                <div class="p-3">
                                                    <h3 class="fs-6 mb-2">
                                                        {{ $product['name'] }}
                                                    </h3>
                                                    <p>Кол-во - {{ $product['quantity'] }} шт.</p>
                                                    <p class="fw-bold fs-6 m-0">
                                                        цена без скидки - {{ $product['price'] }} ₽ / шт.
                                                    </p>
                                                    @if ($product['discountable'] === 1)
                                                        @php
                                                            $discountPercentage = (($product['price'] - ($product['price'] - $pointsForEach)) / $product['price']) * 100;
                                                            if ($discountPercentage < 1){
                                                                $discountPercentage = round($discountPercentage, 2);
                                                            }
                                                            else $discountPercentage = ceil($discountPercentage)
                                                        @endphp
                                                        <p class="fw-bold fs-6 m-0">
                                                            с учётом скидки <span>{{ round($discountPercentage, 2) }}%</span> - ₽ / шт.
                                                        </p>
                                                    @else
                                                        <p class="fw-bold fs-6 m-0">
                                                            На данный товар скидка не распространяется
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                            @endforeach
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card p-3 mt-4">
                        <p class="fs-4">Общая сумма заказа:</p>
                        <p class="fw-bold">{{ $totalPrice }} ₽</p>
                        @if ($discountableCount > 0)
                            @php
                                $totalDiscountPercentage = (($totalPrice - ($onlyDiscounted + $onlyUndiscounted)) / $totalPrice) * 100;
                            @endphp
                            <p class="fs-4">Общая сумма заказа c учётом скидки <span>{{ ceil($totalDiscountPercentage) }}%</span>:</p>
                            <p class="fw-bold">{{ $onlyDiscounted + $onlyUndiscounted }} ₽</p>
                        @endif
                        <button class="btn btn-primary">Заказать</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
