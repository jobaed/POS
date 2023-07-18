<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     *
     */
    public function index() {
        return "Index";
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store( StoreUserRequest $request ) {
        // return $request->input();
    }

    /**
     * Display the specified resource.
     *
     */
    public function show( User $user ) {
        //
    }

    /**
     *
     *
     * Show the form for editing the specified resource.
     *
     */
    public function edit( User $user ) {
        //
    }

    /**
     *
     *
     * Update the specified resource in storage.
     *
     */
    public function update( UpdateUserRequest $request, User $user ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     */
    public function destroy( User $user ) {
        //
    }

    // For Frontend Pages
    public function loginPage(): View {
        return view( 'Frontend.pages.auth.login' );
    }
    public function regiPage(): View {
        return view( 'Frontend.pages.auth.regi' );
    }
    public function otpPage(): View {
        return view( 'Frontend.pages.auth.otp' );
    }
    public function verifyotpPage(): View {
        return view( 'Frontend.pages.auth.verifyOTP' );
    }
    public function resetPassPage(): View {
        return view( 'Frontend.pages.auth.reset-pass' );
    }
    public function dashboardPage(): View {
        return view( 'Frontend.pages.dashboard.dashboard' );
    }

    // For API Call
    public function storeAPIData( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'firstName' => 'required|string|max:150',
            'lastName'  => 'required|string|max:150',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'mobile'    => 'required|max:15',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Input',
            ] );
        }

        try {
            User::create( [
                'firstName' => $request->input( 'firstName' ),
                'lastName'  => $request->input( 'lastName' ),
                'email'     => $request->input( 'email' ),
                'mobile'    => $request->input( 'mobile' ),
                'password'  => $request->input( 'password' ),
            ] );
            return response()->json( [
                'status'  => 'success',
                'message' => 'User Registration Successfully',
            ], 200 );
        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'User Registration Failed',
            ], 400 );
        }

    }

    public function userLogin( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Input',
                'code'    => '403',
            ], 200 );
        }

        $count = User::where( $request->all() )->count();
        if ( $count == 1 ) {

            $token = JWTToken::CreateToken( $request->email );
            return response()->json( [
                'status'  => 'success',
                'message' => 'User Login Successfull',
            ], 200 )->cookie( 'token', $token, 60 * 60 * 24 );

        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Unauthorized',
                'code'    => 401,
            ], 200 );
        }

    }

    public function SendOTPCode( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'email' => 'required|email',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Email',
                'code'    => '401',
            ], 200 );
        }

        $email = $request->input( 'email' );
        $otp = rand( 100000, 999999 );

        $count = User::where( 'email', '=', $email )->count();
        if ( $count == 1 ) {
            // Send Email
            Mail::to( $email )->send( new OTPMail( $otp ) );

            // Otp Update Database
            User::where( 'email', '=', $email )->update( ['otp' => $otp] );

            return response()->json( [
                'status'  => 'success',
                'message' => 'Your Password Reset OTP Has been send',

            ], 200 );

        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Unauthorized',
                'code'    => '403',
            ], 200 );
        }
    }

    public function VerifiedOTP( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'otp' => 'required|min:6|max:6',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Input',
                'code'    => '403',
            ], 200 );
        }

        $email = $request->input( 'email' );
        $otp = $request->input( 'otp' );

        $count = User::where( 'email', '=', $email )
            ->where( 'otp', '=', $otp )->count();

        if ( $count == 1 ) {

            // Update Otp
            User::where( 'email', '=', $email )->update( ['otp' => '0'] );

            // Create Reset Token
            $token = JWTToken::CreateTokenForSetPassword( $request->email );
            return response()->json( [
                'status'  => 'success',
                'message' => 'OTP Varification Successfull',
            ], 200 )->cookie( 'token', $token, 60 * 60 * 24 );

        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Not Match',
                'code'    => '404',
            ], 200 );
        }

    }

    public function ResetPass( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'password' => 'required|min:6',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Input',
                'code'    => '403',
            ] );
        }

        try {
            $token = $request->cookie( 'token' );
            $password = $request->input( 'password' );

            $email = JWTToken::VerifyToken( $token );

            User::where( 'email', '=', $email )->update( ['password' => $password] );
            

            return response()->json( [
                'status'  => 'success',
                'message' => 'Request Success',
            ], 200 )->cookie('token','',-1);

        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Something Went Wrong',
            ] );
        }

    }


    public function logOut(){
        return redirect('/login')->cookie('token', '', -1);
    }

}
