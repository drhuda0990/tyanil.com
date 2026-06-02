<div class="accordion-item shadow border-none wow fadeInDown" data-wow-delay="00ms" data-wow-duration="1500ms">
    <h2 class="accordion-header" id="heading{{ $cv->id }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#s{{ $cv->id }}" aria-expanded="false" aria-controls="s{{ $cv->id }}">
            {{ $key + 1 }} -
            {{ $cv->title }}
        </button>
    </h2>
    <div id="s{{ $cv->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $cv->id }}"
        data-bs-parent="#accordionExample">
        <div class="accordion-body">

            <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                تفاصيل السيرة الذاتية
            </h5>

            <p>
                {{ $cv->profile_content }}</p>

            <a href="{{ route('cv.edit', ['id' => encrypt($cv->id)]) }}">
                <button class="btn-one" type="submit">
                    تعديل
                </button>
            </a>

            <a href="{{ route('cv.pdfDownload', ['id' => encrypt($cv->id), 'temp' => 'pdfTemplate1']) }}">
                <button class="btn-one" type="">
                    النموذج الأول
                </button>
            </a>
            <a href="{{ route('cv.delete', ['id' => encrypt($cv->id)]) }}">
                <button class="btn-one bg-red" type="submit">
                    حذف
                </button>
            </a>
        </div>
    </div>
</div>
