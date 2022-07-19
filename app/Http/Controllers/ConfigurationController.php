<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Http\Requests\ConfigurationRequest;
use App\Photo;
use App\Project;
use App\Part;
use App\Connector;
use App\Miniaplicator;
use App\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use PHPExcel_Worksheet_Drawing;


class ConfigurationController extends Controller
{
    protected $date ;
  
  
    public function index(){
        if(Auth::user()->status == 'admin'){
            $admin = true;
        }else{
            $admin = false;
        }
        $projects = Project::all();
        $codice = Part::all();
        $connectors = Connector::all();

        return view('add_configuration',['projects'=>$projects,'codice'=>$codice,'connectors'=>$connectors]);
    }

    public function insert(ConfigurationRequest $request){
        $configuration = new Configuration;
        $configuration->part_id = $request->codice_configuration;
        $configuration->department = $request->department;
        $configuration->components=$request->components;
        $configuration->connector_id=$request->connector;
        $configuration->sez_components=$request->sez_components;
        $configuration->nr_strand=$request->amount_strands;
        $configuration->height=$request->height;
        $configuration->width = $request->width;
        $configuration->total_sez = $request->total_sez;
        $configuration->save();
        return redirect('/home');
    }
    
    public function get_by_part_id(Request $request){
        return Configuration::where('part_id',$request->part_id)->get();
    }

    public function config_list_view(){

        $route = \Route::current();
        $codice_id = $route->parameter('codiceid');
        $projects = Project::orderBy('name','asc')->get();
        $conneectors = Connector::all();
        $sections = DB::table('part_configuration')
                    ->select('total_sez')
                    ->orderBy('total_sez', 'asc')
                    ->distinct()
                    ->get();
           
        return view('configuration_list',['sections'=>$sections,'projects'=>$projects,'codice_id'=>$codice_id,'connectors'=>$conneectors]);
    }

    // public function config_list(Request $request){
    //     if(Auth::user()->status == 'admin'){
    //             $admin = true;
    //         }else{
    //             $admin = false;
    //     }
    //     if($request->total_sez != ''){

    //         $conf = Configuration::where('total_sez','=',$request->total_sez)->with('codice')->with('connector')->get();
    //         return  array('conf'=>$conf,'admin'=>$admin);
    //     }
    //     if($request->search != ''){
    //         $conf = Configuration::whereHas('codice',function ($query) use($request) {
    //             $query->where('name','like','%'.$request->search.'%');
    //         })->with('codice')->with('connector')->get();
    //         return  array('conf'=>$conf,'admin'=>$admin);
    //     }
    //     else if($request->filter != ''){
    //         $conf = Configuration::whereHas('codice',function ($query) use($request) {
    //             $query->whereIn('project_id',$request->filter);
    //         })->with('codice')->with('connector')->get();
    //         return array('conf'=>$conf,'admin'=>$admin);
    //     }
    //     else if($request->filter2 != ''){
    //          $conf = Configuration::whereHas('connector',function ($query) use($request) {
    //             $query->where('id',$request->filter2);
    //         })->with('codice')->with('connector')->get();
    //         return array('conf'=>$conf,'admin'=>$admin);
    //     }
    //     $conf = Configuration::with(array('codice' => function($query){
    //         $query->orderBy('name','DESC');
    //     }))->with('connector')->get();
          
        
        
    //   return array('conf'=>$conf,'admin'=>$admin);
    // }


    public function config_list(Request $request){
        if(Auth::user()->status == 'admin'){
                $admin = true;
            }else{
                $admin = false;
        }
        if($request->search != ''){
            $conf = Configuration::whereHas('codice',function ($query) use($request) {
                $query->where('name','like','%'.$request->search.'%');
            })->with('codice')->with('connector')->get();
            return  array('conf'=>$conf,'admin'=>$admin);
        }

        $conf = Configuration::select('*');

        if($request->total_sez != ''){

            $conf->section($request->total_sez);
        }
       
        if($request->filter != ''){

            $conf->project($request->filter);

        }

        if($request->filter2 != ''){

            $conf->connectors($request->filter2);
        }
        if($request->department != ''){

            $conf->department($request->department);
        }
      
      $conf = $conf->with('codice.project')->with('connector')->get();
        
         foreach($conf as $configuration){
           
                 $nominal_val = floatval (substr( $configuration['height'], 0, 4));

                 $tollerance = floatval(substr( $configuration['height'], 6, 5));
  
        
                 $measurements =  $this->get_measurements_by_id($configuration['id']);
                
              
        //         if(count($measurements)>2){
        //             $results_capability = $this->capability($measurements,$nominal_val,$tollerance,true);
        //               var_dump($results_capability);
        //         }else{
        //             $results_capability = 0;
        //         }
            
      
         }
        
      return array('conf'=>$conf,'admin'=>$admin);
    }

    public function  upload_foto_view(Request $request){
        $conf = Configuration::where('id','=',$request->id)->with('codice.project')->with('connector')->get();

     
        $minis = Miniaplicator::all();
        $machines = Machine::all();
        return view('upload_view',['conf'=>$conf,'minis'=>$minis, 'machines'=>$machines]);
    }

    public function get_server_date(){
        // return date("Y-m-d H:i:s");
         return  json_encode(date("Y/m/d H:i:s"));
    }

    public function upload_photo(Request $request){
       
        if($request->maked_at != ''){
            $date = $request->maked_at;
        }else{

            $date = date('Y-m-d H-i-s');
        }
        $images = $request->file('images');
        if($images){
        $cnt = 0;
                $path = '\images'.'\\'.$request->project.'\\'.$request->codice.'\\'.$request->components;
//            File::makeDirectory(storage_path().'\images'.'\\'.$request->project.'\\'.$request->codice.'\\'.$request->components);
            Storage::makeDirectory('images/'.$request->project.'/'.$request->codice.'/'.$request->components);
            $image_path = array();
            foreach($images as $image){
                $image_path[] = $image->storeAs($request->project.'\\'.$request->codice.'\\'.$request->components.'\\'.$date, $cnt.'_'.date('Y-m-d').'.'.$image->getClientOriginalExtension(), 'images');
                $cnt++;
            }
            if($request->start_time){
                 $format = "Y/m/d H:i:s";
               $dateobj = \DateTime::createFromFormat($format, $request->start_time);
            }
          
               $foto = new Photo;
               $foto->configuration_id = $request->id;
               $foto->foto1 = $image_path[0];
               $foto->foto2 = $image_path[1];
               $foto->foto3 = $image_path[2];
               $foto->miniaplicator_id = $request->mini;
               $foto->machine_id = $request->machines;
               $foto->height= $request->height_agraf;
               if($request->work_order){
                    $foto->work_order = $request->work_order;
               }
               if($request->start_time){
                   $foto->start_time = $dateobj->format('Y-m-d H:i:s');
               }
               $foto->operator = Auth::user()->name;
               $foto->maked_at = $date;
               $foto->save();

            }
            return redirect(route('conf_list_view'));
    }

    public function update_view($id){

        $cur_config = Configuration::with('codice.project')->where('id','=',$id)->get();
        $projects = Project::all();
        $codice = Part::all();
        $connectors = Connector::all();
        
        return view('update_config_view',['connectors'=>$connectors,'config'=>$cur_config,'projects'=>$projects,'codice'=>$codice]);
    }

    public function capability($array,$nomin_value,$tollerance, $params)
    {
        if(count($array) >2){
            $media =  array_sum($array)/count($array);
            $stand_dev = stats_standard_deviation($array,$params);
            $lsl =  $nomin_value - $tollerance;
            $uls =  $nomin_value + $tollerance;
            $cpl = ($media - $lsl)/(3*$stand_dev);
            $cpu = ($uls - $media)/(3*$stand_dev);
            $cp = round(($uls-$lsl)/(6*$stand_dev),3);
            $cpk = round(min($cpl,$cpu),3);
            return(['cp'=>$cp,'cpk'=>$cpk]);
        }
        return(['cp'=>0,'cpk'=>0]);
        
    }
    public function get_measurements_by_id ($id){
        $measurements = Photo::whereNotNull('height')->where('configuration_id',$id)->get();
        $heights_number = array();
        foreach($measurements as $measurement){
            $heights_number[] = $measurement->height;
        }
        return ($heights_number);
    }

    public function height_measurements_view ($id){
        $cur_configuration = Configuration::where('id',$id)->with('codice')->get();
        $cur_height = floatval (substr($cur_configuration[0]->height, 0, 4));
        $measurements = Photo::whereNotNull('height')->where('configuration_id',$id)->get();

        $heights_distinkt = DB::table('foto')
                            ->whereNotNull('height')
                            ->where('configuration_id','=',$id)
                            ->select('height')
                            ->orderBy('height', 'desc')
                            ->distinct()
                            ->get()
                            ->toArray();
        $photo_count = array();
      
        foreach($heights_distinkt as $height){
            $photo_count[(string)$height->height] = Photo::where([['configuration_id','=',$id],['height','=',(string)$height->height]])->get()->count(); 
        }
        
       $values = array();
      array_unshift($values ,array("Inaltimea","Cantitatea1","Cantitatea2","{role: 'style'}"));
        foreach($photo_count as $key=>$value){
            if($key == $cur_height){
                $values[] = array($key,$value,$value,'#03C836');
            }else{
                $values[] = array($key,$value,$value,'#FFEF00');
            }
            
        }
       
       
 

        $cur_tollerance = floatval(substr($cur_configuration[0]->height, 6, 5));
        $chart_array = array();
        $cnt = 1;
        $heights = array();
        $dates = array();
        $heights_number = $this->get_measurements_by_id($id);
       
        foreach($measurements as $measurement ){
            $heights[$cnt]['height'] = $measurement->height;
            $dates[]= $measurement->maked_at;
            $chart_array[] =array($cnt,$measurement->height,$cur_height - $cur_tollerance,$cur_height + $cur_tollerance);
            $cnt++;
        }
       
            $capability = $this->capability($heights_number,$cur_height,$cur_tollerance,true);
       
      
        return view('height_measurements_view',['measurements'=>$chart_array,'cur_config'=>$cur_configuration,'heights' =>$heights,'dates'=>$dates,'capability'=>$capability,'values'=>$values]);
    }


    public function update(Request $request){
        $config = Configuration::find($request->id);
        $config->department = $request->department;
        $config->part_id = $request->codice_configuration;
        $config->components = $request->components;
        $config->connector_id = $request->connector;
        $config->sez_components = $request->sez_components;
        $config->nr_strand = $request->amount_strands;
        $config->height = $request->height;
        $config->width = $request->width;
        $config->total_sez = $request->total_sez;
        if($config->save() != true){
            $request->session()->flash('error_update', 'Error in update');
            return redirect(route('conf_list_view'));
        }else{
            $request->session()->flash('successfully_update', 'Successfully updated!!');
            return redirect(route('conf_list_view'));
        }
    }
    public function delete(Request $request){

    }

    public function get_excell($project_id = null){
        if($project_id){
            
           $projects =  explode(',',$project_id);
            $conf =Configuration::whereHas('codice',function ($query) use($projects) {
                $query->whereIn('project_id',$projects);
            })->with('codice')->with('connector')->get();

        }else{
           $conf = Configuration::with(['codice' => function ($q) {
  $q->orderBy('name', 'DESC');
}])->with('connector')->get();
        }
        
        $xls = new PHPExcel();
       
// Устанавливаем индекс активного листа
        try {
            $xls->setActiveSheetIndex(0);
        } catch (\PHPExcel_Exception $e) {
        }
// Получаем активный лист
        $sheet = $xls->getActiveSheet();
//добавляем нижний колонтитул ??страница из ??
            $sheet->getHeaderFooter()->setDifferentOddEven(false);
            $sheet->getHeaderFooter()->setOddFooter(' Page &P / &N');
//добавляем сквозные строки при печати
            $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1,2);
//Зум печатной формы
        

//Поля
            $sheet->getPageMargins()->setTop(0.1);
            $sheet->getPageMargins()->setRight(0);
            $sheet->getPageMargins()->setLeft(0);
            $sheet->getPageMargins()->setBottom(0.5);
// Подписываем лист
        $sheet->setTitle('Configuration list');
// Вставляем текст в ячейку A1
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('test_img');
        $objDrawing->setDescription('test_img');
        $objDrawing->setPath('img/SAMMY_logo.jpg');
        $objDrawing->setCoordinates('A1');
        $objDrawing->setResizeProportional(false);
        $objDrawing->setWidthAndHeight(85,44);
        $objDrawing->setOffsetX(4); 
        $objDrawing->setOffsetY(7);                
        $objDrawing->setWorksheet($sheet);


        $sheet->setCellValue("A1", 'TABELA AGRAFATURILOR CU MICROGRAFIE LA FIECARE LOT');
        $sheet->setCellValue("A2", 'Codice');
        $sheet->setCellValue("B2", 'Grup agrafat');
        $sheet->setCellValue("C2", 'Splice / Terminal');
        $sheet->setCellValue("D2", 'Sectiune');
        $sheet->setCellValue("E2", 'Sectiune totala');
        $sheet->setCellValue("F2", 'Inaltimea agrafaturii');
        $sheet->setCellValue("G2", 'Latimea agrafaturii');
        // $sheet->setCellValue("H2", 'Nr lite');

        $sheet->getColumnDimension('A')->setWidth(11);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setWidth(9.3);
        $sheet->getColumnDimension('D')->setWidth(34);
        $sheet->getColumnDimension('E')->setWidth(9);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        // $sheet->getColumnDimension('H')->setWidth(5);


      
        $sheet->getStyle('A1:G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyle('A1:G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        $sheet->getStyle('A2:G2')->getFont()->setSize(11);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('F1')->getFont()->setBold(true);
        $sheet->getStyle('A2:G2')->getFont()->setBold(true);
        
    
        $sheet->getStyle('A1')->getFill()->getStartColor()->setRGB('EEEEEE');
        // $sheet->getStyle('A2')->getFill()->getStartColor()->setRGB('84, 157, 1');
        // $sheet->getStyle('B2')->getFill()->getStartColor()->setRGB('84, 157, 1');
        // $sheet->getStyle('C2')->getFill()->getStartColor()->setRGB('84, 157, 1');
        // $sheet->getStyle('D2')->getFill()->getStartColor()->setRGB('84, 157, 1');
        $sheet->getRowDimension(1)->setRowHeight(42);
        $sheet->getRowDimension(2)->setRowHeight(40);
        $rows = 3;
        $cnt = 0;
        $count_conf = count($conf);
        while($rows< $count_conf+3){
            $sheet->setCellValue('A'.$rows, $conf[$cnt]->codice->name);
            $sheet->setCellValue("B".$rows, $conf[$cnt]->components);
            $sheet->setCellValue("C".$rows, $conf[$cnt]->connector->name);
            $sheet->setCellValue("D".$rows, $conf[$cnt]->sez_components);
            $sheet->setCellValue("E".$rows, $conf[$cnt]->total_sez);
            $sheet->setCellValue("F".$rows, $conf[$cnt]->height);
            $sheet->setCellValue("G".$rows, $conf[$cnt]->width);
            // $sheet->setCellValue("H".$rows, $conf[$cnt]->nr_strand);
            $sheet->getRowDimension($rows)->setRowHeight(20);
           
            $sheet->getStyle('A'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A'.$rows)->getFont()->setBold(true);
            $sheet->getStyle('F'.$rows)->getFont()->setBold(true);
            $sheet->getStyle('G'.$rows)->getFont()->setBold(true);
            $sheet->getStyle('G'.$rows)->getFont()->setSize(10);
            $sheet->getStyle('F'.$rows)->getFont()->setSize(10);
            $sheet->getStyle('F'.$rows)->getFont()->setSize(10);
            $sheet->getStyle('B'.$rows.':E'.$rows)->getFont()->setSize(9);
            $sheet->getStyle('A'.$rows.':G'.$rows)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $sheet->getStyle('H'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $rows++;
            $cnt++;
        }
   $highestColumn =  $sheet->getHighestDataColumn();
          $borderStyle = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
          $cnt = $cnt+2;
        $sheet->getStyle('A1:'. $highestColumn . $cnt)->applyFromArray($borderStyle);
// Объединяем ячейки
        $sheet->mergeCells('A1:G1');
// Выравнивание текста
// 
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:H2')->getAlignment()->setWrapText(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // $xls->getActiveSheet()->getStyle(
        //     'A1:' .
        //     $xls->getActiveSheet()->getHighestColumn() .
        //     $xls->getActiveSheet()->getHighestRow()
        // )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
    
      
//         $objReader = PHPExcel_IOFactory::createReader($inputFileType);
// $objPHPExcel = $objReader->load($inputFileName);
        


// заголовки
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Lista configuratiilor.xls"');
        header('Cache-Control: max-age=0');

// Do your stuff here

        $writer = PHPExcel_IOFactory::createWriter($xls, 'Excel5');

// This line will force the file to download
        $writer->save('php://output');
    }
}