<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller {
    use HttpResponses;

    public function productDash() {
        return view( 'Frontend.pages.dashboard.product' );
    }

    // Create Customer
    Public function CreateProduct( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'name'        => 'required|max:60',
            'price'       => 'required',
            'unit'        => 'required',
            'img'         => 'required',
        ] );

        if ( $validator->fails() ) {
            return $this->error( null, 'Invallid Input', '200' );
        }

        $user_id = $request->header( 'id' );

        // Prepare File Name & Path
        $img = $request->file( 'img' );

        $t = time();
        $file_name = $img->getClientOriginalName();
        $img_name = "{$user_id}-{$t}-{$file_name}";
        $img_url = "uploads/{$img_name}";

        // Upload File
        $img->move( public_path( 'uploads' ), $img_name );

        try {
            $data = Product::create( [
                'category_id' => $request->input( 'category_id' ),
                'name'        => $request->input( 'name' ),
                'price'       => $request->input( 'price' ),
                'unit'        => $request->input( 'unit' ),
                'img_url'     => $img_url,
                'user_id'     => $user_id,
            ] );

            return $this->success( $data, 'Successfully Added Product', '200' );

        } catch ( Exception $e ) {
            return $this->error( $e, 'Something Went Wrong', '200' );
        }

    }

    // Show Customer
    public function ProductList( Request $request ) {

        $user_id = $request->header( 'id' );
        $data = Product::with( ['category'] )->where( 'user_id', '=', $user_id )->get();
        if ( $data->count() == 0 ) {
            return $this->error( 'No Data', 'No Data Found', '200' );
        } else {
            return $this->success( $data, 'Success', '200' );
        }

    }

    // Update
    public function UpdateCustomer( Request $request ) {

        $user_id = $request->header( 'id' );
        $product_id = $request->input( 'id' );

        $data = Product::where( 'id', '=', $product_id )->where( 'user_id', '=', $user_id )->first();

        if ( $data->count() == 0 ) {

            return $this->error( 'No Data', 'No Data Found', '200' );

        } else {

            if ( $request->file( 'img' ) ) {

                // Prepare File Name & Path
                $img = $request->file( 'img' );

                $t = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "{$user_id}-{$t}-{$file_name}";
                $img_url = "uploads/{$img_name}";

                // Upload File
                $img->move( public_path( 'uploads' ), $img_name );

                // Dete Old File
                $old_img = $data->img_url;
                File::delete( $old_img );

                $data = $data->update( [
                    'category_id' => $request->input( 'category_id' ),
                    'name'        => $request->input( 'name' ),
                    'price'       => $request->input( 'price' ),
                    'unit'        => $request->input( 'unit' ),
                    'img_url'     => $img_url,
                ] );
                return $this->success( $data, 'Successfully Updated', '200' );
            } else {
                $data = $data->update( [
                    'category_id' => $request->input( 'category_id' ),
                    'name'        => $request->input( 'name' ),
                    'price'       => $request->input( 'price' ),
                    'unit'        => $request->input( 'unit' ),
                ] );
                return $this->success( $data, 'Successfully Updated', '200' );

            }

        }

    }

    // Delete
    public function DeleteProduct( Request $request ) {

        $user_id = $request->header( 'id' );
        $product_id = $request->input( 'id' );
        $filePath = $request->input( 'file_path' );

        $product = Product::where( "id", "=", $product_id )->where( "user_id", "=", $user_id )->first();

        if ( $product->count() != 0 ) {
            $product->delete();
            File::delete( $filePath );
            return $this->success( $product, 'Product Delete Successfull', '200' );
        } else {
            return $this->error( "", "Product Not Found", "200" );
        }

    }

    // Single Product Get
    public function singleProduct( Request $request ) {
        $user_id = $request->header( 'id' );

        $product_id = $request->input( 'id' );

        $product = Product::where( 'user_id', '=', $user_id )->where( 'id', '=', $product_id )->first();

        return $product;
    }

}
