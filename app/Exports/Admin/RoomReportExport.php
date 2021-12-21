<?php

namespace App\Exports\Admin;

use App\Room;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;

class RoomReportExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $orders = Room::orderBy('id','DESC');
       
        $orders = $orders->get();
        $actualdata = $orders->map(function($order){
            return [$order->room_type,$order->room_no,$order->no_of_bed,$order->price];
        });
        return $actualdata;
    }

    public function headings(): array
    {
        return [
            // '#',
            'Room Type',
            'Room No',
            'No of Bed',
            'Price/Rate',
        ];
    }
}
