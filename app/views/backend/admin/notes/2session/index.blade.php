            <!-- Style 2 -->
            <div class="border card mt-0 p-5">
            <h3><u>Session 2</u></h3>    
            {{ Form::open(['route'=>['submit2sessionfinal', $class->id, $parcour->id], 'class'=>'', 'id'=>'', 'data-toggle'=>''])  }}
            <div class="mt-0">
                <span style="display:none"> 
                     @foreach($deuxieme_sessions as $result)
                           <?php 
                                $totalNote      = Credit::where('class_id',              $class->id)
                                                            ->where('parcour_id',        $parcour->id)
                                                            ->where('id_student',        $result->id_student)
                                                            ->where('session', 2)
                                                            //->where('semestre', 1)
                                                            ->where('status', 1)
                                                            ->groupBy('id_student')
                                                            ->sum('Noteponder'); 
                                
                                $SumCoef        = Credit::where('id_student',           $result->id_student)
                                                            ->where('class_id',         $class->id)
                                                            ->where('parcour_id',       $parcour->id)
                                                            ->where('session', 2)
                                                            //->where('semestre', 1)
                                                            ->where('status', 1)
                                                            ->groupBy('id_student')
                                                            ->sum('coef');

                                $CoefPonder     = EC::where('codeUe',                   $result->codeUe)
                                                            ->where('class_id',         $class->id)
                                                            ->where('parcour_id',       $parcour->id)
                                                            ->groupBy('codeUe')
                                                            ->sum('coef');                              
                            
                                $tests_1         = Delibera::where('class_id',            $class->id)
                                                            ->where('parcour_id',        $parcour->id)
                                                            ->where('id_student',        $result->id_student)
                                                            ->where('session', 1)
                                                            ->where('semestre', 1)
                                                            ->groupBy('id_student')
                                                            ->get();

                                $tests_2         = Delibera::where('class_id',            $class->id)
                                                            ->where('parcour_id',        $parcour->id)
                                                            ->where('id_student',        $result->id_student)
                                                            ->where('session', 1)
                                                            ->where('semestre', 2)
                                                            ->groupBy('id_student')
                                                            ->get();

                                $smoyenne       =  $totalNote/60;  

                                $deliberation   = Deliberation::where('session', 2)->first();                            
                            ?>    
                            @foreach($tests_1 as $test1)
                                <?php 
                                    $var_1          = $test1->moyenne;
                                    $sum1           = $test1->somme;
                                    $somNote1       = $sum1+$totalNote;
                                    $smoyenne1      = $somNote1/60;
                                ?>
                            @endforeach
                            @foreach($tests_2 as $test2)
                                <?php 
                                    $var_2          = $test2->moyenne;
                                    $sum2           = $test2->somme;
                                    $somNote2       = $sum2+$totalNote;
                                    $smoyenne2      = $somNote2/60;
                                ?>
                            @endforeach
                            <input type="hidden" name="id_student[]" value="{{$result->id_student}}">
                            <input type="hidden" name="class_id[]"   value="{{$class->id}}">
                            <input type="hidden" name="parcour_id[]" value="{{$parcour->id}}">
                            <input type="hidden" name="yearsUniv[]"  value="{{$result->yearsUniv}}">
                            <input type="hidden" name="grade[]"      value="{{$result->grade}}">
                            <input type="hidden" name="moisPayed[]"  value="{{$result->stud->mois_reste}}">
                            <input class="form-control" value="{{$result->stud->matricule}}">
                            <input class="form-control" value="{{$result->stud->fname}} {{$result->stud->lname}}">
                            
                            @if($var_1 >= 10)
                          <input type="text" name="somme[]" class="form-control" value="{{number_format($somNote1, 2, '.', '')}}">
                            @elseif($var_2 >= 10 )
                                <input type="text" name="somme[]" class="form-control" value="{{number_format($somNote2, 2, '.', '')}}">
                            @else
                                <input type="text" name="somme[]" class="form-control" value="{{number_format($totalNote, 2, '.', '')}}">
                            @endif

                            @if($var_1 >= 10)
                                <input type="text" name="moyenne[]" class="form-control" value="{{number_format($smoyenne1, 2, '.', '')}}">
                            @elseif($var_2 >= 10 )
                                <input type="text" name="moyenne[]" class="form-control" value="{{number_format($smoyenne2, 2, '.', '')}}">
                            @else
                                <input type="text" name="moyenne[]" value="{{number_format($smoyenne, 2, '.', '')}}" class="form-control">
                            @endif
                        
                            <input type="text" name="deliberation[]" value="{{$deliberation->moyenne}}" class="form-control">

                            <br><br>
                      @endforeach 
                   </span>   
                <br>
                @if($session2_existe > 0)
                 <a href="/admin/resultats_examen/session_2/vérification/{{$class->id.'/'.$parcour->id}}">   
                    <div class="card card_hoverable card_list" style="color:green">
                        <div class="image image_icon">
                            <span class="la la-check la-4x"></span>
                        </div>
                        <div class="body">
                            <h5>Résultats finale de l'examen 2em Session </h5>
                        </div>
                    </div>
                </a>
                @else
                       <div class="grid sm:grid-cols-1 xl:grid-cols-1 gap-5">
                             <button>    
                                <div class="card card_hoverable card_list" style="color:#4F46E5">
                                    <div class="image image_icon">
                                        <span class="la la-file-alt la-4x"></span>
                                    </div>
                                    <div class="body">
                                    <h5>Résultats finale de l'examen 2em Session </h5>
                                    </div>
                                </div>
                            </button>
                        </div>
                @endif
            </div>
             {{ Form::close() }}     
            </div>