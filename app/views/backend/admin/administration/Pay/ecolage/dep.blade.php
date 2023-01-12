{{ HTML::script('js/jquery-1.11.3.min.js') }}
<script type="text/javascript">
$(document).ready(function () { 

            $('#class').on('change',function(e){
            var class_id = e.target.value;

            $(".parcours").css ({"display":"block"});

            $.ajax({
            type: "GET",
            url: "{{ url() }}/ajax-parcour?class_id="+class_id,
                success: function(data) {  

                    var subcat =  $('#parcours').empty();

                    subcat.append('<option value ="" selected="" disabled="">Listes des parcours</option>');

                    $.each(data,function(create,subcatObj){
                    var option = $('<option/>', {id:create, value:subcatObj});
                    subcat.append('<option value ="'+subcatObj+'">'+create+'</option>');
                    });
                }
            });
        });
});

//Students
$(document).ready(function () { 

            $('#parcours').on('change',function(e){
            var parcour_id = e.target.value;

            $(".students").css ({"display":"block"});

            $.ajax({
            type: "GET",
            url: "{{ url() }}/ajax-students?parcour_id="+parcour_id,
                success: function(data) {  

                    var subcat =  $('#students').empty();

                    subcat.append('<option value ="" selected="" disabled="">Liste des étudiants</option>');

                    $.each(data,function(create,subcatObj){
                    var option = $('<option/>', {id:create, value:subcatObj});
                    subcat.append('<option value ="'+subcatObj+'">'+create+'</option>');
                    });

                }
            });


        });
});
</script>        