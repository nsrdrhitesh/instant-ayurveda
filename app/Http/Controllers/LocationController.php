<?php

namespace App\Http\Controllers;

use App\Models\HospitalLocation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        return view('centre.locations', ['locations' => HospitalLocation::orderBy('display_order')->get()]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'published' => $request->boolean('published'),
            'featured' => $request->boolean('featured'),
        ]);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'address' => ['nullable', 'string', 'max:1000'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:254'],
            'map_url' => ['nullable', 'url:http,https', 'max:1000'],
            'opening_hours' => ['nullable', 'string', 'max:500'],
            'published' => ['required', 'boolean'],
            'featured' => ['required', 'boolean'],
            'display_order' => ['required', 'integer', 'between:0,999'],
        ]);
        HospitalLocation::create($this->visitorDetails($data));
        return back()->with('success', 'Hospital location added.');
    }

    public function update(Request $request, HospitalLocation $location)
    {
        $request->merge([
            'published' => $request->boolean('published'),
            'featured' => $request->boolean('featured'),
        ]);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'address' => ['nullable', 'string', 'max:1000'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:254'],
            'map_url' => ['nullable', 'url:http,https', 'max:1000'],
            'opening_hours' => ['nullable', 'string', 'max:500'],
            'published' => ['required', 'boolean'],
            'featured' => ['required', 'boolean'],
            'display_order' => ['required', 'integer', 'between:0,999'],
        ]);
        $location->update($this->visitorDetails($data));
        return back()->with('success', 'Hospital location updated.');
    }

    private function visitorDetails(array $data): array
    {
        foreach (['address', 'postal_code', 'phone'] as $field) {
            $data[$field] = $data[$field] ?? '';
        }

        return $data;
    }

    public function destroy(HospitalLocation $location)
    {
        $location->delete();
        return back()->with('success', 'Hospital location removed.');
    }
}
