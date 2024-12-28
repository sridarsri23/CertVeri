<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
 
use App\Exports\CertExport;
 
 
use Maatwebsite\Excel\Facades\Excel;
 
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;
class ExcelCSVController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function index()
    {
       return view('excel-csv-import');
    }
    

 
    /**
    * @return \Illuminate\Support\Collection
    */
    public function exportExcelCSV($slug) 
    {
         //log
         $user = Auth::user();
         $this->logUserActivity($user->name." Exported Certificates");
        return Excel::download(new CertExport, 'certificates.'.$slug);
           
            
    
    }
    private function logUserActivity($message)
    {
        // Log user activity to Laravel log
        \Illuminate\Support\Facades\Log::info($message);
    }

}