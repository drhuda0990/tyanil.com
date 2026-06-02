<div id="pdfViewer"></div>

@section('JScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc =
            'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
        pdfjsLib.getDocument('/view/pdf/{{ encrypt($file->id) }}').promise.then(function(pdf) {
            pdf.getPage(1).then(function(page) {
                let scale = 1.5;
                let viewport = page.getViewport({
                    scale
                });

                let canvas = document.createElement('canvas');
                let context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                document.getElementById('pdfViewer').appendChild(canvas);

                page.render({
                    canvasContext: context,
                    viewport
                });
            });
        });
    </script>
@endsection
