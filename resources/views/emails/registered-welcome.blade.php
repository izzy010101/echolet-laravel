@component('mail::message')
    # Welcome to Echolet! 🎉

    We're excited to have you on board.

    Now that you’ve joined, you can read and share amazing stories by founders and creatives just like you.

    @component('mail::button', ['url' => config('app.url')])
        Visit Echolet
    @endcomponent

    Thanks,<br>
    The Echolet Team
@endcomponent
