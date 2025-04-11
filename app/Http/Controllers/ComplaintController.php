<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\Complaint;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;

class ComplaintController extends Controller
{
    public function index()
    {
        return Inertia::render('viewjs/complaint/index', [
            'complaints' => Complaint::get()
        ]);
    }
    public function create()
    {
        return Inertia::render('viewjs/complaint/create');
    }
    public function store(StoreComplaintRequest $request)
    {
        // saving and extracting uploaed picture
        if ($request->hasFile('image_file')) {
            $request->merge([
                'picture' => '/storage/' . $request->file('image_file')->store('pictures', 'public'),
            ]);
        }
        $complaint = Complaint::create($request->all());
        return redirect()->route(
            'complaint.show', [
                'complaint' => $complaint
        ]);
    }

    public function show(Complaint $complaint)
    {
        return Inertia::render(
            'viewjs/complaint/show',
            ['complaint' => $complaint]
        );
    }
    public function edit(Complaint $complaint)
    {
        return Inertia::render(
            'viewjs/complaint/edit',
            ['complaint' => $complaint]
        );
    }

    // this must be called using POST if image_file is included
    public function update(UpdateComplaintRequest $request, Complaint $complaint)
    {
        // if update includes saving images, it should ne called by post not put or patch
        // saving and extracting uploaed picture
        if ($request->hasFile('image_file')) {
            if ($request['picture'] != null){
                $originalString = $request['picture'];
                $searchString = '/storage/';
                $replaceString = '';
                $newString = Str::replace($searchString, $replaceString, $originalString);
                Storage::delete($newString);
            }
            $request->merge([
                'picture' => '/storage/' . $request->file('image_file')->store('pictures', 'public'),
            ]);
        }
        $complaint->update($request->all());
        return redirect()->route('complaint.show', ['complaint' => $complaint]);
    }
}
