<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('emails.css')
</head>
<body class="h-screen overflow-hidden flex items-center justify-center">
    <div class="flex flex-col">
  <div class="overflow-x-auto sm:-mx-3 lg:-mx-5">
    <div class="py-5 inline-block min-w-full sm:px-6 lg:px-5">
      <div class="overflow-hidden">
 <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-5">
            <h1>Résultat d'examen - @if($session->session == 1)1<sup>ère</sup> @else 2<sup>ème</sup> @endif Session</h1>
            <p>Liste des Admis:</p>
            </div>
        </section>        
<table class="table-sm table-bordered-bottom w-full text-left text-gray-500">
  <thead>
    <tr class="bg-gray-200 text-sm font-semibold">
        <th width="350">Etudiant</th>
        <th class="">Niveau</th>
        <th class="">Parcours</th>   
        <th class="" style="text-align:right">Mention</th>
    </tr>
  </thead>
  <tbody>
    @foreach($resultats as $resultat)
        <tr>
            <td>
                {{$resultat->stud->fname}} {{$resultat->stud->lname}}
            <td>
            {{$class->short}}
            </td>
            <td class="text-gray-600">{{$parcour->abr}}</td>
            <td class="" align="right">
                @if($resultat->moyenne >= 10 && $resultat->moyenne <= 11.99)Passable 
                    @elseif($resultat->moyenne >= 12 && $resultat->moyenne <= 13.99)Assez-Bien @elseif($resultat->moyenne >= 14 && $resultat->moyenne <= 15.99) Bien
                    @elseif($resultat->moyenne >= 16) Très-Bien
                @endif
           </td>
        </tr>
    @endforeach
  </tbody>
</table>
      </div>
    </div>
  </div>
</div>
</body>
</html>
