# CVMatch AI Production Test Checklist



```bash
composer install
php artisan optimize:clear
php artisan route:list
php artisan test
```

## Required Environment Placeholders

Use real production values only in the deployment environment. Do not commit real secrets.

- `APP_KEY`
- `APP_ENV`
- `APP_URL`
- `FRONTEND_URL`
- `DB_CONNECTION`
- `DB_HOST`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `OPENAI_API_KEY`
- `STRIPE_KEY`
- `STRIPE_SECRET`
- `STRIPE_WEBHOOK_SECRET`
- `GOOGLE_CLIENT_ID`
- `GOOGLE_CLIENT_SECRET`
- `GOOGLE_REDIRECT_URI`

## Manual E2E Flows

Guest flow:

1. Start a free scan.
2. Reach paywall.
3. Start Google sign-in from the paywall.
4. Complete Google sign-in.
5. Start Stripe checkout.
6. Complete payment.
7. Confirm PaymentSuccess verifies server-side.
8. Confirm unlocked result is available.
9. Confirm funnel events and Google Ads conversion fire only after the expected step.

Logged-in no credits:

1. Start a free scan.
2. Click `Buy 1 Credit & Unlock Resume`.
3. Confirm Stripe checkout starts.
4. Complete payment.
5. Confirm PaymentSuccess verifies server-side.
6. Confirm unlocked result is available after credit grant/webhook processing.

Logged-in with credits:

1. Start a free scan.
2. Click `Use 1 Credit to Unlock Resume`.
3. Confirm the result unlocks without Stripe checkout.
4. Confirm only one credit is consumed.

## AI Prompt Validation Scenario

Use an IT Manager target role where the original resume evidence includes computer maintenance, network wiring, router setup, printer/scanner support, admin work, and bus cleaning. Verify:

- Supported IT evidence is promoted honestly.
- Unsupported job keywords are not added to optimized resume sections.
- `keywords_added` includes only resume-supported evidence.
- Role fit is not inflated beyond the source resume.
- Free analysis and unlocked result remain consistent.
- Returned JSON remains valid for Laravel storage and PDF export.

## Payment Security Validation

- Stripe checkout session create route exists.
- Stripe webhook route exists.
- Stripe session verify route exists.
- Verify endpoint retrieves Stripe server-side.
- Verify endpoint rejects unpaid, open, expired, or wrong-owner sessions.
- Verify endpoint does not grant credits directly.
- Repeated verify calls do not double-grant credits.

## Google Ads Validation

- Conversion ID remains `AW-18241901593`.
- Conversion label remains `Al_LCI3C078cEJmotfpD`.
- Fallback value remains `5.0`.
- Dedup key remains transaction-scoped.
- Conversion fires only after verified payment success.
