@component('mail::message')
# Petición de aprobación

Como tutor/a de {{$person->name}}, le solicitamos la aprobación de la imagen adjunta.

@component('mail::button', ['url' => $urlconforme])
Conforme
@endcomponent

@component('mail::button', ['url' => $urlnoconforme])
No Conforme
@endcomponent

Muchas gracias,<br>
{{ config('app.name') }}
@endcomponent
