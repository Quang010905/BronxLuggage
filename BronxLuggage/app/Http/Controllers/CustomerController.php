<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function AuthLogin()
    {
        $id = Session::get('id');
        if ($id) {
            return redirect::to('admin/dashboard');
        } else {
            return redirect::to('admin/login')->send();
        }
    }
    public function add_customer(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => [
                'required',
                'email',
                function ($attribute, $value, $fail)  use ($request) {
                    $cleanedEmail = trim($value);
                    if (preg_match('/\s/', $cleanedEmail)) {
                        $fail('Email cannot contain spaces.');
                    }
                    if (!filter_var($cleanedEmail, FILTER_VALIDATE_EMAIL)) {
                        $fail('Invalid email address.');
                    }
                },
            ],
            'customer_password' => 'required|string|min:8',
            // Các quy tắc khác nếu cần
        ]);
        // Chuyển đổi ngày sinh từ định dạng d/m/Y sang Y-m-d
        $dateString = $request->post('customer_birthday');
        $date = \DateTime::createFromFormat('d/m/Y', $dateString);
        $formattedDate = $date->format('Y-m-d');

        // Mã hóa mật khẩu bằng Bcrypt
        $hashedPassword = Hash::make($request->post('customer_password'));

        $email = trim($request->post('customer_email'));
        $email = preg_replace('/\s+/', '', $email);


        // Chuẩn bị dữ liệu để lưu vào cơ sở dữ liệu
        $data = [
            'customer_name' => $request->post('customer_name'),
            'customer_email' =>  $email,
            'customer_password' => $hashedPassword, // Sử dụng mật khẩu đã mã hóa
            'customer_phone' => $request->post('customer_phone'),
            'customer_birthday' => $formattedDate,
            'customer_gender' => $request->post('customer_gender'),
        ];

        // Thêm dữ liệu vào cơ sở dữ liệu
        Customer::create($data);

        // Chuyển hướng đến trang đăng nhập
        return redirect('login/index');
    }

    public function customer_login()
    {
        return view('home/index');
    }

    public function login(Request $request)
    {
        $customer_email = $request->post('email');
        $customer_password = $request->post('password');

        // Tìm tất cả các tài khoản của khách hàng theo email
        $customers = Customer::where('customer_email', $customer_email)->get();

        // Nếu tìm thấy khách hàng với email đó
        if ($customers->isNotEmpty()) {
            foreach ($customers as $customer) {
                // Kiểm tra mật khẩu cho từng tài khoản
                if (Hash::check($customer_password, $customer->customer_password)) {
                    // Nếu mật khẩu đúng, lưu thông tin vào session
                    session()->put('customer_name', $customer->customer_name);
                    session()->put('customer_id', $customer->customer_id);
                    session()->put('customer_email', $customer->customer_email);

                    // Lấy dữ liệu danh mục và sản phẩm như trong phương thức index
                    $categories = Category::orderBy('category_id')->take(3)->get();
                    $productsByCategory = Product::all()->groupBy('category_id');
                    $products = collect();

                    foreach ($productsByCategory as $categoryProducts) {
                        $product = $categoryProducts->random();
                        $products->push($product);
                    }

                    // Trả về view với đầy đủ dữ liệu
                    return view('home/index', compact('products', 'categories', 'customer'));
                }
            }
            // Nếu không có tài khoản nào khớp với mật khẩu
            $request->session()->flash('msg', 'Wrong Password');
            return redirect('login/index');
        } else {
            // Nếu không tìm thấy email trong cơ sở dữ liệu
            $request->session()->flash('msg', 'Email not found');
            return redirect('login/index');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('customer_name');
        return redirect('home/index');
    }

    public function all_customer()
    {
        $this->AuthLogin();
        $perPage = 10;
        // Lấy danh sách danh mục với phân trang
        $customers = Customer::paginate($perPage);

        $data = [
            'customers' => $customers
        ];
        return view('admin/all_customer')->with($data);
    }

    public function searchByName(Request $request)
    {
        // Lấy giá trị từ request
        $name = $request->input('name');

        // Kiểm tra nếu giá trị tìm kiếm rỗng
        if (empty($name)) {
            // Nếu tìm kiếm rỗng, trả về danh sách tất cả các mục với phân trang
            $customers = Customer::paginate(10);
        } else {
            // Truy vấn cơ sở dữ liệu với điều kiện tìm kiếm
            $customers = Customer::where('customer_name', 'like', '%' . $name . '%')->paginate(10);
        }

        // Truyền dữ liệu đến view
        return view('admin/all_customer', ['customers' => $customers, 'name' => $name]);
    }

    public function delete_customer($id, Request $request)
    {
        $this->AuthLogin();
        try {
            Customer::where('customer_id', $id)->delete();
            $request->session()->flash('msg', 'Delete success');
        } catch (Exception $ex) {
            $request->session()->flash('eror', 'Delete Fail');
        }
        return redirect('manage-customer');
    }

    public function deleteCustomers(Request $request)
    {
        try {
            $ids = $request->input('post'); // Lấy danh sách ID từ request
            if ($ids) {
                DB::table('customer')->whereIn('customer_id', $ids)->delete(); // Xóa các liên hệ
                $request->session()->flash('msg', 'Delete Success');
            }
        } catch (Exception $ex) {
            $request->session()->flash('eror', 'Delete Fail');
        }
        return redirect('manage-customer');
    }
}
