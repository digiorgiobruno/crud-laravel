<?php

namespace App\Http\Controllers;

use App\Models\CheckInOut;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Support\Arr;

class ControlHorarioController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getUserInfo(Request $request){
       
        if(isset($request->cuil)){
            $cuil=$request->cuil;    
        }else{
            if(isset($request->consulta)&&$request->consulta){
                $cuil=$request->cuil;
            }else{
                $cuil=$request->user()->cuil;
            }
        }

        $ultimo=substr($cuil, -1);
        $primeros=substr($cuil,0, 2);
        $medio=substr($cuil, -9, 8);
        $cuil=$primeros."-".$medio."-".$ultimo;
        //dump($request->opcion);
         if($request->opcion==1){$opcion=false; }else{ 
            $opcion=true;
        }
        //dump($request->opcion);    */

        $fichadas = DB::connection('sqlsrv')->table('CheckInOut')
        ->join('USERINFO', 'CheckInOut.USERID', '=', 'USERINFO.USERID')
        ->select('CheckInOut.USERID', 'CheckInOut.CHECKTIME', 'CheckInOut.CHECKTYPE', 'USERINFO.NAME', 'USERINFO.TITLE','USERINFO.SSN')
        ->where('USERINFO.SSN', $cuil)->orderBy('CheckInOut.CHECKTIME', 'DESC');


        if($request->get('Filtrar')!=null && $request->get('to_date')!=null && $request->get('from_date')!=null || $request->get('Filtrar')=='limpiar'){

            $from_date=$request->get('from_date');
            $to_date=$request->get('to_date');  
            //datos que volveran a visualizarse en el formulario
            $datos['from_date']=$from_date;
            $datos['to_date']=$to_date;
            //formateamos los datos antes de hacer la consulta
            $from_date=date("d/m/Y",strtotime($from_date));
            $to_date=date("d/m/Y",strtotime($to_date.'23:59:59.999'));
            //Filtro between
            $fichadas=$fichadas->whereBetween('CheckInOut.CHECKTIME', [$from_date, $to_date]); 
        } 

        $datos['fichadas']=$fichadas->get();
        $datos['cuil']=str_replace("-","",$cuil);
        if($fichadas->get()->count()>0){
            //dd($datos['fichadas'][0]->CHECKTIME);
            if($opcion){
                $datos['fichadas']=$this->totalFichadas($datos['fichadas']);
                $datos['opcion']=$opcion;
            }else{
                $datos['fichadas']=$datos['fichadas'];
                $datos['opcion']=$opcion;
            }
            
            
            return view('usuarioFichada.index',$datos);
        }else{
            if(isset($request->consulta)&&$request->consulta){ 
                $datos['mensaje']='No se encontr?? el CUIL.';
            }else{
                $datos['mensaje']='No se encontraron fichadas en ese rango de fechas.';
            }
            
            return view('usuarioFichada.index',$datos);
        }

        //return $datos;
    }
    
    public function totalFichadas($fichadas){
        $c=0;
        $i=0;
        //$newFichada[$i]=$fichadas[0]->CHECKTIME;

        $newFichada=array();
        foreach ($fichadas as $key => $marca) {
           
            if($key < count($fichadas) ){
                if(isset($fichadas[$key+1]->CHECKTIME)){ 
                    $fProx=$fichadas[$key+1]->CHECKTIME;
                    $fechaProxima=date("d/m/Y",strtotime($fProx));
                }else{
                    $fechaProxima="";
                }
                $fecha=date("d/m/Y",strtotime($marca->CHECKTIME));
                $hora=date("H:i:s",strtotime($marca->CHECKTIME));

                if($fecha == $fechaProxima){
                    $newFichada[$i]=$fichadas[$key];
                    $newFichada[$i]->FECHA = $fecha;
                    $marcaDia[$c]=$hora;
                    $c++;
                }else{
                    $marcaDia[$c]=$hora;
                    if(!isset($newFichada[$i])){
                        $newFichada[$i]=$fichadas[$key];
                        $newFichada[$i]->FECHA = $fecha;
                    }
                    $newFichada[$i]->HORA=$marcaDia; 
                    $c++;
                    
                    
                    $total='0';
                    $cartel="";
                    //dump($newFichada);
                    //dump($marcaDia);
                    if((count($marcaDia)%2)==0){
                        
                   //dump($marcaDia);
                   /* dump($newFichada); */
                    for ( $k=0;  $k < count($marcaDia) ;  $k++) { 
                    
                            if(isset($marcaDia[$k+1]) && isset($marcaDia[$k])){
                                try {
                                    $resta= abs($this->pasarASegundo($marcaDia[$k]) - $this->pasarASegundo($marcaDia[$k+1]));
                                    $total= $total + $resta;
                                    $k+2; 
                                } catch (Exception $e) {
                                     //dump($e);
                                }
                                
                            }
                        }
                        unset($marcaDia);
                        $totalHora=$total/3600;
                        $totalHora=round($totalHora,2);
                        //dump($totalHora);
                        if($totalHora >= 5){
                            $cartel="5 horas cumplidas";
                            $tipo="success";
                            unset($marcaDia);
                        }else{
                            $cartel="No se cumplen 5 horas";
                            $tipo="danger";
                            unset($marcaDia);
                        }
                        $minutos='';
                        $partes=explode('.',$totalHora);
                        if(isset($partes[0])){$horas=$partes[0]." hr";}
                        if(isset($partes[1])){$minutos=round($partes[1]*0.6)." min";}                    
                        $totalHora=$horas." ".$minutos;

                    }else{
                        $cartel="Imposible calcular total faltan marcas";
                        $totalHora="Indefinido";
                        $tipo="warning";
                        unset($marcaDia);
                        
                    }

                    $newFichada[$i]->total=$totalHora;
                    $newFichada[$i]->cartel=$cartel;
                    $newFichada[$i]->tipo=$tipo;
                    $i++;
                    $c=0;    
                }
            }

          
        }
        return $newFichada;

    }

    function pasarASegundo($hora)
    {
        
        list($h, $m, $s) = explode(':', $hora);
        $segs=$s + $m*60 + $h*3600; 
        //dd($segs);
        return  $segs;
    } 


 /*    function sumar($hora1, $hora2)
    {
        //dd($hora1);
        list($h, $m, $s) = explode(':', $hora1);
        
        ///dd('Horas '.$h.' Minutos '.$m.' Segudos '.$s);
        $segs1=$s + $m*60 + $h*3600; 
       

        list($h2, $m2, $s2) = explode(':', $hora2);
        $segs2=$s2 + $m2*60 + $h2*3600; 
        $totalSegs=$segs2+$segs1;
        return gmdate("h:i:s", $totalSegs);
    }  */

    public function getCheckinout(){
        return CheckInOut::all();
    }

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['empleados']=UserInfo::paginate(6);
        return view('empleado.index',$datos);
    }

 
 /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function show(UserInfo $userInfo)
    {
        //

        
    }


}
