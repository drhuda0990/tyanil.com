<footer class="footer-two-area sub-bg rtlDirection">
    <div class="footer-two__shape-left">
        <img class="animation__rotateY" src="{{ asset('frontend/images/shape/footer-two-shape-left.png') }}"
            alt="shape">
    </div>
    <div class="footer-two__shape-right">
        <img src="{{ asset('frontend/images/shape/footer-two-line.png') }}" alt="shape">
    </div>
    <div class="container">
        <div class="footer__wrp pt-100 pb-100">
            <div class="footer__item footer-about wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                <a href="{{ route('index') }}" class="logo mb-30">
                    <img src="{{ asset("storage/$gSetting->logo") }}" alt="{{ $gSetting->name }}">
                </a>
                <p>
                    {!! \App\Support\SafeHtml::clean($gSetting->summary) !!}
                </p>
                @if (!empty($gSetting->business_register_number))
                    <div class="footer-register-card" aria-label="رقم السجل التجاري">
                        <span class="footer-register-card__icon" aria-hidden="true">
                            <img src="{{ asset('images/sa-commercial-register.png') }}" alt="">
                        </span>
                        <span class="footer-register-card__text">
                            <span class="tr-ar">سجل تجاري رقم</span>
                            <span class="tr-en">Commercial registration</span>
                            <strong>{{ $gSetting->business_register_number }}</strong>
                        </span>
                    </div>
                @endif
                <ul class="mt-25">
                    {{-- <li>
                        <svg class="me-1" width="16" height="20" viewBox="0 0 16 20" fill="none"
                            xmlns="https://www.w3.org/2000/svg">
                            <path
                                d="M7.99991 0C3.92603 0 0.611816 3.31421 0.611816 7.38809C0.611816 8.72925 1.21329 10.1717 1.2385 10.2325C1.43276 10.6936 1.81608 11.4098 2.09248 11.8296L7.1581 19.505C7.3654 19.8196 7.67222 20 7.99991 20C8.32759 20 8.63442 19.8196 8.84172 19.5054L13.9078 11.8296C14.1846 11.4098 14.5675 10.6936 14.7618 10.2325C14.787 10.1721 15.388 8.72968 15.388 7.38809C15.388 3.31421 12.0738 0 7.99991 0ZM13.9604 9.89526C13.787 10.3086 13.4302 10.9748 13.182 11.3512L8.11594 19.0269C8.01599 19.1786 7.98426 19.1786 7.88431 19.0269L2.81825 11.3512C2.5701 10.9748 2.21329 10.3081 2.03989 9.89483C2.0325 9.87701 1.481 8.54933 1.481 7.38809C1.481 3.79357 4.40538 0.869187 7.99991 0.869187C11.5944 0.869187 14.5188 3.79357 14.5188 7.38809C14.5188 8.55106 13.966 9.88223 13.9604 9.89526Z"
                                fill="#D989A3" />
                            <path
                                d="M7.99972 3.47754C5.84283 3.47754 4.08838 5.23243 4.08838 7.38888C4.08838 9.54534 5.84283 11.3002 7.99972 11.3002C10.1566 11.3002 11.9111 9.54534 11.9111 7.38888C11.9111 5.23243 10.1566 3.47754 7.99972 3.47754ZM7.99972 10.431C6.32262 10.431 4.95757 9.06641 4.95757 7.38888C4.95757 5.71135 6.32262 4.34673 7.99972 4.34673C9.67682 4.34673 11.0419 5.71135 11.0419 7.38888C11.0419 9.06641 9.67682 10.431 7.99972 10.431Z"
                                fill="#D989A3" />
                        </svg>
                        <a href="#0" class="p-0">6391 Elgin St. Celina, USA</a>
                    </li> --}}
                    <li>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="https://www.w3.org/2000/svg">
                            <path
                                d="M18.7719 14.1213C18.7388 14.0938 14.9913 11.4275 13.9794 11.5906C13.4913 11.6769 13.2125 12.01 12.6531 12.6762C12.4985 12.8617 12.3403 13.0443 12.1788 13.2238C11.8252 13.1086 11.4804 12.9682 11.1469 12.8038C9.42533 11.9656 8.03437 10.5747 7.19625 8.85312C7.03179 8.51964 6.89143 8.1748 6.77625 7.82125C6.96 7.65312 7.2175 7.43625 7.3275 7.34375C7.99062 6.7875 8.32312 6.50812 8.40938 6.01937C8.58625 5.0075 5.90625 1.26125 5.87875 1.2275C5.7567 1.05441 5.59775 0.910578 5.41336 0.806386C5.22897 0.702193 5.02374 0.640241 4.8125 0.625C3.72625 0.625 0.625 4.6475 0.625 5.32562C0.625 5.365 0.681875 9.3675 5.6175 14.3881C10.6325 19.3181 14.635 19.375 14.6744 19.375C15.3519 19.375 19.375 16.2737 19.375 15.1875C19.3596 14.9762 19.2975 14.771 19.1932 14.5866C19.0889 14.4022 18.945 14.2433 18.7719 14.1213ZM14.605 18.1213C14.0625 18.075 10.7 17.6319 6.5 13.5063C2.35437 9.28563 1.9225 5.9175 1.87937 5.39563C2.69861 4.10978 3.68799 2.94064 4.82062 1.92C4.84562 1.945 4.87875 1.9825 4.92125 2.03125C5.78989 3.21702 6.53817 4.48642 7.155 5.82062C6.95441 6.02242 6.7424 6.21253 6.52 6.39C6.17512 6.65278 5.85843 6.95063 5.575 7.27875C5.52704 7.34604 5.4929 7.42217 5.47456 7.50274C5.45621 7.5833 5.45403 7.66671 5.46812 7.74813C5.60039 8.32108 5.80297 8.87549 6.07125 9.39875C7.03243 11.3725 8.62735 12.9672 10.6012 13.9281C11.1244 14.1968 11.6788 14.3996 12.2519 14.5319C12.3333 14.5463 12.4168 14.5443 12.4974 14.5259C12.578 14.5075 12.6541 14.4732 12.7213 14.425C13.0505 14.1404 13.3494 13.8225 13.6131 13.4762C13.8094 13.2425 14.0712 12.9306 14.1706 12.8425C15.5082 13.4587 16.7805 14.2079 17.9681 15.0787C18.02 15.1225 18.0569 15.1562 18.0812 15.1781C17.0606 16.3111 15.8912 17.3007 14.605 18.12V18.1213ZM14.375 9.375H15.625C15.6235 8.04937 15.0962 6.77847 14.1589 5.84111C13.2215 4.90375 11.9506 4.37649 10.625 4.375V5.625C11.6193 5.62599 12.5725 6.0214 13.2756 6.72445C13.9786 7.42749 14.374 8.38074 14.375 9.375Z"
                                fill="#D989A3" />
                        </svg>
                        <a href="tel:{{ $gSetting->phone }}" class="p-0">{{ $gSetting->phone }}</a>
                    </li>
                </ul>
            </div>

            <div class="footer__item footer-links wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
                <h3 class="footer-title"><span class="tr-ar">روابط سريعة</span><span class="tr-en">Quick links</span></h3>
                <ul class="footer-link-list">
                    <li>
                        <a href="{{ route('index') }}">
                            <i class="fa-solid fa-house"></i>
                            <span class="tr-ar">الرئيسية</span><span class="tr-en">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('category.services', ['id' => 'all']) }}">
                            <i class="fa-solid fa-store"></i>
                            <span class="tr-ar">كل المنتجات</span><span class="tr-en">All products</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}">
                            <i class="fa-solid fa-headset"></i>
                            <span class="tr-ar">اتصل بنا</span><span class="tr-en">Contact us</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="footer__item footer-touch wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1500ms">
                <h3 class="footer-title"><span class="tr-ar">اتصل بنا</span><span class="tr-en">Contact us</span></h3>
                <p class="mb-20">{!! \App\Support\SafeHtml::clean($gSetting->about) !!}</p>
                <ul class="footer-contact-list">
                    @if ($gSetting->email_2)
                        <li>
                            <a href="mailto:{{ $gSetting->email_2 }}">
                                <i class="fa-solid fa-envelope"></i>
                                <span>{{ $gSetting->email_2 }}</span>
                            </a>
                        </li>
                    @endif
                    @if ($gSetting->mobile)
                        <li>
                            <a href="tel:{{ $gSetting->mobile }}">
                                <i class="fa-solid fa-phone"></i>
                                <span>{{ $gSetting->mobile }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="footer-socials">

                    @if ($gSetting->tiktok)
                        <a href="{{ $gSetting->tiktok }}" target="_blank">
                            <img class="contestWidth" src="{{ asset('images/tik.png') }}" />
                        </a>
                    @endif
                    @if ($gSetting->linkedin)
                        <a href="{{ $gSetting->linkedin }}" target="_blank">
                            {{-- <i class="icon-facebook"></i> --}}
                            <img class="contestWidth" src="{{ asset('images/link.png') }}" />
                        </a>
                    @endif
                    @if ($gSetting->x)
                        <a href="{{ $gSetting->x }}" target="_blank">
                            {{-- <i class="icon-x"></i> --}}
                            <img class="contestWidth" src="{{ asset('images/x.png') }}" />
                        </a>
                    @endif
                    @if ($gSetting->instagram)
                        <a href="{{ $gSetting->instagram }}" target="_blank">
                            {{-- <i class="icon-instagram"></i> --}}
                            <img class="contestWidth" src="{{ asset('images/inst.png') }}" />
                        </a>
                    @endif
                    @if ($gSetting->youtube)
                        <a href="{{ $gSetting->youtube }}" target="_blank">
                            <img class="contestWidth" src="{{ asset('images/yout.png') }}" />
                            {{-- <i class="icon-youtube"></i> --}}

                        </a>
                    @endif
                    @if ($gSetting->snapchat)
                        <a href="{{ $gSetting->snapchat }}" target="_blank">
                            {{-- <i class="fa fa-snapchat"></i> --}}
                            <img class="contestWidth" src="{{ asset('images/sna.png') }}" />
                        </a>
                    @endif

                    @if ($gSetting->telegram)
                        <a href="{{ $gSetting->telegram }}" target="_blank">
                            {{-- <i class="fa fa-telegram"></i> --}}
                            <img class="contestWidth" src="{{ asset('images/teleg.png') }}" />
                        </a>
                    @endif
                    @if ($gSetting->whatsapp)
                        <a href="https://api.whatsapp.com/send?phone=+966<?= $gSetting->whatsapp ?>&text=مرحبا"
                            target="_blank">
                            {{-- <i class="fa fa-whatsapp"></i> --}}
                            <img class="contestWidth" src="{{ asset('images/wapp.png') }}" />
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <div class="footer__copyright">
        <div class="container">
            <div
                class="d-flex gap-1 flex-wrap align-items-center justify-content-md-between justify-content-center rtlDirection">
                <p class="wow fadeInDown" data-wow-delay="00ms" data-wow-duration="1500ms">&copy;
                    <span class="tr-ar">جميع الحقوق محفوظة</span><span class="tr-en">All rights reserved</span> {{ now()->year }}

                    <span class="tr-ar">لدى</span><span class="tr-en">by</span> <a class="primary-color">{{ $gSetting->name }}</a></p>
                <ul class="footer-policy-list d-flex align-items-center gap-4 wow fadeInDown" data-wow-delay="200ms"
                    data-wow-duration="1500ms">

                    <li><a class="footer-policy-link" href='{{ url('page/1') }}'><i class="fa-solid fa-file-contract" aria-hidden="true"></i><span class="tr-ar">الشروط والأحكام</span><span class="tr-en">Terms</span></a></li>
                    <li><a class="footer-policy-link" href='{{ url('page/2') }}'><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><span class="tr-ar">سياسة الخصوصية</span><span class="tr-en">Privacy</span></a></li>
                    <li><a class="footer-policy-link" href='{{ url('page/3') }}'><i class="fa-solid fa-rotate-left" aria-hidden="true"></i><span class="tr-ar">سياسة الاسترجاع</span><span class="tr-en">Returns</span></a></li>
                </ul>
            </div>
            <div class="neweb-credit-row">
                <a class="neweb-credit" href="https://www.ne-wb.com" target="_blank" rel="noopener noreferrer"
                    aria-label="تطوير وتصميم Neweb">
                    <span class="neweb-credit__icon" aria-hidden="true">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </span>
                    <span class="neweb-credit__text">
                        <span class="neweb-credit__arabic">تطوير وتصميم</span>
                        <strong>Neweb</strong>
                    </span>
                </a>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-policy-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        white-space: nowrap;
    }

    .footer-policy-link i {
        color: #D989A3;
        font-size: 0.95em;
    }

    .footer-register-card {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        margin-top: 18px;
        padding: 12px 14px;
        border: 1px solid rgba(255, 249, 239, 0.16);
        border-radius: 8px;
        background:
            linear-gradient(135deg, rgba(255, 249, 247, 0.10), rgba(217, 137, 163, 0.06)),
            rgba(255, 249, 247, 0.055);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08), 0 16px 34px rgba(0, 0, 0, 0.10);
    }

    .footer-register-card__icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 64px;
        width: 64px;
        height: 64px;
        border-radius: 0;
        background: transparent;
        box-shadow: none;
        overflow: visible;
    }

    .footer-register-card__icon img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 0;
    }

    .footer-register-card__text {
        display: grid;
        gap: 2px;
        min-width: 0;
        color: #FFF9F7 !important;
        font-size: 13px;
        font-weight: 900;
        line-height: 1.45;
    }

    .footer-register-card__text span,
    .footer-register-card__text strong {
        color: #FFF9F7 !important;
    }

    .footer-register-card__text strong {
        direction: ltr;
        font-size: 16px;
        letter-spacing: 0;
    }

    @media (max-width: 767px) {
        .footer__copyright .container > .d-flex {
            display: grid !important;
            grid-template-columns: 1fr;
            justify-items: center;
            text-align: center;
        }

        .footer-policy-list {
            width: 100%;
            display: grid !important;
            grid-template-columns: 1fr;
            gap: 8px !important;
            padding: 0;
            margin: 0;
        }

        .footer-policy-list li {
            width: 100%;
        }

        .footer-policy-link {
            width: 100%;
            min-height: 42px;
            white-space: normal;
            text-align: center;
        }
    }

    .neweb-credit-row {
        display: flex;
        justify-content: flex-start;
        direction: ltr;
        margin-top: 12px;
        margin-left: calc((min(100vw, 1140px) - 100vw) / 2 + 1px);
    }

    .neweb-credit {
        position: static !important;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        min-height: 40px;
        max-width: calc(100vw - 36px);
        padding: 7px 14px 7px 10px !important;
        border: 1px solid rgba(255, 255, 255, 0.78);
        border-radius: 999px;
        color: #2F3B31 !important;
        background:
            radial-gradient(circle at 18% 18%, rgba(255, 255, 255, 0.96), rgba(255, 255, 255, 0.5) 32%, rgba(207, 166, 160, 0.28) 100%),
            linear-gradient(135deg, rgba(255, 252, 246, 0.94), rgba(255, 249, 239, 0.72));
        box-shadow: 0 18px 45px rgba(47, 59, 49, 0.16), inset 0 1px 0 rgba(255, 255, 255, 0.72);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        font-size: 12px;
        font-weight: 900;
        line-height: 1.35;
        text-decoration: none;
        letter-spacing: 0;
        overflow: hidden;
        transition: box-shadow 0.22s ease, border-color 0.22s ease, background-color 0.22s ease;
    }

    .neweb-credit::before {
        display: none;
    }

    .neweb-credit__icon {
        position: relative;
        display: grid;
        place-items: center;
        flex: 0 0 26px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        color: #FFF9F7;
        background: linear-gradient(135deg, #3E4A3F, #8FAF8B 66%, #CFA6A0);
        box-shadow: 0 10px 24px rgba(47, 59, 49, 0.20);
    }

    .neweb-credit__icon::after {
        content: "";
        position: absolute;
        inset: -4px;
        border-radius: inherit;
        border: 1px solid rgba(207, 166, 160, 0.38);
    }

    .footer-two-area .footer__copyright .neweb-credit .neweb-credit__text {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        direction: rtl;
        white-space: nowrap;
        color: #4B213F !important;
    }

    .footer-two-area .footer__copyright .neweb-credit .neweb-credit__arabic {
        display: inline-flex;
        color: #4B213F !important;
        font-weight: 900;
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.7);
    }

    .footer-two-area .footer__copyright .neweb-credit .neweb-credit__text strong {
        display: inline-flex;
        align-items: center;
        padding: 1px 5px;
        border-radius: 999px;
        color: #163D2C !important;
        background: rgba(255, 255, 255, 0.58);
        font-size: 15px;
        font-weight: 900;
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.72);
    }

    .neweb-credit:hover {
        color: #2F3B31 !important;
        border-color: rgba(207, 166, 160, 0.58);
        box-shadow: 0 20px 48px rgba(47, 59, 49, 0.20), inset 0 1px 0 rgba(255, 255, 255, 0.82);
    }

    @media (max-width: 575px) {
        .neweb-credit-row {
            justify-content: center;
            margin-left: 0;
            margin-top: 14px;
        }

        .neweb-credit {
            padding: 9px 12px 9px 10px;
            font-size: 12px;
        }
    }
</style>

<script src="{{ asset('frontend/js/jquery-3.7.1.min.js') }}"></script>
<!-- Jquery 3. 7. 1 Min Js -->
<!-- Bootstrap min Js -->
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<!-- Mean menu Js -->
<script src="{{ asset('frontend/js/meanmenu.js') }}"></script>
<!-- Swiper bundle min Js -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<!-- Counterup min Js -->
<script src="{{ asset('frontend/js/jquery.counterup.min.js') }}"></script>
<!-- Wow min Js -->
<script src="{{ asset('frontend/js/wow.min.js') }}"></script>
<!-- Magnific popup min Js -->
<script src="{{ asset('frontend/js/magnific-popup.min.js') }}"></script>
<!-- Nice select min Js -->
{{-- <script src="{{ asset('frontend/js/nice-select.min.js') }}"></script> --}}
<!-- Parallax Js -->
<script src="{{ asset('frontend/js/parallax.js') }}"></script>
<!-- Waypoints Js -->
<script src="{{ asset('frontend/js/jquery.waypoints.js') }}"></script>
<!-- Script Js -->
<script src="{{ asset('frontend/js/script.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.SwalBtn1', function() {
            swal.clickConfirm();
        });
        $(document).on('click', '.SwalBtn2', function() {
            swal.clickConfirm();
        });
        $('.select2').select2({
            allowClear: true
        });

        const applyLanguage = (lang) => {
            const isEnglish = lang === 'en';
            document.documentElement.lang = lang;
            document.documentElement.dir = isEnglish ? 'ltr' : 'rtl';
            document.body.classList.toggle('lang-en', isEnglish);
            document.body.classList.toggle('lang-ar', !isEnglish);
            $('[data-lang-switch]').removeClass('active');
            $('[data-lang-switch="' + lang + '"]').addClass('active');
            $('[data-placeholder-ar]').each(function() {
                $(this).attr('placeholder', isEnglish ? $(this).data('placeholder-en') : $(this).data('placeholder-ar'));
            });
            localStorage.setItem('tyanielLang', lang);
        };

        applyLanguage(localStorage.getItem('tyanielLang') || 'ar');
        $(document).on('click', '[data-lang-switch]', function() {
            applyLanguage($(this).data('lang-switch'));
        });

        const closeHeaderMenus = () => {
            $('.main-menu li.is-open').removeClass('is-open');
        };

        $(document).on('click', '.main-menu nav > ul > li > a', function(event) {
            const $item = $(this).parent('li');
            if (!$item.children('.sub-menu').length) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();
            $item.toggleClass('is-open')
                .siblings('li')
                .removeClass('is-open')
                .find('.is-open')
                .removeClass('is-open');
        });

        $(document).on('click', '.main-menu .sub-menu > li > a', function(event) {
            const $item = $(this).parent('li');
            if (!$item.children('.sub-sub-menu').length) {
                closeHeaderMenus();
                return;
            }

            event.preventDefault();
            event.stopPropagation();
            $item.toggleClass('is-open')
                .siblings('li')
                .removeClass('is-open');
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.main-menu').length) {
                closeHeaderMenus();
            }
        });

        $(document).on('keydown', function(event) {
            if (event.key === 'Escape') {
                closeHeaderMenus();
            }
        });
    });
</script>

@yield('JScript')


</body>

</html>
