<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ContactusController extends Controller
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

    public function contactus()
    {
        return view('contactus/index');
    }

    public function add_contact()
    {
        $contact = DB::table('contact')->orderBy('contact_id', 'desc')->get();
        $customer = DB::table('customer')->orderBy('customer_id', 'desc')->get();
        return view('contactus/index')->with('contacts',   $contact)->with('customers', $customer);
    }

    public function save_contact(Request $request)
    {
        // Lấy customer_id từ session (hoặc cách khác bạn lưu trữ customer_id)
        $customer_id = $request->session()->get('customer_id');

        // Kiểm tra nếu customer_id không tồn tại
        if (!$customer_id) {
            // Xử lý trường hợp không tìm thấy customer_id
            $request->session()->flash('error', 'Customer ID not found.');
            return redirect('contactus/index');
        }

        // Tạo mảng dữ liệu liên hệ với customer_id
        $contactus = [
            'contact_customer_id' => $customer_id, // Thêm customer_id vào dữ liệu
            'contact_customername' => $request->post('contact_name'),
            'contact_customeremail' => $request->post('contact_email'),
            'contact_message' => $request->post('contact_message'),
            'contact_subject' => $request->post('contact_subject'),
            'customer_id' => $request->input('customer_id')
        ];

        // Lưu dữ liệu liên hệ vào cơ sở dữ liệu
        Contact::create($contactus);

        // Hiển thị thông báo thành công và chuyển hướng
        $request->session()->flash('msg', 'Send Contact Success');
        return redirect('contactus/index');
    }

    public function all_contact()
    {
        $perPage = 20;
      
        // Lấy danh sách danh mục với phân trang
        $contacts = Contact::paginate($perPage);

        $data = [
            'contacts' => $contacts
        ];
        return view('admin/all_contact')->with($data);
    }

    public function edit_contact($id)
    {
        $this->AuthLogin();
        $data = [
            'contacts' => Contact::where('contact_id', $id)->get()
        ];
        return view('admin/edit_contact')->with($data);
    }

    public function delete_contact($id, Request $request)
    {
      
        try {
            Contact::where('contact_id', $id)->delete();
            $request->session()->flash('msg', 'Delete Success');
        } catch (Exception $ex) {
            $request->session()->flash('msg', 'Delete Fail');
        }
        return redirect('all-contact');
    }

    public function searchByName(Request $request)
    {
        // Lấy giá trị từ request
        $name = $request->input('name');

        // Kiểm tra nếu giá trị tìm kiếm rỗng
        if (empty($name)) {
            // Nếu tìm kiếm rỗng, trả về danh sách tất cả các mục với phân trang
            $contacts = Contact::paginate(20);
        } else {
            // Truy vấn cơ sở dữ liệu với điều kiện tìm kiếm
            $contacts = Contact::where('contact_customername', 'like', '%' . $name . '%')->paginate(20);
        }

        // Truyền dữ liệu đến view
        return view('admin/all_contact', ['contacts' => $contacts, 'name' => $name]);
    }

    public function deleteContacts(Request $request)
    {
        $ids = $request->input('post'); // Lấy danh sách ID từ request
        if ($ids) {
            DB::table('contact')->whereIn('contact_id', $ids)->delete(); // Xóa các liên hệ
            return redirect()->back()->with('msg', 'Delete Success');
        }
        return redirect()->back()->with('msg', 'Delete Fail');
    }

    
    
}
