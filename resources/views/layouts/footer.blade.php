<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mb-lg-0 mb-3">
                    <nav class="footer-menu">
                        {!! Menu::get('FooterMenu')->asUl() !!}
                    </nav>
                </div>
                <div class="col-lg-1 col-md-4 footer-button">
                    <a class="btn-blue btn-block" href="{{route('archive')}}">@lang('footer.archive')</a>
                </div>
                {{--<div class="col-lg-2 col-md-4 footer-button">
                    <a class="btn-blue btn-block" href="{{route('partner')}}">@lang('footer.partner')</a>
                </div>--}}
                @auth
                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator'))
                <div class="col-lg-2 col-md-4 footer-button">
                    @if(!$international)
                        <a class="btn-blue btn-block" href="{{route('home')}}international">@lang('footer.international')</a>
                    @else
                        <a class="btn-blue btn-block" href="{{ str_replace('international/','',route('home'))}}">@lang('footer.ukraine')</a>
                    @endif
                </div>
                @endif
                @endauth
                <div class="col-lg-2 col-md-4 footer-button">
                    <a class="btn-orange btn-block" href="#" data-toggle="modal" data-target="#feedback_form_modal">@lang('footer.send_us')</a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="copyright">
                        © <strong>naprobu.ua</strong>, 2011-{{Carbon\Carbon::now()->year}}. @lang('footer.all_rights_reserved')
                    </div>
                    <nav class="legal-menu">
                        {!! Menu::get('LegalMenu')->asUl() !!}
                    </nav>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    <ul class="social-footer float-right-lg">
                        <li class="facebook-footer">
                            <a href="https://www.facebook.com/naprobu.ua/" target="_blank"><img src="{{asset('public/svg/icons/facebook.svg')}}" alt="Facebook"> <span>Facebook</span></a>
                        </li>
                        <li class="telegram-footer">
                            <a href="https://t.me/naprobu_ua" target="_blank"><img src="{{asset('public/svg/icons/telegram.svg')}}" alt="Telegram"> <span>Telegram</span></a>
                        </li>
                        <li class="instagram-footer">
                            <a href="https://www.instagram.com/naprobu.ua/" target="_blank"><img src="{{asset('public/svg/icons/instagram.svg')}}" alt="Instagram"> <span>Instagram</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
