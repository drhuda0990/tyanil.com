<?php

namespace App\Http\Controllers;

use App\cvTemplate;
use App\cvSectionTemplate;
use App\Http\Requests\StorecvTemplateRequest;
use App\Http\Requests\UpdatecvTemplateRequest;
use Illuminate\Http\Request;
use Auth;
use Mpdf\Mpdf;

class CvTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('CV.index');
    }

    public function create()
    {
        $sectionTypes = [
            'experience' => 'الخبرات',
            'education' => 'التعليم',
            'skills' => 'المهارات',
            'languages' => 'اللغات',
            'certificates' => 'الشهادات',
            'work_history' => 'التاريخ الوظيفي',
            'references' => 'المراجع',
        ];

        return view('CV.create', compact('sectionTypes'));
    }

    // Save CV and sections
    public function store(Request $request)
    {
        $cv = cvTemplate::create([
            'profile_content' => $request->profile_content,
            'title' => $request->title,
            'name' => $request->name,
            'job' => $request->job,
            'customer_id' => Auth::guard('customer')->user()->id,
            'contact' => $request->contact,
            'location' => $request->location,
            'language' => $request->language,
        ]);

        if ($request->sections) {
            foreach ($request->sections as $section) {
                cvSectionTemplate::create([
                    'cv_template_id' => $cv->id,
                    'customer_id' => Auth::guard('customer')->user()->id,
                    'title' => $section['title'] ?? null,
                    'date' => $section['date'] ?? null,
                    'content' => $section['content'] ?? null,
                    'url' => $section['url'] ?? null,
                    'order_num' => $section['order_num'] ?? null,
                    'location' => $section['location'] ?? null,
                    'expert_level' => $section['expert_level'] ?? null,
                    'type' => $section['type'] ?? null,
                ]);
            }
        }

        return redirect()->route('CV.index');
    }


    public function edit($id)
    {
        $cv = cvTemplate::with('sections')->findOrFail(decrypt($id));
        $sectionTypes = [
            'education' => 'التعليم',
            'experience' => 'الخبرة العملية',
            'skills' => 'المهارات',
            'projects' => 'المشاريع',
            'certificates' => 'الشهادات',
            'languages' => 'اللغات',
            'references' => 'المراجع',
        ];

        return view('CV.create', compact('cv', 'sectionTypes'));
    }

    public function update(Request $request, $id)
    {
        $cv = cvTemplate::findOrFail($id);
        $cv->update([
            'profile_content' => $request->profile_content,
            'title' => $request->title,
            'name' => $request->name,
            'job' => $request->job,
            'contact' => $request->contact,
            'location' => $request->location,
            'language' => $request->language,
        ]);

        // Delete old sections
        cvSectionTemplate::where('cv_template_id', $cv->id)->delete();

        // Add updated sections
        if ($request->sections) {
            foreach ($request->sections as $section) {
                cvSectionTemplate::create([
                    'cv_template_id' => $cv->id,
                    'customer_id' => Auth::guard('customer')->user()->id,
                    'title' => $section['title'] ?? null,
                    'date' => $section['date'] ?? null,
                    'content' => $section['content'] ?? null,
                    'url' => $section['url'] ?? null,
                    'order_num' => $section['order_num'] ?? null,
                    'location' => $section['location'] ?? null,
                    'expert_level' => $section['expert_level'] ?? null,
                    'type' => $section['type'] ?? null,
                ]);
            }
        }

        return redirect()->route('CV.index')->with('info', 'تم التحديث بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cv = cvTemplate::with('sections')->findOrFail(decrypt($id));
        cvSectionTemplate::where('cv_template_id', $cv->id)->delete();
        $cv->delete();
        return redirect()->route('CV.index')->with('info', 'تم الحذف بنجاح');
    }
    public function pdfDownload($id, $template)
    {
        $cv = cvTemplate::with('sections')->findOrFail(decrypt($id));
        $html = view("cv.$template", compact('cv'))->render();

        $mpdf = new Mpdf([
            'default_font' => 'dejavusans',
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 15,
            'margin_right' => 15,
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output("cv.$template", 'I'); // I = inline, D = download
    }
}
