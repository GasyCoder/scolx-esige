<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>EXAM EMAIL RESULT</title>
</head>
<body>
 <div>

 	<hr>
 	<table>
 		<thead>
 			<tr>
 				<th>Id</th>
 				<th>Nom</th>
 				<th>Prénom</th>
 				<th>Admis</th>
 				<th>Mention</th>
 			</tr>
 		</thead>
 		<tbody>
 			@foreach($etudiants as $key=> $exam)
 			<?php $moyenne = DB::table('notes')->where('class_id', $exam->class_id)
                                               ->where('id_student', $exam->id)
                                               ->orderBy('note', 'desc')
                                               ->avg('note'); ?>
 				<tr>
 					<td>{{$exam->id}}</td>
 					<td>{{$exam->fname}}</td>
 					<td>{{$exam->lname}}</td>
 					<td class="text-center">
                      @if($moyenne >= 10) <span class="badge badge_success">Oui</span> @else <span class="badge badge_danger">Non</span> @endif</span>
                    </td>
                   <td>
                   	@if($moyenne <= 9.99)<b>NULL</b>
                   	@elseif($moyenne >= 10 && $moyenne <= 11.99)<b>Passable</b>	
		            @elseif($moyenne >= 12 && $moyenne <= 13.99)<b>Assez-Bien</b> 
		            @elseif($moyenne >= 14 && $moyenne <= 15.99) <b>Bien</b> 
		            @elseif($moyenne >= 16) <b>Très-Bien</b> 
                    @endif
                   </span>
                  </td>
 				</tr>
 			@endforeach
 		</tbody>
 	</table>
 </div>
</body>
</html>