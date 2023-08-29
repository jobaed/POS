<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller {

    public function reportPage() {
        return view( 'Frontend.pages.dashboard.report' );
    }

    public function SalesReport( Request $request ) {

        $user_id = $request->header( 'id' );
        $FormDate = date( 'Y-m-d', strtotime( $request->FormDate ) );
        $ToDate = date( 'Y-m-d', strtotime( $request->ToDate ) );

        $total = Invoice::where( 'user_id', $user_id )->whereDate( 'created_at', '>=', $FormDate )->whereDate( 'created_at', '<=', $ToDate )->sum( 'total' );
        $vat = Invoice::where( 'user_id', $user_id )->whereDate( 'created_at', '>=', $FormDate )->whereDate( 'created_at', '<=', $ToDate )->sum( 'vat' );
        $payable = Invoice::where( 'user_id', $user_id )->whereDate( 'created_at', '>=', $FormDate )->whereDate( 'created_at', '<=', $ToDate )->sum( 'payable' );
        $discount = Invoice::where( 'user_id', $user_id )->whereDate( 'created_at', '>=', $FormDate )->whereDate( 'created_at', '<=', $ToDate )->sum( 'discount' );
        $list = Invoice::where( 'user_id', $user_id )->whereDate( 'created_at', '>=', $FormDate )->whereDate( 'created_at', '<=', $ToDate )->with( 'customer' )->get();

        $data = ['payable' => $payable, 'discount' => $discount, 'total' => $total, 'vat' => $vat, 'list' => $list, 'FormDate' => $request->FormDate, 'ToDate' => $request->FormDate];
        $pdf = Pdf::loadView( 'Frontend.report.SalesReport', $data );
        return $pdf->download( $FormDate . "-to-" . $ToDate . '-Report.pdf' );
        // return $data;

    }
}
