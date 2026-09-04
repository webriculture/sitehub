# BACKUP-CLAIMS.md — how to portray the Need Navigator backup process

Verified directly against the running system (object headers, IAM policies, live runs) on **2026-07-23**. Binding for all marketing copy, same standing as [FEATURES.md](FEATURES.md).

**The rule that resolves all ambiguity:** scope every claim to exactly what it covers. The words "backups," "on the application server," and "nightly" are your friends; the words "all," "everything," "always," and "immutable" are how this goes wrong.

## True and claimable

| Claim | Status |
|---|---|
| Automated backups of every client database run nightly | ✅ Claim freely |
| Backups are stored off-server / off-site in redundant cloud storage (AWS S3, designed for 99.999999999% durability) | ✅ Claim freely |
| Backups are encrypted at rest (AES-256) and in transit (TLS) | ✅ Claimable — scoped to backups |
| Client data is encrypted at rest on the application server | ✅ Claimable — scoped exactly this way |
| Backups are retained on a rolling schedule (35 days of dailies, 13 months of monthlies) | ✅ Claim freely |
| Backup copies are protected against deletion from the production server (the server's credentials cannot delete or overwrite backup history) | ✅ Claimable — use this phrasing, not "immutable" |
| Every backup run is automatically verified for restorability and its success or failure alerts our team immediately | ✅ Claimable ("integrity-verified," "monitored with immediate alerting") |
| Backups are maintained in multiple independent locations | ✅ Claimable (cloud + an independent secondary site) |

## Not claimable — do not use, regardless of how good it sounds

- ❌ "All data is encrypted at rest" or any org-wide/blanket encryption claim. Column-level encryption of PII fields (SSN, DOB) inside the database does not exist, and two secondary servers are not yet covered. Encryption claims must stay scoped to backups and the application server.
- ❌ "Immutable backups" — deletion is blocked for the server's credentials, but this is not WORM/Object-Lock storage.
- ❌ "Continuous," "real-time," or "zero data loss" — backups are nightly; the honest recovery point is up to 24 hours.
- ❌ "HIPAA-compliant backups" or any named-framework compliance claim — that's a legal determination, not a marketing one.
- ❌ "Regularly tested restore procedures" — automated per-run integrity verification is true and claimable; a human restore-drill cadence is planned but has not yet occurred. Don't claim it until it has.
- ❌ Anything referencing the previous backup system or past outages.
- ❌ "Military-grade," "bank-level," or unscoped superlatives.

## Suggested copy, three registers

- **Conservative:** "Client data is backed up automatically every night to secure, encrypted off-site storage."
- **Standard (recommended):** "Every client database is backed up nightly to redundant, encrypted cloud storage, with integrity verification on every run and a 35-day retention window."
- **Fullest defensible:** "Client data is encrypted at rest on the application server. Nightly backups of every database are encrypted in transit and at rest, verified for restorability on every run, retained for 35 days (13 months for monthly archives), held in multiple independent locations, and protected against deletion from the production environment."

## Snapshots

Dave, 2026-07-25: **server-level snapshots are not part of the backup routine — never reference snapshots in copy.** (Supersedes the earlier "until verified" timing note.)
