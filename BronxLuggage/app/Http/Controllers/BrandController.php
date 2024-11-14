<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
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

    public function add_brand()
    {
        $this->AuthLogin();
        return view('admin/add_brand');
    }

    public function all_brand()
    {
        $perPage = 8;
        $this->AuthLogin();
        // Lấy danh sách danh mục với phân trang
        $brands = Brand::paginate($perPage);
        $data = [
            'brands' => $brands
        ];
        return view('admin/all_brand')->with($data);
    }

    public function save_brand(Request $request)
    {
        $this->AuthLogin();
        try {
            $data = [
                'brand_name' => $request->post('brand_name'),
                'brand_description' => $request->post('brand_description'),
                'brand_status' => $request->post('brand_status')
            ];
            DB::table('brand')->insert($data);
            $request->session()->flash('msg', 'Add Success');
            return redirect('all-brand');
        } catch (Exception $ex) {
            $request->session()->flash('msg', 'Add Fail');
            return redirect('add-category');
        }
    }

    public function unactive_brand($id)
    {
        $this->AuthLogin();
        Brand::where('brand_id', $id)->update(['brand_status' => 0]);
        session()->put('message', 'Fail');
        return redirect('all-brand');
    }

    public function active_brand($id)
    {
        $this->AuthLogin();
        Brand::where('brand_id', $id)->update(['brand_status' => 1]);
        session()->put('message', 'Success');
        return redirect('all-brand');
    }

    public function edit_brand($id)
    {
        $this->AuthLogin();
        $data = [
            'brands' => Brand::where('brand_id', $id)->get()
        ];
        return view('admin/edit_brand')->with($data);
    }


    public function update_brand(Request $request, $id)
    {
        $this->AuthLogin();
        try {
            $data = [
                'brand_name' => $request->post('brand_name'),
                'brand_description' => $request->post('brand_description'),
            ];
            DB::table('brand')->where('brand_id', $id)->update($data);
            $request->session()->flash('msg', 'Update Success');
            return redirect('all-brand');
        } catch (Exception $ex) {
            $request->session()->flash('msg', 'Update Fail');
            return redirect('edit-brand/' . $id);
        }
    }

    public function delete_brand($id, Request $request)
    {
        $this->AuthLogin();
        try {
            Brand::where('brand_id', $id)->delete();
            $request->session()->flash('msg', 'Delete success');
        } catch (Exception $ex) {
            $request->session()->flash('eror', 'Delete Fail');
        }
        return redirect('all-brand');
    }

    public function deleteBrands(Request $request)
    {
        try {
            $ids = $request->input('post'); // Lấy danh sách ID từ request
            if ($ids) {
                DB::table('brand')->whereIn('brand_id', $ids)->delete(); // Xóa các liên hệ
                $request->session()->flash('msg', 'Delete Success');
            }
        } catch (Exception $ex) {
            $request->session()->flash('eror', 'Delete Fail');
        }
        return redirect('all-brand');
    }

    public function searchByName(Request $request)
    {
        // Lấy giá trị từ request
        $name = $request->input('name');

        // Truy vấn cơ sở dữ liệu với điều kiện tìm kiếm
        $brands = Brand::where('brand_name', 'like', '%' . $name . '%')->paginate(4);

        // Truyền dữ liệu đến view
        return view('admin/all_brand', ['brands' => $brands, 'name' => $name]);
    }

    //End function admin

    public function show_brand($id)
    {
        $perPage = 9;
        $category_product = DB::table('category')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        $brand_by_id = Product::join('brand', 'brand.brand_id', '=', 'product.brand_id')
            ->where('product.brand_id', $id)
            ->paginate($perPage);
        $brand_name = Brand::where('brand_id', $id)->limit(1)->get();
        $product_name = Product::where('product_id', $id)->limit(1)->get();
        return view('brand/show_brand')->with('categories', $category_product)->with('brands', $brand_product)
            ->with('brands_by_id', $brand_by_id)->with('brand_name', $brand_name)->with('product_name', $product_name);
    }
    
}
