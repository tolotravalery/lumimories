@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot
    @slot('slot')
        @component('mail::paragraphe')
            ![Ceci est un exemple d’image]({{$image}})
        @endcomponent <br/><br/>
        @component('mail::paragraphe')
            {{ $hebrewDate }}
        @endcomponent <br/><br/>
        @component('mail::paragraphe')
            {{ __('website.text-email-click-link') }}
        @endcomponent <br/><br/>
        @component('mail::paragraphe')
            [Click ici]({{ $url }})
        @endcomponent <br/><br/>
        @component('mail::paragraphe')
            {{ __('website.share-in') }} :
        @endcomponent <br/><br/>
        @component('mail::button-share',['url' => 'https://api.whatsapp.com/send?text='.$url,'color' => 'whatsapp'])
            Whatsapp
        @endcomponent
        @component('mail::button-share',['url' => 'https://www.facebook.com/sharer/sharer.php?u='.$url,'color' => 'facebook'])
            Facebook
        @endcomponent <br/><br/>
        @component('mail::paragraphe')
        {{ __('website.text-email-affectionately') . "," }}
        @endcomponent <br/><br/>
        @component('mail::paragraphe')
        {{ __('website.text-email-slogan') }}
        @endcomponent
    @endslot
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset
    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent