@if(Session::has('success'))
<div class="alert alert_success">
    <strong class=""><bdi>Succès!</bdi></strong>
    {{ Session::get('success') }}
    <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div><br>
@endif
@if(Session::has('error'))
<div class="alert alert_danger">
    <strong class=""><bdi>Erreur!</bdi></strong>
    {{ Session::get('error') }}
    <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div><br>
@endif
@if(Session::has('warning'))
<div class="alert alert_warning">
    <strong class="text-red-700"><bdi>Attention!</bdi></strong>
    <span style="color:#DC2626">{{ Session::get('warning') }}</span>
    <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div><br>
@endif