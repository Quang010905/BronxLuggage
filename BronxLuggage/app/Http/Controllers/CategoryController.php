<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
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

    public function add_category()
    {
        $this->AuthLogin();
        return view('admin/add_category');
    }

    public function all_category()
    {
        $this->AuthLogin();
        $perPage = 8;
        // Lấy danh sách danh mục với phân trang
        $categories = Category::paginate($perPage);

        $data = [
            'categories' => $categories
        ];
        return view('admin/all_category')->with($data);
    }

    public function save_category(Request $request)
    {
        $this->AuthLogin();
        try {
            $data = [
                'category_name' => $request->post('category_name'),
                'category_description' => $request->post('category_description'),
                'category_status' => $request->post('category_status')
            ];
            Category::create($data);
            $request->session()->flash('msg', 'Add Success');
            return redirect('all-category');
        } catch (Exception $ex) {
            $request->session()->flash('msg', 'Add Fail');
            return redirect('add-category');
        }
    }

    public function unactive_category($id)
    {
        $this->AuthLogin();
        Category::where('category_id', $id)->update(['category_status' => 0]);
        session()->put('message', 'Fail');
        return redirect('all-category');
    }

    public function active_category($id)
    {
        $this->AuthLogin();
        Category::where('category_id', $id)->update(['category_status' => 1]);
        session()->put('message', 'Success');
        return redirect('all-category');
    }

    public function edit_category($id)
    {
        $this->AuthLogin();
        $data = [
            'categories' => Category::where('category_id', $id)->get()
        ];
        return view('admin/edit_category')->with($data);
    }


    public function update_category(Request $request, $id)
    {
        $this->AuthLogin();
        try {
            $data = [
                'category_name' => $request->post('category_name'),
                'category_description' => $request->post('category_description'),
            ];
            DB::table('category')->where('category_id', $id)->update($data);
            $request->session()->flash('msg', 'Update Success');
            return redirect('all-category');
        } catch (Exception $ex) {
            $request->session()->flash('msg', 'Update Fail');
            return redirect('edit-category/' . $id);
        }
    }

    public function delete_category($id, Request $request)
    {
        $this->AuthLogin();
        try {
            Category::where('category_id', $id)->delete();
            $request->session()->flash('msg', 'Delete Success');
        } catch (Exception $ex) {
            $request->session()->flash('eror', 'Delete Fail');
        }
        return redirect('all-category');
    }

    public function searchByName(Request $request)
    {
        // Lấy giá trị từ request
        $name = $request->input('name');

        // Kiểm tra nếu giá trị tìm kiếm rỗng
        if (empty($name)) {
            // Nếu tìm kiếm rỗng, trả về danh sách tất cả các mục với phân trang
            $categories = Category::paginate(8);
        } else {
            // Truy vấn cơ sở dữ liệu với điều kiện tìm kiếm
            $categories = Category::where('category_name', 'like', '%' . $name . '%')->paginate(8);
        }

        // Truyền dữ liệu đến view
        return view('admin/all_category', ['categories' => $categories, 'name' => $name]);
    }

    public function deleteCategories(Request $request)
    {
        try {
            $ids = $request->input('post'); // Lấy danh sách ID từ request
            if ($ids) {
                DB::table('category')->whereIn('category_id', $ids)->delete(); // Xóa các liên hệ
                $request->session()->flash('msg', 'Delete Success');
            }
        } catch (Exception $ex) {
            $request->session()->flash('eror', 'Delete Fail');
        }
        return redirect('all-category');
    }

    //End function admin page

    public function show_category($id)
    {
        $perPage = 9;
        $category_product = DB::table('category')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        $category_by_id = Product::join('category', 'category.category_id', '=', 'product.category_id')
            ->where('product.category_id', $id)->paginate($perPage);
        $category_name = Category::where('category_id', $id)->limit(1)->get();
        return view('category/show_category')->with('categories', $category_product)->with('brands', $brand_product)
            ->with('categories_by_id', $category_by_id)->with('category_name', $category_name);
    }
}
