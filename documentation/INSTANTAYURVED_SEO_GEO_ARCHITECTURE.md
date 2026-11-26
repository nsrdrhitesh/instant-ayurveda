# InstantAyurved SEO and GEO architecture

The existing metadata, canonical URLs, XML sitemap, schemas and historical post and service slugs remain in use. The release adds 301 mappings for legacy pages and services with known destinations. Laravel generates robots.txt using the configured sitemap route. Staging access protection and staff noindex headers remain active.

Remaining work includes general redirect administration, complete per-page metadata overrides, verified location schema, and consistent answer-first content. The long-form blog URL requires a destination once the article is imported and published.

Homepage, SEO & GEO provides title, description and quick-answer overrides. Blank fields derive from the site settings. Public location cards emit MedicalClinic data for listed locations with complete address and phone details. Incomplete locations remain visible with their verification note.
