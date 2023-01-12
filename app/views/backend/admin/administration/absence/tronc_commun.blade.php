@extends('backend.main')
<?php $path = Session::get('language'); ?>

@section('title') Absence - Classses @stop

@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-4">
@include('backend.break')
            </div>
        </section>
@if(count($socle_tronc) >= 1)
                <div class="card p-5">
                    <h3>Niveau tronc commun</h3>
                    <table class="table table_bordered w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right" colspan="3">Niveau</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($socle_tronc as $student)
                        <?php $student = Student::where('class_id', $student->class_id)->first();?>  
                            <tr>
                                <td>{{ $student->fname }} {{ $student->lname }}</td>
                                <td>{{ $student->parcour->abr }}</td>
                                <td class="text-center" style="color:red"><span class="la la-random text-xl"></span> 
                                	{{ $student->id }}
                                </td>
                                <td>
	                            	<?php $ec = EC::where('tronc', 1)->where('status', 1)->first();?>
	                            	<a href="{{ URL::current().'/'.$ec->codeEc }}/open">
	                            	<div class="badge badge_success">Ouvrir</div>
	                            	</a>
                                </td>
                            </tr>
                		@endforeach 
                         </tbody>
                    </table>
                </div>
@endif     
@include('backend.pages.footer')
</main>
@stop