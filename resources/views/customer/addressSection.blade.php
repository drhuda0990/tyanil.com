<div class="accordion-item shadow border-none wow fadeInDown" data-wow-delay="00ms" data-wow-duration="1500ms">
    <h2 class="accordion-header" id="heading{{ $address->id }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#s{{ $address->id }}" aria-expanded="false" aria-controls="s{{ $address->id }}">
            {{ $key + 1 }} - {{ $address->name }} | {{ $address->phone }} |
            {{ $address->email }}
        </button>
    </h2>
    <div id="s{{ $address->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $address->id }}"
        data-bs-parent="#accordionExample">
        <div class="accordion-body">

            <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                تفاصيل العنوان
            </h5>
            {{-- <p>
            الدولة:
            {{ $address->country_id }}</p> --}}
            <p>
                المدينة:
                {{ $address->city_id }}</p>
            <p>
                الشارع:
                {{ $address->street }}</p>
            <p>
                العنوان:
                {{ $address->address }}</p>
            <hr>


            <a href="{{ route('customer.address', ['id' => encrypt($address->id)]) }}">
                <button class="btn-one" type="submit">
                    تعديل
                </button>
            </a>

            <a href="{{ route('customer.address.delete', ['id' => encrypt($address->id)]) }}">
                <button class="btn-one bg-red" type="submit">
                    حذف
                </button>
            </a>
        </div>
    </div>
</div>
