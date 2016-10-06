<?php
class Report_ReportPickFuelController extends Controller{
    public function getIndex()
    {
        $inputs = Input::all();
        $month = !empty($inputs['month']) ? ''.$inputs['month']+1: null;
        $year = !empty($inputs['year']) ? ''.($inputs['year']-543): null;
        $list=null;
         // dd($month);
        if(!empty($inputs['sort']) && $inputs['sort'] =='all')
        {
            $sql=PickFuel::where(DB::raw('YEAR(pick_fuel.pk_date_save)'),$year)
                        ->where(DB::raw('MONTH(pk_date_save)'),$month)
                        ->join('cars','cars.id','=','pick_fuel.pk_car_id');
            
            $listPick =  $sql->groupBy('pick_fuel.pk_car_id')->orderBy('cars.car_no','ASC')
                        ->select('cars.id','cars.car_no','cars.car_province','cars.car_dept','cars.car_type')
                        ->get();
            
            $detailsPick = $sql->groupBy('pk_type_fuel','cars.id')
                        ->select('pk_car_id','pk_type_fuel',DB::raw('SUM(pick_fuel.pk_qty) AS total'))
                        ->get();
            
            if((count($detailsPick)>0)&&(count($detailsPick)>0))
            {
                $list[][] = array();
                $row = 0;
                 foreach ($listPick as $l)
                {   
                    $list[$row][0]=$l->car_no.' '.$l->car_province; //CarNumber
                    $list[$row][1]=$l->car_type;  //col 1 
                    $list[$row][2]=$l->car_dept; //col 2
                    foreach ($detailsPick as $d)
                        {
                            if($d->pk_car_id==$l->id)//ถ้า ID รถตรงกัน
                                {   
                                   $tatal = $d->total;
                                    if($d->pk_type_fuel=='น้ำมันเบนซิลธรรมดา')
                                    {
                                        $list[$row][3]=$tatal; 
                                    }else if($d->pk_type_fuel=='น้ำมันเบนซิลซุปเปอร์')
                                    {
                                        $list[$row][4]=$tatal;

                                    }else if($d->pk_type_fuel=='น้ำมันดีเซล')
                                    {
                                       $list[$row][5]=$tatal;
                                    }

                                }
                        }
                        $row++;
                }
            }
        }
        else
        {
            $sql= PickFuel::where(DB::raw('YEAR(pick_fuel.pk_date_save)'),$year)
                        ->where(DB::raw('MONTH(pk_date_save)'),$month)
                        ->join('cars','cars.id','=','pick_fuel.pk_car_id');
            
            $listDept =  $sql->groupBy('cars.car_dept')->orderBy('cars.car_dept','ASC')
                        ->select('cars.car_dept')->get();
            
            $detailsPick = $sql->groupBy('pk_type_fuel','car_dept')
                        ->select('car_dept','pk_type_fuel',DB::raw('SUM(pick_fuel.pk_qty) AS total'))
                        ->get();
            
           if((count($listDept)>0)&&(count($detailsPick)>0))
            {
                $list[][] = array();
                $row = 0;
                foreach ($listDept as $l)
                {   
                    $list[$row][0]=$l->car_dept; 
                    foreach ($detailsPick as $d)
                        {
                            if($d->car_dept==$l->car_dept)//ถ้า ID รถตรงกัน
                                {   
                                   $tatal = $d->total;
                                    if($d->pk_type_fuel=='น้ำมันดีเซล')
                                    {
                                        $list[$row][1]=$tatal; 
                                    }else if($d->pk_type_fuel=='น้ำมันเบนซิลซุปเปอร์')
                                    {
                                        $list[$row][2]=$tatal;

                                    }else if($d->pk_type_fuel=='น้ำมันเบนซิลธรรมดา')
                                    {
                                       $list[$row][3]=$tatal;
                                    }

                                }
                        }
                        $row++;
                }
            }
        }
    $data = array('list'=>$list);
    return View::make('report.pickup',$data); 
    }
}