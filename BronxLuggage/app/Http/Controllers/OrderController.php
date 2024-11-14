<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function showCustomerOrders($id)
    {
        // Lấy tất cả đơn hàng của khách hàng với phân trang
        $orders = Order::join('customer', 'order.customer_id', '=', 'customer.customer_id')
            ->select('order.*', 'customer.customer_name', 'customer.customer_email')
            ->where('order.customer_id', $id) // Lọc theo customer_id
            ->orderBy('order.order_id', 'desc') // Sắp xếp theo order_id giảm dần
            ->paginate(10); // Phân trang

        // Lấy chi tiết tất cả đơn hàng
        $orderIds = $orders->pluck('order_id'); // Lấy danh sách ID đơn hàng
        $orderDetails = OrderDetails::join('product', 'orderdetails.product_id', '=', 'product.product_id')
            ->whereIn('orderdetails.order_id', $orderIds)
            ->select('orderdetails.*', 'product.product_name', 'product.product_image', 'product.product_price')
            ->get();

        // Trả dữ liệu đến view
        return view('customer/order_details', compact('orders', 'orderDetails'));
    }
}
