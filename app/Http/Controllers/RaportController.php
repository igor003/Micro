<?php
namespace App\Http\Controllers;
use App\Part;
use Illuminate\Http\Request;
use PHPExcel;
use PHPExcel_IOFactory;
use App\Photo;
class RaportController extends Controller
{
	public function get_compare_view(){
	        return view('raport_view');
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

		foreach($parts_name_xls as $part_xls){
			foreach($parts_name as $part_name) {
				if(stristr($part_xls,$part_name)){
					$parts_with_micro[] = $part_name;
				}
			}
		}
		 
		$photos = Photo::where('maked_at',$request->data_raport)->orWhere('maked_at','like',$request->data_raport.'%')->with('configurations.codice')->orderBy('maked_at', 'asc')->get();	 
		$parts_names = array();
		 foreach ($photos as $photo){
		 	$parts_names[] = ($photo->configurations[0]->codice['name']);
		 }
		 // $cnt= 0;
		 // while($cnt<count($parts_names)){
	 	// 	// $parts_names[$cnt]
	 	// 	 foreach($parts_with_micro as $part_with_micro ){
	 		 	
	 	// 	 }
		 // 	$cnt++;
		 // }
			$difference = array_diff_key($parts_with_micro,$parts_names);
		return view('raport_list',['parts_micro'=>$parts_with_micro,'parts'=>$count_parts, 'parts_efectuated'=>$parts_names, 'difference'=>$difference, 'data_raport'=>$request->data_raport]);

    }
}