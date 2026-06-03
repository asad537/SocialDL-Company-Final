<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="/images/logofinal.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - Video Saver</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #fff; color: #111827; }
        .legal-wrap { max-width: 980px; margin: 0 auto; padding: 3rem 1.25rem 3.5rem; }
        .legal-hero {
            margin-bottom: 1.4rem;
            background: linear-gradient(135deg, rgba(255, 157, 7, 0.22), #FFFFFF);
            border: 1px solid #FF9D07;
            border-radius: 20px;
            padding: 2rem 1.5rem;
            box-shadow: 0 6px 20px rgba(17, 24, 39, 0.05);
        }
        .legal-hero h1 { font-size: 2rem; font-weight: 800; color: #111827; margin-bottom: 0.55rem; }
        .legal-hero p { color: #4B5563; font-size: 0.98rem; line-height: 1.6; max-width: 760px; }
        .legal-head { margin-bottom: 1.4rem; }
        .legal-head h1 { font-size: 2rem; font-weight: 800; margin-bottom: 0.55rem; }
        .legal-head p { color: #6B7280; font-size: 0.95rem; }
        .legal-card { border: 1px solid #ECEFF3; border-radius: 18px; padding: 1.6rem; box-shadow: 0 4px 14px rgba(17, 24, 39, 0.04); }
        .legal-card h2 { font-size: 1.08rem; font-weight: 800; margin: 1rem 0 0.5rem; color: #111827; }
        .legal-card h2:first-child { margin-top: 0; }
        .legal-card p, .legal-card li { font-size: 0.95rem; color: #4B5563; line-height: 1.75; }
        .legal-card ul { margin: 0.5rem 0 0.8rem 1.2rem; }
        .accent { color: #FFB800; font-weight: 700; }
        @media (max-width: 768px) {
            .legal-wrap { padding-top: 2.1rem; }
            .legal-hero { margin-top: 5.2rem; padding: 1.35rem 1rem; border-radius: 16px; }
            .legal-hero h1 { font-size: 1.55rem; }
            .legal-hero p { font-size: 0.9rem; }
        }
    </style>
</head>

<body class="has-fixed-header">
    @include('partials.header', ['headerClass' => 'header-white'])

    <main class="legal-wrap">
        <section class="legal-hero">
            <h1>Terms of Service</h1>
            <p>These terms govern your use of Video Saver and outline your responsibilities when using our service.</p>
        </section>

        <div class="legal-head">
            <p>Last updated: {{ date('F d, Y') }}</p>
        </div>

        <div class="legal-card">
            <h2>1. Acceptance of Terms</h2>
            <p>By using <span class="accent">Video Saver</span>, you agree to these Terms of Service and all
                applicable laws and regulations.</p>

            <h2>2. Use of Service</h2>
            <ul>
                <li>You are responsible for ensuring you have rights to access and download requested content.</li>
                <li>You agree not to misuse, disrupt, or attempt unauthorized access to the platform.</li>
                <li>You must comply with local copyright and intellectual property laws.</li>
            </ul>

            <h2>3. Intellectual Property</h2>
            <p>The website design, branding, and software are owned by Video Saver or licensed to us. Third-party
                content rights remain with their respective owners.</p>

            <h2>4. Service Availability</h2>
            <p>We may modify, suspend, or discontinue features at any time without prior notice to maintain quality and
                security.</p>

            <h2>5. Limitation of Liability</h2>
            <p>Video Saver is provided on an "as is" and "as available" basis. We are not liable for indirect or
                consequential damages arising from use of the service.</p>

            <h2>6. Third-Party Platforms</h2>
            <p>Our service may interact with third-party platforms. We are not responsible for third-party policies,
                outages, or content changes.</p>

            <h2>7. Termination</h2>
            <p>We reserve the right to restrict or terminate access if misuse, abuse, or violations are detected.</p>

            <h2>8. Contact</h2>
            <p>If you have questions about these terms, please contact us through the website support channel.</p>
        </div>
    </main>

    @include('partials.footer')
</body>

</html>
