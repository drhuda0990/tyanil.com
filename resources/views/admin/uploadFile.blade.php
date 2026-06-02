@extends('layouts.app')
@section('title', 'لوحة التحكم')
<!--* ********************************* -->
@section('SCSS')
    <style>
    </style>
@endsection
<!--* ********************************* -->
@section('content')
    <section class="contact-area pt-120 pb-120">
        <div class="container">
            <div class="section-header mb-40">
                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> الملفات المرفقة للخدمة:
                    {{ $service->title }}
                </h5>
            </div>
            <div class="contact__info pb-120">

                <div class="row g-5">

                    <div class="col-lg-12 order-1 order-lg-2 ">
                        <div class="accordion rtlDirection" id="accordionExample">
                            <form id="uploadForm" class="form-box rtlDirection">
                                <input type="hidden" name="model_id" id="model_id" value="{{ $service->id }}">
                                <input type="file" id="files" name="files[]" multiple>

                                <button class="btn-one" type="submit" id="submitBtn">
                                    <span class="label">حفظ وإرسال</span>
                                    <span class="loader" style="display:none;">⏳ جاري الرفع...</span>
                                    <i class="fa-light fa-arrow-right-long"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<!--* ********************************* -->
@section('JScript')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const uploadUrl = "{{ route('admin.chunkUpload.post') }}";

        const form = document.getElementById('uploadForm');
        const submitBtn = document.getElementById('submitBtn');
        const label = submitBtn.querySelector('.label');
        const loader = submitBtn.querySelector('.loader');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const files = document.getElementById('files').files;
            const model_id = document.getElementById('model_id').value;

            if (!files.length) {
                alert("يرجى اختيار ملفات للتحميل.");
                return;
            }

            submitBtn.disabled = true;
            label.style.display = "none";
            loader.style.display = "inline-block";

            let uploadedCount = 0;

            for (let i = 0; i < files.length; i++) {
                uploadFileInChunks(files[i], model_id, () => {
                    uploadedCount++;
                    if (uploadedCount === files.length) {
                        submitBtn.disabled = false;
                        label.style.display = "inline";
                        loader.style.display = "none";

                        Swal.fire({
                            title: "",
                            icon: "success",
                            html: "<br>✅ تم تحميل جميع الملفات بنجاح<br><br><button type='button' class='btn-one SwalBtn1'>حسناً</button>",
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });

        function uploadFileInChunks(file, model_id, onComplete) {
            const chunkSize = 1024 * 1024 * 50; // 5MB
            const totalChunks = Math.ceil(file.size / chunkSize);
            let currentChunk = 0;

            const sendChunk = () => {
                const start = currentChunk * chunkSize;
                const end = Math.min(start + chunkSize, file.size);
                const chunk = file.slice(start, end);
console.log(`📦 Uploading chunk ${currentChunk + 1}/${totalChunks} for ${file.name}`);
                const formData = new FormData();
                formData.append("file", chunk); // 👈 must be 'file'
                formData.append("resumableFilename", file.name);
                formData.append("resumableChunkNumber", currentChunk + 1);
                formData.append("resumableTotalChunks", totalChunks);
                formData.append("resumableChunkSize", chunkSize);
                formData.append("resumableTotalSize", file.size);
                formData.append("model_id", model_id);

                fetch(uploadUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData,
                        credentials: 'same-origin' // ✅ Important for session tracking
                    })
                    .then(async res => {
                        if (!res.ok) {
                            const errorText = await res.text();
                            console.error('❌ خطأ بالسيرفر:', errorText);
                            throw new Error('فشل التحميل');
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.done === false) {
                            currentChunk++;
                            sendChunk();
                        } else {
                            onComplete(); // ✅ Done!
                        }
                    })
                    .catch(err => {
                        alert("❌ حدث خطأ أثناء رفع الملف: " + file.name);
                        console.error(err);
                        submitBtn.disabled = false;
                        label.style.display = "inline";
                        loader.style.display = "none";
                    });
            };

            sendChunk();
        }
    </script>

@endsection
