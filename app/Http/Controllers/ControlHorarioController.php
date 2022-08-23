<?php

namespace App\Http\Controllers;

use App\Models\CheckInOut;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ControlHorarioController extends Controller
{
    public function getUserInfo(Request $request){
        
        
        $fichadas = DB::connection('sqlsrv')->table('CheckInOut')
        ->join('USERINFO', 'CheckInOut.USERID', '=', 'USERINFO.USERID')
        ->select('CheckInOut.USERID', 'CheckInOut.CHECKTIME', 'CheckInOut.CHECKTYPE', 'USERINFO.NAME', 'USERINFO.TITLE','USERINFO.SSN')
        ->where('USERINFO.SSN', '20-11629269-7')->orderBy('CheckInOut.CHECKTIME', 'DESC');


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
     
        if($fichadas->get()->count()>0){
            return view('usuarioFichada.index',$datos);
        }else{
            $datos['mensaje']='No se encontraron fichadas en ese rango de fechas.';
            return view('usuarioFichada.index',$datos);
        }

        //return $datos;
    }
    

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
