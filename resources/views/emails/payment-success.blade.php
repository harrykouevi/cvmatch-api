<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Confirmed - CVMatch AI</title>
</head>

<body style="margin:0;padding:0;background:#F8F7F3;font-family:Arial,Helvetica,sans-serif;color:#0f172a;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#F8F7F3;margin:0;padding:32px 12px;">
    <tr>
      <td align="center">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:680px;background:#ffffff;border-radius:28px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 20px 50px rgba(15,23,42,0.08);">

          <tr>
            <td style="background:linear-gradient(135deg,#07111F,#0B1628 52%,#064E5F);padding:40px 32px;text-align:center;color:#ffffff;">
              <div style="width:76px;height:76px;border-radius:24px;margin:0 auto;background:rgba(34,197,94,0.15);border:1px solid rgba(134,239,172,0.35);color:#86EFAC;font-size:44px;font-weight:900;line-height:76px;text-align:center;">
                ✓
              </div>

              <div style="display:inline-block;margin-top:24px;padding:8px 14px;border-radius:999px;background:rgba(34,197,94,0.12);border:1px solid rgba(134,239,172,0.24);color:#bbf7d0;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1.8px;">
                Payment confirmed
              </div>

              <h1 style="margin:20px 0 0;font-size:34px;line-height:1.1;font-weight:900;letter-spacing:-1px;">
                Your credits are ready
              </h1>

              <p style="margin:14px auto 0;max-width:480px;color:rgba(255,255,255,0.68);font-size:16px;line-height:1.7;">
                Thank you for your purchase. Your CVMatch AI credits have been added to your account.
              </p>
            </td>
          </tr>

          <tr>
            <td style="padding:34px 28px 10px;">
              <p style="margin:0;font-size:18px;line-height:1.7;font-weight:700;color:#0f172a;">
                Hello {{ $firstName }},
              </p>

              <p style="margin:14px 0 0;font-size:15px;line-height:1.8;color:#475569;">
                Your payment has been successfully processed. You can now use your credits to optimize resumes, generate tailored cover letters, and download premium PDF versions.
              </p>
            </td>
          </tr>

          <tr>
            <td style="padding:18px 28px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-radius:24px;background:linear-gradient(135deg,#ecfdf5,#ecfeff,#ffffff);border:1px solid #d1fae5;overflow:hidden;">
                <tr>
                  <td style="padding:22px 16px;text-align:center;border-right:1px solid #d1fae5;">
                    <div style="font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:1.5px;color:#059669;">
                      Credits Added
                    </div>
                    <div style="margin-top:8px;font-size:38px;font-weight:900;color:#16a34a;">
                      +{{ $creditsAdded }}
                    </div>
                    <div style="font-size:12px;color:#64748b;font-weight:700;">
                      Resume credits
                    </div>
                  </td>

                  <td style="padding:22px 16px;text-align:center;border-right:1px solid #d1fae5;">
                    <div style="font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:1.5px;color:#0891b2;">
                      Current Balance
                    </div>
                    <div style="margin-top:8px;font-size:38px;font-weight:900;color:#0891b2;">
                      {{ $currentBalance }}
                    </div>
                    <div style="font-size:12px;color:#64748b;font-weight:700;">
                      Available credits
                    </div>
                  </td>

                  <td style="padding:22px 16px;text-align:center;">
                    <div style="font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:1.5px;color:#64748b;">
                      Plan
                    </div>
                    <div style="margin-top:10px;font-size:16px;font-weight:900;color:#0f172a;">
                      {{ $planName }}
                    </div>
                    <div style="font-size:13px;color:#64748b;font-weight:700;">
                      {{ $amount }}
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td style="padding:10px 28px 0;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8fafc;border-radius:22px;border:1px solid #e2e8f0;">
                <tr>
                  <td style="padding:22px;">
                    <h2 style="margin:0 0 14px;font-size:18px;font-weight:900;color:#0f172a;">
                      Purchase details
                    </h2>

                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                      <tr>
                        <td style="padding:8px 0;color:#64748b;font-size:14px;">Plan</td>
                        <td align="right" style="padding:8px 0;color:#0f172a;font-size:14px;font-weight:800;">{{ $planName }}</td>
                      </tr>
                      <tr>
                        <td style="padding:8px 0;color:#64748b;font-size:14px;">Amount paid</td>
                        <td align="right" style="padding:8px 0;color:#0f172a;font-size:14px;font-weight:800;">{{ $amount }}</td>
                      </tr>
                      <tr>
                        <td style="padding:8px 0;color:#64748b;font-size:14px;">Credits added</td>
                        <td align="right" style="padding:8px 0;color:#16a34a;font-size:14px;font-weight:900;">+{{ $creditsAdded }}</td>
                      </tr>
                      <tr>
                        <td style="padding:8px 0;color:#64748b;font-size:14px;">Current balance</td>
                        <td align="right" style="padding:8px 0;color:#0891b2;font-size:14px;font-weight:900;">{{ $currentBalance }}</td>
                      </tr>
                      <tr>
                        <td style="padding:8px 0;color:#64748b;font-size:14px;">Transaction ID</td>
                        <td align="right" style="padding:8px 0;color:#0f172a;font-size:13px;font-weight:800;">{{ $transactionId }}</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td style="padding:24px 28px 0;">
              <h2 style="margin:0 0 14px;font-size:18px;font-weight:900;color:#0f172a;">
                What you can do now
              </h2>

              <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                <tr><td style="padding:8px 0;font-size:15px;color:#334155;">✓ Generate ATS-optimized resumes</td></tr>
                <tr><td style="padding:8px 0;font-size:15px;color:#334155;">✓ Create tailored cover letters</td></tr>
                <tr><td style="padding:8px 0;font-size:15px;color:#334155;">✓ Download premium PDF resumes</td></tr>
                <tr><td style="padding:8px 0;font-size:15px;color:#334155;">✓ Compare your original and optimized resume</td></tr>
                <tr><td style="padding:8px 0;font-size:15px;color:#334155;">✓ Improve your ATS match score</td></tr>
              </table>
            </td>
          </tr>

          <tr>
            <td style="padding:28px;text-align:center;">
              <a href="{{ $dashboardUrl }}" style="display:inline-block;background:linear-gradient(135deg,#3B82F6,#22D3EE);color:#ffffff;text-decoration:none;font-weight:900;border-radius:18px;padding:15px 26px;font-size:15px;box-shadow:0 16px 34px rgba(34,211,238,0.22);">
                Go to Dashboard
              </a>

              <div style="height:12px;"></div>

              <a href="{{ $appUrl }}" style="display:inline-block;background:#ffffff;color:#0f172a;text-decoration:none;font-weight:900;border-radius:18px;padding:14px 24px;font-size:15px;border:1px solid #e2e8f0;">
                Continue Optimizing Resume
              </a>
            </td>
          </tr>

          <tr>
            <td style="padding:0 28px 28px;">
              <div style="background:#ecfeff;border:1px solid #cffafe;border-radius:22px;padding:20px;">
                <div style="font-size:15px;font-weight:900;color:#0e7490;">
                  Pro tip
                </div>
                <p style="margin:8px 0 0;color:#155e75;font-size:14px;line-height:1.7;">
                  Use one credit per specific job description. The more closely your resume matches the role, the stronger your ATS alignment can become.
                </p>
              </div>
            </td>
          </tr>

          <tr>
            <td style="padding:0 28px 28px;">
              <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:22px;padding:18px;">
                <p style="margin:0;color:#64748b;font-size:12px;line-height:1.7;">
                  Important notice: CVMatch AI provides AI-assisted resume optimization. Results should be reviewed and verified by the user before submitting job applications. CVMatch AI does not guarantee interviews, job offers, or employment outcomes.
                </p>
              </div>
            </td>
          </tr>

          <tr>
            <td style="padding:26px 28px;background:#0f172a;text-align:center;color:rgba(255,255,255,0.58);">
              <div style="font-size:18px;font-weight:900;color:#ffffff;">
                CVMATCH <span style="color:#22D3EE;">AI</span>
              </div>

              <p style="margin:8px 0 0;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;font-weight:800;">
                Match your CV. Get hired.
              </p>

              <p style="margin:16px 0 0;font-size:13px;line-height:1.7;">
                Need help? Contact
                <a href="mailto:{{ $supportEmail }}" style="color:#67e8f9;text-decoration:none;font-weight:800;">
                  {{ $supportEmail }}
                </a>
              </p>

              <p style="margin:14px 0 0;font-size:11px;color:rgba(255,255,255,0.38);">
                © 2026 CVMatch AI. All rights reserved.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
