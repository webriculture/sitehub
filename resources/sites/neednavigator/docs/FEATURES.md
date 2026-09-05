# Need Navigator — Product Feature Inventory

*Generated 2026-07-22 from a full audit of the application code (routes, navigation, controllers, services, views, and scheduled jobs); updated 2026-07-24 with product decisions on all 20 audit questions; audited 2026-09-04 against the July and August 2026 release notes (`release-notes/2026-07.md`, `2026-08.md`) and moved here from the repo root. Written for nonprofit Executive Directors and Program Directors. Maturity flags are honest assessments intended to keep marketing accurate — items marked **Partial / WIP** should not be marketed as available today.*

*SiteHub copy: synced 2026-09-04 from the Need Navigator repo's export. The export arrived truncated partway through GeoTracker, so everything from **Part 6 — Insight & Oversight** onward is carried over unchanged from the 2026-07-24 version — refresh those sections when the remainder arrives.*

**Maturity legend: Stable** = in production use, mature · **Recently shipped** = released within roughly the last two release cycles (spring–summer 2026) · **Partial / WIP** = built in part or not yet live; do not market without confirming.

---

## What Need Navigator is

Need Navigator is case-management software for human-services organizations — community action agencies, shelters, food banks, parent-education providers, and other community aid organizations. Each agency runs on its **own isolated copy of the application with its own private database** (no shared multi-tenant database), configured to that agency's programs, forms, roles, and vocabulary. Staff manage client records, households, assistance requests, referrals, visits, goals, and documents in one place; the public can apply for help, register for events and classes, and check in with QR codes without ever needing an account.

---

# Part 1 — Client Records

## Individuals (Client Records)

**One sentence:** The central client record — a configurable profile of each person your agency serves, with demographics, photo, program history, and a complete service dossier on one page.

**Key capabilities**

- Each agency chooses which profile fields appear on create, edit, view, and list screens, and which are required — the record adapts to your intake practice rather than the other way around.
- Capture demographics your funders ask about: race, ethnicity, gender, language, education level, veteran status, housing status (current and prior), disability (multiple disabling conditions supported), income, insurance, and more. Recent additions: pronouns (off by default), a domestic-violence-survivor flag, and an "expected member" flag for anticipated household members such as an unborn child.
- Client photo via file upload or webcam, with live face detection to help line up the shot.
- Fast search by name, date of birth, phone, SSN, or HMIS number, with matched text highlighted.
- Duplicate prevention: exact duplicates (same name + DOB, or same HMIS number) are blocked at save; a fuzzy matcher also warns about *likely* duplicates before you create a new record.
- Merge two records when a duplicate slips through — case history, submissions, program history, and documents are consolidated onto the surviving record.
- Test client records: flag any record as a test individual — excluded from lists, searches, and reports by default (each user can opt in to see them), so staff can train and demo safely without polluting real data.
- **Data freshness**: set a review interval on any profile field; the system tracks when each field was last confirmed, surfaces a count of clients whose data needs review right in the menu, and lets staff re-verify a value without editing it. Each user chooses the scope of their own review alerts.
- One-page dossier: alerts, insurance, income, care team, relationships, program enrollments (with each enrollment period selectable), and tabs for history, needs, visits, referrals, goals, billing, notes, and files. The household icon carries a member-count badge and the header shows the record id (August 2026).
- A radial quick-action menu on every profile creates a visit, referral, need, goal, task, billing record, note, or field location log in one tap.

**Compliance / reporting hooks:** HMIS number is a first-class field and duplicate key. Every profile view by agency staff is logged (who, when, from where) and screened by configurable suspicious-access rules — see *Audit Trail & Access Monitoring*.

**Maturity:** Stable (data freshness, pronouns, DV flag, education level, expected-member flag, and multi-condition disability all released with the June 2026 update).

**Differentiators:** per-agency configurable field layout without custom development; built-in duplicate prevention *and* merge; field-level data-freshness tracking; access-pattern monitoring on client records.

---

## Households & Relationships

**One sentence:** Group clients into households with a head of household, member relationships, and shared data that stays in sync.

**Key capabilities**

- Build typed households with a designated head of household and a member-to-member relationship matrix (including relationships that extend outside the household).
- When a household member's address is updated, staff are prompted to copy the new address, phone, and housing status to selected household members in one step.
- Form answers marked "sync across household" copy between household members' submissions and pre-fill new ones.
- Household income rolls up automatically for program eligibility (minor income counted only where a program says so).

**Maturity:** Stable.

---

## Care Team

**One sentence:** Track everyone assigned to a client — internal staff *and* external partner contacts — by role and program, with full history.

**Key capabilities**

- Multiple concurrent care-team members per client, each with a role, program, and start/end dates; ended assignments are kept as history, never erased.
- Assign internal staff or a contact at a partner organization.
- Directory view with filters (program, role, provider type, status) and summary counts.
- **Caseload transfer:** reassign one worker's entire active caseload — or just one program's worth — to another worker in one operation, preserving history.
- Care-team roles are agency-defined and tied to Teams, so role dropdowns only offer people who actually hold that role.
- **Caseload summary (August 2026):** a case worker with the "Generate Caseload Summaries" permission gets a one-click branded PDF of the clients on their care team — visits, needs, referrals and goals in the last 7/30/90 days, for one client or the whole caseload. Service activity only (no form answers, notes, or identifiers beyond the name); records outside their programs/teams are left out; every generation is logged.

**Maturity:** Recently shipped (rebuilt January 2026 to replace single case-manager assignment, released with the March 2026 update; role-to-Team gating added June 2026).

**Differentiators:** external partners as first-class care-team members; one-step caseload transfer for staff turnover.

---

## Income & Program Eligibility

**One sentence:** Capture each client's income sources with proof documents, distinguish staff-verified from self-reported amounts, and evaluate program eligibility against poverty-level (FPL) and area-median-income (AMI) thresholds.

**Key capabilities**

- Income sources (type, employer, current/past) with per-pay-period records and attached proof (paystub photo or PDF, snapped directly on a phone).
- **Guided income capture** on intake forms: a step-by-step, mobile-friendly wizard ("Does this person have income?") that walks applicants through each source, in English or Spanish. Choosing "no income" records an explicit declaration — clearly different from "not asked."
- Income captured from a public form lands on the client record marked **unverified** until a staff member confirms it; only staff-verified income — the client's and every household member's — counts toward eligibility (the household-member rule was tightened in the August 2026 update). The provenance is visible on the profile.
- Annualized income projection per source and per household.
- **Eligibility engine:** income thresholds by year, type (FPL or AMI), geographic area, and household size, with a percentage multiplier; programs combine income rules with other rules (required fields, field values, age ranges) and show clients as eligible / partially eligible. A bulk tool generates next year's thresholds from the current year's.
- Financial-assistance requests automatically pull the household's recent income (within a configurable tracking window) and compare it to the program's maximum allowed income right on the printable request.

**Compliance / reporting hooks:** FPL/AMI thresholds by geographic area (MSA, CoC, county, state) are the backbone for poverty-level grant compliance (CSBG-style demographics and eligibility documentation). Verified-vs-self-reported distinction is enforced, not just displayed.

**Maturity:** Stable core; guided capture and verification workflow Recently shipped (built April–May 2026, released with the June 2026 update). Capturing income for *multiple* household members from a single public submission shipped with the June 2026 update; a remaining form-shape restriction was lifted 2026-07-21 — confirm per-tenant deployment before marketing that step.

---

## Insurance

**One sentence:** Store each client's insurance policies with card images and coverage dates, with automatic primary-policy management.

**Key capabilities**

- Policies with provider, member ID, group number, plan type, and coverage dates; front and back card images (photo or PDF); "renew from" pre-fill.
- Primary policy managed automatically (first policy becomes primary; deleting the primary promotes the next active one).
- Card front and back merge into a single PDF for viewing/printing.
- Coverage dates feed billing validation (see *Billing*).

**Maturity:** Stable.

---

## Releases of Information (ROI)

**One sentence:** A per-client consent record with an expiration date and the signed document attached, automatically extended across the household through the head of household.

**Key capabilities**

- Upload the signed release and set its expiration; a client is covered if they or their head of household holds a current release.
- Recorded from the client or household edit screen; coverage automatically follows the current head of household, so members are covered without re-entering the release.

**Maturity:** Stable, deliberately simple (one active release per client; no per-organization consent granularity).

---

## Documents & Files

**One sentence:** Every client's paperwork in one organized, permission-controlled place — plus an org-wide document manager and a scanner inbox for bulk intake.

**Key capabilities**

- **Client files:** single or multi-file upload with a document type (and type-specific custom fields) per file; attach files to a client, need, visit, task, or organization; organize in folders with team-based visibility; recover soft-deleted files; drag files between folders.
- Default folder sets are created automatically when a client enrolls in a program.
- **PDF merge:** combine selected files (PDFs, images, Office documents) into one PDF — e.g., assemble a complete application packet.
- **Document Inbox** (optional, per-agency): a scanner or SFTP drop folder feeds a triage screen where staff preview each file, find the right client/visit/need, and file it with a type and folder in a couple of clicks.
- **Document Manager** (organization-wide): tree browsing with search and filters, folder colors/descriptions, version history (upload, list, restore, download prior versions), tags, and archive/template flags.
- **Document sharing with partner organizations:** share a document or folder with one or more partner organizations at view/download/edit level, with an optional message and expiration, and manage or revoke shares from an admin screen. (The partner-facing view of shared items is built in code but not yet reachable — do not market partner access.)

**Compliance / reporting hooks:** team-based permission levels on files and folders; program-security checks on client-file downloads; share expirations.

**Maturity:** Client files: Stable. Document Inbox: Stable — built for one agency but available to any, set up and tailored per site (requires a scanner/SFTP drop). Document Manager and partner sharing: **Beta — do not list yet** (staff-side sharing works; bulk actions and the in-app partner viewer are unfinished, and partner-facing access runs through the separate portal application).

---

## Organizations & Contacts (Partner Directory)

**One sentence:** A directory of the agencies you work with — funders, referral partners, schools — with their contacts, services, and service areas.

**Key capabilities**

- Organizations with type, parent/child hierarchy, logo, funder flag, and search across names, phone numbers, types, and contact names/phones.
- Contacts under each organization; contacts can serve as external care-team members and (optionally) receive a portal login.
- Per-organization service listings: areas served, hours, services offered, eligibility notes, and languages spoken.
- **Vetting badge:** once staff have confirmed an organization is legitimate (business registry, W-9, not a shell set up to draw down program funds) it can be marked vetted. The system records who vetted it and when, keeps an optional note of what was checked, shows a badge beside the name with the details on hover, filters the directory by vetting status, and records every change in the audit log.
- Organizations are the anchors for referrals, document sharing, funding pools, and the Need Navigator Network.

**Maturity:** Stable. (Contact portal logins are behind a per-agency switch.)

---

# Part 2 — Service Delivery

## Needs & Emergency Assistance

**One sentence:** The end-to-end workflow for assistance requests — from intake through review, approval, funding allocation, and a printable voucher — with funder dollars tracked to the penny.

**Key capabilities**

- Log a need for a client against your agency's catalog of resources (financial or non-financial), with need types, quantity, amount, and recipient organization.
- **Status ladder:** Pending → Ready for Review → Approved → Finalized → Voucher Printed, with Denied and Closed as off-ramps — giving supervisors a clear review/approval queue. Status can be updated inline from the Quick Forms submissions grid.
- **Your own status vocabulary (August 2026):** statuses live in the agency's database — an admin screen ("Manage Need Statuses" permission) sets each one's label, color and order, switches unused ones off, and limits a status to particular resources. Automations, saved reports and Quick Forms views keep working because the meaning behind each status is fixed.
- **Status timeline:** every change is recorded (to what, when, by whom) and shown on the need as a timeline rail with an off-ramp marker for denied/closed.
- **Funding pools:** budgets tied to funder organizations or programs, with balances, date ranges, and per-need allocations; a request can be split across multiple pools, and the system warns when allocations don't add up to the request amount.
- **Disbursements:** each financial need carries a payment record; staff attach the invoice PDF and can email it to the payee directly from the system, with sent/finalized status tracked.
- The printable request/voucher shows household size, recent household income, the program's maximum allowed income, and an under/over-limit verdict — the eligibility math is printed right on the voucher.
- Billing records can be generated automatically from the need's types (see *Billing*), and Automations can fire emails/tasks/messages on status changes.

**Compliance / reporting hooks:** funder-level spending and remaining-balance reporting; eligibility documentation on the printed voucher; full audit trail of status changes.

**Maturity:** Stable; "Voucher Printed" (July 2026), renameable statuses and the status timeline (August 2026) Recently shipped. (Payments are tracked and invoiced by email — there is no check-printing or ACH integration.)

**Differentiators:** funding-pool split allocation with reconciliation warnings; eligibility math printed on the voucher.

---

## Referrals

**One sentence:** Route a client to another program, partner organization, or even another agency on the Need Navigator Network — and close the loop with a QR code the receiving provider scans.

**Key capabilities**

- Refer to an internal program/user or an external organization and contact; referrals can be spawned from a visit or task.
- **Incoming referrals:** a program that opts in ("Accepts incoming referrals") can record the outside organization and contact a referral came *from*, so referrals received are tracked alongside referrals sent.
- **QR loop closure:** the printed referral carries a QR code; the receiving provider scans it (no login needed) and records who received the client and their feedback — completing the referral with a timestamp.
- Cross-agency referrals transmit to the receiving agency's own Need Navigator system over the Need Navigator Network.
- Message threads attach to each referral for follow-up conversation.
- Referral reasons are agency-defined and can carry automations (e.g., send an email when a referral is created).

**Compliance / reporting hooks:** loop-closure timestamps and provider feedback support referral-outcome reporting.

**Maturity:** Stable.

**Differentiators:** no-login QR loop closure; true agency-to-agency referral delivery.

---

## Goals & Case Plans

**One sentence:** Build client goal plans from reusable templates with sequenced, dated steps, and track progress to completion.

**Key capabilities**

- Agency-defined goal templates with ordered steps and default durations; new goals pre-populate their steps from the template.
- Steps schedule sequentially (each starts when the prior ends) or in parallel; each step has start/due dates and records who completed it and when.
- Goal completion rolls up automatically when all steps are done; progress ("3 of 5 steps") shows on lists and profiles, with a Gantt-style timeline view.
- A **Journey** row on each goal (August 2026): Created → each step in order, completed ones dated and the next one highlighted → Completed or the target date, with who did what on hover.

**Maturity:** Stable.

---

## Visits

**One sentence:** Log encounters — individual or group — with reasons, topics, time tracking, per-reason forms, and an optional manager sign-off workflow.

**Key capabilities**

- One visit can include multiple clients (group visits), and one entry can be recorded across multiple dates at once.
- Visit reasons, topics, and types are agency-configurable (visit statuses are a fixed system list); reasons can attach forms that get filled per client per visit.
- Start/end times captured; billing records can be generated automatically per client from the visit's reasons (see *Billing*).
- **Manager review:** flag any visit reason as requiring review — the caseworker's manager gets a review panel (Unreviewed / Reviewed / Completed / Staff Action Needed) with notes only the manager can edit.
- List view with quick inline edits and copy-visit; visits also appear on the shared Calendar.
- With an Automation on the visit reason, recording a visit can auto-enroll an un-enrolled client or route you to the program's enrollment form; logging a visit from a task marks that task complete.
- **Visit summary PDF (August 2026):** every visit can produce a branded record of service — date, program, type, reasons, who conducted it, the person's forms from that visit, and the narrative. One document per person by default; a program can opt into combined household documents (only when every attendee is in the same household). Each generation is recorded on the person's history.
- Internal-location lists are searchable rather than one long dropdown; multi-date entries bill and keep their narrative on every visit, not just the first.

**Compliance / reporting hooks:** duration-based billing generation; manager sign-off; program-enrollment prompts and auto-enrollment via Automations.

**Maturity:** Stable (manager review June 2026; visit summary PDFs August 2026).

---

## Notes, Messages & Threads

**One sentence:** Permissioned case notes and staff messaging with an inbox, delivery-delay undo window, attachments, @mentions, and live conversation threads on needs and referrals.

**Key capabilities**

- Case notes with per-note visibility (everyone / program / team), recipients with read tracking, reply chains, pinning, and file attachments.
- **Undo window:** notes deliver after a personal grace period (e.g., 60 seconds to 10 minutes) so a mis-sent note can be caught before anyone sees it.
- @mention colleagues in rich-text notes to notify them directly.
- **Threads:** live chat attached to a need, referral, or program — messages appear for other participants in real time, with typing indicators.
- Cross-agency threads: agencies connected on the Need Navigator Network can hold a shared live conversation about a shared client or referral.

**Maturity:** Stable.

---

## Programs & Enrollment

**One sentence:** Define your programs — forms, folders, eligibility rules, and options — and track every client's enrollment episodes with entry/exit history.

**Key capabilities**

- Per-program configuration: intake and exit forms, default document folders, visit reason/topic requirements, minor-income tracking, cross-program access, and a program wiki for staff reference.
- **Eligibility rule builder:** combine income thresholds with age-range rules and required-field / field-value rules on core client fields (veteran status, insurance provider, disabling condition, housing status, SSN) — no custom development.
- **Enrollment periods:** each stay in a program is its own episode with entry/exit dates, who enrolled/exited the client (including partner-portal attribution), and which intake was used; the profile tells periods apart ("2 of 3") and shows each one's dates and intake. Agency-defined exit reasons, grouped into categories, are captured at shelter check-out and can trigger automations — including closing the enrollment.
- **New intake on re-enrollment** (per program, August 2026): off by default (a returning client's earlier intake is reused); on, each new period gets its own intake record pre-filled from the prior one — the HMIS 5.03 expectation of one Project Start per enrollment period. Enrolling from a shared intake form now enrolls into the program you clicked.
- Enrollment periods are a report type of their own (see *Reports*) and a dashboard Custom List source.
- **Program homepage:** enrollment counts, average enrollment duration, retention rate, six-month enrollment trend (all computed from enrollment periods since August 2026), resources distributed, dollars disbursed, and activity totals (visits, needs, goals, tasks, referrals) — plus embedded task lists and a program-wide message thread.

**Compliance / reporting hooks:** episodic entry/exit history with attribution (HMIS-style); exit-reason categories; retention and outcome counts per program.

**Maturity:** Stable.

---

## Billing

**One sentence:** Generate insurance-style billing records automatically from visits and needs, validate them against the client's insurance coverage, apply the Medicare 8-minute rule, and export claim-ready batches to Excel.

**Key capabilities**

- Agency-defined billing codes with categories, modifiers, regions, units, and expected unit costs.
- Billing records auto-generate from visit reasons (using actual visit duration, per client) and from need types; records can also be entered manually.
- Record statuses (pending → batched → submitted → paid/rejected) with filtering, search, and export.
- **Batching:** select unbatched records and generate a batch — records outside the client's insurance coverage dates are excluded, minutes convert to billable units under the 8-minute rule, and totals compute per client, code, and date with the insurance carrier stamped on each line. Export the batch to Excel (the Grouped Summary export lists each person's active programs).
- **Rate history (August 2026):** billing-code rates are effective-dated — a rate change takes an effective date and keeps the history, and each line is priced at the rate in effect on its own date of service.
- **Batches freeze when submitted:** a batch stores the rate and service date on every line and recalculates once more at submission, so a submitted batch is a permanent record of what was billed; later rate edits re-price future work only, and submitted batches refuse further edits.

**Compliance / reporting hooks:** insurance coverage-date validation; 8-minute rule unit calculation; full attribution of who created each record.

**Maturity:** Stable through batch generation and Excel export (built to contract, including the 8-minute rule); rate history and frozen batches Recently shipped (August 2026). Electronic remittance/claim submission was never built — the exported batch is the hand-off point. A few batch-level controller actions (add/remove line, recalculate) remain unrouted; lines are managed from the record side.

---

## Tasks & Task Lists

**One sentence:** Team task management wired into casework — tasks link to clients, needs, and visits, live on shared filtered lists, and can stamp a GPS location.

**Key capabilities**

- Tasks with priority, assignee, team, due date, and threaded comment posts with read tracking; attachments and @mentions.
- Link a task to a client, need, or visit; create a task from a note; logging a visit from a task automatically marks the task complete.
- Task lists: saved filtered views with default status/assignee filters, badge counts in the sidebar, and optional embedding on a program's homepage.
- Optional GPS capture on task creation (for field/home-visit programs) — see *GeoTracker*.
- Excel export.

**Maturity:** Stable.

---

## Calendar

**One sentence:** One shared calendar that overlays visits, tasks, needs, referrals, goals, reservations, and events, with per-user saved default views.

**Key capabilities**

- Toggle which record types appear; filter by shelter, room, resource, user, or client; save your default view.
- Events flow in from the Events module. (Class sessions do not yet appear on the shared calendar.)
- "Meet now" links plus pre-filled scheduling links for Microsoft Teams or Google Calendar; Zoom opens its scheduling page without prefill (one provider per agency — link generation, not calendar sync).

**Maturity:** Stable.

---

## Client Alerts

**One sentence:** Colored banner alerts pinned to a client's record — safety notes, reminders, expiring notices — visible the moment the record opens.

**Key capabilities**

- Per-client banners with custom colors and icon, active/inactive status, expiration dates, and ordering; filterable admin list; pre-fills the most recently used style for fast entry.

**Maturity:** Recently shipped (banner system built December 2025, released with the March 2026 update).

---

## Smart Buttons

**One sentence:** One-click buttons on the client profile that perform a whole intake in a single tap — creating a need, referral, and/or visit with forms, notes, and billing records pre-filled the way your agency defined.

**Key capabilities**

- Admins compose a button from a sequence of actions (create Need / Referral / Visit, executed in the order added) with pre-set field values, template variables (client name, program, date), and embedded forms.
- **Ask at run time:** anything left blank prompts the worker at click time — visit length, visit type (and where it happened), narrative, topics, and status — in a redesigned, column-laid-out run dialog; prompts are validated against the button's program, never a way around a rule.
- **Household visit in one click (August 2026):** a visit action can record the whole household as participants, so people-served counts are right without reconstruction; a household run is all-or-nothing when a usage limit blocks a member.
- Buttons show service-limit eligibility right on the profile ("Eligible again Mon, Aug 3") — see *Service Usage Limits*.
- Billing records and funding-pool allocations are created exactly as they would be manually — consistency without retraining.
- Buttons carry a color/icon or a short text abbreviation, can be favorited, and redirect to the created record.

**Maturity:** Stable (text abbreviation July 2026; household visits, run-time prompts and the new run dialog August 2026).

**Differentiators:** genuinely no-code standardization of multi-step front-desk workflows.

---

## Service Usage Limits

**One sentence:** Ration a service — food boxes, bus passes, showers, hygiene kits — by setting how often a client (or their household) can receive it, and have the rule enforced on every screen that can record it.

**Key capabilities**

- Configured on the service itself (a visit reason or a need resource), not on a button: **per calendar period** ("once per calendar week, from Monday") or a **rolling window** ("not within 7 days of the last one"); scoped to the **individual** or their **household**; **warn only** or **block**.
- Enforced wherever the service can be created — Smart Button, the normal visit form, a copied visit, a multi-date entry — so nobody routes around it. Smart Buttons show the next-eligible date on the profile; a blocked run leads with that date rather than an error.
- **Overrides:** staff holding "Override Service Limits" can proceed with a reason; the reason, who gave it and which service are recorded permanently — the alternative (mis-filing under another reason or family member) corrupts the very records the limits count from.
- Cancelled and no-show visits don't consume the allowance; a denied need doesn't count, a pending one does. Household counting starts from the release the feature shipped in (the app only began recording household membership at the moment of service then); individual limits count full history.
- Recommended rollout: warn-only first, review the would-have-been-refused report, then switch to block — no deploy needed.

**Compliance / reporting hooks:** honest rationing records with an audited override trail; household-at-time-of-service is now captured on every visit and need.

**Maturity:** Recently shipped (August 2026).

**Differentiators:** limits live on the service and apply everywhere, with a real override instead of a workaround.

---

## Automations

**One sentence:** No-code rules that react to casework — when a need, visit, referral, form submission, need document upload, or shelter exit occurs, automatically send emails, create tasks, post messages, or enroll/exit the client from a program.

**Key capabilities**

- Attach rules to a resource, form, referral reason, visit reason, or exit reason; trigger on create or when a specific field changes to a defined value.
- Actions include: send templated email (with variables and optional attachments), create a task, post a message to a need's thread, and enroll in / close a program from a visit or reservation exit.

**Maturity:** Stable.

---

# Part 3 — Forms & Data Collection

## Form Builder

**One sentence:** Staff build their own intake and case-management forms — with conditional logic, repeatable sections, live client-record fields, helper images, and per-field permissions — without a developer.

**Key capabilities**

- Field types: short/long text, date, time, number (with precision control), email, radio, checkbox (with "other"), dropdown — plus **live client-record fields** (name, address, phone, DOB, SSN, HMIS number, demographics, income) that read and write the real client record, and lookup fields for funding pools, schools, class offerings, and staff.
- Conditional show/hide on fields *and* whole sections; repeatable sections ("Add Another") for household members or multiple income sources (an auto-count field is supported on public portal forms).
- Helper image on any field to guide the person filling it out.
- Per-field edit permissions by team or user; sections and fields reorder by drag.
- Forms attach to programs (intake/exit), visit reasons, resources, and smart buttons; a form can't be archived while something depends on it. A System Form Locations screen shows administrators where every form is in use before they change or retire it.
- **Form portability:** a form design (sections, fields, options, translations) can be exported and imported into another Need Navigator system with internal references remapped automatically (an administrator/command-line operation today); staff can deep-copy a form in place from the UI.

**Maturity:** Stable (core builder); form portability Recently shipped (May–July 2026).

---

## Quick Forms (Submissions Workspace)

**One sentence:** A live, spreadsheet-style workspace for a form's submissions where the whole team works at once — everyone sees edits, colors, and status changes in real time.

**Key capabilities**

- Real-time collaboration: cell-level presence ("who's editing what"), inline edits, row/column colors, column resize and drag-reorder — all synced live to every viewer.
- Handles large forms fast (incremental loading), with a unified search box, filters by date, client, submitter, program membership, and status.
- **Saved views:** name a combination of column order/visibility, status filter, and sort; share a default view for the team.
- The status shown per row is the linked assistance request's status — the grid doubles as a review/approval queue.
- Export submissions to Excel honoring every active filter — date, client, submitter, program, status, search and "in program only" (fixed August 2026) — as a branded, print-ready sheet; print individual submissions.
- Link a single submission to a person from its row, or run the household link flow; both offer a "create new" escape hatch when the person really is new. Editing a cell changes only that cell — it never re-runs a form's enrollment automations.
- Submission history shows field-level detail (which answers changed, from what to what) with the labels as they were at the time.
- Show a form's latest submission data on client profiles (per-form toggle), open pre-filled forms from profile smart buttons, or surface a Quick Form grid as a dashboard widget.

**Maturity:** Stable (grid rebuilt February 2026, extended continuously through August 2026).

**Differentiators:** true multi-user real-time grid over case data — rare in this product category.

---

## Submission-to-Client Matching

**One sentence:** Public and intake submissions become client records without re-typing — a matching engine ranks likely existing clients, and whole households can be created from a single submission.

**Key capabilities**

- Each incoming submission is classified **exact match / probable match / new individual** using name, date of birth, and signals like SSN/HMIS number.
- From the grid, staff confirm a match, pick among ranked candidates, or create the person in one click — cutting duplicate records and data re-entry.
- **Household capture:** when one submission collects several people (e.g., a family application), a guided stepper matches or creates each member, designates the primary member, builds the household, and attaches everyone in one pass.
- The household wizard includes a **program enrollment step** (which program, who in the household, or "don't enroll right now"), so a fresh submission becomes matched, enrolled clients in one pass; clicking Enroll for someone who already applied through a public form opens their submission rather than a blank intake.
- Matching works at the form-section level: any section carrying a first name, last name and date of birth counts as a person, and a public form that copies the applicant into the household section is distilled into one person.
- Program intake submissions surface on the client's profile automatically; other forms can be shown there with a per-form toggle.

**Maturity:** Recently shipped (released with the June 2026 update; household capture, section-level matching and in-flow enrollment refined through August 2026), in active use.

**Differentiators:** household-level intake materialization is a genuine differentiator for family-serving agencies.

---

## Multilingual Forms & AI Translation

**One sentence:** Present any form to clients in Spanish (with more languages planned) — an AI drafts the full translation in seconds and bilingual staff polish it in a side-by-side editor.

**Key capabilities**

- One click generates a complete AI baseline translation of a form — title, sections, field labels, helper text, and answer options — written for an approachable reading level, preserving program/organization names.
- Side-by-side translation editor organized form → section → field → option, with unsaved-change tracking; each language version records when its AI baseline was generated and when it was last hand-edited, and by whom (tracked per form).
- Stored answer values stay in English behind the scenes, so conditional logic and reporting are unaffected; translations travel with form export/import.
- The public intake portal renders forms in the visitor's language; event and class translations are delivered to your website through the feed. (Need Navigator's own hosted event/class pages currently render in English only.)

**Maturity:** Recently shipped (built May 2026, released with the June 2026 update). English + Spanish today; the translation engine is provider-configurable (works with OpenAI, Anthropic, or OpenRouter models).

**Note for marketing:** AI translations are positioned as a reviewed starting point, not a replacement for bilingual staff review.

---

# Part 4 — Community-Facing

## MyNeedNav Public Intake Portal

**One sentence:** Community members apply for help online — no account needed — on a public portal that renders your chosen forms, in their language, and feeds submissions straight into your review queue.

**Key capabilities**

- Publish selected forms to the portal; they render with full support for sections, conditional logic, repeatable sections, required fields, helper text, and helper images.
- Multilingual: applicants complete forms in English or Spanish.
- Guided income capture is supported on portal forms; income arrives marked unverified for staff review. (Verify paystub photo upload end-to-end on the live portal before marketing that specific step.)
- Submissions arrive as standard form submissions, ready for the matching engine (match / create client / build household) — nothing auto-links without staff review.
- Locked down by design: a server access token, an explicit allow-list of exposed forms, and a designated system user for attribution; the portal is disabled until configured.

**Maturity:** Recently shipped (built April–May 2026, released with the June 2026 update) and explicitly a foundation — expect it to expand. Live with two agencies; the portal front-end is a separate application consuming the Need Navigator API.

---

## Events

**One sentence:** Take your events online — a branded public page with registration, ticket types, waitlists, promo codes, and donations, plus QR check-in on event day.

**Key capabilities**

- Public event pages (only when explicitly published) with hero image, schedule, location or virtual link, capacity indicators, and rich description. (Spanish event content is delivered through the website feed; the hosted page itself currently renders in English.)
- Online registration with ticket types and quantities, per-attendee details, free name-and-email signup for ticketless events, duplicate-registration prevention, and registration windows.
- Waitlists are **Partial / WIP** — the plumbing exists, but at-capacity registrations are currently rejected rather than waitlisted, promotion runs only on staff-side cancellations, and promoted attendees aren't notified. Do not market waitlists.
- Promo codes (percentage or fixed amount) with expiration dates and usage limits.
- Event items — auction items, merchandise, and sponsor tables — with images, prices or starting bids, and quantities, shown on the public event page (display only: no online bidding or item purchase).
- Donation option with preset or custom amounts records a donation pledge — like registrations, no charge is collected online yet; staff can record offline cash/check donations.
- Self-service management: attendees look up and cancel their registrations with an emailed 6-digit code — no account.
- Day-of tools: per-attendee QR check-in links, manual check-in/undo, no-show, cancel, and walk-in registration.
- Staff back office for registrations, orders, attendees, donations, and promo codes.

**Maturity:** Recently shipped (built April–May 2026, released with the June 2026 update) — **except online payment collection (registrations and donations) and waitlists, which are Partial / WIP**. Stripe is the selected processor, pending a first end-to-end client run. Do not market online payment processing yet.

---

## Parent Education Classes

**One sentence:** Run parent-education programming end to end — course catalog, public registration, SMS/email reminders, QR self-check-in, attendance, fidelity-based completion, and printable certificates.

**Key capabilities**

- Courses (curriculum templates with a completion-fidelity threshold) → offerings (enrollable runs: online / in-person / hybrid, capacity, public page) → sessions generated from a weekday pattern.
- Public registration page per offering with bot protection and **verify-before-store** contact confirmation: required phone/email must pass a one-time code before the registration is accepted.
- Automatic reminders per session (a few days ahead and day-of) by SMS and email, with per-offering opt-in.
- **QR self-check-in** designed to protect privacy: scanning the poster never reveals who is enrolled; confirmed participants get a single-use, short-lived check-in link by text or email. Households can check in together, and confidential members are never disclosed.
- Facilitator tools: mobile attendance grid (present/absent/late/excused with credit overrides), on-the-spot walk-in enrollment, session notes.
- Completion computed against the course's fidelity threshold; **completion certificates (PDF)** generate for qualifying participants; printable roster sheets and per-session QR check-in posters.
- Class handouts/resources attach at the course and session level and hand off to participants at check-in via short-lived secure links.
- Class enrollment and completion outcomes are reportable on dashboards (Class Offerings and Class Enrollments are Custom List sources).
- Every course, class and session has a permanent link; facilitators preview exactly what a participant sees after check-in; reminders honor each participant's text-message consent (text where authorized, email otherwise).
- Two permissions: "Manage Classes" owns the catalog, "Manage Course Offerings" runs a class (schedule, sessions, attendance, enrollment, publishing); both scoped to the course's program.

**Compliance / reporting hooks:** attendance-driven completion to fidelity (a common evidence-based-program requirement); enrollment outcome reporting; program-scoped confidentiality protections for DV survivors.

**Maturity:** Recently shipped (released with the August 2026 update) — live with two agencies; Mid-Valley Parenting's public site cut over to the class feed and registration pages in September 2026.

**Differentiators:** enumeration-proof QR check-in; fidelity-threshold completion engine; SMS + email touchpoints throughout.

---

## Website Event & Class Feed

**One sentence:** Your public website (or a partner's) can display your upcoming events and open class offerings automatically from a secure, read-only feed.

**Key capabilities**

- A token-protected feed serves published events — and optionally public class offerings — as marketing data only (no client information by construction).
- Per-site tokens with scoping, revocation, and rate limits; content available in English and Spanish.

**Maturity:** Recently shipped (August 2026 update; classes opt-in per site — first partner site connected September 2026).

---

## Need Navigator Network (Cross-Agency)

**One sentence:** Agencies that both run Need Navigator can opt in to work together — search and link shared clients, send referrals system-to-system, and message in shared live threads.

**Key capabilities**

- Opt-in, per-organization federation with token-secured server-to-server connections and network-specific permissions (send messages, send referrals, view/search individuals).
- Search a partner agency's clients, link the same person across agencies, import profile data and photos, and see cross-agency updates.
- Send referrals directly into the partner agency's system; shared live message threads span both agencies.

**Maturity:** Stable feature set, heavily tested internally and good-quality code — but no agency pairs are federating in production yet. Market as a capability, not an active network.

**Differentiators:** true cross-instance federation between independent agencies — each keeps its own database.

---

## Partner Portal (Organization Logins)

**One sentence:** Partner organizations log in with their own credentials to view documents you've shared, manage their own class offerings and events, submit needs, and post to shared task lists — all through controlled channels.

**Key capabilities**

- Staff can issue partner contacts their own login credentials (per-agency switch) and share documents/folders with per-share permissions, messages, and expiry; the partner-facing viewer lives in the separate portal application.
- A controlled API lets the partner portal create and publish class offerings and events, record attendance, register walk-ins, submit Needs (against resources flagged for portal use), and post to task lists marked as accepting portal posts — every write is attributed to the acting contact, validated against their organization, and subject to the same rules as staff actions.

**Maturity:** **Live** for configured agencies — the portal application runs separately (enabled per agency rather than by default) against Need Navigator's controlled API. (An unused in-app document viewer remains unfinished; the live portal supersedes it.)

---

# Part 5 — Facilities & Field Work

## Shelters & Bed Reservations

**One sentence:** Manage shelter facilities visually — floor plans, rooms, and beds — and run the full reservation lifecycle from booking through check-out, including families staying together.

**Key capabilities**

- Configure shelters with eligibility attributes (age range, veteran-only, household size limits) and typical check-in/out times; build rooms and beds individually or in bulk (floors × rooms × beds in one step).
- **Visual floor-plan editor:** draw multi-floor layouts with live bed status colors (available / occupied / maintenance / offline); every change is saved as a new version with author and reason; an AI assistant can draft a to-scale floor plan from your room/bed inventory.
- Reservations move through pending → confirmed → checked in → checked out (with cancel and no-show), including open-ended stays where allowed.
- **Family/group reservations:** book a family together and check the whole group in or out in one action.
- Availability at a glance: a week-at-a-time bed-by-date matrix with occupant spans (navigable week by week), plus per-date room summaries and a visual bed picker.
- Bed maintenance/offline tracking with comments and resolution history.
- Check-out captures an exit reason (categorized) and can trigger automations such as closing the client's program enrollment.

**Compliance / reporting hooks:** bed nights (actual and planned-vs-actual) are tracked per stay; exit reasons and shelter eligibility attributes align with HUD-style reporting needs; reservations are a first-class report type. (There is no HMIS CSV export — see Decisions #14 and issue #25.)

**Maturity:** Stable.

**Differentiators:** versioned visual floor plans with AI-assisted drafting; group check-in/out.

---

## GeoTracker (Field Location Logging)

**One sentence:** Field staff log a GPS-stamped location for a client encounter in one tap, and supervisors see all activity on a clustered map with automatic grouping into named places.

**Key capabilities**

- One-tap location logging from the client profile (with the client's record and optionally a task attached); GPS capture on task creation for home-visit programs.
- Locations cluster automatically into "places" (within ~250 feet); staff name places, remove empty ones, freeze a named center so it stops drifting, and reposition a place by hand (August 2026).
- The one-tap circle menu opens as a half-circle so every button stays on screen, and collapses after logging so a double-tap can't log twice.
- Supervisor map with marker clustering and filters (worker, client, task list, place, date range); Excel export of location logs.

**Compliance / reporting hooks:** location-stamped service verification for home-visiting/outreach funders; well-suited to HUD Point-in-Time (PIT) count fieldwork.

**Maturity:** Stable — in heavy daily mobile use in the field at a large agency (Northwest Human Services); cleared for marketing.

*(The 2026-09-04 export was cut off in the middle of the GeoTracker compliance line; the rest of that line and the maturity line above are carried over from 2026-07-24.)*

---

<!-- ===== Carried over unchanged from the 2026-07-24 version (2026-09-04 export truncated before this point). Refresh from the next export. ===== -->

# Part 6 — Insight & Oversight

## Reports

**One sentence:** Build, save, and schedule your own reports across eleven record types — clients, households, visits, needs, referrals, goals, forms, events, reservations, billing, and funders — with Excel export and charts.

**Key capabilities**

- Custom report builder: pick a record type, choose columns, and stack condition filters (programs, exit reasons, shelters, users, date ranges, and more); save the definition with its own visibility level.
- **PII redaction levels** per report, so a board-ready export doesn't carry sensitive identifiers.
- Excel export for every type; on-screen paginated views; charts (bar/pie) on form reports with PDF download.
- Built-in analytics: spending by program, resources distributed, funds remaining by funder, requests over time, and demographic breakdowns (race, ethnicity, gender, language, ZIP).
- **Scheduled delivery:** weekly or monthly (including patterns like "3rd Tuesday" and "last Friday") at a chosen time, delivered by email, in-app message, or both.
- Report library grouped by program, with reordering and batch management.

**Compliance / reporting hooks:** demographic and expenditure breakdowns map to CSBG-style funder reporting; funder report aggregates funding-pool spending by calendar year; income, housing-status (current and prior), and projected-annual-income columns support eligibility documentation. There are no pre-built, named HUD/CSBG form templates — reports are assembled from the builder.

**Maturity:** Stable. (Known gap: no funder-mandated report templates — HUD/CSBG requirements discovery is tracked as issue #25.)

> ⚠️ **Stale count — do not quote "eleven" until re-synced (flagged 2026-09-04).** This section is carried over from 2026-07-24, but the September export's *Programs & Enrollment* section states that enrollment periods are now a report type of their own. The builder therefore spans at least twelve record types; the exact list is unknown until the rest of the export arrives. Six places in the site copy quote "eleven record types" — see SITE-PLAN §8.

---

## Dashboards

**One sentence:** A personal landing page of your open work today, and a configurable per-program widget board for the metrics your team watches.

**Key capabilities**

- **Home dashboard:** your upcoming visits, your goals with step progress, needs (including a pending-approval queue), referrals, events, unread messages, and a client search — toggle between "mine" and "everyone."
- Actionable to-do counts live in the sidebar for every major module — needs awaiting action, pending referrals, today's visits and reservations, open tasks and goals — each linking straight to the filtered list it represents.
- **Configurable dashboard (v2):** drag-and-drop widget board per program — recent clients, build-your-own query tables (choose columns, filters, sort over a safe, curated data catalog including visits, needs, and class outcomes), funding-pool balances with health indicators, client search, and embedded Quick Forms. Date presets include fiscal year.
- Editing rights are permission-gated; everyone in the program shares the board.

**Maturity:** Home dashboard: Stable. Configurable dashboard: **Ready to market** — live on roughly half of customer sites with no major issues reported; preferred over the legacy dashboard for new customers. (Not yet linked from the main navigation — reachable by direct URL.)

---

## Audit Trail & Access Monitoring

**One sentence:** Every create, update, delete, and client-record view is logged — and unusual access patterns are flagged automatically for administrator review.

**Key capabilities**

- Automatic audit entries on record changes across the system, rendered as a readable per-client history timeline (permission-gated).
- Every client-profile view by agency staff is logged with user, time, IP, and device.
- **Suspicious-access monitoring:** eight toggleable rules flag abnormal behavior — repeated views of one client, unusually many clients in a day or minute, access outside assigned programs, night-hours access, sudden spikes vs. a 30-day baseline, returns after long inactivity, and sequential record walking. Flags queue for admin resolution (single or batch), and access logs export to CSV.
- Field-verification activity (data freshness) is audit-logged.

**Compliance / reporting hooks:** supports HIPAA-style "minimum necessary" access review and funder data-security questionnaires.

**Maturity:** Stable.

**Differentiators:** built-in insider-access anomaly detection is uncommon in this market.

---

# Cross-Cutting Platform

## Multi-tenancy & data isolation

- Each agency runs its own application instance with its **own PostgreSQL database** — no shared database, no cross-tenant queries possible by construction. Instances run on AWS behind a load balancer; per-agency secrets are managed in AWS Systems Manager Parameter Store.
- Because deployment is per-agency, feature availability can genuinely vary by site (seeded roles/permissions, optional modules). Marketing should describe the product; sales should confirm per-site enablement.

## Roles & permissions

- Role-based access control with nearly 80 granular permissions (create/manage/view per module) assignable to agency-defined roles through an admin UI; per-user role assignment.
- A searchable admin Settings hub lets permissioned staff maintain the agency's own option lists — demographic answer sets (race, ethnicity, gender, language, housing status, veteran status, disability, education level, insurance providers, relationships) and operational vocabularies (document types, bed types, event types, note origins, organization types, geographic areas) — no vendor request needed to change a dropdown.
- Each staff member has a personal profile with interface theme choices and workflow defaults (default visit duration, message-delivery delay, review-alert scope, calendar view).
- **Record-level visibility** on notes, documents, folders, goals, visits, needs, referrals, and reports: everyone / same program / selected teams.
- Team constructs group users by program and care-team role; field-level edit permissions exist inside the form builder.
- Per-seat licensing at $25/user/month (approved for transparent publication on the website); seat limits are enforced per instance.

## Security & account protection

- Sign-in options per agency: password (with complexity rules and forced-change support), **SAML single sign-on**, **passkeys (WebAuthn)**, and two-factor via authenticator app (TOTP) or emailed one-time codes (per-user; a global-enforcement flag exists in code but is currently non-functional — missing config key).
- **Cloudflare Turnstile** bot protection on login, password reset, and public registration flows — designed to fail open so a Cloudflare outage can never lock staff out.
- Optional IP-based access modes per agency: open, IP-allowlist only, IP-allowlist with a 2FA-verified remote-access override, or SSO-only.
- Admin impersonation (restricted to designated super-users) for support; seat-limit enforcement; session security (HTTPS enforced, secure cookies, server-side sessions).
- All traffic is HTTPS; passwords and one-time codes are stored hashed; website-feed API tokens are stored hashed (partner-organization and portal tokens are held as shared secrets). *(Field-level encryption of database contents is not implemented in the application. Infrastructure-level disk encryption IS in place on the application server as of 2026-07-23: EBS AES-256 on both volumes, SSE-encrypted S3 SQL backups. See Decisions #15 for safe marketing wording.)*

## Real-time collaboration

- Live updates are pushed (not polled) for message threads, typing indicators, and the Quick Forms grid (cell presence, edits, colors, layout) via hosted Pusher channels with per-channel authorization. (Grid presence is currently limited to users with forms-management access by a permission-name mismatch — one-line engineering fix identified.)

## Data import / export

- Excel export across ~16 record types (clients, households, visits, needs, referrals, goals, tasks, events, reservations, billing batches, submissions, location logs, and more).
- Form designs export from the UI as files; importing into another Need Navigator system is operator tooling with automatic reference remapping.
- PDF tooling: merge client documents into packets, insurance cards to PDF, chart PDFs, class certificates/rosters/posters.
- There is currently **no bulk client-data importer** (e.g., CSV migration tooling) in the product — migrations are handled as services.

## AI capabilities (precise scope)

- Two shipped AI features: **AI form translation** (full-form baseline translation with human review workflow) and **AI shelter floor-plan drafting** (generate a to-scale layout from a text description of rooms and beds).
- Provider-configurable (OpenAI, Anthropic, or OpenRouter). No AI chat, summarization, or drafting features exist — do not market beyond the two above.

## Automation & scheduling

- Hourly scheduled-report delivery; daily class reminders (SMS/email); per-minute note-delay processing; daily cleanup of abandoned income-photo uploads.
- Event-driven Automations (see module) run in-line with casework.

## API surface

- Token-secured APIs serve: the MyNeedNav public portal, the public events/classes website feed, partner-organization portals, and cross-agency Need Navigator Network federation. All are allow-listed, rate-limited, and attribution-aware. There is no general-purpose public developer API.

---

# Integrations

| Service | Used for | Status |
| --- | --- | --- |
| Cloudflare Turnstile | Bot protection on login, password reset, public registration | Live |
| Pusher | Real-time messaging, typing, collaborative grid | Live |
| Google Maps & Places | Address autocomplete, geocoding, tracker map | Live |
| SMTP2GO | Transactional email and SMS (class reminders, check-in links, one-time codes) | Live |
| OpenAI / Anthropic / OpenRouter | AI translation and floor-plan drafting (configurable provider) | Live |
| SAML identity providers | Single sign-on (one IdP per agency) | Live |
| Google Chat | Internal error alerting for operations | Live (internal) |
| Microsoft Teams / Google Calendar / Zoom | Meeting deep links (URL generation only — not calendar sync) | Live (limited) |
| AWS (EC2, ALB, SSM Parameter Store) | Hosting and secrets management | Live (infrastructure) |
| Stripe (selected processor) | Online payment for event tickets/donations | **In progress — awaiting first end-to-end client run; do not market yet** |

---

# Decisions & Answers (Dave, 2026-07-24)

The audit's 20 open questions have all been answered. The calls, for whoever writes the marketing site:

1. **Workflow engine** — does not exist; the Needs/EFA workflow is the closest thing. Stays omitted from this document.
2. **Configurable dashboard (v2)** — ready to market. Live on roughly half of customer sites with no major issues; preferred over the legacy dashboard for new customers.
3. **Document Manager / partner document sharing** — beta; do not list yet.
4. **Event payments** — Stripe is the chosen processor; finalization awaits the first end-to-end client run. Not a marketable feature yet.
5. **Parent Ed classes** — live with two clients and ready for prime time.
6. **Partner portal** — live; configured per agency rather than for everyone.
7. **Need Navigator Network** — no agencies are federating yet; list it as a capability (heavily tested internally, good-quality code), not as an active network.
8. **Billing** — built to contract through batching and the 8-minute rule; electronic remittance was never built (the client contracted exclusively with a competing referral network, and clearinghouse red tape blocked the rest). Market as claim preparation + Excel export, not claim submission.
9. **"Voucher Printed" automation** — confirmed missing; filed as issue #23.
10. **MyNeedNav** — live with two tenants. The portal front-end is a separate application (server path `/var/www/myneednav`) consuming the Need Navigator API.
11. **GeoTracker** — market it hard. In heavy daily phone use at Northwest Human Services and very stable; also a strong Point-in-Time (PIT) count tool.
12. **Document Inbox** — built for one client, available to any agency and tailored as needed.
13. **Meeting links** — list as a convenience. The bigger idea (platform transcription + AI summary posted back to the originating record) is filed as issue #24.
14. **HUD/CSBG reporting** — honest gap: exports exist, funder-requirements knowledge doesn't. Discovery filed as issue #25. Avoid compliance claims beyond an "HMIS-adjacent data model" for now.
15. **Encryption at rest** — in place at the infrastructure level as of 2026-07-23: both application-server EBS volumes (OS + Postgres data; code + client documents) are AES-256-encrypted, nightly SQL backups stream to SSE-encrypted, versioned, no-delete S3 (35-day retention), and encrypted DLM snapshots are rolling out (legacy unencrypted snapshots/volumes scheduled for deletion by ~2026-07-30). Safe claim: **"client data is encrypted at rest on the application server."** Caveats: the application does not additionally encrypt PII columns (SSN/DOB/HMIS #), full SSN displays unmasked when configured to show on profile, and two secondary EC2 instances still carry unencrypted volumes — avoid blanket "all data everywhere" wording.
16. **Pricing** — $25/user/month per seat, enforced per instance; approved for transparent publication on the website.
17. **"Resources" naming** — Resources = the catalog that instantiates Needs. Class handouts are ordinary documents filed under a seeded "Resource" document type (no separate table). No rename planned.
18. **Contact logins** — live, but only meaningful with the partner portal (#6): partners manage their classes, submit Needs against portal-flagged resources, and post to task lists marked as accepting portal posts.
19. **Thread reactions/read receipts** — verified: reactions don't exist anywhere; read-tracking is per-recipient on classic notes only. The CLAUDE.md correction is tracked in issue #20, and realtime warrants a fresh look (see also issue #13, the presence-channel permission mismatch).
20. **Legacy assets** (`components/`, inert `LogsController`, unused Passport) — plan: disable them and watch for breakage (believed unused); re-enable anything that turns out to be load-bearing.
