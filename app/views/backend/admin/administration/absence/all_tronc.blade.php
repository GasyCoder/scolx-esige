@extends('backend.main')
<?php $path = Session::get('language'); ?>

@section('title') Absence - Niveau @stop

@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-4">
@include('backend.break')
            </div>
        </section>
                <div class="card p-5">
                    <h3>Niveau tronc commun</h3>
                    <table class="table table_bordered w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right" colspan="3">Niveau Auditeur libre</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($elements as $const)
						<?php $students = Student::where('class_id', $const->class_id)->first();?>
				
                            <tr>
                                <td>
                                	{{ $students->fname }} {{ $students->lname }}
                                </td>
                                <td class="text-center" style="color:red"><span class="la la-random text-xl"></span>
                                {{ $students->id }} 
                                </td>
                                <td>
	                            	<?php $ec = EC::where('tronc', 1)->where('status', 1)->where('class_id', $const->class_id)->first(); ?>
	                            	<a href="{{ URL::current().'/'.$ec->codeEc }}/open">
	                            	<div class="badge badge_success">Ouvrir</div>
	                            	</a>
                                </td>
                            </tr>  
                		@endforeach 
                         </tbody>
                    </table>
                </div>    
@include('backend.pages.footer')
</main>
@stop