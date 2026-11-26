# InstantAyurved deployment guide

Use a protected staging copy and back up the populated database and uploaded media. Confirm the web root points to public, PHP satisfies composer.json, and the deployment retains the existing APP_KEY and private environment configuration. Review pending migrations with the application owner before running them against production.

Use production dependencies and enable HTTPS. Verify redirects and robots.txt through the host web server, then check XML sitemap, login, consultation delivery, storage, sessions and queue configuration. The current release slice requires further content migration and acceptance testing before production deployment.
