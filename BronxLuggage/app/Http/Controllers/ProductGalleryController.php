<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProductGalleryController extends Controller
{
    public function AuthLogin()
    {
        $id = Session::get('id');
        if ($id) {
            return Redirect::to('admin/dashboard');
        } else {
            return Redirect::to('admin/login')->send();
        }
    }

    public function add_gallery($product_id)
    {
        $this->AuthLogin();
        $productId = $product_id;
        return view('admin.add_gallery')->with(compact('productId'));
    }

    public function update_gallery_name(Request $request)
    {
        $this->AuthLogin();
        $gal_id = $request->gal_id;
        $gal_text = $request->gal_text;
        $gallery = ProductGallery::find($gal_id);
        if ($gallery) {
            $gallery->details_name = $gal_text;
            $gallery->save();
            return response()->json(['success' => true, 'message' => 'Update Success']);
        }
        return response()->json(['success' => false, 'message' => 'Gallery not found']);
    }

    public function insert_gallery(Request $request, $product_id)
    {
        $this->AuthLogin();
        $get_image = $request->file('file');
        if ($get_image) {
            foreach ($get_image as $image) {
                $get_name_image = $image->getClientOriginalName();
                $name_image = pathinfo($get_name_image, PATHINFO_FILENAME);
                $new_image = $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $new_image);

                $gallery = new ProductGallery();
                $gallery->details_name = $name_image;
                $gallery->details_image = $new_image;
                $gallery->product_id = $product_id;
                $gallery->save();
            }
        }
        Session::flash('message', 'Add photo success');
        return redirect()->back();
    }

    public function delete_gallery(Request $request)
    {
        $gal_id = $request->gal_id;
        $gallery = ProductGallery::find($gal_id);

        if ($gallery) {
            $imagePath = public_path('images/' . $gallery->details_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
                $gallery->delete();
                return response()->json(['success' => true, 'message' => 'Photo deleted success']);
            } else {
                return response()->json(['success' => false, 'message' => 'Image does not exist on server']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'No image found']);
        }
    }

    public function update_gallery(Request $request)
    {
        $this->AuthLogin();
        $gal_id = $request->gal_id;
        $gallery = ProductGallery::find($gal_id);

        if ($gallery) {
            if ($request->hasFile('file')) {
                $oldImage = public_path('images/' . $gallery->details_image);
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }

                $file = $request->file('file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);

                $gallery->details_image = $filename;
                $gallery->save();

                return response()->json(['success' => true, 'message' => 'Update photo success']);
            } else {
                return response()->json(['success' => false, 'message' => 'Image does not exist on server']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'No image found']);
        }
    }


    public function select_gallery(Request $request)
    {
        
        $product_id = $request->productId;
        $gallery = ProductGallery::where('product_id', $product_id)->get();
        $gallery_count = $gallery->count();

        $output = '
            <form>
                ' . csrf_field() . '
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Details_name</th>
                            <th>Details_image</th>
                            <th>Manager</th>
                        </tr>
                 </thead>
                 <tbody>';
        if ($gallery_count > 0) {
            $i = 0;
            foreach ($gallery as $gal) {
                $i++;
                $output .= '
                    <tr>
                         <td>' . $i . '</td>
                         <td contenteditable class="edit_gal_name" data-gal_id="' . $gal->details_id . '">' . $gal->details_name . '</td>
                         <td>
                            <img src="' . asset('images/' . $gal->details_image) . '" class="img-thumbnail" width="120" height="120"> <br>
                            <input type="file" class="file_image" style="width:40%" data-gal_id="' . $gal->details_id . '" id="file-' . $gal->details_id . '"
                            name="file" accept="images/*">
                         </td>
                         <td>
                             <button type="button" data-gal_id="' . $gal->details_id . '" class="btn btn-xs btn-danger delete-gallery">Delete</button>
                         </td>
                    </tr>';
            }
        } else {
            $output .= '<tr><td colspan="4">There are no products in the photo gallery</td></tr>';
        }
        $output .= '</tbody></table></form>';
        echo $output;
    }
}
