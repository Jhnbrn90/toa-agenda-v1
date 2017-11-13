@component('mail::message')
# Nieuwe aanvraag
** {{ $task['title' ] }} **
<br>
{{ $task['body'] }}

##Meerdere data
...overzichtje van data

@endcomponent
