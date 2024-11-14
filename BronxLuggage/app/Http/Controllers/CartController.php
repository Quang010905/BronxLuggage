<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function save_cart(Request $request)
    {
        $productId = $request->post('productid_hidden');
        $customerId = session('customer_id');
        $product_info = DB::table('product')->where('product_id', $productId)->first();
        $existingCartItem = DB::table('shoppingcart')
            ->where('customer_id', $customerId)
            ->where('product_id', $productId)
            ->first();
        if ($existingCartItem) {
            // Cập nhật số lượng của sản phẩm trong giỏ hàng
            $newQuantity = $existingCartItem->cart_quantity + 1; // Tăng số lượng thêm 1

            // Kiểm tra số lượng còn lại trong kho
            $product_quantity = $product_info->product_quantity;
            if ($newQuantity <= $product_quantity) {
                DB::table('shoppingcart')
                    ->where('cart_id', $existingCartItem->cart_id)
                    ->update(['cart_quantity' => $newQuantity]);
            } else {
                // Nếu số lượng yêu cầu lớn hơn số lượng trong kho, xử lý lỗi hoặc thông báo
                $request->session()->flash('msg', 'Not enough stock available.');
            }
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $data = [
                'cart_name' => $product_info->product_name,
                'cart_price' => $product_info->product_price,
                'cart_image' => $product_info->product_image,
                'cart_quantity' => 1, // Khởi tạo số lượng là 1
                'customer_id' => $customerId,
                'product_id' => $productId // Thêm ID sản phẩm để dễ quản lý
            ];
            Cart::create($data);
        }

        return redirect('show-cart');
    }

    public function show_cart()
    {
        // Lấy danh mục và thương hiệu sản phẩm
        $category_product = DB::table('category')
            ->where('category_status', '1')
            ->orderBy('category_id', 'desc')
            ->get();

        $brand_product = DB::table('brand')
            ->where('brand_status', '1')
            ->orderBy('brand_id', 'desc')
            ->get();

        // Lấy ID khách hàng từ session
        $customerId = session('customer_id');

        // Lấy tất cả các sản phẩm từ giỏ hàng
        $cart_items = DB::table('shoppingcart')
            ->join('product', 'shoppingcart.product_id', '=', 'product.product_id')
            ->where('shoppingcart.customer_id', $customerId)
            ->select(
                'shoppingcart.cart_id',
                'product.product_id',
                'product.product_name as cart_name',
                'product.product_price as cart_price',
                'product.product_quantity',
                'product.product_image as cart_image',
                'shoppingcart.cart_quantity'
            )
            ->get();

        $total_price = 0;
        $has_out_of_stock = false;

        foreach ($cart_items as $item) {
            // Kiểm tra xem sản phẩm có hết hàng không
            if ($item->product_quantity < $item->cart_quantity) {
                // Cập nhật số lượng giỏ hàng bằng số lượng còn trong kho
                DB::table('shoppingcart')
                    ->where('cart_id', $item->cart_id)
                    ->update(['cart_quantity' => $item->product_quantity]);

                // Cập nhật số lượng giỏ hàng trong $cart_items
                $item->cart_quantity = $item->product_quantity;

                // Đánh dấu có sản phẩm hết hàng
                $has_out_of_stock = true;
            }

            // Tính tổng giá tiền
            $total_price += $item->cart_quantity * $item->cart_price;
        }

        // Truyền dữ liệu vào view để hiển thị
        return view('cart/show_cart')
            ->with('categories', $category_product)
            ->with('brands', $brand_product)
            ->with('cart_items', $cart_items)
            ->with('total_price', $total_price)
            ->with('has_out_of_stock', $has_out_of_stock);
    }
    public function delete_cart($id, Request $request)
    {

        try {
            $customerId = session('customer_id');
            Cart::where('cart_id', $id)->where('customer_id', $customerId)->delete();
            $request->session()->flash('msg', 'Delete Success');
        } catch (Exception $ex) {
            $request->session()->flash('msg', 'Delete Fail');
        }
        return redirect('show-cart');
    }

    public function update_cart_quantity(Request $request, $id)
    {
        try {
            // Lấy thông tin giỏ hàng từ cơ sở dữ liệu
            $cartItem = DB::table('shoppingcart')->where('cart_id', $id)->first();

            if (!$cartItem) {
                // Nếu không tìm thấy giỏ hàng, trả về thông báo lỗi
                $request->session()->flash('msg', 'Cart item not found');
                return redirect('show-cart');
            }

            // Lấy thông tin sản phẩm từ cơ sở dữ liệu
            $product = DB::table('product')->where('product_id', $cartItem->product_id)->first();

            if (!$product) {
                // Nếu không tìm thấy sản phẩm, trả về thông báo lỗi
                $request->session()->flash('msg', 'Product not found');
                return redirect('show-cart');
            }

            // Lấy số lượng sản phẩm mới từ request
            $newQuantity = $request->post('cart_quantity');

            // Kiểm tra số lượng mới có vượt quá số lượng có sẵn trong kho không
            if ($newQuantity > $product->product_quantity) {
                // Nếu số lượng vượt quá số lượng trong kho, trả về thông báo lỗi
                $request->session()->flash('msg', 'Quantity exceeds available stock');
                return redirect('show-cart');
            }

            // Cập nhật số lượng giỏ hàng
            DB::table('shoppingcart')->where('cart_id', $id)->update([
                'cart_quantity' => $newQuantity,
            ]);

            $request->session()->flash('message', 'Update Success');
            return redirect('show-cart');
        } catch (Exception $ex) {
            // Xử lý lỗi và trả về thông báo lỗi
            $request->session()->flash('msg', 'Update Fail');
            return redirect('show-cart');
        }
    }
}
