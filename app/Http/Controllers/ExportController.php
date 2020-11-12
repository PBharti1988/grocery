<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderReportExport;
use App\Exports\PaymentReportExport;
use App\Exports\OrderReportExport1;
use App\Exports\customerReportExport;
use App\Exports\customerReport1Export;
use App\Exports\PaymentReportExport1;
use Carbon\Carbon;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function orderExport(){
        $name = time().'_orderReportDownload.xlsx';
        return Excel::download(new OrderReportExport, $name);
    }

    public function customerExport(){
        $name = time().'_customerReportDownload.xlsx';
        return Excel::download(new customerReportExport, $name);
    }

    public function paymentExport(){
        $name = time().'_paymentReportDownload.xlsx';
        return Excel::download(new PaymentReportExport, $name);
    }

    public function orderExportCondition($from_date,$to_date,$mode){
        
        $from_date1 = Carbon::parse($from_date)->startOfDay();
        $to_date1 = Carbon::parse($to_date)->endOfDay();
        $name = time().'_orderReportDownload.xlsx';
        return Excel::download(new OrderReportExport1($from_date1,$to_date1,$mode), $name);
    }

    public function customerExportCondition($from_date,$to_date,$mode){
        
        $from_date1 = Carbon::parse($from_date)->startOfDay();
        $to_date1 = Carbon::parse($to_date)->endOfDay();
        $name = time().'_customerReportDownload.xlsx';
        return Excel::download(new customerReport1Export($from_date1,$to_date1,$mode), $name);
    }


    public function paymentExportCondition($from_date,$to_date,$mode){
        
        $from_date1 = Carbon::parse($from_date)->startOfDay();
        $to_date1 = Carbon::parse($to_date)->endOfDay();
        $name = time().'_customerReportDownload.xlsx';
        return Excel::download(new PaymentReportExport1($from_date1,$to_date1,$mode), $name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
