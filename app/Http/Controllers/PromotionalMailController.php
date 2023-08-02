<?php

namespace App\Http\Controllers;

use App\Mail\PromotionalMail;
use App\Models\Customer;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PromotionalMailController extends Controller {


    use HttpResponses;

    
    public function sendPromotionalMail( Request $request ) {

        $user_id = $request->header( 'id' );
        $subject = $request->input( 'subject' );
        $body = $request->input( 'body' );
        $description = $request->input( 'description' );

        $customer = Customer::where( "user_id", "=", $user_id )->pluck( 'email' );

        try {
            Mail::to( $customer )->send( new PromotionalMail( $subject, $body, $description ) );
            return $this->success( '', 'Successfully Send Email', '200' );

        } catch ( Exception $e ) {
            return $this->error( '', $e, '200' );

        }

    }

    public function promotionlMailPage(){
        return view('Frontend.pages.dashboard.promotionalMail');
    }


}
