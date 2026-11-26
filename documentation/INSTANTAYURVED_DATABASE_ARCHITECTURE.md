# InstantAyurved database architecture

Laravel migrations remain the schema source. Users and staff roles provide authentication and authorization. Posts use revisions, taxonomy, authors and media. Services have sections and historical slugs. Public pages provide FAQ assignments. Inquiries retain encrypted fields and follow-up records.

The treatment video migration creates a catalogue with a unique YouTube ID and an index for public listing order. The location correction updates the original Pune seed only when its identifying fields and timestamps match. Blank visitor details support the unverified Nashik record. A populated database needs a backup and migration review before applying the release.
