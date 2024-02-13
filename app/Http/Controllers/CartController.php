<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function showCart(Request $request)
    {
//                $request->session()->forget('cart');
        $user = Auth::user();
        $username = $user->name;
        $carts = $request->session()->get('cart', []);
        $points = $user->points;

        if (isset($carts[$username])) {
            $productIds = array_keys($carts[$username]);
        }

        if (empty($productIds)) {
            $userCart = [];
        } else {
            $userCart = Product::whereIn('id', $productIds)->get()->toArray();

            foreach ($userCart as &$product) {
                $productId = $product['id'];
                $product['quantity'] = $carts[$username][$productId]['quantity'];
            }
        }
//        dd($request->session()->all());
//        dd($points);
        return view('cart', ['cart' => $userCart, 'points' => $points]);
    }

    public function add(Request $request, $id)
    {
//        $request->session()->forget('cart');
//        $request->session()->forget('products');
//dd($request->session()->all());

        $user = Auth::user();
        $username = $user->name;
        $carts = $request->session()->get('cart', []);

        if (isset($carts[$username])) {
            $productIds = $carts[$username];
            $productIds[$id] = ['quantity' => 1];
        } else {
            $productIds = [$id => ['quantity' => 1]];
        }

        $carts[$username] = $productIds;
        $request->session()->put('cart', $carts);

//        $request->session()->forget('cart');

//        dd($request->session()->all());

//        dd($request->session()->get('cart'));

        return redirect()->back()->with('success', 'Товар успешно добавлен в корзину.');
    }

    public function decreaseQuantity(Request $request, $productId)
    {
        $carts = $request->session()->get('cart', []);
        $user = Auth::user();
        $username = $user->name;

        if (isset($carts[$username][$productId]['quantity']) && $carts[$username][$productId]['quantity'] > 0) {
            $carts[$username][$productId]['quantity']--;

            if ($carts[$username][$productId]['quantity'] < 1) {
                unset($carts[$username][$productId]);
            }
        }

        $request->session()->put('cart', $carts);

        return redirect()->back();
    }

    public function increaseQuantity(Request $request, $productId)
    {
        $carts = $request->session()->get('cart', []);
        $user = Auth::user();
        $username = $user->name;

        if (isset($carts[$username][$productId]['quantity'])) {
            $carts[$username][$productId]['quantity']++;
        } else {
            $carts[$username][$productId]['quantity'] = 1;
        }

        $request->session()->put('cart', $carts);

        return redirect()->back();
    }
}
