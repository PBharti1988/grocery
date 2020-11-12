<?php

namespace App\Exports;

use App\TransactionDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Auth;
use DB;

class PaymentReportExport1 implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($from,$to,$mode)
    {
        $this->from = $from;
        $this->to = $to;
        $this->mode = $mode;

    }
    public function collection()
    {
        //$res_id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id()){
            $res_id= Auth::guard('restaurant')->id();
            }
            else{
               $manager = Auth::guard('manager')->user();
               $res_id=$manager->restaurant_id;
            }
        $data = TransactionDetail::query();
        $data = $data->Join('restaurants', 'restaurants.id', '=', 'transaction_details.restaurant_id')
        ->select('restaurants.name','transaction_details.payment_id','transaction_details.mobile_no','transaction_details.payment_mode','transaction_details.amount',DB::raw('Date(transaction_details.created_at)'))
        ->where('transaction_details.restaurant_id', $res_id)
        ->whereBetween('transaction_details.created_at', [$this->from, $this->to]);
        if ($this->mode !="blank") {
                $data->where('transaction_details.payment_mode', $this->mode);
                }  
        return $data->get();

        // return TransactionDetail::Join('restaurants', 'restaurants.id', '=', 'transaction_details.restaurant_id')
        // ->select('restaurants.name','transaction_details.payment_id','transaction_details.mobile_no','transaction_details.payment_mode','transaction_details.amount',DB::raw('Date(transaction_details.created_at)'))
        // ->where('transaction_details.restaurant_id', $res_id)
        // ->whereBetween('transaction_details.created_at', [$this->from, $this->to]);
        // if (!empty($this->mode)) {
        //     $data->where('transaction_details.payment_mode', $this->mode);
        //     }
        // ->get();
    }

    public function headings(): array
    {
        return [
            'Restaurant Name','Payment ID','Mobile Number','Payment Mode','Amount','Order Date'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(15);
            },
        ];
    }
}
