@component('mail::message')
# Aanvraag verwijderd

De volgende aanvraag was verwijderd door {{ $user['name'] }}.

## Details aanvraag

Datum: {{ $date }}
Tijd: {{ $time }}

@component('mail::table')

| Docent            |       | Vak                  |       | Type              |
|-------------------|-------|----------------------|-------|-------------------|
| {{ $user['name'] }} |       | {{ $task['subject'] }} |       | {{ $task['type'] }} |

| Klas               |       | Locatie               |
|--------------------|-------|-----------------------|
| {{ $task['class'] }} |       | {{ $task['location'] }} |

@endcomponent


@endcomponent
