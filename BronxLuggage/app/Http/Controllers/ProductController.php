<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
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

    public function add_product()
    {
        $this->AuthLogin();
        $category_product = DB::table('category')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('brand')->orderBy('brand_id', 'desc')->get();
        return view('admin/add_product')->with('category_product', $category_product)->with('brand_product', $brand_product);
    }

    public function all_product()
    {
        $this->AuthLogin();
        $perPage = 9;
        $data = [
            'products' => Product::join('category', 'category.category_id', '=', 'product.category_id')
                ->join('brand', 'brand.brand_id', '=', 'product.brand_id')
                ->select('product.*', 'category.category_name as category_name', 'brand.brand_name as brand_name')
                ->orderby('product.product_id', 'desc')
                ->paginate($perPage)
        ];
        return view('admin/all_product')->with($data);
    }

    function generateFileName($fileName)
    {
        $name = uniqid();
        $lastIndex = strrpos($fileName, '.');
        $ext = substr($fileName, $lastIndex);
        return $name . $ext;
    }

    public function save_product(Request $request)
    {

        try {
            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                // Đảm bảo file không phải là null
                if ($file) {
                    $newFileName = $this->generateFileName($file->getClientOriginalName());
                    // Di chuyển file
                    $file->move(public_path('images'), $newFileName);

                    $product = [
                        'product_name' => $request->post('product_name'),
                        'product_price' => $request->post('product_price'),
                        'product_image' => $newFileName,
                        'product_description' => $request->post('product_description'),
                        'product_content' => $request->post('product_content'),
                        'product_status' => $request->post('product_status') != null,
                        'product_quantity' => $request->post('product_quantity'),
                        'category_id' => $request->post('product_category'),
                        'brand_id' => $request->post('product_brand')
                    ];
                    Product::create($product);
                    $request->session()->flash('msg', 'Add Product Success');
                    return redirect('all-product');
                } else {
                    throw new Exception('No file was uploaded.');
                }
            } else {
                throw new Exception('No file field present.');
            }
        } catch (Exception $ex) {
            $request->session()->flash('msg', 'Add Product Fail');
            return redirect('add-product');
        }
    }


    public function unactive_product($id)
    {

        Product::where('product_id', $id)->update(['product_status' => 0]);
        session()->put('message', 'Fail');
        return redirect('all-product');
    }

    public function active_product($id)
    {

        Product::where('product_id', $id)->update(['product_status' => 1]);
        session()->put('message', 'Success');
        return redirect('all-product');
    }

    public function edit_product($id)
    {
        $this->AuthLogin();
        $product = Product::find($id);

        if (!$product) {
            // Xử lý khi không tìm thấy sản phẩm, có thể redirect hoặc hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Product not exist.');
        }
        $data = [
            'products' => $product,
            'categories' => Category::all(),
            'brands' => Brand::all()
        ];
        return view('admin/edit_product')->with($data);
    }


    public function update_product(Request $request)
    {
        $this->AuthLogin();
        try {
            $productId = $request->post('product_id');
            $product = Product::find($productId);
            $image = $product->product_image; // Lưu tên hình ảnh cũ

            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $newFileName = $this->generateFileName($file->getClientOriginalName());
                $file->move(public_path('images'), $newFileName);
                $image = $newFileName; // Cập nhật tên hình ảnh mới
            }

            $data = [
                'product_name' => $request->post('product_name'),
                'product_price' => $request->post('product_price'),
                'product_image' => $image, // Sử dụng tên hình ảnh (cũ hoặc mới)
                'product_description' => $request->post('product_description'),
                'product_content' => $request->post('product_content'),
                'product_status' => $request->post('product_status') != null,
                'product_quantity' => $request->post('product_quantity'),
                'category_id' => $request->post('product_category'),
                'brand_id' => $request->post('product_brand')
            ];

            Product::where('product_id', $productId)->update($data);

            $request->session()->flash('msg', 'Update Success');
            return redirect('all-product');
        } catch (Exception $ex) {
            $request->session()->flash('msg', 'Update Fail');
            return redirect('edit-product/' . $productId);
        }
    }


    public function delete_product($id, Request $request)
    {
        $this->AuthLogin();
        try {
            Product::where('product_id', $id)->delete();
            $request->session()->flash('msg', 'Delete success');
        } catch (Exception $ex) {
            $request->session()->flash('msg', 'Delete Fail');
        }
        return redirect('all-product');
    }

    public function deleteProducts(Request $request)
    {
        try {
            $ids = $request->input('post'); // Lấy danh sách ID từ request
            if ($ids) {
                DB::table('product')->whereIn('product_id', $ids)->delete(); // Xóa các liên hệ
                $request->session()->flash('msg', 'Delete Success');
            }
        } catch (Exception $ex) {
            $request->session()->flash('eror', 'Delete Fail');
        }
        return redirect('all-product');
    }

    public function searchByName(Request $request)
    {
        $this->AuthLogin();
        // Lấy giá trị từ request
        $name = $request->input('name');

        // Truy vấn cơ sở dữ liệu với điều kiện tìm kiếm và thực hiện phép join
        $products = Product::join('category', 'category.category_id', '=', 'product.category_id')
            ->join('brand', 'brand.brand_id', '=', 'product.brand_id')
            ->where('product.product_name', 'like', '%' . $name . '%')
            ->select('product.*', 'category.category_name as category_name', 'brand.brand_name as brand_name')
            ->paginate(20);

        // Truyền dữ liệu đến view
        return view('admin/all_product', ['products' => $products, 'name' => $name]);
    }
    //End public function

    public function product_detail($id)
    {
        $category_product = DB::table('category')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        $detail_product = DB::table('product')
            ->join('category', 'category.category_id', '=', 'product.category_id')
            ->join('brand', 'brand.brand_id', '=', 'product.brand_id')
            ->where('product.product_id', $id)
            ->select('product.*', 'category.category_name', 'brand.brand_name')
            ->first();

        $comments = Comment::where('comment_product', $id) //Lay cmt ra view
            ->orderBy('comment_id', 'desc')
            ->paginate(10); // Số bình luận mỗi trang

        $galleryImages = DB::table('product_image')
            ->where('product_id', $id)->get();

        return view('product/show_detail', [
            'categories' => $category_product,
            'brands' => $brand_product,
            'product' => $detail_product,
            'comments' => $comments,
            'galleryImages' => $galleryImages
        ]);
    }

    public function postComment(Request $request, $product_id)
    {
        $comment = new Comment();
        $comment->comment_name = $request->name;
        $comment->comment_email = $request->email;
        $comment->comment_content = $request->content;
        $comment->comment_product = $product_id;
        $comment->comment_status = 1;
        $comment->save();
        return back();
    }

    public function list_comment()
    {
        $this->AuthLogin();
        $comment = Comment::with('product')->orderBy('comment_status', 'DESC')->get();
        return view('admin/comment/list_comment')->with(compact('comment'));
    }

    public function unactive_comment($id)
    {
        $this->AuthLogin();
        Comment::where('comment_id', $id)->update(['comment_status' => 0]);
        session()->put('message', 'Comment has been hidden.');
        return redirect('comment');
    }

    public function active_comment($id)
    {
        $this->AuthLogin();
        Comment::where('comment_id', $id)->update(['comment_status' => 1]);
        session()->put('message', 'Comment has been displayed.');
        return redirect('comment');
    }

    public function delete_comment($id, Request $request)
    {
        $this->AuthLogin();
        try {
            Comment::where('comment_id', $id)->delete();
            $request->session()->flash('msg', 'Delete success');
        } catch (Exception $ex) {
            $request->session()->flash('msg', 'Delete Fail');
        }
        return redirect('comment');
    }

    public function deleteComments(Request $request)
    {
        try {
            $ids = $request->input('post'); // Lấy danh sách ID từ request
            if ($ids) {
                DB::table('comment')->whereIn('comment_id', $ids)->delete(); // Xóa các liên hệ
                $request->session()->flash('msg', 'Delete Success');
            }
        } catch (Exception $ex) {
            $request->session()->flash('eror', 'Delete Fail');
        }
        return redirect('comment');
    }
}
