@extends('default')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                <div class="header">
                                      <div class="pull-right">
                                          <a href="{{url('manage/car/create')}}" class="btn btn-info">เพิ่มข้อมูลรถ</a>
                                      </div>
                                </div>
                                <div class="content table-responsive table-full-width">
                                    <table class="table table-striped">
                                        <thead>
                                            <th style="text-align:center"><label>#</label></th>
                                            <th><label>เลขทะเบียนรถ</label></th>
                                            <th><label>จังหวัด</label></th>
                                            <th><label>ประเภท</label></th>
                                            <th><label>กอง</label></th>
                                            <th><label>สี</label></th>
                                            <th><label>วันหมดอายุพรบ.</label></th>
                                            <th style="text-align: center"><label>จัดการ</label></th>
                                        </thead>
                                        <tbody>
                                            @if(count($car)>0)
                                              <?php 
                                                    $util = new Util;
                                                    $currentPage=$car->getCurrentPage();
                                                    $perPage = $car->getPerPage();
                                                    $cnt = ($currentPage*$perPage)-$perPage;
                                                 ?>
                                                @foreach($car as $c)
                                                    <?php $dateExp = $util->ThaiDate($c->car_act_exp);?>
                                                    <tr>
                                                        <td style="text-align:center">{{++$cnt}}</td>
                                                        <td>{{$c->car_no}}</td>
                                                        <td>{{$c->car_province}}</td>
                                                        <td>{{$c->car_type}}</td>
                                                        <td>{{$c->car_dept}}</td>
                                                        <td>{{$c->car_color}}</td>
                                                        <td>{{$dateExp}}</td>
                                                        <td style="text-align:center">
                                                            <a href="{{url("manage/car/update/$c->id")}}"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;
                                                            <a href="#" onclick="del({{$c->id}})"> <i class="glyphicon glyphicon-trash"></i></a>&nbsp;
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <center>
                                        {{$car->links()}}
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
<script type="text/javascript">
    function del(id)
    {
    swal({title:'ต้องการลบข้อมูลหรือไม่' ,type: 'question',showCancelButton: true})
            .then(function(){
                 location.replace('{{URL::to("manage/car/delete")}}/'+id);
            });
    }
</script>
@stop