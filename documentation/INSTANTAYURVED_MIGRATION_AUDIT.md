# InstantAyurved Migration Audit

## 1. Source Website Inventory

The plain-PHP source is archived in `public_html.zip` and was extracted for audit. Production root pages include home, about, doctor profile, facility, services, five service detail pages, treatments, blog, contact, and legal pages. `gallery.php` and `testimonials.php` are zero-byte placeholders. Shared source layout is in `includes/header.php` and `includes/footer.php`, with Bootstrap, Font Awesome, AOS, Google Fonts and a custom stylesheet.

The `staging/` tree mirrors the production tree and contains only minor page/layout differences. No staging-only pages or deployment evidence justify migrating both trees. The production files are the canonical source.

## 2. Existing Laravel Architecture

- PHP `^8.3`; Laravel `^13.17`; Symfony HTML Sanitizer `^7.4`.
- Direct CSS/JavaScript assets under `public/css`, `public/js`, and `public/images`; no Vite manifest.
- Blade public and admin layouts with authentication and staff/RBAC middleware.
- Existing modules: posts/blog, revisions, categories/tags, services, FAQs, inquiries, follow-ups, reviews, client stories, media, comments, scripts, users and website settings.
- Existing public SEO metadata, canonical/robots/Open Graph/Twitter fields, BlogPosting/Organization/Service/FAQ JSON-LD, historical slug redirects and XML sitemap.
- No separate GEO/AEO, general redirect CMS or application email notification module is currently implemented.

## 3. Existing Database Inventory

Reusable migrations cover users, cache/session/job infrastructure, media, posts/revisions/categories/tags/comments, services/sections/slugs, public pages, FAQs/page assignments, stories, reviews, inquiries/follow-ups, and site settings. RBAC is role-based with administrator/editor roles and a separate inquiry-management permission.

The bundled SQLite file is zero bytes and no populated source schema was available. MySQL is selected in the active `.env`; migration files are the authoritative local schema.

## 4. Source-to-Target Page Mapping

| InstantAyurved source | Laravel target |
|---|---|
| `index.php` | `/` and existing public home |
| `about.php` | `/about` new route/view |
| `about-dr-tejas-kadam.php` | `/doctor-tejas-kadam` new route/view |
| `about-our-facility.php` | `/facility` new route/view |
| `services.php` | `/services` existing CMS-backed route |
| Five `service-*.php` pages | Existing `/services/{slug}` CMS records |
| `treatments.php` | `/treatment-videos` new route/view |
| `gallery.php` | `/facility` gallery or dynamic media module |
| `blog.php` / `single-blog.php` | `/blog` and `/blog/{slug}` existing CMS routes |
| `testimonials.php` | `/reviews` existing route |
| `contact.php` | `/contact` existing inquiry route |
| `privacy-policy.php` | `/privacy` existing route |
| `terms-conditions.php` | `/terms` new route/view |

## 5. Source-to-Target Content Mapping

Dr. Tejas Kadam, hospital addresses, telephone numbers, social profiles, services, facilities, video catalogue and blog content are retained as verified source data. Vidya-specific database records must be replaced or relabelled as part of migration. Existing public models and seed mechanisms remain intact.

## 6. Image and Media Mapping

Production assets under `assets/img/` and `assets/img/` subdirectories are reusable. Blog PNGs are mostly 1536x1024 and require WebP/responsive optimization. Therapy PNGs are 2048x2048. Duplicate production/staging assets will not be imported. Missing source files include the hero MP4, social-preview image, logo PNG and `panchakarma-detox.jpg`; no broken reference will be retained.

## 7. SEO Feature Mapping

Existing title, description, canonical, robots, OG, Twitter, Article/Organization/Service/FAQ schema and sitemap capabilities are preserved. The source's missing files and static social metadata are replaced with Laravel-generated metadata. A dedicated sitemap entry for all new core pages and robots sitemap declaration are required.

## 8. GEO/AEO Feature Mapping

The FAQ, public-page and structured-data modules provide a reusable base for AEO. The migration adds concise answer-first content, local organization and location schema, and FAQ schema where applicable. Dedicated GEO tooling does not currently exist and is outside the existing module's implementation unless required by a later migration phase.

## 9. Missing Functionality

- Gallery and testimonial placeholder pages.
- Production terms route.
- Submitted-forms do not execute in the plain PHP source.
- General redirect CMS.
- Robots sitemap declaration.
- Dedicated GEO/AEO and email notifications.
- Responsive image processing and missing logo/social/hero assets.

## 10. Required Database Extensions

Add a reusable `hospital_locations` table for both InstantAyurved locations, preserving CMS/site settings. The existing service, FAQ, blog, media and inquiry structures require no wholesale replacement.

## 11. Security Considerations

- Preserve CSRF, authentication, staff/admin middleware, sanitizer, validation and upload checks.
- Re-key public form submissions and consent data.
- Remove staging-only or test identity from public output.
- Do not store secrets or the `.env` key in source changes.
- Avoid importing executable PHP or private data from staging; copy only approved media and content.

## 12. Implementation Plan

1. Remove visible Vidya identity and relabel configuration and layouts.
2. Copy and optimize approved InstantAyurved media.
3. Replace public seed/settings and add both hospital locations.
4. Map five services into CMS records and add core InstantAyurved pages.
5. Add treatment videos, facility, doctor, terms, robots and sitemap routes.
6. Add dynamic location/Facebook/Instagram/YouTube settings and location schema.
7. Run migrations, focused tests and browser verification.

## 13. Testing Plan

Test public routes, all CMS-backed service slugs, inquiry submission, robots/sitemap, metadata, schema output, mobile navigation, media fallback, authentication and RBAC. Run existing PHPUnit suite plus focused route smoke tests.

## 14. Potential Migration Risks

- Existing production database may contain legacy Vidya records and must be reconciled with reviewed migrations rather than dropped.
- Source addresses/phone numbers need confirmation if displayed inconsistently.
- Large PNG and missing source assets require optimization or replacement.
- YouTube thumbnails depend on third-party availability.
- Staging differences should not overwrite production content.

## 15. Implementation checkpoint

The video catalogue, hospital location correction, legacy page redirects and crawlability changes are implemented. The database, content, SEO, admin, deployment and QA documents in this directory record current coverage and pending acceptance work. The next implementation stage is the editorial import of the complete source article and listing excerpts, followed by the full source media and layout comparison.
