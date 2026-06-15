# CVMatch AI — Backend/API package for Claude audit

## Non-negotiable rules

[MODE TOKEN MINIMAL]

PRODUCTION DESIGN LOCKED.
PRICING LOCKED.
ABSOLUTE RULE:
Any pricing change is forbidden.
If task requires pricing changes, stop and report “pricing locked”.

## Context

This package was cleaned from the original CVMATCH.rar archive for backend/security audit.
It appears to be a Laravel API backend for CVMatch AI, with routes, controllers, models, services, jobs, migrations, tests, composer/package files.

## What was excluded from the clean package

- `.env`
- `.git/`
- `vendor/`
- `node_modules/`
- storage logs/cache/uploads/app data
- generated cache files
- database dumps / sqlite / db files
- private keys / pem / key / cert files
- nested archives
- `.phpunit.result.cache`
- `.rnd`

## Main audit goals for Claude

Audit only first. Do not modify files unless explicitly requested later.

Verify:

1. Ownership / IDOR protection:
   - `/v1/analyses/:id`
   - unlock endpoints
   - resume upload/read/download endpoints
   - guest token ownership
   - authenticated user ownership

2. Privacy consistency:
   - deletion capability for resume + analysis + files
   - retention/cleanup policy in code
   - server-side logs do not contain CV/JD/OpenAI prompts/responses

3. Upload security:
   - PDF/DOCX validation
   - MIME validation
   - file size limits
   - private storage
   - no public raw CV URLs

4. Payment/unlock:
   - idempotency
   - webhook signature verification
   - no public simulation route in production
   - no unsafe GET unlock if state-changing
   - no double credit/unlock

5. API response safety:
   - no unnecessary raw extracted text
   - no tokens/secrets in responses
   - no job descriptions returned unnecessarily

## Important product constraints

- Do not change pricing.
- Do not add plans.
- Do not rename plans.
- Do not change credit logic unless explicitly requested.
- Do not change checkout/paywall behavior unless explicitly requested.
- Design/frontend is locked and out of scope for backend audit.
