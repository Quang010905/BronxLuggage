<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Shipping;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

class CheckoutController extends Controller
{
    public function AuthLogin()
    {
        $id = Session::get('id');
        if ($id) {
            return redirect::to('home/index');
        } else {
            return redirect::to('login/index')->send();
        }
    }
    public function index()
    {
        return view('checkout/index');
    }

    public function save_checkout(Request $request)
    {
        // Chuẩn bị dữ liệu để lưu vào cơ sở dữ liệu
        $data = [
            'shipping_name' => $request->post('shipping_name'),
            'shipping_address' => $request->post('shipping_address'),
            'shipping_phone' => $request->post('shipping_phone'),
            'shipping_email' => $request->post('shipping_email'),
            'shipping_note' => $request->post('shipping_note'),
        ];

        // Thêm dữ liệu vào cơ sở dữ liệu và lấy đối tượng Shipping
        $shipping = Shipping::create($data);

        // Lưu shipping_id vào session
        Session::put('shipping_id', $shipping->shipping_id);

        // Chuyển hướng đến trang đăng nhập
        return redirect('/payment');
    }

    public function payment()
    {
        $customerId = session('customer_id');

        // Lấy tất cả các sản phẩm từ giỏ hàng
        $cart_items = DB::table('shoppingcart')->where('customer_id', $customerId)->get();

        // Tính tổng giá trị của giỏ hàng
        $total_price = $cart_items->reduce(function ($carry, $item) {
            return $carry + ($item->cart_quantity * $item->cart_price);
        }, 0);

        return view('checkout/payment')
            ->with('cart_items', $cart_items)
            ->with('total_price', $total_price);
    }

    public function order_place(Request $request)
    {
        //get payment method
        $customer_id = Session::get('customer_id');
        $cart_items = DB::table('shoppingcart')
            ->join('product', 'shoppingcart.product_id', '=', 'product.product_id')
            ->where('shoppingcart.customer_id', $customer_id)
            ->select('product.product_id', 'product.product_name', 'product.product_price', 'product.product_quantity', 'shoppingcart.cart_quantity')
            ->get();

        // Tính tổng tiền từ giỏ hàng
        $total = 0;
        foreach ($cart_items as $item) {
            $total += $item->cart_quantity * $item->product_price;
        }

        // Lấy phương thức thanh toán
        $data = [
            'payment_method' => $request->post('payment_option'),
            'payment_status' => 'Processing'
        ];

        $payment_id = DB::table('payment')->insertGetId($data);

        // Dữ liệu cho đơn hàng
        $order_data = [
            'customer_id' => $customer_id,
            'shipping_id' => Session::get('shipping_id'),
            'payment_id' => $payment_id,
            'order_total' => $total,  // Tổng tiền đã được tính
            'order_status' => 'Processing'
        ];
        $order_id = DB::table('order')->insertGetId($order_data);

        // Lưu chi tiết từng sản phẩm trong giỏ hàng vào bảng orderdetails
        foreach ($cart_items as $item) {
            // Kiểm tra nếu số lượng sản phẩm trong kho đủ để trừ
            if ($item->product_quantity >= $item->cart_quantity) {
                // Cập nhật số lượng sản phẩm trong kho
                DB::table('product')
                    ->where('product_id', $item->product_id)
                    ->decrement('product_quantity', $item->cart_quantity);

                // Lưu chi tiết đơn hàng
                $order_details_data = [
                    'order_id' => $order_id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'product_price' => $item->product_price,
                    'product_sales_quantity' => $item->cart_quantity
                ];
                DB::table('orderdetails')->insert($order_details_data);
            } else {
                // Nếu không đủ hàng, thông báo hết hàng
                return back()->with('error', 'Product ' . $item->product_name . ' Sold out');
            }
        }
        DB::table('shoppingcart')
            ->where('customer_id', $customer_id)
            ->delete();
        // Kiểm tra phương thức thanh toán
        if ($data['payment_method'] == 1) {
            return view('checkout/handcash');
        } else {
            return view('checkout/handcash');
        }
    }

    public function manage_order()
    {

        $perPage = 20;
        $data = [
            'orders' => Order::join('customer', 'order.customer_id', '=', 'customer.customer_id')
                ->select('order.*', 'customer.customer_name')
                ->orderby('order.order_id', 'desc')
                ->paginate($perPage)
        ];
        return view('admin/manage_order')->with($data);
    }

    public function delete_order($id, Request $request)
    {

        try {
            Order::where('order_id', $id)->delete();
            $request->session()->flash('msg', 'Delete Success');
        } catch (Exception $ex) {
            $request->session()->flash('eror', 'Delete Fail');
        }
        return redirect('manage-order');
    }

    public function view_order($id)
    {


        // Lấy thông tin đơn hàng, khách hàng và chi tiết đơn hàng
        $order = Order::join('customer', 'order.customer_id', '=', 'customer.customer_id')
            ->join('shipping', 'order.shipping_id', '=', 'shipping.shipping_id')
            ->select('order.*', 'customer.customer_name', 'customer.customer_email', 'shipping.shipping_name', 'shipping.shipping_address', 'shipping.shipping_phone')
            ->where('order.order_id', $id)
            ->first(); // Sử dụng first() nếu bạn chỉ cần một bản ghi

        $orderDetails = OrderDetails::where('order_id', $id)->get(); // Lấy chi tiết đơn hàng

        return view('admin/view_order', compact('order', 'orderDetails'));
    }
    public function deleteOrders(Request $request)
    {
        try {
        $ids = $request->input('post'); // Lấy danh sách ID từ request
        if ($ids) {
            DB::table('order')->whereIn('order_id', $ids)->delete(); // Xóa các liên hệ
            return redirect()->back()->with('msg', 'Delete Success');
        }} catch (Exception $ex) {
            $request->session()->flash('eror', 'Delete Fail');
        }
        return redirect()->back();
    }

    public function searchByName(Request $request)
    {
        // Lấy giá trị từ request
        $name = $request->input('name');

        // Truy vấn cơ sở dữ liệu
        $query = Order::join('customer', 'order.customer_id', '=', 'customer.customer_id')
            ->select('order.*', 'customer.customer_name');

        // Kiểm tra nếu có giá trị tìm kiếm
        if (!empty($name)) {
            $query->where('customer.customer_name', 'like', '%' . $name . '%');
        }

        // Thực hiện phân trang
        $order = $query->paginate(20);

        // Truyền dữ liệu đến view
        return view('admin/manage_order', ['orders' => $order, 'name' => $name]);
    }
}
