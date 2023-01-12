@extends('backend.main')
<?php $path = Session::get('language'); ?>
@include('backend.timeAgo')
@section('title') Profile - {{ $teacher->fname }} {{ $teacher->lname }} @stop
@section('content') 
    <!-- Workspace -->
<main class="workspace workspace_with-sidebar">
@include('backend.pages.alerts')   
        <!-- Header -->
        <div class="card p-3 flex flex-wrap gap-2">
            <a href="{{ URL::route('indexTeacher')}}" class="btn btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <a href="{{ URL::route('TeacherEdit', $teacher->id)}}" class="btn btn-icon btn_primary ltr:ml-5 rtl:mr-5"> <span class="la la-pen-fancy"></span></a>

                <a href="#" class="btn btn-icon btn_danger ltr:ml-2 rtl:mr-2">
                 <span class="la la-trash-alt"></span>
                </a>
            </div>
         
        </div>             
        <div class="grid lg:grid-cols-4 gap-5 mt-5">
            <!-- Categories -->
            <div class="lg:col-span-2 xl:col-span-1">
            <div class="card p-5">
                <div class="status bg-success"></div>
                <center>
                @if(!empty($teacher->image))
                <?php echo HTML::image('uploads/profiles/teachers/'.$teacher->image.'', '', ['class'=>'', 'width'=>'180','height'=>'80']) 
                ?>
                @elseif($teacher->sexe == 1)
                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'50']) }}
                @endif
                {{ Form::open(['route'=>['pdp_teacher', $teacher->id], 'files'=>'true', 'class'=>'mb-3'])  }}    
                    <label class="input-group font-normal py-2 px-2" for="customFile3">
                        <div class="file-name input-addon input-addon-prepend input-group-item w-full overflow-x-hidden">photo de profile</div>
                        <input id="customFile3" type="file" name="image" class="hidden">
                        <button type="submit" class="input-group-item badge badge_secondary"><span class="la la-cloud-upload-alt text-xl"></span> Uploader</button> 
                    </label>
                {{ Form::close() }}   
               </center>
            <div class="border-t border-dashed mt-2">
                <h5>{{$teacher->grade}} {{$teacher->fname}} {{$teacher->lname}}</h5>
                <i><span>Sexe:</span>@if($teacher->sexe == 1) Homme @else Femme @endif - Nationalité: @if($teacher->nationality == 0) Malagasy @elseif($teacher->nationality == 1) Français @else Comoriens @endif</i>
            </div>
                    <div class="mt-2 leading-normal">
                        <a href="#" class="flex items-center text-normal">
                            <span class="la la-birthday-cake text-muted text-2xl ltr:mr-0 rtl:ml-0"></span>
                           <h6></h6>{{$teacher->birth}} à {{$teacher->birthLocation}}
                        </a>
                        <hr class="border-dashed">
                        <a href="#" class="flex items-center text-normal">
                            <span class="la la-phone text-muted text-2xl ltr:mr-0 rtl:ml-0"></span>
                            <h6></h6> {{$teacher->phone_1}}
                        </a>
                        <a href="#" class="flex items-center text-normal">
                            <span class="la la-at text-muted text-2xl ltr:mr-0 rtl:ml-0"></span>
                            <h6></h6> {{$teacher->email}}
                        </a>
                        @if($teacher->facebook > 0)
                         <a href="#" class="flex items-center text-normal">
                            <span class="la la-facebook text-muted text-xl ltr:mr-0 rtl:ml-0"></span>
                            {{$teacher->facebook}}
                        </a>
                        @else
                        @endif
                        <hr class="border-dashed">
                        <a href="#" class="flex items-center text-normal">
                            <span class="la la-map-marked-alt text-muted text-2xl ltr:mr-2 rtl:ml-2"></span>
                            {{$teacher->address}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-3">
                <div class="card p-5">
                    <div class="accordion rounded-xl mt-0">
                        <h4 class="p-2">Liste de matières:</h4>
                         <table class="table table_bordered w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right">#</th>
                                <th class="ltr:text-left rtl:text-right">Matières</th>
                                <th class="text-center">Classe</th>
                                <th class="text-center">Vol horaire</th>
                                <th class="text-center">Coef</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matieres as $key=> $matiere)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$matiere->name}}</td>
                                <td class="text-center">{{$matiere->niveau->short}}</td>
                                <td class="text-center">{{$matiere->volH}}</td>
                                <td class="text-center">{{$matiere->coef}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>     
                </div>
            </div>           
        </div>  
@include('backend.pages.footer')  
</main>
<!--Sidebar -->
@include('backend.admin.pedagogie.Teachers.side')
@stop