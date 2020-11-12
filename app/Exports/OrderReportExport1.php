<?php

namespace App\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Auth;

class OrderReportExport1 implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
      
    public function __construct($from,$to,$mode)
    {
        $this->from = $from;
        $this->to = $to;
        $this->mode =$mode;
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
         $data=Order::query();
         $data=$data->select('orders.order_id','orders.payment_id','orders.name','restaurants.name as restaurant_name','orders.mobile_no','orders.address','order_statuses.name as status_name','orders.sub_total','orders.tax','orders.total')
        ->join('restaurants','restaurants.id','orders.restaurant_id')
        ->join('order_statuses','order_statuses.id','orders.order_status')
        ->whereBetween('orders.created_at', [$this->from, $this->to])
        ->where('orders.restaurant_id',$res_id);
        if ($this->mode !="blank") {
            $data->where('orders.order_status', $this->mode);
            }  
        return $data->get();
    }

    public function headings(): array
    {
        return [
            'Order ID','Payment ID','Name','Restaurant','Mobile Number','Address','Order Status','Sub Total','Tax','Total'
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
