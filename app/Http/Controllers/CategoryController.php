<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller {
    use HttpResponses;

    public function categoryPage() {
        return view( 'Frontend.pages.dashboard.category' );
    }

    // Create Customer
    Public function CreateCategory( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'name' => 'required|string|max:50',
        ] );

        if ( $validator->fails() ) {
            return $this->error( null, 'Invallid Input', '200' );
        }

        try {
            $user_id = $request->header( 'id' );
            $data = Category::create( [
                'name'    => $request->input( 'name' ),
                'user_id' => $user_id,
            ] );

            return $this->success( $data, 'Successfully Added Customer', '200' );

        } catch ( Exception $e ) {
            return $this->error( $e, 'Something Went Wrong', '200' );
        }

    }

    // Show Customer
    public function CategoryList( Request $request ) {

        $user_id = $request->header( 'id' );
        $data = Category::where( 'user_id', '=', $user_id )
            ->get();
        if ( $data->count() == 0 ) {
            return $this->error( 'No Data', 'No Data Found', '200' );
        } else {
            return $this->success( $data, 'Success', '200' );
        }

    }

    // Update
    public function UpdateCategory( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'name' => 'required|string|max:50',
            
        ] );

        if ( $validator->fails() ) {
            return $this->error( null, 'Invallid Input', '200' );
        }

        $user_id = $request->header( 'id' );
        $category_id = $request->input( 'id' );

        $data = Category::where( 'id', '=', $category_id )->where( 'user_id', '=', $user_id );

        if ( $data->count() == 0 ) {

            return $this->error( 'No Data', 'No Data Found', '200' );

        } else {

            $data = $data->update( [
                'name' => $request->input( 'name' ),
            ] );
            return $this->success( $data, 'Successfully Updated', '200' );

        }

    }

    // Delete
    public function DeleteCategory( Request $request ) {

        $user_id = $request->header( 'id' );
        $category_id = $request->input( 'id' );

        $data = Category::where( 'id', '=', $category_id )->where( 'user_id', '=', $user_id );
        if ( $data->count() == 0 ) {

            return $this->error( '', 'Customer Not Found', '200' );
        } else {
            $dataProduct = Product::where( 'category_id', '=', $category_id )->get();

            if ( $dataProduct->count() != 0 ) {
                return $this->error( null, 'This Category Have Many Products. You Can\'t Delete.', '200' );
            } else {
                $data->delete();
                return $this->success( $data, 'Data Deleted Successfully', '200' );
            }

        }

    }
}
