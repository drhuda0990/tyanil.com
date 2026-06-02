@extends('layouts.app')
@section('title', isset($cv) ? 'تعديل السيرة الذاتية' : 'إضافة سيرة ذاتية')

@section('content')
    <section class="contact-area pt-120 pb-120">
        <div class="container">
            <div class="section-header mb-40">
                <h5>{{ isset($cv) ? 'تعديل السيرة الذاتية' : 'إنشاء سيرة ذاتية جديدة' }}</h5>
            </div>
            <hr>
            <div class="contact__info pb-120">
                <div class="row g-5">
                    <div class="col-lg-12 order-1 order-lg-2 rtlDirection">

                        <form action="{{ isset($cv) ? route('cv.update', $cv->id) : route('cv.store') }}" method="POST"
                            class="form-box rtlDirection form-class form-bground">
                            @csrf
                            @if (isset($cv))
                                @method('PUT')
                            @endif

                            <h4>المعلومات العامة</h4>

                            <input type="text" name="title" placeholder="عنوان السيرة الذاتية" class="form-control mb-2"
                                value="{{ old('title', $cv->title ?? '') }}">
                            <input type="text" name="name" placeholder="الاسم الكامل" class="form-control mb-2"
                                value="{{ old('name', $cv->name ?? '') }}">
                            <input type="text" name="job" placeholder="العنوان الوظيفي" class="form-control mb-2"
                                value="{{ old('job', $cv->job ?? '') }}">
                            <input type="text" name="contact" placeholder="بيانات التواصل" class="form-control mb-2"
                                value="{{ old('contact', $cv->contact ?? '') }}">
                            <input type="text" name="location" placeholder="الموقع" class="form-control mb-2"
                                value="{{ old('location', $cv->location ?? '') }}">

                            <div class="mb-3">
                                <label>لغة السيرة الذاتية</label>
                                <select name="language" class="form-control select2">
                                    <option value="ar"
                                        {{ old('language', $cv->language ?? '') == 'ar' ? 'selected' : '' }}>عربي</option>
                                    <option value="en"
                                        {{ old('language', $cv->language ?? '') == 'en' ? 'selected' : '' }}>إنجليزي
                                    </option>
                                </select>
                            </div>

                            <textarea name="profile_content" class="form-control mb-3" placeholder="نبذة عنك">{{ old('profile_content', $cv->profile_content ?? '') }}</textarea>

                            <hr><br><br>
                            <h4>الأقسام</h4>

                            <div id="sections">
                                @if (isset($cv) && $cv->sections)
                                    @foreach ($cv->sections as $index => $section)
                                        <div class="section mb-3 border p-3 rounded">
                                            <select name="sections[{{ $index }}][type]"
                                                class="form-control mb-2 select2">
                                                <option value="">نوع القسم</option>
                                                @foreach ($sectionTypes as $key => $label)
                                                    <option value="{{ $key }}"
                                                        {{ $section->type == $key ? 'selected' : '' }}>{{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="sections[{{ $index }}][title]"
                                                value="{{ $section->title }}" placeholder="عنوان القسم"
                                                class="form-control mb-2">
                                            <input type="text" name="sections[{{ $index }}][date]"
                                                value="{{ $section->date }}" placeholder="التاريخ"
                                                class="form-control mb-2">
                                            <input type="text" name="sections[{{ $index }}][location]"
                                                value="{{ $section->location }}" placeholder="الموقع"
                                                class="form-control mb-2">
                                            <input type="text" name="sections[{{ $index }}][expert_level]"
                                                value="{{ $section->expert_level }}" placeholder="مستوى الخبرة (إن وجد)"
                                                class="form-control mb-2">
                                            <input type="text" name="sections[{{ $index }}][url]"
                                                value="{{ $section->url }}" placeholder="الرابط (إن وجد)"
                                                class="form-control mb-2">
                                            <input type="text" name="sections[{{ $index }}][order_num]"
                                                value="{{ $section->order_num }}" placeholder="الترتيب"
                                                class="form-control mb-2">
                                            <textarea name="sections[{{ $index }}][content]" class="form-control" placeholder="المحتوى">{{ $section->content }}</textarea>
                                            <button type="button" class="btn btn-danger btn-sm removeSection mt-2">حذف هذا
                                                القسم</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="section mb-3 border p-3 rounded">
                                        <select name="sections[0][type]" class="form-control mb-2 select2">
                                            <option value="">نوع القسم</option>
                                            @foreach ($sectionTypes as $key => $label)
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="sections[0][title]" placeholder="عنوان القسم"
                                            class="form-control mb-2">
                                        <input type="text" name="sections[0][date]" placeholder="التاريخ"
                                            class="form-control mb-2">
                                        <input type="text" name="sections[0][location]" placeholder="الموقع"
                                            class="form-control mb-2">
                                        <input type="text" name="sections[0][expert_level]"
                                            placeholder="مستوى الخبرة (إن وجد)" class="form-control mb-2">
                                        <input type="text" name="sections[0][url]" placeholder="الرابط (إن وجد)"
                                            class="form-control mb-2">

                                        <input type="text" name="sections[0][order_num]" placeholder="الترتيب"
                                            class="form-control mb-2">
                                        <textarea name="sections[0][content]" class="form-control" placeholder="المحتوى"></textarea>
                                        <button type="button" class="btn btn-danger btn-sm removeSection mt-2">حذف هذا
                                            القسم</button>
                                    </div>
                                @endif
                            </div>

                            <button type="button" id="addSection" class="btn btn-sm btn-secondary mt-2">+ إضافة
                                قسم</button>

                            <br><br>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($cv) ? 'تحديث السيرة الذاتية' : 'حفظ السيرة الذاتية' }}
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('JScript')
    <script>
        $(document).ready(function() {
            // Function to enable delete buttons
            function enableRemoveButtons() {
                document.querySelectorAll('.removeSection').forEach(btn => {
                    btn.addEventListener('click', function() {
                        this.closest('.section').remove();
                    });
                });
            }

            // Enable delete on load
            enableRemoveButtons();
            // Initialize Select2 on page load
            $('select.select2').select2({
                allowClear: true,
                width: '100%'
            });

            let sectionIndex = {{ isset($cv) && $cv->sections ? count($cv->sections) : 1 }};

            $('#addSection').on('click', function() {
                const div = document.createElement('div');
                div.classList.add('section', 'mb-3', 'border', 'p-3', 'rounded');
                div.innerHTML = `
            <hr><br>
            <select name="sections[${sectionIndex}][type]" class="form-control mb-2 select2">
                <option value="">نوع القسم</option>
                @foreach ($sectionTypes as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            <input type="text" name="sections[${sectionIndex}][title]" placeholder="عنوان القسم" class="form-control mb-2">
            <input type="text" name="sections[${sectionIndex}][date]" placeholder="التاريخ" class="form-control mb-2">
            <input type="text" name="sections[${sectionIndex}][location]" placeholder="الموقع" class="form-control mb-2">
            <input type="text" name="sections[${sectionIndex}][expert_level]" placeholder="مستوى الخبرة (إن وجد)" class="form-control mb-2">
            <input type="text" name="sections[${sectionIndex}][url]" placeholder="الرابط (إن وجد)" class="form-control mb-2">
            <input type="text" name="sections[${sectionIndex}][order_num]" placeholder="الترتيب" class="form-control mb-2">
            <textarea name="sections[${sectionIndex}][content]" class="form-control" placeholder="المحتوى"></textarea>
            <button type="button" class="btn btn-danger btn-sm removeSection mt-2">حذف هذا القسم</button>
 `;
                document.getElementById('sections').appendChild(div);

                // ✅ Reinitialize Select2 only for the new element
                $(div).find('select.select2').select2({
                    allowClear: true,
                    width: '100%'
                });

                sectionIndex++;
                enableRemoveButtons();

            });

        });
    </script>
@endsection
