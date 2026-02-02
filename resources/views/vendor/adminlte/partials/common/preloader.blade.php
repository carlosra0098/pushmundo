@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

<div class="{{ $preloaderHelper->makePreloaderClasses() }}" style="{{ $preloaderHelper->makePreloaderStyle() }} background-color: #333c87 !important; display: flex; justify-content: center; align-items: center;">

    @hasSection('preloader')

        {{-- Use a custom preloader content --}}
        @yield('preloader')

    @else

        {{-- Use the Tenor GIF preloader content --}}
        <div class="tenor-gif-embed" data-postid="21753782" data-share-method="host" data-aspect-ratio="0.88125" data-width="70%">
            <a href="https://tenor.com/view/mundo-dance-gif-21753782">Mundo Dance GIF</a>
        </div>
        <script type="text/javascript" async src="https://tenor.com/embed.js"></script>

    @endif

</div>
