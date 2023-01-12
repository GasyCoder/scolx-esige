@extends('backend.main')
<?php $path = Session::get('language'); $control = Control::find(1);?>
@section('title') Ajouter notes des étudiants {{$class->short}} @stop
@section('content')
<style type="text/css">
@if($note->noteExam >= 10)    
input[type=number]:focus {
  background-color:#F0FDF4;
  border: 1px solid #1E40AF;
}
input[type=number] {
  background-color:#D1FAE5;
  border: 1px solid #15803D;
  font-weight: bold;
}
@else
input[type=number]:focus {
  background-color:#ffffff;
  border: 1px solid red;
}
input[type=number] {
  background-color:#ffffff;
  border: 1px solid red;
  font-weight: bold;
}
@endif
</style>

<main class="workspace workspace_with-sidebar">
        <section class="breadcrumb lg:flex items-start">
            <div>
            <h3>{{$title}} 2ème session</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Menu</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$sous}}</li>
            </ul>
            <a href="/admin/notes/etudiants/notes/ajouter-2-session/{{$class->id}}/{{$parcour->id.'/2/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '=')}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary mt-5">
                <span class="la la-undo"></span>
            </a> 
            </div>
           <div class="flex flex-wrap gap-2 items-center ltr:ml-auto rtl:mr-auto mt-5 lg:mt-0">
                <div class="flex gap-x-2">
                <div class="avatar w-16 h-16 ltr:mr-5 rtl:ml-5">
                <div class="status bg-success"></div>
                @if(!empty($student->image))
                <?php echo HTML::image('uploads/profiles/students/'.$student->image.'', '', ['class'=>'', 'width'=>'180','height'=>'80']) ?>
                @elseif($student->sexe == 1)
                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'50']) }}
                @endif
                </div>
                <div>
                <h5>{{$student->fname}} {{$student->lname}}</h5>
                <p>Niveau : {{$student->niveau->short}} | Parcour : {{$student->parcour->abr}} <br> Année Universitaire : {{$years->yearsUniv}}</p>
                </div>
                </div>
            </div>            
        </section>  
        <div class="mt-0">
            <div class="lg:col-span-2 xl:col-span-3">           
             <form method="post" action="{{ URL::current() }}">   
                <div class="card p-5 mt-3">
                    <table class="table table_bordered w-full mt-0">
                        <thead>
                            <tr style="color:#334155">
                                <th class="" style="text-align:center;" width="210">Matières</th>
                                <th class="text-center" style="text-align:center;" width="150">Ajouter note 2e session</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-bold text-primary uppercase" style="text-align:center;">{{$note->mat->name}}</td>
                                <td class="px-4">
                                 <label>Ancien note/20</label>    
                                <div class="input-group">
                                    <input 
                                    class="form-control input-group-item" 
                                    type="number" 
                                    step="any" 
                                    value="{{$note->noteExam}}" 
                                    max="20" 
                                    pattern="[0-9]+([\.][0-9]+)?"
                                    placeholder="Saisir le note sur 20" 
                                    name="noteExam" 
                                    required/>
                                    <button class="btn btn_primary input-group-item">Ajouter</button>
                                    <div class="help-block with-errors"></div>
                                    @if($errors->first('note'))
                                    <span class="text-red-700">{{ $errors->first('note') }}</span>
                                    @endif      
                                </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
             </form>
        </div>
        </div>
@include('backend.pages.footer')
@section('js')
@endsection
</main>
@stop