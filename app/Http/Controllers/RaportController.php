<?php
namespace App\Http\Controllers;
use App\Part;
use Illuminate\Http\Request;
use PHPExcel;
use PHPExcel_IOFactory;
use App\Photo;
use App\Raport;
use Illuminate\Support\Facades\DB;
class RaportController extends Controller
{

	public function generate_custome_html_tooltyp($operator,$date_from,$date_to,$diff){
		$result = '<div style="padding: 12px 12px 12px 12px;font-size:13px">
						<div class ="text-center" style="line-height:12px;">
							<strong> Operator:</strong> <br>'.$operator.'
						</div>
						<div class ="text-center" style="line-height:12px; padding-top:15px">
							<strong>From:</strong> '.$date_to.'	<br>
							<strong>To:</strong> '.$date_from.'
						</div>
						<div style="font-size:20px;line-height:24px; padding-top:15px" class ="text-info text-center">
						<strong>'.$diff.'</strong>
						</div>
				   </div>';
	   return $result;
	}
	public  function get_data_exec_time(Request $request){
		
		$date = $request->date;
    	
		if($date){
		    $dates = $this->dates_of_micross($date,1);
		    	
		}else{
			$dates = $this->dates_of_micross(date("Y-m-d"),1);
			$date = date("Y-m-d");
		}	

	    $result = array();
		$cnt = 1;
		$summ_difer = 0;
		foreach ($dates as $key=>$date1) {

			$time_start = new \DateTime($date1[0]);
			$time_done = new \DateTime($date1[1]);
			$summ_difer +=abs(strtotime($date1[0]) - strtotime($date1[1]));
		
		  	$diff_min = intdiv(abs(strtotime($date1[0]) - strtotime($date1[1])),60);
		  	$diff_sec = abs(strtotime($date1[0]) - strtotime($date1[1]))-($diff_min*60);

		  	$result[0][] = [$cnt,round($diff_min,1,PHP_ROUND_HALF_UP),$this->generate_custome_html_tooltyp($date1[2],
		  																								$time_done->format('H:i:s'),
		  																								$time_start->format('H:i:s'),
		  																								$diff_min.'min '.$diff_sec.'sec')]; 
			$cnt++;
			
		}
			 	$result[1] =  round($summ_difer / count($dates)/60,1,PHP_ROUND_HALF_UP);
		return $result;
	}
	// public  function get_data_exec_time($date){
	// 	if($date){
	// 	    $dates = $this->dates_of_micross($date,1);
		    	
	// 	}else{
	// 		$dates = $this->dates_of_micross(date("Y-m-d"),1);
	// 		$date = date("Y-m-d");
	// 	}	

	//     $result = array();
	// 	$cnt = 1;
	// 	foreach ($dates as $key=>$date1) {
	// 		$time_start = new \DateTime($date1[0]);
	// 		$time_done = new \DateTime($date1[1]);
		
	// 	  	$diff_min = intdiv(abs(strtotime($date1[0]) - strtotime($date1[1])),60);
	// 	  	$diff_sec = abs(strtotime($date1[0]) - strtotime($date1[1]))-($diff_min*60);

	// 	  	$result[] = [$cnt,round($diff_min,1,PHP_ROUND_HALF_UP),$this->generate_custome_html_tooltyp($date1[2],
	// 	  																								$time_done->format('H:i:s'),
	// 	  																								$time_start->format('H:i:s'),
	// 	  																								$diff_min.'min '.$diff_sec.'sec')]; 
	// 		$cnt++;
			
	// 	}
	// 	return $result;
	// }

	public function execut_time_report(){

		return view('execut_raport_view');
	}

	public function yearly_report(){
		$months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
		$years_data = $this->get_distinct_year();
		$years = [];
	 	foreach($years_data as $year_data){
			$years[] = $year_data['year'];
	 	}
		$route = \Route::current();
		if($route->parameter('year')){
	 		$year = $route->parameter('year');
  		}else{
  			$year = date('Y');
  		}	
  		$cnt = 1;
  		$count_month = array();
  		for ($cnt = 1; $cnt <= 12; $cnt++) {

  			$count_month[$cnt][] =  $months[$cnt-1];
    		$count_month[$cnt][] = Photo::whereMonth('maked_at', '=', str_pad($cnt, 2, '0', STR_PAD_LEFT))->whereYear('maked_at', $year)->count();
		}
  			
  			 array_unshift($count_month,array("date","number of micrography"));
		return view('yearly_raport_view',['years'=>$years,'cur_year'=>$year,'fotos'=>$count_month]);
	}
	public function monthly_report() {
	 	$months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
	 	$years_data = $this->get_distinct_year();
	 	$years = [];
	 	foreach($years_data as $year_data){
			$years[] = $year_data['year'];
	 	}
	 	$route = \Route::current();
	 	if($route->parameter('month')){
	 		$month = $route->parameter('month');
	 	}else{
	 		$month = date('m');
	 	}
	 	if($route->parameter('year')){
	 		$year = $route->parameter('year');
  		}else{
  			$year = date('Y');
  		}	
    	$fotos_dates = $this->months_count_micros($month,$year);
		
    	
    	
    	$foto_dates = [];
        $cnt = 1;
	
    	foreach ($fotos_dates as $foto_date) {
    	
    		$caunt = Photo::where('maked_at','LIKE',''.$foto_date['date'].'%')->count();
			$foto_caunt[] = [$foto_date['date'],$caunt];
    	}
	    array_unshift($foto_caunt,array("date","number of micrography"));
		return view('monthly_raport_view',['years'=>$years,'months'=>$months,'fotos'=>$foto_caunt,'cur_month'=>$months[$month-1], 'cur_year'=>$year]);
	}
	
	public function get_distinct_year(){
		$years = Photo::whereNotNull('created_at')->distinct()->get([DB::raw('YEAR(created_at) as year')]);
		return $years;
	}
	public function months_count_micros($month,$year){
		
		if($month && $year){
		 	$fotos_dates = Photo::whereMonth('maked_at','=',$month)
				->whereYear('maked_at', $year)
				->whereNotNull('maked_at')
				->distinct()
				->get([DB::raw('DATE(maked_at) as date')]);
		}else if($month){
			$fotos_dates = Photo::whereMonth('maked_at','=',$month)
				->whereYear('maked_at',  Date('Y'))
				->whereNotNull('maked_at')
				->distinct()
				->get([DB::raw('DATE(maked_at) as date')]);
		}else{
			$fotos_dates = Photo::whereMonth('maked_at','=',Date("m"))
				->whereYear('maked_at',  Date('Y'))
				->whereNotNull('maked_at')
				->distinct()
				->get([DB::raw('DATE(maked_at) as date')]);
		}
		return $fotos_dates;
	}

	public function dates_of_micross($date,$flag){
		
		if($date){
			$fotos = Photo::whereDate('maked_at','=',$date)
				->whereYear('maked_at', Date('Y'))
				->with('configurations.codice')
			    ->orderBy('maked_at', 'asc')
				->get();
		}else{
			$fotos = Photo::whereDate('maked_at','=',date("Y-m-d"))
				->whereYear('maked_at', Date('Y'))
				->with('configurations.codice')
			    ->orderBy('maked_at', 'asc')
				->get();
		}
          
		$dates = array();
		$dates_codice= array();
		$cnt=0;
		foreach($fotos as $photo){

			$dates[$cnt]['date']=$photo->maked_at;
			$dates[$cnt]['operator'] = $photo->operator;
			$dates[$cnt]['start_time'] = $photo->start_time;
			$cnt++;

		};
	
		$cnt = 0;
		foreach ($dates as $dates1) {

			$dates_codice[$cnt]['date'] = $dates1['date'];
			$dates_codice[$cnt]['start'] = $dates1['start_time'];
			$dates_codice[$cnt]['operator'] = $dates1['operator'];
			$cnt++;

		}
		
		$jsArray1 = array();
		$cnt=1;
		$summ_diff = 0;
		foreach($dates_codice as $array) {
			if($flag == 0){
				$time_start = new \DateTime($array['start']);
				$time_done = new \DateTime($array['date']);
			  	$diff_min = intdiv(abs(strtotime($array['date']) - strtotime($array['start'])),60);
			  	$diff_sec = abs(strtotime($array['date']) - strtotime($array['start']))-($diff_min*60);
			  	$summ_diff += abs(strtotime($array['date']) - strtotime($array['start']));
		  		$jsArray1[] = array((string)$array['operator'],

		  							(string)$array['start'],
	  								(string)$array['date'],
		  							$this->generate_custome_html_tooltyp($array['operator'],
		  																 $time_done->format('H:i:s'),
																		 $time_start->format('H:i:s'),
		  																 $diff_min.'min '.$diff_sec.'sec')
		  							); 
		  		
			}else if($flag == 1){
				$jsArray1[] = array((string)$array['date'],(string)$array['start'],(string)$array['operator']); 
			}
		    $cnt++;
		   
		}

	
		return $jsArray1;
	}
	public function get_compare_view(){
		$route = \Route::current();
    	$codice_id = $route->parameter('date');
		
    	if($codice_id){
			$date = $this->dates_of_micross($codice_id,0);
    	}else{
			$date = $this->dates_of_micross(date('Y-m-d'),0);
			
		}
		
        return view('raport_view',['jsArray1'=>$date]);
    }

    public function generate_raport(Request $request){

    	$filename = $request->file('document')->getClientOriginalName();
    	$path = $request->file('document')->storeAs('public\\uploads\\', $filename);
		
    	$file_name = "storage/uploads/".basename($filename);
		$type = PHPExcel_IOFactory::identify($file_name);
		$objReader = PHPExcel_IOFactory::createReader($type);
		$objPHPExcel = $objReader->load($file_name);

		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
		    $worksheets = $worksheet->toArray();
		}
		$parts = Part::all()->toArray();
		$parts_name = [];

		$cnt = 0;
		while($cnt<count($parts)){
			$parts_name[] = $parts[$cnt]['name'];
			$cnt++;
		}

		$parts_name_xls = [];
		$cnt1 = 0;
		while($cnt1<count($worksheets)){
			if($worksheets[$cnt1][0] == NULL){
				$cnt1++;
				continue;
			}
			$parts_name_xls[] = $worksheets[$cnt1][0];
			$cnt1++;
		}

		$parts_with_micro = [];
		$count_parts = count($parts_name_xls);
		
		$flag = 0;
		foreach($parts_name_xls as $key => $part_xls){
			foreach($parts_name as $key1 => $part_name) {
				if(stristr($part_xls,$part_name)){
					$parts_with_micro[] = $part_name;
					$flag = 1;
					break;
				}
			}
			if($flag){
				unset($parts_name_xls[$key]);
			}
			$flag=0;
		}
	
		$photos = Photo::where('maked_at',$request->data_raport)->orWhere('maked_at','like',$request->data_raport.'%')->with('configurations.codice')->orderBy('maked_at', 'asc')->get();	 
		$parts_names = array();
			foreach ($photos as $photo){
			 	$parts_names[] = ($photo->configurations[0]->codice['name']);
			 	
			}
        $flag2 = 0;
        $difference = array();
        $parts_with_micro_copy = $parts_with_micro;
        $parts_names_copy = $parts_names;
		foreach($parts_with_micro_copy as $key=>$parts){
			foreach($parts_names_copy as $key1=>$parts_n){
				if($parts === $parts_n){
					$flag2 = 1;
					unset($parts_names_copy[$key1]);
					break;
				}
			}
			if($flag2){
				unset($parts_with_micro_copy[$key]);
			}
			$flag2 = 0;
		}

		return view('raport_list',['parts_micro'=>$parts_with_micro,'parts'=>$count_parts, 'parts_efectuated'=>$parts_names, 'difference'=>$parts_with_micro_copy, 'data_raport'=>$request->data_raport]);

    }

	public function create_report(Request $request){
	
		$report = new Raport;
        $report->total_micr = $request->total_micr;
        $report->efectuated_micr = $request->efectuated_micr;
        $report->total_launch = $request->total_launch;
        $report->date = $request->date;
        $report->save();
        return redirect('/home');
	}


	public function get_all(){
		$reports = Raport::all();
		return $reports;
	} 
	
    public function report_list_view(){
    	$reports = Raport::all();
 		return view('raport_list_view',['reports'=>$reports]);
    }
}