@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Привет!')
@endif
@endif

Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
Сброс пароля
@endcomponent
@endisset

Срок действия ссылки для сброса пароля истечет через 60 минут.

Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Если Вы не можете нажать на кнопку \":actionText\", скопируйте и вставьте адрес ниже\n".
    'в ваш браузер:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
