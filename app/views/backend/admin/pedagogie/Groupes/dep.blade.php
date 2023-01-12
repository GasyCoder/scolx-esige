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

                    subcat.append('<option value ="">Listes des parcours</option>');

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

            $('#class').on('change',function(e){
            var class_id = e.target.value;

            $(".students").css ({"display":"block"});

            $.ajax({
            type: "GET",
            url: "{{ url() }}/ajax-students?class_id="+class_id,
                success: function(data) {  

                    var subcat =  $('#students').empty();

                    subcat.append('<option value ="">Liste des étudiants</option>');

                    $.each(data,function(create,subcatObj){
                    var option = $('<option/>', {id:create, value:subcatObj});
                    subcat.append('<option value ="'+subcatObj+'">'+create+'</option>');
                    });

                }
            });


        });
});
</script>        