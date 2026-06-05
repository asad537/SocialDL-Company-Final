<style>
    /* ── Bottom CTA ── */
    .bottom-cta {
        background: var(--primary);
        border-radius: 24px;
        padding: 2.2rem 3rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 4rem auto; /* Let the container handle outer spacing, just center it and add some vertical margin */
        text-align: left;
        max-width: 900px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .cta-content h2 {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-size: 1.7rem;
        font-weight: 700;
        color: #000;
        margin-bottom: 0.5rem;
        letter-spacing: normal;
    }

    .cta-content p {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-size: 0.95rem;
        color: #000;
        opacity: 0.8;
        font-weight: 500;
        letter-spacing: normal;
        margin: 0; line-height: 1.45; }

    .btn-cta {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        background: #ffffff;
        color: #000;
        padding: 1.1rem 2.2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 800;
        font-size: 1.05rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        white-space: nowrap;
        display: inline-block;
        position: relative;
    }

    .btn-cta::after {
        content: '';
        position: absolute;
        top: -10px;
        bottom: -15px; /* Extra space at the bottom to prevent hover loss when translating Y up */
        left: -10px;
        right: -10px;
        border-radius: 60px;
        z-index: -1;
    }

    .btn-cta:hover {
        background: #FF6807;
        color: #ffffff;
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(255, 104, 7, 0.3);
    }

    @media (max-width: 768px) {
        .bottom-cta {
            flex-direction: column;
            text-align: center;
            padding: 2rem 1.5rem;
            gap: 1.5rem;
            margin-top: 3.5rem;
        }

        .cta-content h2 {
            font-size: 1.4rem;
        }
    }
</style>

<div class="bottom-cta">
    <div class="cta-content">
        <h2>Ready to Start Downloading?</h2>
        <p style="line-height: 1.45;">Join millions of users who rely on HD Video Saver for fast, easy, and reliable downloads</p>
    </div>
    <a href="https://play.google.com/store/apps/details?id=com.jmdsol.videodownloader.videosaver"
        class="btn-cta">Download Video Saver</a>
</div>
