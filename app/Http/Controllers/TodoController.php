<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;

class TodoController extends Controller {

    use HttpResponses;
    public function CreateToDo( Request $request ) {
        // return $request;

        try {

            $user_id = $request->header( 'id' );
            if ( is_null( $request->input( 'description' ) ) ) {

                return Todo::create(
                    [
                        'user_id'     => $user_id,
                        'title'       => $request->input( 'title' ),
                        'description' => null,
                    ]
                );

            } else {

                return Todo::create(
                    [

                        'user_id'     => $user_id,
                        'title'       => $request->input( 'title' ),
                        'description' => $request->input( 'description' ),

                    ]
                );
            }

            // return $this->success( $data, 'Successfully Added ToDo', '200' );

        } catch ( Exception $e ) {
            return $this->error( $e, 'Something Went Wrong', '200' );
        }

    }

    // Show Customer
    public function TodoList( Request $request ) {

        $user_id = $request->header( 'id' );

        $data = Todo::with( 'user' )
            ->where( 'user_id', '=', $user_id )
            ->get();


       
        if ( $data->count() == 0 ) {
            return $this->error( 'No Data', 'No Data Found', '200' );
        } else {
            return $this->success( $data, 'Success', '200' );
        }

    }

    // // Update
    public function UpdateTodo( Request $request ) {

        $user_id = $request->header( 'id' );
        $todo = $request->input( 'id' );

        $data = Todo::where( 'id', '=', $todo )->where( 'user_id', '=', $user_id );

        if ( $data->count() == 0 ) {

            return $this->error( 'No Data', 'No Data Found', '200' );

        } else {

            $data = $data->update( [
                'title'       => $request->input( 'title' ),
                'description' => $request->input( 'description' ),
                'completed'   => $request->input( 'completed' ),
            ] );
            return $this->success( $data, 'Successfully Updated', '200' );

        }

    }

    // // Delete
    public function DeleteTodo( Request $request ) {

        $user_id = $request->header( 'id' );
        $todo = $request->input( 'id' );

        $data = Todo::where( 'id', '=', $todo )->where( 'user_id', '=', $user_id );
        if ( $data->count() == 0 ) {
            return $this->error( '', 'Customer Not Found', '200' );
        } else {
            $data->delete();
            return $this->success( $data, 'Data Deleted Successfully', '200' );
        }

    }
}
