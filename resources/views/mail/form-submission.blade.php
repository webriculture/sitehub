New message from the {{ $site->name }} website ({{ $formKey }} form):

@foreach ($payload as $field => $value)
{{ str($field)->replace('_', ' ')->title() }}: {{ $value }}
@endforeach

—
Sent by SiteHub
