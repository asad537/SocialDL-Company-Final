<style>
    .site-footer {
        background: #fff;
        border-top: 1px solid #EBEBEB;
        padding: 3rem 0 0;
    }

    .footer-inner {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr 1.4fr 1fr;
        gap: 2.5rem;
        padding-bottom: 2.5rem;
        align-items: start;
    }

    .footer-logo-link {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        text-decoration: none;
        margin-bottom: 1rem;
    }

    .footer-logo-link img {
        height: 85px;
        width: auto;
        margin-top: -34px;
    }

    .footer-desc {
        font-size: 0.88rem;
        color: #111827;
        line-height: 1.85;
        max-width: 190px;
    }

    .footer-col-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 1.1rem;
        margin-top: 0;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.65rem;
    }

    .footer-links a {
        font-size: 0.88rem;
        color: #111827;
        text-decoration: none;
        transition: opacity 0.2s;
    }

    .footer-links a:hover {
        opacity: 0.6;
    }

    .footer-copyright {
        border-top: 1px solid #EBEBEB;
        padding: 1.1rem 0;
        text-align: center;
    }

    .footer-copyright p {
        font-size: 0.83rem;
        color: #9CA3AF;
        margin: 0;
    }

    /* ── Tablet: 2 columns ── */
    @media (max-width: 900px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        .footer-desc {
            max-width: 100%;
        }
    }

    /* ── Mobile: single column ── */
    @media (max-width: 600px) {
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .site-footer {
            padding: 2rem 0 0;
        }

        .footer-logo-link img {
            height: 60px;
            margin-top: 0;
        }

        .footer-desc {
            max-width: 100%;
        }

        .footer-col-title {
            font-size: 0.9rem;
            margin-bottom: 0.8rem;
        }

        .footer-links {
            gap: 0.5rem;
        }

        .footer-links a {
            font-size: 0.85rem;
        }

        .footer-copyright p {
            font-size: 0.78rem;
        }
    }
</style>

<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-grid">

            <!-- Brand -->
            <div>
                <a href="/" class="footer-logo-link">
                    <img src="/images/logofinal.png" alt="Video Saver">
                </a>
                <p class="footer-desc">
                    Download videos, audios and reels from your
                    favourite platforms in high quality for free.
                    No login required. Works on all devices.
                    Fast, safe and 100% free to use.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="footer-col-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="/">Home</a></li>
                    <li><a href="#supported">Supported Platforms</a></li>
                    <li><a href="#">Download</a></li>
                    <li><a href="/faqs">FAQs</a></li>
                    <li><a href="#">Help center</a></li>
                </ul>
            </div>

            <!-- Supported Platforms -->
            <div>
                <h4 class="footer-col-title">Supported Platforms</h4>
                <ul class="footer-links">
                    <li><a href="#">Instagram Video Downloader</a></li>
                    <li><a href="#">Facebook Video Downloader</a></li>
                    <li><a href="#">TikTok Video Downloader</a></li>
                    <li><a href="#">Twitter Video Downloader</a></li>
                    <li><a href="#">WhatsApp Status Downloader</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h4 class="footer-col-title">Legal</h4>
                <ul class="footer-links">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Term of Service</a></li>
                    <li><a href="#">Disclaimer</a></li>
                </ul>
            </div>

        </div>
    </div>

    <!-- Copyright -->
    <div class="footer-copyright">
        <div class="footer-inner">
            <p>© {{ date('Y') }} Video Saver. All rights reserved.</p>
        </div>
    </div>
</footer>