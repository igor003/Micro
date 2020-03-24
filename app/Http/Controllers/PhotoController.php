<?php

namespace App\Http\Controllers;


use App\Part;
use App\Photo;
use App\Project;
use App\Miniaplicator;
use App\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use PHPExcel_Writer_Excel5;
use ZipArchive;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $projects = Project::orderBy('name','asc')->get();
        $codice = Part::orderBy('name','ASC')->get();
        $minis = Miniaplicator::all();
        $machines = Machine::all();
        $route = \Route::current();
        $codice_id = $route->parameter('codiceid');
        return view('photo_list',['projects'=>$projects,'codicies'=>$codice,'codice_id'=>$codice_id,'minis'=>$minis, 'machines'=>$machines]);
    }

    public function photo_list(Request $request){
        $curent_page = $request->cur_page;
        $photos= Photo::select('*');

        $total_photo = count(Photo::select('*')->get());
       
        if($request->date_from && $request->date_to){
            $photos->date($request->date_from, $request->date_to);
        }
        if($request->project != ''){
            $photos->project($request->project);
        }
        if($request->codice != ''){
            $photos->codice($request->codice);
        }
        if($request->mini != ''){
            $photos->mini($request->mini);
        }
        if($request->machine != ''){
            $photos->machine($request->machine);
        }
        
        $photos->with('configurations.codice.project')->with('configurations.connector')->with('minis')->with('machines');
        // exit( $photos->with('configurations.codice.project')->with('configuration.connector'));
        $total_photo_with_filter =  $photos->with('configurations.codice.project')->get();
        $schip = ($request->cur_page - 1)*$request->per_page;

        if($request->config_id){
          $photos = $photos->where('configuration_id',$requestconfig_id)->take($request->per_page)->orderBy('maked_at', 'desc')->skip($schip)->get();
        }else{
          $photos = $photos->take($request->per_page)->orderBy('maked_at', 'desc')->skip($schip)->get();
        }
        if(Auth::user()->status == 'admin'){
          $admin = true;
        }else{
          $admin = false;
        }
       return array("photos"=>$photos,"total_count"=>$total_photo,'total_photo_with_filter'=>$total_photo_with_filter,'admin'=>$admin);
    }

    public function download_photo( Request $request){
        $files = [];
        $files[] = $request->photo_1;
        $files[] = $request->photo_2;
        $files[] = $request->photo_3;
        $storagePath  = Storage::disk('images')->getDriver()->getAdapter()->getPathPrefix();

        $zipname = 'file.zip';
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($files as $file) {
            $zip->addFile($storagePath.$file,basename($file));
        }
        
        $zip->close();
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='.$zipname);
        header('Content-Length: ' . filesize($zipname));
        readfile($zipname);
    }

    public function delete_photo($id){
        $photo = Photo::find($id);
        $dir = str_replace(basename($photo->foto1),'',$photo->foto1);
        Storage::disk('images')->deleteDirectory($dir);
        $photo->delete();

        return redirect()->route('photo_list_view');
    }

    public function raport_view(){
        $parts = Part::all();
        $projects = Project::all();
        return view('photo_raport',['parts'=>$parts,'projects'=>$projects]);
    }

    public function raport(Request $request){
      $photoss = Photo::select('*');
      if($request->date_from && $request->date_to){
        $photoss->raport($request->date_from,$request->date_to);
      }
      if(!is_null($request->part)){
        $photoss->configuration($request->part);
      }
        $raport = $photoss->get();     
      // Создаем объект класса PHPExcel
      $xls = new PHPExcel();
// Устанавливаем индекс активного листа
      $xls->setActiveSheetIndex(0);
// Получаем активный лист
      $sheet = $xls->getActiveSheet();
// Подписываем лист
      $sheet->setTitle('Таблица умножения');
// Вставляем текст в ячейку A1
      $sheet->setCellValue("A1", 'Raport Micrografia');
      $sheet->setCellValue("A2", 'Data');
      $sheet->setCellValue("B2", 'Project');
      $sheet->setCellValue("C2", 'Codice');
      $sheet->setCellValue("D2", 'Terminal/Splice');
      $sheet->setCellValue("E2", 'Configuration');
      $sheet->setCellValue("F2", 'Miniaplicator');
      $sheet->setCellValue("G2", 'Preseta');
      $sheet->getColumnDimension('A')->setAutoSize(true);
      $sheet->getColumnDimension('B')->setAutoSize(true);
      $sheet->getColumnDimension('C')->setAutoSize(true);
      $sheet->getColumnDimension('D')->setAutoSize(true);
      $sheet->getColumnDimension('E')->setAutoSize(true);
      $sheet->getColumnDimension('F')->setAutoSize(true);
      $sheet->getColumnDimension('G')->setAutoSize(true);
      $sheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
      $sheet->getStyle('A1')->getFill()->getStartColor()->setRGB('EEEEEE');
      $sheet->getStyle('A1')->getFont()->setSize(18);
      $sheet->getRowDimension(1)->setRowHeight(25);
      $sheet->getRowDimension(2)->setRowHeight(25);
      $rows = 3;
      $cnt = 0;
      $count_photo = count($raport);
      while($rows< $count_photo+3){
        $sheet->setCellValue('A'.$rows, $raport[$cnt]->maked_at);
        $sheet->setCellValue("B".$rows, $raport[$cnt]->configurations[0]->codice->project->name);

        $sheet->setCellValue("C".$rows, $raport[$cnt]->configurations[0]->codice->name);
        $sheet->setCellValue("D".$rows, $raport[$cnt]->configurations[0]->connector->name);
        $sheet->setCellValue("E".$rows, $raport[$cnt]->configurations[0]->components);
        if($raport[$cnt]->minis){
           $sheet->setCellValue("F".$rows, $raport[$cnt]->minis->name);
        }else{
           $sheet->setCellValue("F".$rows, "---");
        }
        if($raport[$cnt]->machines){
            $sheet->setCellValue("G".$rows, $raport[$cnt]->machines->number);
        }else{
           $sheet->setCellValue("G".$rows, "---");
        }
       
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
// заголовки
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rapot Micrografii '.$request->date_from.'<->'.$request->date_to.'.xls"');
        header('Cache-Control: max-age=0');
// Do your stuff here
        $writer = PHPExcel_IOFactory::createWriter($xls, 'Excel5');
// This line will force the file to download
        $writer->save('php://output');
    }
}
