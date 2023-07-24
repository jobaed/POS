<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller {

    use HttpResponses;

    // Create Customer
    Public function CreateCustomer( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'name'   => 'required|string|max:150',
            'email'  => 'required|email',
            'mobile' => 'required|max:15',
        ] );

        if ( $validator->fails() ) {
            return $this->error( null, 'Invallid Input', '200' );
        }

        try {
            $user_id = $request->header( 'id' );
            $data = Customer::create( [
                'name'    => $request->input( 'name' ),
                'email'   => $request->input( 'email' ),
                'mobile'  => $request->input( 'mobile' ),
                'user_id' => $user_id,
            ] );

            return $this->success( $data, 'Successfully Added Customer', '200' );

        } catch ( Exception $e ) {
            return $this->error( $e, 'Something Went Wrong', '200' );
        }

    }

    // Show Customer
    public function CustomerList( Request $request ) {

        $user_id = $request->header( 'id' );
        $data = Customer::where( 'user_id', '=', $user_id )->get();
        if ( $data->count() == 0 ) {
            return $this->error( 'No Data', 'No Data Found', '200' );
        } else {
            return $this->success( $data, 'Success', '200' );
        }

    }

    // Update
    public function UpdateCustomer( Request $request ) {

        $user_id = $request->header( 'id' );
        $customer = $request->input( 'id' );

        $data = Customer::where( 'id', '=', $customer )->where( 'user_id', '=', $user_id );

        if ( $data->count() == 0 ) {

            return $this->error( 'No Data', 'No Data Found', '200' );

        } else {

            $data = $data->update( [
                'name'   => $request->input( 'name' ),
                'email'  => $request->input( 'email' ),
                'mobile' => $request->input( 'mobile' ),
            ] );
            return $this->success( $data, 'Successfully Updated', '200' );

        }

    }

    // Delete
    public function DeleteCustomer( Request $request ) {

        $user_id = $request->header( 'id' );
        $customer = $request->input( 'id' );

        $data = Customer::where( 'id', '=', $customer )->where( 'user_id', '=', $user_id );
        if ( $data->count() == 0 ) {
            return $this->error( '', 'Customer Not Found', '200' );
        } else {
            $data->delete();
            return $this->success( $data, 'Data Deleted Successfully', '200' );
        }

    }

}
