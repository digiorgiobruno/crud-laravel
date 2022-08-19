<?php

namespace App\Http\Controllers;

use App\Models\CheckInOut;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ControlHorarioController extends Controller
{
    //
    public function getUserInfo(Request $request){
        
        
        $fichadas = DB::connection('sqlsrv')->table('CheckInOut')
        ->join('USERINFO', 'CheckInOut.USERID', '=', 'USERINFO.USERID')
        ->select('CheckInOut.USERID', 'CheckInOut.CHECKTIME', 'CheckInOut.CHECKTYPE', 'USERINFO.NAME', 'USERINFO.TITLE','USERINFO.SSN')
        ->where('USERINFO.SSN', '20-11629269-7')->orderBy('CheckInOut.CHECKTIME', 'DESC');
        
        if($request->get('Filtrar')!='null'){

            dump("From date".$request->get('from_date')."  To date".$request->get('to_date'));

            if($request->get('from_date')!='null'){
                $from_date=$request->get('from_date');
            }else{
                //$from_date=(new Carbon)->now()->endOfDay()->toDateString();
            }

            if($request->get('to_date')!='null'){
                $to_date=$request->get('to_date');
            }else{
                //$to_date=(new Carbon)->subDays(30)->startOfDay()->toDateString();
            }    
            $from_date=date("d/m/Y",strtotime($from_date));
            $to_date=date("d/m/Y",strtotime($to_date.'23:59:59.999'));

            dump("From date".$from_date."  To date".$to_date);
            //Filtro between
            $fichadas=$fichadas->whereBetween('CheckInOut.CHECKTIME', [$from_date, $to_date]);

        }    
        //dd($datos['fichadas']);
        $datos['fichadas']=$fichadas->get();
        return view('usuarioFichada.index',$datos);
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
