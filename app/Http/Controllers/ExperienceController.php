<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Services\ExperienceSettings;
use App\Services\WebsiteSettings;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function edit(WebsiteSettings $settings, ExperienceSettings $experience)
    {
        $website = $settings->all();

        return view('centre.experience', [
            'fields' => ExperienceSettings::FIELDS,
            'settings' => $website,
            'preview' => $experience->content($website),
        ]);
    }

    public function update(Request $request, WebsiteSettings $settings)
    {
        $rules = [];
        foreach (ExperienceSettings::FIELDS as $key => [, , $max]) {
            $rules[$key] = ['nullable', 'string', 'max:'.$max];
        }

        $data = $request->validate($rules);
        $sanitizer = app(\App\Services\ArticleContent::class);
        foreach (['about_page_content', 'doctor_page_content', 'facility_page_content'] as $key) {
            if (isset($data[$key])) {
                $data[$key] = $sanitizer->sanitize($data[$key]);
            }
        }

        $settings->save($data);
        Activity::record('Homepage and search settings updated', 'Website settings');

        return back()->with('success', 'Homepage and search settings saved.');
    }
}
