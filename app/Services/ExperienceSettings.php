<?php

namespace App\Services;

use Illuminate\Support\Str;

class ExperienceSettings
{
    public const FIELDS = [
        'about_page_title' => ['About page heading', 'About InstantAyurved', 120],
        'about_page_description' => ['About page introduction and search description', 'Learn about InstantAyurved, Dr. Tejas Kadam and our approach to Ayurvedic care.', 320],
        'about_page_content' => ['About page body (optional HTML override)', '', 15000],
        'doctor_page_description' => ['Doctor page search description', 'Dr. Tejas Kadam, M.S. (Shalya Tantra), is an Ayurvedic surgeon and physician.', 320],
        'doctor_page_content' => ['Doctor page body (optional HTML override)', '', 15000],
        'facility_page_title' => ['Facility page heading', 'Our Facilities', 120],
        'facility_page_description' => ['Facility page introduction and search description', 'Explore InstantAyurved facilities and hospital locations in Daund and Nashik.', 320],
        'facility_page_content' => ['Facility page body (optional HTML override)', '', 15000],
        'newsletter_title' => ['Newsletter heading', 'Subscribe to Newsletter', 120],
        'home_online_title' => ['Online consultation heading', 'Online Consultation', 120],
        'home_online_copy' => ['Online consultation description', 'Request a virtual consultation with Dr. Tejas Kadam when you cannot visit the hospital in person.', 500],
        'home_callback_title' => ['Callback form heading', 'Request a Call Back', 120],
        'home_urgent_phone' => ['Urgent enquiry phone', '+91 7385498981', 30],
        'home_doctor_heading' => ['Doctor section label', 'About Our Doctor', 120],
        'home_trust_items' => ['Trust strip (one value and label per line)', "15+ | Years Experience\n5000+ | Patients Treated\n5+ | Speciality Services\n100% | Authentic Ayurveda", 500],
        'home_values_heading' => ['Why choose us heading', 'Why Choose InstantAyurved', 120],
        'home_values_items' => ['Why choose us cards (one title and description per line)', "Expert Doctors | Clinical care led by Dr. Tejas Kadam.\nAuthentic Ayurveda | Ayurvedic treatment approaches and dedicated therapy facilities.\nHolistic Approach | Consultations consider lifestyle, symptoms and personal care needs.", 900],
        'home_review_heading' => ['Patient stories heading', 'Patient Success Stories', 120],
        'home_video_heading' => ['Video section heading', 'Our YouTube Channel', 120],
        'home_label' => ['Hero label', 'Ayurvedic Super Speciality Hospital', 120],
        'home_services_heading' => ['Services heading', 'Ayurvedic Services We Offer', 120],
        'home_facility_heading' => ['Facility heading', 'A hospital built around Ayurvedic care', 120],
        'home_facility_copy' => ['Facility introduction', 'Explore our consultation spaces, therapy rooms and Panchakarma department in Daund.', 500],
        'home_cta_heading' => ['Consultation heading', 'Talk with our care team', 120],
        'home_cta_copy' => ['Consultation introduction', 'Tell us how to reach you and what kind of consultation you are looking for.', 500],
        'search_title' => ['Home search title', '', 120],
        'search_description' => ['Home search description', '', 320],
        'search_answer' => ['Public quick answer', '', 500],
    ];

    public function content(array $website): array
    {
        $content = [];
        foreach (self::FIELDS as $key => [, $default]) {
            $content[$key] = ($website[$key] ?? '') ?: $default;
        }

        $area = trim($website['service_area'] ?? '');
        $founder = trim($website['founder_name'] ?? 'Dr. Tejas Kadam');
        $brand = $website['brand_name'];
        $answer = "{$brand} offers Ayurvedic consultations with {$founder}";
        $answer .= $area === '' ? '.' : " in {$area}.";

        $content['search_title'] = $content['search_title'] ?: "Ayurvedic Super Speciality Hospital | {$brand}";
        $content['search_answer'] = $content['search_answer'] ?: $answer;
        $content['search_description'] = $content['search_description'] ?: Str::limit($content['search_answer'], 155);

        return $content;
    }

    public function locations(iterable $locations, string $organizationId): array
    {
        $nodes = [];
        foreach ($locations as $location) {
            if (!$location->address || !$location->postal_code) {
                continue;
            }

            $nodes[] = [
                '@type' => 'MedicalClinic',
                '@id' => route('contact').'#location-'.$location->id,
                'name' => $location->name,
                'parentOrganization' => ['@id' => $organizationId],
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $location->address,
                    'addressLocality' => $location->city,
                    'addressRegion' => $location->state,
                    'postalCode' => $location->postal_code,
                    'addressCountry' => 'IN',
                ],
            ] + array_filter([
                'telephone' => $location->phone,
                'hasMap' => $location->map_url,
            ]);
        }

        return ['@context' => 'https://schema.org', '@graph' => $nodes];
    }
}
