<?php 
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\Models;
use Maatwebsite\Excel\Concerns\Exportable;

class ExportLogtime implements FromView
{
    protected $fromDate;
    protected $toDate;
    public function __construct($fromDate, $toDate){
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }
    public function view():View{        
            $date_start =  date('Y-m-d H:i:s', strtotime($this->fromDate));
            $date_end   = date('Y-m-d H:i:s', strtotime($this->toDate));
            $data = Models\Logtime::with('m_user')->where('user_id', '!=' , 1)->whereBetween('created_at',[$date_start,$date_end])
            ->orderBy('created_at','asc')
            ->get();
        return view('theme.admin.section.exportexcel.logtime')->with(['list' => $data]);
    }
}