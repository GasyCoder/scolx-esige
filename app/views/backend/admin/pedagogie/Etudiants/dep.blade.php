<script type="text/javascript">
$(document).ready(function () { 

            $('#student').on('change',function(e){
            var student = e.target.value;

            $(".promo").css ({"display":"block"});

            $.ajax({
            type: "GET",
            url: "{{ url() }}/ajax_promo?student="+student,
                success: function(data) {  

                    var subcat =  $('#promo').empty();

                    //subcat.append('<option value =""  selected disabled>Date de promotion</option>');

                    $.each(data,function(create,subcatObj){
                    var option = $('<option/>', {id:create, value:subcatObj});
                    subcat.append('<option value ="'+subcatObj+'" class="text-primary font-bold">'+create+'</option>');
                    });
                }
            });
        });
});
</script>        