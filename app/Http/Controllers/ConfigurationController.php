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
        
        return view('configuration_list',['projects'=>$projects,'codice_id'=>$codice_id,'connectors'=>$conneectors]);
    }

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
        else if($request->filter != ''){
            $conf = Configuration::whereHas('codice',function ($query) use($request) {
                $query->whereIn('project_id',$request->filter);
            })->with('codice')->with('connector')->get();
            return array('conf'=>$conf,'admin'=>$admin);
        }
        else if($request->filter2 != ''){
             $conf = Configuration::whereHas('connector',function ($query) use($request) {
                $query->where('id',$request->filter2);
            })->with('codice')->with('connector')->get();
            return array('conf'=>$conf,'admin'=>$admin);
        }
        $conf = Configuration::with(array('codice' => function($query){
            $query->orderBy('name','DESC');
        }))->with('connector')->get();
           // $conf = Configuration::with('codice')->orderBy('codice.name','')->with('connector')->get();
        
        
      return array('conf'=>$conf,'admin'=>$admin);
    }

    public function  upload_foto_view(Request $request){
        $conf = Configuration::where('id','=',$request->id)->with('codice.project')->with('connector')->get();

        
        $minis = Miniaplicator::all();
        $machines = Machine::all();
        return view('upload_view',['conf'=>$conf,'minis'=>$minis, 'machines'=>$machines]);
    }

    public function upload_photo(Request $request){
       
        if($request->maked_at != ''){
            $date = $request->maked_at;
        }else{

            $date = date('Y-m-d H-i');
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
    public function update(Request $request){
        $config = Configuration::find($request->id);
        $config->part_id = $request->codice_configuration;
        $config->components=$request->components;
        $config->connector_id=$request->connector;
        $config->sez_components=$request->sez_components;
        $config->nr_strand=$request->amount_strands;
        $config->height=$request->height;
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

    public function get_excell(){
        $conf = Configuration::with('codice')->with('connector')->get();

        $xls = new PHPExcel();
// Устанавливаем индекс активного листа
        try {
            $xls->setActiveSheetIndex(0);
        } catch (\PHPExcel_Exception $e) {
        }
// Получаем активный лист
        $sheet = $xls->getActiveSheet();
// Подписываем лист
        $sheet->setTitle('Configuration list');
// Вставляем текст в ячейку A1
        $sheet->setCellValue("A1", 'TABELA AGRAFATURILOR CU MICROGRAFIE LA FIECARE LOT');
        $sheet->setCellValue("A2", 'Codice');
        $sheet->setCellValue("B2", 'Grup agrafat');
        $sheet->setCellValue("C2", 'Splice/Terminal');
        $sheet->setCellValue("D2", 'Sectiune');
        $sheet->setCellValue("E2", 'Inaltimea agrafaturii');
        $sheet->setCellValue("F2", 'Latimea agrafaturii');
        $sheet->setCellValue("G2", 'Nr lite');
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setRGB('EEEEEE');
        $sheet->getStyle('A2')->getFill()->getStartColor()->setRGB('84, 157, 1');
        $sheet->getStyle('B2')->getFill()->getStartColor()->setRGB('84, 157, 1');
        $sheet->getStyle('C2')->getFill()->getStartColor()->setRGB('84, 157, 1');
        $sheet->getStyle('D2')->getFill()->getStartColor()->setRGB('84, 157, 1');
        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->getRowDimension(2)->setRowHeight(25);
        $rows = 3;
        $cnt = 0;
        $count_conf = count($conf);
        while($rows< $count_conf+3){
            $sheet->setCellValue('A'.$rows, $conf[$cnt]->codice->name);
            $sheet->setCellValue("B".$rows, $conf[$cnt]->components);
            $sheet->setCellValue("C".$rows, $conf[$cnt]->connector->name);
            $sheet->setCellValue("D".$rows, $conf[$cnt]->sez_components);
            $sheet->setCellValue("E".$rows, $conf[$cnt]->height);
            $sheet->setCellValue("F".$rows, $conf[$cnt]->width);
            $sheet->setCellValue("G".$rows, $conf[$cnt]->nr_strand);
            $sheet->getRowDimension($rows)->setRowHeight(25);
            $sheet->getStyle('A'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G'.$rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $rows++;
            $cnt++;
        }
// Объединяем ячейки
        $sheet->mergeCells('A1:G1');
// Выравнивание текста
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $xls->getActiveSheet()->getStyle(
            'A2:' .
            $xls->getActiveSheet()->getHighestColumn() .
            $xls->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


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