@component('mail::message')
# Nieuwe herhalende aanvraag
** {{ $task['title' ] }} **
<br>
{{ $task['body'] }}

@component('mail::button', ['url' => $actionURL])
Aanvraag bekijken
@endcomponent

@endcomponent
