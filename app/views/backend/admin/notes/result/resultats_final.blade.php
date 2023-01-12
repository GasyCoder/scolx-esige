        {{ Form::open(['route'=>['confirmResult', $class->id, $parcour->id], 'class'=>'', 'id'=>'', 'data-toggle'=>''])  }}
            <div class="mt-0">
                  <table class="table table_bordered w-full" style="display:none;">
                    <tbody>
                      @foreach($resultats as $result)
                       <?php   
                            $test1          = Delibera::where('yearsUniv',  $year->yearsUniv)
                                                     ->where('class_id',    $class->id)
                                                     ->where('parcour_id',  $parcour->id)
                                                     ->where('id_student',  $result->id_student)
                                                     ->where('session', 1)
                                                     ->where('semestre', 1)
                                                     ->first();

                            $test2          = Delibera::where('yearsUniv',  $year->yearsUniv)
                                                     ->where('class_id',    $class->id)
                                                     ->where('parcour_id',  $parcour->id)
                                                     ->where('id_student',  $result->id_student)
                                                     ->where('session', 1)
                                                     ->where('semestre', 2)
                                                     ->first();

                            $sum1          = Delibera::where('yearsUniv',  $year->yearsUniv)
                                                     ->where('class_id',    $class->id)
                                                     ->where('parcour_id',  $parcour->id)
                                                     ->where('id_student',  $result->id_student)
                                                     ->where('session', 1)
                                                     ->where('semestre', 1)
                                                     ->sum('somme');

                            $sum2          = Delibera::where('yearsUniv',  $year->yearsUniv)
                                                     ->where('class_id',    $class->id)
                                                     ->where('parcour_id',  $parcour->id)
                                                     ->where('id_student',  $result->id_student)
                                                     ->where('session', 1)
                                                     ->where('semestre', 2)
                                                     ->sum('somme');

                            $total           = ($sum1+$sum2);
                            $moyennes        = $total/60;
                            $delib           = Deliberation::where('session', 1)->first();
                        ?> 
                        @if($existeS2 && $existeS1 > 0)
                        @if($test1->moyenne >= 10 && $test2->moyenne >= 10 && $moyennes >= $delib->moyenne)
                        <tr>
                            <input type="hidden" name="id_student[]" value="{{$result->stud->id}}">
                            <input type="hidden" name="class_id[]" value="{{$result->stud->class_id}}">
                            <input type="hidden" name="parcour_id[]" value="{{$result->stud->parcour_id}}">
                            <input type="hidden" name="yearsUniv[]" value="{{$result->yearsUniv}}">
                            <input type="hidden" name="grade[]" value="{{$result->grade}}">
                            <input type="hidden" name="moisPayed[]" value="{{$result->stud->mois_reste}}">

                            <input type="hidden" name="moyenne[]" value="{{number_format($moyennes, 2, ',', '')}}">
                            <input type="hidden" name="somme[]" value="{{number_format($total, 2, ',', '')}}">
                            <input type="hidden" name="admis[]" value="1">

                            <td class="text-center font-bold">{{$result->stud->matricule}}</td>
                            <td class="font-bold">{{$result->stud->fname}}</td>
                            <td class="font-bold">{{$result->stud->lname}}</td>
                        </tr>
                        @else
                        <tr>
                            <input type="hidden" name="id_student[]" value="{{$result->stud->id}}">
                            <input type="hidden" name="class_id[]" value="{{$result->stud->class_id}}">
                            <input type="hidden" name="parcour_id[]" value="{{$result->stud->parcour_id}}">
                            <input type="hidden" name="yearsUniv[]" value="{{$result->yearsUniv}}">
                            <input type="hidden" name="grade[]" value="{{$result->grade}}">
                            <input type="hidden" name="moisPayed[]" value="{{$result->stud->mois_reste}}">

                            <input type="hidden" name="moyenne[]" value="0">
                            <input type="hidden" name="somme[]" value="0">
                            <input type="hidden" name="admis[]" value="0">

                            <td class="text-center font-bold">{{$result->stud->matricule}}</td>
                            <td class="font-bold">{{$result->stud->fname}}</td>
                            <td class="font-bold">{{$result->stud->lname}}</td>
                        </tr>
                        @endif
                        @endif    
                      @endforeach
                    </tbody>
                </table>
                <br>
                @if($resultat_existe > 0)
                 <a href="/admin/resultats_examen/session_1/version-officiel/résultats/{{$class->id.'/'.$parcour->id}}">   
                    <div class="card card_hoverable card_list" style="color:green">
                        <div class="image image_icon">
                            <span class="la la-check la-4x"></span>
                        </div>
                        <div class="body">
                            <h5>Résultats finale de l'examen 1er Session </h5>
                        </div>
                    </div>
                </a>
                @else
                @if($existeS2 && $existeS1 > 0)
                <button>    
                    <div class="card card_hoverable card_list bg-success" style="color:#000">
                        <div class="image image_icon">
                            <span class="la la-file-alt la-4x"></span>
                        </div>
                        <div class="body">
                            <h5>Résultats finale de l'examen 1er Session </h5>
                        </div>
                    </div>
                </button>
                @endif
              @endif  
            </div>
             {{ Form::close() }}     
         