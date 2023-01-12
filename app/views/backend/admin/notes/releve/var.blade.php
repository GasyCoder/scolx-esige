 <?php  

        $mat       = EC::where('codeUe', $rvnote->codeUe)
                                ->where('class_id', $rvnote->class_id)
                                ->where('parcour_id', $rvnote->parcour_id)
                                ->where('tronc', 0)
                                ->groupBy('codeEc')
                                ->get();   

        $Coeffis     = EC::where('codeUe', $rvnote->codeUe)
                                ->where('class_id', $rvnote->class_id)
                                ->where('parcour_id', $rvnote->parcour_id)
                                ->where('tronc', 0)
                                ->groupBy('codeEc')
                                ->get();

        $CoefPondere     = EC::where('codeUe', $rvnote->codeUe)
                                ->where('class_id', $rvnote->class_id)
                                ->where('parcour_id', $rvnote->parcour_id)
                                ->where('tronc', 0)
                                ->groupBy('codeUe')
                                ->sum('coef');            

        $TotalCoefs     = EC::where('class_id', $rvnote->class_id)
                                ->where('parcour_id', $rvnote->parcour_id)
                                ->where('tronc', 0)
                                ->groupBy('class_id')
                                ->sum('coef');

        $matMix      = EC::where('codeUe', $rvnote->codeUe)
                                ->where('class_id', $rvnote->class_id)
                                ->where('tronc', 1)
                                ->groupBy('codeEc')
                                ->get();

        $ues        = UE::where('codeUe', $rvnote->codeUe)
                                 ->where('class_id', $rvnote->class_id)
                                 ->groupBy('name')
                                 ->first(); 

        $Notes       = Note::where('class_id', $rvnote->class_id)
                                ->where('id_student', $student->id)
                                ->where('codeUe', $rvnote->codeUe)
                                ->orderBy('codeEc')
                                ->groupBy('codeEc')
                                ->get(); 


        $sumEc     = DB::table('notes')
                                ->where('class_id', $rvnote->class_id)
                                ->where('id_student', $student->id)
                                ->where('codeUe', $rvnote->codeUe)
                                ->groupBy('codeEc')
                                ->sum('note');

        $sumUe     = DB::table('notes')
                                ->where('class_id', $rvnote->class_id)
                                ->where('id_student', $student->id)
                                ->where('codeUe', $rvnote->codeUe)
                                ->groupBy('codeEc')
                                ->get(); 

       //$cost        = $sumUe/$sumEc;                                    
    ?> 