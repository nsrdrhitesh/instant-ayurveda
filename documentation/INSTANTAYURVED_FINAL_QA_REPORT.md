# InstantAyurved QA status

The starting workspace passed 59 tests with 428 assertions on the local PHP and SQLite test configuration.

Automated release checks cover video import, publication, filtering, CRUD and role enforcement. They also cover legacy redirects, robots.txt, and separate production and staging indexing behavior. The tests do not verify remote YouTube playback, rendered layouts, a populated MySQL upgrade or the production web server.

Remaining acceptance work includes the complete content and media migration, source layout comparisons, CMS coverage, SEO/GEO/AEO completion and production deployment verification.

The full suite passed 64 tests with 477 assertions after the location, video and indexing changes. After the final seed guard and Apache rule edits, the focused suite passed 5 tests with 49 assertions. Apache rewrite behavior remains unverified through a running Apache host.
