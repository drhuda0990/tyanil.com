@php($gSetting = \App\Support\StoreSettings::get())
@include('layouts.header')
<!-- ****************** -->
<main>
    @yield('content')
</main>

<!-- ****************** -->
@include('layouts.footer')
<script>
    window.tyanielEscapeHtml = function(value) {
        return String(value ?? '').replace(/[&<>"']/g, function(character) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[character];
        });
    };
</script>
@if ($errors->any())
    <script>
        const validationErrors = @json($errors->all());
        Swal.fire({
            title: "",
            icon: "error",
            html: "<br>" +
                validationErrors.map(window.tyanielEscapeHtml).join('<br>') + '<br>' +
                '<br><button type="button" role="button" tabindex="0" class="btn-one SwalBtn1">' +
                'حسناً' + '</button>',
            showCancelButton: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.getPopup().setAttribute('dir', 'rtl');
            }

        });
    </script>
@endif
@if (session('status'))
    <script>
        const statusMessage = @json(session('status'));
        Swal.fire({
            title: "",
            icon: "success",
            html: "<br>" +
                window.tyanielEscapeHtml(statusMessage) + '<br>' +
                '<br><button type="button" role="button" tabindex="0" class="btn-one SwalBtn1 ">' +
                'حسناً' + '</button>',
            showCancelButton: false,
            showConfirmButton: false

        });
    </script>
@endif
@if (session('cartAdded'))
    <script>
        const cartAddedMessage = @json(session('cartAdded'));
        Swal.fire({
            title: "",
            icon: "success",
            html: "<br>" +
                window.tyanielEscapeHtml(cartAddedMessage) + '<br>' +
                '<div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;margin-top:18px;">' +
                '<button type="button" role="button" tabindex="0" class="btn-one SwalBtn1" onclick="Swal.close()">' +
                'متابعة التسوق' +
                '</button>' +
                '<a style="text-decoration:none;" class="btn-one SwalBtn1" href="{{ route('customer.cart') }}">' +
                'الذهاب للسلة والدفع' +
                '</a>' +
                '</div>',
            showCancelButton: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.getPopup().setAttribute('dir', 'rtl');
            }
        });
    </script>
@endif
@if (session('info'))
    <script>
        const infoMessage = @json(session('info'));
        Swal.fire({
            title: "",
            icon: "info",
            html: "<br>" +
                window.tyanielEscapeHtml(infoMessage) + '<br>' +
                '<br><button type="button" role="button" tabindex="0" class="btn-one SwalBtn1">' +
                'حسناً' + '</button>',
            showCancelButton: false,
            showConfirmButton: false

        });

        // toastr.info('{{ session('info') }}');
    </script>
@endif
@if (session('message'))
    <script>
        const messageText = @json(session('message'));
        Swal.fire({
            title: "",
            icon: "info",
            html: "<br>" +
                window.tyanielEscapeHtml(messageText) + '<br>' +
                '<br><button type="button" role="button" tabindex="0" class="btn-one SwalBtn1">' +
                'حسناً' + '</button>',
            showCancelButton: false,
            showConfirmButton: false

        });
        // toastr.success('{{ session('message') }}');
    </script>
@endif
@if (session('noCartAddress'))
    <script>
        const noCartAddressMessage = @json(session('noCartAddress'));
        Swal.fire({
            title: "",
            icon: "info",
            html: "<br>" +
                window.tyanielEscapeHtml(noCartAddressMessage) + '<br>' +
                '<a style="color:#4ea350;text-decoration:none;margin:5px;" class="SwalBtn1 btn-one" href="{{ route('customer.cart') }}#checkout-address" >' +
                'تعبئة العنوان داخل الدفع' +
                '</a>',
            showCancelButton: false,
            showConfirmButton: false

        });
        // toastr.success('{{ session('message') }}');
    </script>
@endif

@if (session('needAddress'))
    {{-- <script>
        Swal.fire({
            title: "",
            icon: "info",
            html: "<br>" +
                'شكراً لك لتحديث بياناتك نرجوا منك إضافة عنوان للشحن' + '<br><br>' +
                '<a style="color:#4ea350;text-decoration:none;margin:5px;" href="{{ route('customer.newAddress') }}" ><button type="button" role="button" tabindex="0" class="SwalBtn1 btn-one">' +
                '  إضافة عنوان ' +
                '</button></a><br><button type="button" role="button" tabindex="0" class="btn-one SwalBtn1 bg-red">' +
                ' إلغاء' + '</button>',
            showCancelButton: false,
            showConfirmButton: false

        });
        // toastr.success('{{ session('message') }}');
    </script> --}}
@endif
