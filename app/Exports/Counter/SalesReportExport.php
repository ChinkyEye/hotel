<?php

namespace App\Exports\Counter;

use App\Order_detail;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use Auth;

class SalesReportExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize,WithStyles, WithEvents
{
    use Exportable, RegistersEventListeners;
    /**
    * @return \Illuminate\Support\Collection
    */
    private $bill_id = NULL;
    private $user_type = NULL;
    private $table_id = NULL;
    private $bill_type = NULL;
    private $start_date = NULL;
    private $end_date = NULL;
    public function __construct($bill_id, $user_type, $table_id, $bill_type, $start_date, $end_date)
	{
		if($bill_id!="") $this->bill_id = $bill_id;
		if($user_type!="") $this->user_type = $user_type;
		if($table_id!="") $this->table_id = $table_id;
		if($bill_type!="") $this->bill_type = $bill_type;
		if($start_date!="") $this->start_date = $start_date;
		if($end_date!="") $this->end_date = $end_date;
	}

    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('Logo');
    //     $drawing->setDescription('This is my logo');
    //     // $drawing->setPath(public_path('/image/logo.png'));
    //     $drawing->setHeight(90);
    //     $drawing->setCoordinates('B3');

    //     return $drawing;
    // }

    public function columnWidths(): array
    {
        return [
            // 'A' => 55,
            // 'B' => 45,       
            // 'C' => 55,       
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // return [
            // 1    => ['font' => ['bold' => true]],
            // 4    => ['font' => ['bold' => true]],
        // ];
        $sheet->getStyle('4')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('A3:D3');
    }

    public function query()
    {
        $orders = Order_detail::query();
	    $orders = $orders->orderBy('id','DESC')->where('bill_type','!=','2')->where('receive_type','0')->where('is_confirmed','1')->where('created_by',Auth::user()->id);
	    if($this->bill_id != NULL)
	      {            
	        $orders = $orders->where('bill_id', 'LIKE',"%{$this->bill_id}%");
	      }
	    if($this->user_type != NULL)
	      {
	        $orders = $orders->where('usertype_id','LIKE',"%{$this->user_type}%");
	      }
	    if($this->table_id != NULL)
	      {
	        $orders = $orders->where('table_id',$this->table_id);
	      }
	    if($this->bill_type != NULL){
	        $orders = $orders->where('bill_type',$this->bill_type);
	    }
	    if(($this->start_date != NULL) || ($this->end_date != NULL))
	      {
	        $orders = $orders->whereBetween('date', [$this->start_date, $this->end_date]);
	      }
	    $orders = $orders->with('customer','usertype','table');
        return $orders;
    }

    public function map($order): array
    {
        return [
            [
                $order->customer->name,
                $order->usertype->name,
                $order->bill_id,
                $order->table->name, 
                $order->total,
                $order->discount,
                $order->received, 
                $order->grand_total - $order->received, 
                $order->created_at,
            ],
        ];
    }

    public function headings(): array
    {
        return [
            [
                'Restaurant Management',
            ],
            [
                'Bhupi Marga',
            ],
            [
                'Biratnagar'
            ],
            [
                'Customer name',
                'Type',
                'Bill ID',
                'Table',
                'Total(Rs)',
                'Discount(Rs)',
                'Received(Rs)',
                'Due(Rs)',
                'Date',
            ],
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        $highestRow = $event->sheet->getHighestRow()+1;
        $secondHighestRow = $event->sheet->getHighestRow();
        $event->sheet->getCellByColumnAndRow(1,$highestRow)->setValue("Total: ");
        $event->sheet->getCellByColumnAndRow(5,$highestRow)->setValue("=SUM(E5:E$secondHighestRow)");
        $event->sheet->getCellByColumnAndRow(6,$highestRow)->setValue("=SUM(F5:F$secondHighestRow)");
        $event->sheet->getCellByColumnAndRow(7,$highestRow)->setValue("=SUM(G5:G$secondHighestRow)");
        $event->sheet->getCellByColumnAndRow(8,$highestRow)->setValue("=SUM(H5:H$secondHighestRow)");
        $event->sheet->mergeCells("A$highestRow:D$highestRow");
    }

    
}
