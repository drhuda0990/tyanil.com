<?php

namespace App\Http\Controllers;

use App\AdditionalFeatures;
use Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Customer;
use App\City;
use App\General;
use App\Definition;
use Laravel\Nova\Notifications\NovaNotification;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\PaymentRequest;
use App\PaymentResponse;
use App\GeneralSetting;
use App\Cart;
use App\CustomerAddress;
use App\Discount;
use App\Rules\NumWords;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\JitsiMeeting;
use App\SerInvoiceItemsFeature;
use App\ServiceInvoiceItem;
use App\Service;
use App\ServiceInvoice;
use Illuminate\Http\Request;
use Session;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;
use Illuminate\Auth\Events\Registered;
use Firebase\JWT\JWT;
use MacsiDigital\Zoom\Meeting;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Support\Facades\Log;
use Pion\Laravel\ChunkUpload\Handler\ResumableJSUploadHandler;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.web');
    }
    /**
     * Display a listing of the resource.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:512000'],
            'model_id' => ['required', 'integer', 'exists:services,id'],
            'resumableFilename' => ['required', 'string', 'max:255'],
            'resumableChunkNumber' => ['required', 'integer', 'min:1'],
            'resumableTotalChunks' => ['required', 'integer', 'min:1'],
        ]);

        $receiver = new FileReceiver("file", $request, ResumableJSUploadHandler::class);
        if (!$receiver->isUploaded()) {
            return response()->json(['error' => 'لم يتم تحميل الملف'], 400);
        }
        $save = $receiver->receive();
        if ($save->isFinished() && ($request->resumableChunkNumber >= $request->resumableTotalChunks)) {
            $file = $save->getFile();
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf', 'video/mp4'];
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'pdf', 'mp4'];
            $originalName = basename((string) $request->get('resumableFilename'));
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            if (!in_array($file->getMimeType(), $allowedMimeTypes, true) || !in_array($extension, $allowedExtensions, true)) {
                @unlink($file->getPathname());

                return response()->json(['error' => 'نوع الملف غير مسموح'], 422);
            }

            $baseName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) ?: 'upload';
            $safeFileName = $baseName . '-' . Str::random(8) . '.' . $extension;
            $model = Service::find($request->get('model_id'));
            if ($model) {
                $model->addMedia($file)
                    ->usingName(pathinfo($originalName, PATHINFO_FILENAME))
                    ->usingFileName($safeFileName)
                    ->toMediaCollection('largeFileUploads');
            }
            // dd($save->isFinished());
            return response()->json(['done' => true]); // ✅ this tells JS: we're finished
        }

        // Return progress for non-final chunks
        $handler = $save->handler();
        Log::info('Chunk handler class:', ['class' => get_class($handler)]);

        $chunkId = method_exists($handler, 'getChunkFileIdentifier')
            ? $handler->getChunkFileIdentifier()
            : null;

        Log::info('Uploading chunk', [
            'chunk_number' => $request->get('resumableChunkNumber'),
            'chunk_id' => $chunkId,
            'percentage' => $handler->getPercentageDone()
        ]);

        return response()->json([
            'done' => false,
            'percentage' => $handler->getPercentageDone()
        ]);
    }

    public function showupload($id = null)
    {
        $service = Service::find($id);
        if ($service) {
            $SQL = [
                'service' => $service,
            ];
            return view('admin.uploadFile', $SQL);
        } else {
            abort(404);
        }
    }
    public function pdfInvoice($invoices)
    {
        $invoice_fields = Session::get('invoice_fields');
        // dd();
        $mfields = decrypt($invoices);
        $from_date = null;
        $to_date = null;
        if ($invoice_fields) {
            if ($invoice_fields->all_filter_data || ($invoice_fields->all_filter_data == null && $invoice_fields->selected_data == null)) {
                $mInvoice = ServiceInvoiceItem::where('purchase_price', '>', 0);
                // dd($mfields);
                // $filters = json_decode(base64_decode($request->filters), true);
                foreach ($mfields as $mfield) {
                    foreach ($mfield as $key => $value) {
                        if ($key == 'App\Nova\Filters\FromInvoiceDateFilters' && $value != "") {
                            $mInvoice->whereDate('created_at', '>=', \Illuminate\Support\Carbon::parse($value));
                            $from_date = $value;
                        }
                        if ($key == 'App\Nova\Filters\ToDateInvoiceFilters' && $value != "") {
                            $mInvoice->whereDate('created_at', '<=', \Illuminate\Support\Carbon::parse($value));
                            $to_date = $value;
                        }
                    }
                }
                $invoices = $mInvoice->get();
                $invoice = $invoices[0];
            }



            if ($invoice_fields->selected_data) {
                $invoices = Session::get('invoice_data');

                $invoices = ServiceInvoiceItem::whereIn('id', $invoices)->get();
                $invoice = $invoices[0];
            }
        } else {
            abort(404);
        }

        $gSetting = GeneralSetting::first();

        return view('admin.pdfInvoice', compact('invoices', 'gSetting', 'from_date', 'to_date'));
    }
}
