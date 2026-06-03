<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="/images/logofinal.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Saver - HD Video & Music Downloader</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #FFB800;
            --primary-hover: #E5A600;
            --text-dark: #111827;
            --text-gray: #4B5563;
            --bg-light: #FFFFFF;
            --bg-off: #F9FAFB;
            --border: #E5E7EB;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        /* Prevent Inter from overriding Font Awesome icons */
        .fa,
        .fas,
        .far,
        .fab,
        .fa-solid,
        .fa-regular,
        .fa-brands {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands", "Font Awesome 5 Free", "Font Awesome 5 Brands", sans-serif !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 700;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
            top: 0 !important;
        }

        /* Prevent horizontal scroll */
        html {
            overflow-x: hidden;
        }

        /* ── Header ── */
        header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 1.2rem 0;
            background: transparent;
            display: flex;
            justify-content: center;
        }

        .header-container {
            width: 100%;
            max-width: 1200px;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 800;
            font-size: 1.1rem;
        }

        .logo img {
            height: 65px;
            width: auto;
            border-radius: 8px;
        }

        .nav-wrap {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .lang-dropdown {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            backdrop-filter: blur(8px);
            position: relative;
            z-index: 1000;
        }

        .lang-menu {
            position: absolute;
            top: 110%;
            right: 0;
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            width: 150px;
            display: none;
            flex-direction: column;
            overflow: hidden;
        }

        .lang-menu div {
            padding: 10px 15px;
            font-size: 0.85rem;
            color: var(--text-dark);
            transition: background 0.2s;
        }

        .lang-menu div:hover {
            background: var(--bg-off);
            color: var(--primary);
        }

        /* Ultra-Aggressive Hide Google Translate */
        iframe.skiptranslate,
        .goog-te-banner-frame,
        .goog-te-banner,
        .goog-te-balloon-frame,
        #goog-gt-tt,
        .goog-tooltip,
        .goog-tooltip:hover,
        .goog-te-spinner-pos,
        .goog-te-spinner,
        .goog-te-spinner-pos+div {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }

        body {
            top: 0px !important;
            position: static !important;
        }

        /* ── Hero ── */
        .hero {
            position: relative;
            width: 100%;
            height: 35vw;
            /* Height scales with width to maintain aspect ratio */
            min-height: 450px;
            max-height: 650px;
            display: flex;
            align-items: center;
            padding: 2vw 0;
            overflow: hidden;
            background-color: #fff5f6;
            /* Matches the light pink background of the image */
        }

        /* 13 inch screens */
        @media (min-width: 1200px) {
            .hero {
                height: 35vw;
            }
        }

        /* 15 inch screens */
        @media (min-width: 1440px) {
            .hero {
                height: 35vw;
            }
        }

        /* Above 15 inch */
        @media (min-width: 1600px) {
            .hero {
                height: 35vw;
            }
        }

        /* BG image — Never cuts, always shows full image */
        .hero-bg-img {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center right;
            z-index: 0;
        }

        .hero-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
            overflow: visible;
        }

        .hero-content {
            max-width: 750px;
            margin-top: 70px;
        }

        .hero h1 {
            font-size: 2rem;
            font-weight: 600;
            line-height: 1.2;
            color: var(--text-dark);
            margin-bottom: 2rem;
        }

        .hero-btn {
            background: var(--primary);
            color: var(--text-dark);
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-block;
            box-shadow: 0 10px 15px -3px rgba(255, 184, 0, 0.3);
            transition: all 0.2s;
            margin-bottom: 3rem;
        }

        .hero-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .trust-row {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-gray);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .trust-item img {
            height: 24px;
        }

        /* ── Search Section ── */
        .search-section {
            padding: 5rem 0;
            text-align: center;
            background: white;
        }

        .search-section h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 2.5rem;
            color: var(--text-dark);
        }

        .search-box-wrap {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }

        .search-container {
            background: white;
            border: 2px solid var(--primary);
            border-radius: 16px;
            padding: 8px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .search-container i.fa-globe {
            margin-left: 1.5rem;
            color: #9CA3AF;
            font-size: 1.2rem;
        }

        .search-container input {
            flex: 1;
            border: none;
            outline: none;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
        }

        .search-container button {
            background: var(--primary);
            color: var(--text-dark);
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.2s;
        }

        .search-container button:hover {
            background: var(--primary-hover);
        }

        .search-container button i {
            background: rgba(0, 0, 0, 0.1);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .tutorial-link {
            margin-top: 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #3B82F6;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .tutorial-link i {
            font-size: 1.2rem;
        }

        .tutorial-link span {
            color: var(--text-gray);
            font-weight: 400;
            margin-left: 5px;
        }

        /* ── Loader ── */
        .loader-box {
            display: none;
            text-align: center;
            padding: 4rem 1rem;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #F3F4F6;
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── Skeleton ── */
        .skeleton-wrapper {
            max-width: 1100px;
            margin: 2rem auto;
            display: none;
            grid-template-columns: 320px 1fr;
            gap: 30px;
            padding: 0 2rem;
        }

        .skeleton-box {
            background: #F9FAFB;
            border-radius: 24px;
            border: 1px solid var(--border);
            padding: 24px;
        }

        .skel {
            background: #E5E7EB;
            border-radius: 8px;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* ── Results ── */
        .results-wrapper {
            max-width: 1100px;
            margin: 2rem auto 0;
            display: none;
            flex-direction: row;
            gap: 30px;
            padding: 0 2rem;
            align-items: flex-start;
        }

        .sidebar {
            background: white;
            padding: 15px;
            height: fit-content;
            width: 260px;
            flex-shrink: 0;
            /* Width fixed rahe */
        }

        .thumb-box {
            width: 100%;
            aspect-ratio: 16/9;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 12px;
            background: #E0E0E0;
        }

        .thumb-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-title {
            font-size: 0.85rem !important;
            /* Force small size */
            font-weight: 700;
            margin-bottom: 10px !important;
            line-height: 1.3;
            color: #212121;
            display: block;
        }

        .duration-badge {
            background: #FFE082;
            color: #000;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .main-content {
            background: white;
            padding: 0 5px;
            flex: 1;
            /* Baki sari width le lo */
        }

        .section-header {
            padding: 15px 0 8px 0;
            border-bottom: 1px solid #E0E0E0;
            font-size: 1.1rem;
            /* Smaller header */
            font-weight: 800;
            color: #000;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .section-header i {
            color: #FBC02D;
            font-size: 1.2rem;
        }

        .format-row {
            display: grid;
            grid-template-columns: 60px 70px 90px 1fr;
            padding: 12px 0;
            align-items: center;
            border-bottom: 1px solid #F5F5F5;
            gap: 8px;
        }

        .format-badge {
            background: #00C853;
            color: white;
            padding: 3px 0;
            border-radius: 4px;
            font-weight: 800;
            font-size: 0.7rem;
            text-align: center;
            width: 50px;
        }

        .quality-text {
            font-weight: 700;
            font-size: 0.85rem;
            color: #212121;
        }

        .size-text {
            color: #616161;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .dl-btn {
            background: white;
            color: #000;
            border: 1.5px solid #FFC107;
            padding: 6px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: fit-content;
            justify-self: end;
            transition: all 0.2s;
        }

        .dl-btn i {
            color: #FFC107;
            font-size: 1rem;
        }

        .dl-btn:hover {
            background: #FFF9C4;
        }

        #error {
            color: #EF4444;
            text-align: center;
            max-width: 700px;
            margin: 2rem auto;
            display: none;
            font-weight: 600;
            padding: 1rem 2rem;
            background: #FEF2F2;
            border: 1px solid #FEE2E2;
            border-radius: 12px;
        }

        /* ── Feature Sections ── */
        .feature-item {
            margin: 1.5rem auto;
            max-width: 850px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 40px;
            text-align: left;
            flex-wrap: wrap;
            padding: 0 20px;
        }

        .feature-item.reverse {
            flex-direction: row-reverse;
        }

        .feature-image-wrap {
            flex: 0 0 auto;
        }

        .feature-image {
            width: 100%;
            max-width: 250px;
            height: auto;
            border-radius: 15px;
        }

        .feature-content {
            flex: 1;
            min-width: 300px;
        }

        .feature-content h2 {
            font-size: 1.3rem !important;
            font-weight: 800 !important;
            margin-bottom: 0.8rem !important;
            line-height: 1.2 !important;
            text-align: left !important;
        }

        .feature-content h3 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #212121;
            margin-bottom: 0.8rem;
        }

        .feature-content p {
            color: var(--text-gray);
            font-size: 0.85rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            text-align: justify;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            font-size: 0.85rem;
        }

        .feature-list li {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }

        .feature-list i {
            color: var(--primary);
            font-size: 0.9rem;
        }

        .features-intro-title {
            font-size: 2.8rem;
            font-weight: 800;
            line-height: 1.2;
            color: #111827;
            text-align: center !important;
            margin: 0 auto 1rem;
            max-width: 860px;
        }

        .features-intro-text {
            font-size: 1.55rem;
            line-height: 1.45;
            color: #1f2937;
            text-align: center !important;
            max-width: 1050px;
            margin: 0 auto 0.2rem;
        }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            header {
                padding: 1rem 0;
            }

            .logo img {
                height: 60px;
            }

            .hero {
                background-position: center bottom;
                text-align: center;
                padding: 8rem 0 300px 0;
                height: auto;
                min-height: 600px;
            }

            .hero-bg-img {
                object-position: center center;
                object-fit: cover;
            }

            .hero-content {
                max-width: 100%;
            }

            .trust-row {
                justify-content: center;
                flex-wrap: wrap;
            }

            .results-wrapper,
            .skeleton-wrapper {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 0;
            }

            .header-container {
                padding: 0 1rem;
            }

            .logo img {
                height: 50px;
            }

            .nav-links {
                display: none;
            }

            .lang-dropdown {
                font-size: 0.8rem;
                padding: 6px 12px;
            }

            .hero {
                padding: 0 0 2rem;
                min-height: auto;
                height: auto;
                background: #fff;
                justify-content: flex-start;
                flex-direction: column;
                text-align: center;
            }

            .hero picture {
                display: block;
                width: min(100%, 480px);
                margin: 0 auto;
                overflow: hidden;
            }

            .hero-bg-img {
                position: relative;
                display: block;
                width: 100%;
                height: clamp(365px, 101vw, 480px);
                margin: 0 auto;
                object-fit: cover;
                object-position: center top;
            }

            .hero-content {
                display: block;
                max-width: 430px;
                margin: 1.15rem auto 0;
                padding: 0 1.25rem;
            }

            .hero h1 {
                max-width: 410px;
                margin-left: auto;
                margin-right: auto;
                font-size: clamp(1.45rem, 6vw, 1.75rem);
                font-weight: 800;
                line-height: 1.16;
                margin-bottom: 1.45rem;
            }

            .hero-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 220px;
                min-height: 48px;
                font-size: 0.95rem;
                padding: 0 1.5rem;
                margin-bottom: 2.4rem;
                box-shadow: 0 6px 10px rgba(17, 24, 39, 0.18);
            }

            .trust-row {
                width: 100%;
                max-width: 390px;
                margin: 0 auto;
                padding: 0 0.45rem;
                justify-content: space-between;
                flex-wrap: nowrap;
                gap: 0.75rem;
            }

            .trust-item {
                color: #111;
                font-size: 0.95rem;
                font-weight: 700;
                gap: 9px;
                white-space: nowrap;
            }

            .trust-item img,
            .trust-item .trust-lookout-icon {
                width: 32px;
                height: 32px;
                flex: 0 0 32px;
            }

            .trust-item .trust-lookout-icon {
                color: #34c759;
                font-size: 31px;
                line-height: 1;
            }

            .features-intro-title {
                font-size: clamp(1.45rem, 6vw, 2rem);
                line-height: 1.25;
                margin-bottom: 0.75rem;
                text-align: center !important;
            }

            .features-intro-text {
                font-size: clamp(0.95rem, 3.8vw, 1.15rem);
                line-height: 1.55;
                padding: 0 0.2rem;
                text-align: center !important;
            }

            .search-section {
                padding: 2.25rem 0 !important;
            }

            .search-section h2 {
                font-size: clamp(1.9rem, 7vw, 2.3rem) !important;
                line-height: 1.18;
                margin-bottom: 1rem !important;
            }

            #searchBox {
                display: flex !important;
                align-items: center;
                gap: 0.35rem;
                padding: 6px !important;
                border-radius: 14px !important;
            }

            #searchBox i.fa-globe {
                margin-left: 0.6rem !important;
                font-size: 0.95rem !important;
            }

            #videoUrl {
                min-width: 0;
                flex: 1 1 auto;
                width: 1%;
                padding: 0.55rem 0.35rem !important;
                font-size: 0.95rem !important;
            }

            #fetchBtn {
                flex: 0 0 auto;
                white-space: nowrap;
                padding: 8px 12px !important;
                font-size: 0.86rem !important;
                border-radius: 10px !important;
            }

            #fetchBtn i {
                width: 20px !important;
                height: 20px !important;
                font-size: 0.62rem !important;
            }

            .search-section p {
                margin-top: 0.7rem !important;
                line-height: 1.35;
            }

            .search-section p a {
                font-size: 0.92rem !important;
            }

            .search-section p span {
                margin-left: 5px !important;
                font-size: 0.92rem !important;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding-bottom: 1.5rem;
                margin-top: 5rem;
            }

            .hero picture {
                width: 100%;
            }

            .hero h1 {
                padding: 0 0.6rem;
            }

            .trust-row {
                max-width: 390px;
            }

            .trust-item {
                font-size: clamp(0.78rem, 3.2vw, 0.95rem);
                gap: 7px;
            }

            .trust-item img,
            .trust-item .trust-lookout-icon {
                width: clamp(24px, 6.8vw, 32px);
                height: clamp(24px, 6.8vw, 32px);
                flex-basis: clamp(24px, 6.8vw, 32px);
            }

            .trust-item .trust-lookout-icon {
                font-size: clamp(24px, 6.6vw, 31px);
            }

            .search-section h2 {
                font-size: 1.3rem !important;
            }

            #searchBox i.fa-globe {
                margin-left: 0.45rem !important;
            }

            #videoUrl {
                padding: 0.5rem 0.2rem !important;
                font-size: 0.92rem !important;
            }

            #fetchBtn {
                padding: 8px 9px !important;
                font-size: 0.82rem !important;
                gap: 4px !important;
            }

            #fetchBtn i {
                width: 18px !important;
                height: 18px !important;
            }

            .search-section p a,
            .search-section p span {
                font-size: 0.84rem !important;
            }

            .features-intro-title {
                font-size: clamp(1.3rem, 7vw, 1.6rem);
            }

            .features-intro-text {
                font-size: clamp(0.88rem, 4.2vw, 1rem);
            }
        }

        /* ── Everything Section ── */
        .everything-section {
            padding: 4rem 0;
            background: #fff;
            overflow: hidden;
        }

        .everything-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .everything-header h2 {
            font-size: 1.8rem !important;
            font-weight: 800 !important;
            color: #111827 !important;
            margin-bottom: 0.8rem !important;
        }

        .everything-header p {
            font-size: 0.95rem;
            color: #6B7280;
            max-width: 600px;
            margin: 0 auto;
        }

        .everything-container {
            position: relative;
            max-width: 750px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 550px;
        }

        .phone-mockup-center {
            position: relative;
            z-index: 5;
            width: 380px;
        }

        .phone-mockup-center img {
            width: 100%;
            height: auto;
            display: block;
        }

        .callout-box {
            position: absolute;
            width: 220px;
            z-index: 10;
        }

        .callout-box h3 {
            font-size: 1rem;
            font-weight: 800;
            color: #FBBF24;
            /* Figma Yellow */
            margin-bottom: 0.4rem;
        }

        .callout-box p {
            font-size: 0.8rem;
            color: #111827;
            line-height: 1.4;
            font-weight: 600;
        }

        /* Connector Lines */
        .connector-dot {
            width: 8px;
            height: 8px;
            background: #FBBF24;
            border-radius: 50%;
            position: absolute;
        }

        .connector-dot.hollow {
            background: #fff;
            border: 2px solid #FBBF24;
        }

        .line-v {
            position: absolute;
            width: 2px;
            background: #FBBF24;
        }

        .line-h-dashed {
            position: absolute;
            height: 2px;
            border-top: 2px dashed #FBBF24;
        }

        /* Position Callouts */
        .callout-left {
            left: 20px;
            top: 45%;
            transform: translateY(-50%);
            text-align: right;
        }

        .callout-right-top {
            right: 20px;
            top: 15%;
            text-align: left;
        }

        .callout-right-bottom {
            right: 20px;
            bottom: 15%;
            text-align: left;
        }

        /* Everything Section Responsive */
        @media (max-width: 1024px) {
            .everything-container {
                flex-direction: column;
                min-height: auto;
                padding: 2rem 0;
            }

            .callout-box {
                position: relative !important;
                left: auto !important;
                right: auto !important;
                top: auto !important;
                bottom: auto !important;
                transform: none !important;
                max-width: 100% !important;
                margin: 2rem 0;
                text-align: center !important;
                width: 100%;
            }

            .phone-mockup-center {
                order: 1;
                margin: 2rem 0;
            }

            .callout-left {
                order: 0;
            }

            .callout-right-top {
                order: 2;
            }

            .callout-right-bottom {
                order: 3;
            }

            .line-v,
            .line-h-dashed,
            .connector-dot {
                display: none !important;
            }
        }

        /* ── Everything Section Layout ── */
        .everything-section {
            padding: 1.5rem 0;
            background: white;
            position: relative;
            overflow: hidden;
        }

        .everything-section-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .everything-section-header h2 {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.4rem;
        }

        .everything-section-header p {
            font-size: 0.85rem;
            color: var(--text-gray);
            max-width: 550px;
            margin: 0 auto;
            line-height: 1.5;
        }

        .everything-wrapper {
            position: relative;
            max-width: 750px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 420px;
            padding: 1rem 0 50px 0;
            overflow: visible;
        }

        .phone-center {
            position: relative;
            z-index: 2;
        }

        .phone-center img {
            width: 100%;
            max-width: 295px;
            height: auto;
            display: block;
        }

        .callout-top-right {
            position: absolute;
            right: -4px;
            top: 12%;
            max-width: 200px;
        }

        .callout-middle-left {
            position: absolute;
            left: 2px;
            top: 42%;
            max-width: 200px;
        }

        .callout-bottom-right {
            position: absolute;
            right: -69px;
            top: 72%;
            max-width: 260px;
        }

        .callout-inner {
            /* Common styles */
            max-width: 100%;
        }

        .callout-top-right .callout-inner {
            text-align: left;
            margin-top: -8px;
            margin-right: 0;
        }

        .callout-top-right .callout-inner h3 {
            margin-bottom: 0;
        }

        .callout-top-right .callout-inner p {
            margin-top: 2px;
        }

        .callout-middle-left .callout-inner {
            text-align: left;
            margin-top: -53px;
            margin-right: -38px;
        }

        .callout-middle-left .callout-inner h3 {
            margin-bottom: 0;
        }

        .callout-middle-left .callout-inner p {
            margin-top: 2px;
        }

        .callout-bottom-right .callout-inner {
            text-align: left;
            margin-top: -76px;
            margin-right: 0;
        }

        .callout-inner h3 {
            font-size: 0.95rem;
            font-weight: 800;
            color: #FFB800;
            margin-bottom: 0.3rem;
        }

        .callout-inner p {
            font-size: 0.78rem;
            color: #4B5563;
            line-height: 1.4;
            font-weight: 500;
            text-align: justify;
        }

        /* ── How It Works Section (img6) ── */
        .howitworks-section {
            padding: 1.5rem 0 2.5rem;
            background: transparent;
            position: relative;
            overflow: hidden;
        }

        /* Floating BG Icons */
        .hw-bg-icon {
            position: absolute;
            font-size: 5rem;
            opacity: 0.12;
            filter: blur(3px);
            color: #FFB800;
            pointer-events: none;
            z-index: 0;
        }

        .howitworks-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .howitworks-header h2 {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.4rem;
        }

        .howitworks-header p {
            font-size: 0.85rem;
            color: var(--text-gray);
            max-width: 550px;
            margin: 0 auto;
            line-height: 1.5;
        }

        .howitworks-wrapper {
            position: relative;
            max-width: 850px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 460px;
            padding: 1rem 0 60px 0;
            overflow: visible;
        }

        .howitworks-phone {
            position: relative;
            z-index: 2;
            flex-shrink: 0;
        }

        .howitworks-phone img {
            width: 100%;
            max-width: 350px;
            height: auto;
            display: block;
        }

        /* Left callouts */
        .hw-paste-link {
            position: absolute;
            left: 33px;
            top: 15%;
            max-width: 210px;
            text-align: left;
        }

        .hw-format-quality {
            position: absolute;
            left: 42px;
            top: 65%;
            max-width: 210px;
            text-align: left;
        }

        /* Right callout */
        .hw-download-video {
            position: absolute;
            right: 32px;
            top: 19%;
            max-width: 210px;
            text-align: left;
        }

        .hw-callout h3 {
            font-size: 0.95rem;
            font-weight: 800;
            color: #FFB800;
            margin-bottom: 0;
        }

        .hw-callout p {
            font-size: 0.78rem;
            color: #4B5563;
            line-height: 1.4;
            font-weight: 500;
            text-align: left;
            margin-top: 2px;
        }

        .mobile-overview-section {
            display: none;
        }

        @media (max-width: 768px) {

            .everything-section,
            .howitworks-section {
                display: none;
            }

            .mobile-overview-section {
                display: block;
                padding: 1.6rem 0 2rem;
                background: #f3f4f6;
            }

            .mobile-overview-header {
                text-align: center;
                margin-bottom: 0.9rem;
            }

            .mobile-overview-header h2 {
                font-size: 2.1rem !important;
                line-height: 1.12 !important;
                margin-bottom: 0.55rem;
                text-align: center !important;
            }

            .mobile-overview-header p {
                max-width: 340px;
                margin: 0 auto;
                font-size: 0.9rem;
                line-height: 1.4;
                color: #4B5563;
                text-align: center !important;
            }

            .mobile-overview-block {
                margin: 1rem auto 1.3rem;
                max-width: 410px;
                display: grid;
                grid-template-columns: 1fr auto;
                align-items: start;
                column-gap: 0.3rem;
                row-gap: 0.35rem;
            }

            .mobile-overview-phone {
                /* width: 100%; */
                max-width: 228px;
                margin: 0 auto;
                display: block;
                grid-column: 2;
                grid-row: 1 / span 2;
            }

            .mobile-overview-note {
                color: #1f2937;
                font-size: 0.78rem;
                line-height: 1.2;
                max-width: 132px;
            }

            .mobile-overview-note h4 {
                color: #ffb800;
                font-size: 0.84rem !important;
                font-weight: 800;
                margin-bottom: 0.2rem;
                margin-top: 0.5rem;
            }

            .mobile-overview-note p {
                color: #1f2937;
                font-size: 0.55rem;
                line-height: 1.23;
                margin: 0;
            }

            .mobile-overview-note.left-top {
                grid-column: 1;
                grid-row: 1;
                justify-self: end;
                text-align: right;
                padding-right: 0;
            }

            .mobile-overview-note.left-bottom {
                grid-column: 1;
                grid-row: 2;
                align-self: start;
                justify-self: end;
                text-align: right;
                padding-right: 0;
                margin-top: 0.1rem;
            }

            .mobile-overview-note.right-top {
                grid-column: 3;
                grid-row: 1;
                justify-self: start;
                text-align: left;
                padding-left: 0;
            }

            .mobile-overview-note.right-bottom {
                grid-column: 3;
                grid-row: 2;
                align-self: start;
                justify-self: start;
                text-align: left;
                padding-left: 0;
                margin-top: -4.9rem;
            }

            .mobile-overview-note.center-bottom {
                grid-column: 2;
                grid-row: 3;
                margin: 0.15rem auto 0;
                max-width: 200px;
                text-align: center !important;
            }

            .mobile-overview-note.center-bottom h4,
            .mobile-overview-note.center-bottom p {
                text-align: center !important;
            }

            .mobile-overview-divider {
                margin: 0.35rem auto 0.5rem;
                width: 96%;
                border-top: 1px dashed rgba(255, 184, 0, 0.35);
            }
        }

        /* ── SEO Content Section ── */
        #seo-content-wrap,
        #seo-content-wrap * {
            font-family: 'Inter', sans-serif !important;
        }

        /* ── Blog Section ── */
        .blog-section {
            padding: 3rem 0;
            background: #fff;
        }

        .blog-section-inner {
            max-width: 1100px;
        }

        .blog-section-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0F0F0F;
            margin-bottom: 2rem;
            letter-spacing: -0.02em;
            text-align: left !important;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 2.5rem;
            margin-top: 1.5rem;
        }

        .blog-featured {
            display: flex;
            flex-direction: column;
        }

        .featured-img-wrap {
            width: 100%;
            aspect-ratio: 16/9;
            border-radius: 12px;
            overflow: hidden;
            background: #f3f4f6;
            margin-bottom: 1rem;
            border: 1px solid #eee;
        }

        .featured-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .blog-meta-info {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #6B7280;
            margin-bottom: 0.6rem;
            font-weight: 500;
        }

        .blog-featured h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #0F0F0F;
            margin-bottom: 0.6rem;
            line-height: 1.4;
        }

        .blog-featured p {
            font-size: 0.88rem;
            color: #6B7280;
            line-height: 1.5;
        }

        .blog-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .blog-item-sm {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 1.2rem;
            align-items: flex-start;
        }

        .sm-img-wrap {
            width: 160px;
            height: 90px;
            border-radius: 10px;
            overflow: hidden;
            background: #f3f4f6;
            border: 1px solid #eee;
        }

        .sm-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #001f3f;
            /* Matching the dark blue in the image provided */
        }

        .sm-info h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: #0F0F0F;
            line-height: 1.4;
            margin-top: 0.1rem;
        }

        .btn-read-all {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #FFB800;
            color: #000;
            font-weight: 700;
            padding: 0.7rem 2.2rem;
            border-radius: 30px;
            text-decoration: none;
            font-size: 0.85rem;
            box-shadow: 0 4px 15px rgba(255, 184, 0, 0.25);
            align-self: flex-end;
            margin-top: 0.5rem;
            transition: transform 0.2s;
        }

        .btn-read-all:hover {
            transform: translateY(-2px);
        }

        .why-choose-section {
            padding: 3rem 0;
            background: #ffffff;
        }

        .why-choose-container {
            max-width: 1050px;
        }

        .why-choose-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .why-choose-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0F0F0F;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .why-choose-desc {
            font-size: 0.93rem;
            color: #6B7280;
            max-width: 620px;
            margin: 0 auto;
            line-height: 1.75;
            text-align: center !important;
        }

        .why-choose-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.2rem;
        }

        .why-choose-card {
            background: #ffffff;
            border: 1.5px solid #F0F1F3;
            border-radius: 18px;
            padding: 1.5rem 1.8rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .why-choose-icon {
            width: 60px;
            height: 60px;
            background: #FEF3C7;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .why-choose-icon img {
            width: 35px;
            height: 35px;
            object-fit: contain;
        }

        .why-choose-card h3 {
            font-size: 1rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 0.45rem;
            text-align: left !important;
        }

        .why-choose-card p {
            font-size: 0.875rem;
            color: #6B7280;
            line-height: 1.65;
            margin: 0;
            text-align: left !important;
        }

        @media (max-width: 991px) {
            .blog-grid {
                grid-template-columns: 1fr;
            }

            .why-choose-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .why-choose-section {
                padding: 2rem 0;
            }

            .why-choose-header {
                margin-bottom: 1.4rem;
                text-align: left;
            }

            .why-choose-title {
                font-size: 1.35rem;
                margin-bottom: 0.6rem;
            }

            .why-choose-desc {
                max-width: 100%;
                margin: 0;
                font-size: 0.92rem;
                line-height: 1.6;
                text-align: left !important;
            }

            .why-choose-grid {
                grid-template-columns: 1fr;
                gap: 0.95rem;
            }

            .why-choose-card {
                border-radius: 16px;
                padding: 1.25rem 1.2rem;
            }

            .blog-section {
                padding: 2.1rem 0 2.6rem;
                background: #f3f4f6;
            }

            .blog-section-inner {
                max-width: 560px;
            }

            .blog-section-title {
                font-size: 2.85rem;
                line-height: 1.15;
                margin-bottom: 1.2rem;
            }

            .blog-grid {
                margin-top: 0;
                gap: 1rem;
            }

            .blog-featured {
                background: #fff;
                border: 1px solid #E5E7EB;
                border-radius: 18px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
                padding-bottom: 1rem;
            }

            .featured-img-wrap {
                margin-bottom: 0.9rem;
                border-radius: 0;
                border: none;
                aspect-ratio: 16 / 10.5;
            }

            .blog-featured .blog-meta-info,
            .blog-featured h3,
            .blog-featured p {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .blog-featured .blog-meta-info {
                font-size: 0.72rem;
                margin-bottom: 0.5rem;
            }

            .blog-featured h3 {
                font-size: 1.55rem;
                line-height: 1.3;
                margin-bottom: 0.55rem;
            }

            .blog-featured p {
                font-size: 0.82rem;
                line-height: 1.55;
                margin-bottom: 0;
            }

            .blog-sidebar {
                gap: 0;
                align-items: center;
            }

            .blog-item-sm {
                display: none;
            }

            .btn-read-all {
                align-self: center;
                margin-top: 1.35rem;
                min-width: 190px;
                min-height: 56px;
                border-radius: 999px;
                font-size: 0.95rem;
                font-weight: 800;
                color: #fff;
                box-shadow: 0 4px 12px rgba(255, 184, 0, 0.35);
            }
        }

        @media (max-width: 480px) {
            .blog-section-title {
                font-size: 2.1rem;
            }

            .blog-featured h3 {
                font-size: 1.18rem;
            }

            .blog-featured p {
                font-size: 0.72rem;
            }

            .btn-read-all {
                min-width: 230px;
                min-height: 60px;
                font-size: 0.9rem;
            }
        }

        /* ── End Blog Section ── */

        /* ── End How It Works ── */
    </style>
</head>

<body>

    @include('partials.header')

    <section class="hero">
        <picture>
            <source media="(max-width: 768px)" srcset="/images/mobile/Hero-Image.jpg">
            <img class="hero-bg-img" src="/images/hero_section.jpeg" alt="Video Saver Hero">
        </picture>
        <div class="hero-container">
            <div class="hero-content">
                <h1>{!! $settings->hero_heading ?? 'HD Video & Music Downloader for<br>Seamless Downloads' !!}</h1>
                <a href="{{ $settings->hero_button_url ?? '#' }}" class="hero-btn">
                    {{ $settings->hero_button_text ?? 'Download Video Saver' }}
                </a>

                <!-- @if (!empty($settings->hero_description))
<div class="hero-description" style="margin-top:1rem;font-size:0.9rem;color:rgba(255,255,255,0.8);max-width:500px;line-height:1.6;">
                    {!! $settings->hero_description !!}
                </div>
@endif -->

                <div class="trust-row">
                    <div class="trust-item">
                        <img src="/images/security2.png" alt="McAfee"> McAfee
                    </div>
                    <div class="trust-item">
                        <img src="/images/security1.png" alt="CM Security"> CM Security
                    </div>
                    <div class="trust-item">
                        <i class="fas fa-shield-alt trust-lookout-icon" aria-hidden="true"></i> Lookout
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.downloader')
    <!-- Supported Sites Section -->
    @php
        $platforms = json_decode($settings->platforms_data ?? '[]', true) ?: [];
    @endphp
    <section style="padding: 3rem 0 3.5rem; background: #fff; border-top: 1px solid #F3F4F6;">
        <div class="hero-container" style="max-width: 1000px; text-align: center;">

            <h2 style="font-size: 1.6rem; font-weight: 800; color: #111827; margin-bottom: 0.8rem;">
                {{ $settings->sites_heading ?? 'Download Videos from More Supported Sites' }}
            </h2>
            <p style="font-size: 0.92rem; color: #6B7280; max-width: 620px; margin: 0 auto 2.5rem; line-height: 1.7;">
                {{ $settings->sites_description ?? 'Video Saver lets you download content from your favorite platforms.' }}
            </p>

            @if (count($platforms) > 0)
                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem 2.5rem;">
                    @foreach ($platforms as $p)
                        <a href="{{ $p['url'] ?? '#' }}"
                            style="display:flex; flex-direction:column; align-items:center; gap:0.5rem; text-decoration:none; transition:transform 0.2s;"
                            onmouseover="this.style.transform='translateY(-5px)'"
                            onmouseout="this.style.transform='translateY(0)'">
                            <div
                                style="width:75px; height:75px; border-radius:50%; overflow:hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.15); border:2px solid #f0f0f0;">
                                @if (!empty($p['img']))
                                    <img src="{{ $p['img'] }}" alt="{{ $p['name'] }}"
                                        style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <div
                                        style="width:100%;height:100%;background:{{ $p['color'] ?? '#333' }};display:flex;align-items:center;justify-content:center;">
                                        <i class="{{ $p['icon'] ?? 'fas fa-globe' }}"
                                            style="font-size:1.8rem;color:#fff;"></i>
                                    </div>
                                @endif
                            </div>
                            <span style="font-size:0.8rem; font-weight:600; color:#555; text-transform:capitalize;">
                                {{ $p['name'] }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </section>
    <!-- Features Area -->
    <div class="features-container" style="margin-top: 2.5rem; text-align: center;">
        <h2 class="features-intro-title">More Than a Downloader Video
            Saver Does It All</h2>
        <p class="features-intro-text">Video Saver combines powerful features with a seamless experience, making
            downloads faster, smarter, and more flexible no matter what or where you save from.</p>
        <!-- 1. Mobile Features -->
        <div class="feature-item">
            <div class="feature-image-wrap">
                <img src="/images/mobile1.png" alt="Mobile App" class="feature-image">
            </div>
            <div class="feature-content">
                <h2>Experience High-Speed Downloads on Any Device</h2>
                <p>Our downloader is fully optimized for mobile devices. Save your favorite videos in high
                    resolution directly to your phone gallery with just a single tap. Works seamlessly in your
                    browser without any app installation.</p>
                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i> 100% Free & Unlimited</li>
                    <li><i class="fas fa-check-circle"></i> Support for 4K & HD</li>
                    <li><i class="fas fa-check-circle"></i> No Registration Required</li>
                </ul>
            </div>
        </div>

        <!-- 2. Status & Media Saver -->
        <div class="feature-item reverse">
            <div class="feature-image-wrap">
                <img src="/images/mobile4.png" alt="Status Saver" class="feature-image">
            </div>
            <div class="feature-content">
                <h2>Status & Media Saver</h2>
                <h3>Save WhatsApp statuses, Instagram photos, and more before they disappear.</h3>
                <p>Never miss out on your favorite social moments again. Video Saver makes it easy to download
                    and keep status videos, stories, and images directly on your device. Quickly browse, save,
                    and revisit content anytime you want.</p>
            </div>
        </div>

        <!-- 3. Smarter, Faster Downloads -->
        <div class="feature-item">
            <div class="feature-image-wrap">
                <img src="/images/mobile5.png" alt="Fast Downloads" class="feature-image">
            </div>
            <div class="feature-content">
                <h2>Smarter, Faster Downloads</h2>
                <h3>Save high-quality videos and music in just a few taps quick, smooth, and hassle-free.</h3>
                <p>Choose the quality that fits your needs, from standard to ultra-clear formats. With improved
                    performance and optimized speed, Video Saver delivers a faster and more reliable downloading
                    experience.</p>
            </div>
        </div>

        <!-- 4. Video to MP3 Converter -->
        <div class="feature-item reverse">
            <div class="feature-image-wrap">
                <img src="/images/mobile2.png" alt="Video to MP3" class="feature-image">
            </div>
            <div class="feature-content">
                <h2>Video to MP3 Converter</h2>
                <h3>Turn your favorite videos into MP3 and create your own music collection with ease.</h3>
                <p>Video Saver doubles as a powerful audio converter for music lovers. Download tracks, extract
                    audio from videos, and save them in high-quality MP3 format. It’s a fast, smooth, and
                    reliable way to build your personal library.</p>
            </div>
        </div>

        <!-- 5. Endless Wallpaper Collection -->
        <div class="feature-item">
            <div class="feature-image-wrap">
                <img src="/images/mobile3.png" alt="Wallpapers" class="feature-image">
            </div>
            <div class="feature-content">
                <h2>Endless Wallpaper Collection</h2>
                <h3>Browse a vast library of stunning wallpapers and download your favorites with ease.</h3>
                <p>The Video Saver app offers a wide range of categories, including nature, abstract, minimal,
                    and more. Discover fresh designs daily, get personalized recommendations, and save
                    high-quality wallpapers directly to your device.</p>
            </div>
        </div>

    </div>
    </div>
    </section>

    <!-- Everything You Need Section -->
    <section class="everything-section">
        <div class="hero-container">
            <div class="everything-section-header">
                <h2>Everything You Need to Download</h2>
                <p>From videos to audio and more download your content quickly and easily in one place.</p>
            </div>

            <div class="everything-wrapper">

                <!-- BG Floating Icons -->
                <i class="fas fa-photo-video hw-bg-icon" style="top: 5%; left: 2%; font-size: 5.5rem;"></i>
                <i class="fas fa-mobile-alt hw-bg-icon" style="bottom: 15%; left: 6%; font-size: 4rem;"></i>
                <i class="fas fa-wifi hw-bg-icon" style="top: -5%; right: 9%; font-size: 4.5rem;"></i>
                <i class="fas fa-cloud-download-alt hw-bg-icon" style="bottom: 10%; right: 5%; font-size: 5rem;"></i>

                <!-- Mobile Phone Image (Center) -->
                <div class="phone-center">
                    <img src="/images/final1.png" alt="Video Saver App">
                </div>

                <!-- Top Right: Search -->
                <div class="callout-top-right">
                    <div class="callout-inner">
                        <h3>Search</h3>
                        <p>Sub-caption: Discover the latest trends, insights, and useful information now.</p>
                    </div>
                </div>

                <!-- Middle Left: Supported Sites -->
                <div class="callout-middle-left">
                    <div class="callout-inner">
                        <h3>Supported Sites</h3>
                        <p>Stay connected, share moments, and grow your online presence fast.</p>
                    </div>
                </div>

                <!-- Bottom Right: Navigation Bar -->
                <div class="callout-bottom-right">
                    <div class="callout-inner">
                        <h3>Navigation Bar</h3>
                        <p>User can access Home page, Progress page, My File page.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- How It Works Section (img) -->
    <section class="howitworks-section">
        <div class="hero-container">


            <div class="howitworks-wrapper">

                <!-- BG Floating Icons -->
                <i class="fas fa-film hw-bg-icon" style="top: -5%; left: 3%; font-size: 6rem;"></i>
                <i class="fas fa-music hw-bg-icon" style="bottom: 2%; left: 8%; font-size: 4rem;"></i>
                <i class="fas fa-video hw-bg-icon" style="top: 4%; right: 14%; font-size: 5rem;"></i>
                <i class="fas fa-headphones hw-bg-icon" style="bottom: 20%; right: 3%; font-size: 4.5rem;"></i>
                <i class="fas fa-download hw-bg-icon" style="top: 50%; left: 15%; font-size: 3.5rem;"></i>
                <i class="fas fa-compact-disc hw-bg-icon" style="top: 40%; right: 15%; font-size: 4rem;"></i>

                <!-- Center Phone -->
                <div class="howitworks-phone">
                    <img src="/images/final2.png" alt="How Video Saver Works">
                </div>

                <!-- Left Top: Paste Link -->
                <div class="hw-paste-link hw-callout">
                    <h3>Paste Link</h3>
                    <p>Paste your copied link here to fetch the video instantly.</p>
                </div>

                <!-- Left Bottom: Format & Quality -->
                <div class="hw-format-quality hw-callout">
                    <h3>Format &amp; Quality</h3>
                    <p>Click "Download", then choose your format (MP4/MP3) and quality (up to 4K, depending on the
                        source).</p>
                </div>

                <!-- Right Top: Download Video -->
                <div class="hw-download-video hw-callout">
                    <h3>Download Video</h3>
                    <p>Download your favorite videos easily and watch them offline anytime.</p>
                </div>

            </div>
        </div>
    </section>

    <section class="mobile-overview-section">
        <div class="hero-container">
            <div class="mobile-overview-header">
                <h2>Everything You Need to Download</h2>
                <p>From videos to audio and more download your content quickly and easily in one place.</p>
            </div>

            <div class="mobile-overview-block">
                <div class="mobile-overview-note left-top">
                    <h4>Search</h4>
                    <p>Sub-caption: Discover the latest trends, insights, and useful information now.</p>
                </div>
                <img class="mobile-overview-phone" src="/images/mobile/Image%201%20New%20Mobile.png"
                    alt="Everything you need app overview">
                <div class="mobile-overview-note left-bottom">
                    <h4>Supported Sites</h4>
                    <p>Stay connected, share moments and grow your online presence fast.</p>
                </div>
                <div class="mobile-overview-note center-bottom">
                    <h4>Navigation Bar</h4>
                    <p>User can access Home page, Progress page, My File page.</p>
                </div>
            </div>

            <div class="mobile-overview-divider"></div>

            <div class="mobile-overview-block">
                <div class="mobile-overview-note right-bottom">
                    <h4>Paste Link</h4>
                    <p>Paste your copied link here to fetch the video instantly.</p>
                </div>
                <img class="mobile-overview-phone" src="/images/mobile/Image%202%20Mobile%20New.png"
                    alt="How it works app overview">
                <div class="mobile-overview-note right-top">
                    <h4>Download Video</h4>
                    <p>Download your favorite videos easily and watch them offline anytime.</p>
                </div>
                <div class="mobile-overview-note center-bottom">
                    <h4>Format &amp; Quality</h4>
                    <p>Click "Download", then choose your format (MP4/MP3) and quality (up to 4K, depending on the
                        source).</p>
                </div>
            </div>
        </div>
    </section>



    <!-- SEO Content Section -->
    <section style="padding: 2rem 0; background: #fff; border-top: 1px solid #F3F4F6;">
        <div class="hero-container" style="max-width: 900px;">

            {{-- Collapsible content wrapper --}}
            <div id="seo-content-wrap"
                style="position:relative; overflow:hidden; max-height:380px; transition: max-height 0.5s ease; text-align:justify;">

                @if (!empty($settings->hero_description))
                    <div style="font-size: 0.95rem; color: #000000ff; line-height: 1.8;">
                        {!! App\Models\Blog::renderEditorJS($settings->hero_description) !!}
                    </div>
                @else
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #111827; margin-bottom: 0.8rem;">
                        By Platform: Download From Any Social Media
                    </h2>
                    <p style="font-size: 0.95rem; color: #000000ff; line-height: 1.8; margin-bottom: 1.5rem;">
                        If you're looking for a fast, reliable, and completely free video downloader that supports all
                        major
                        platforms — you've found it. Video Saver lets you effortlessly save videos, reels, stories, and
                        audio
                        from YouTube, Instagram, TikTok, Facebook, Twitter, and many more.
                    </p>

                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #111827; margin-bottom: 0.8rem;">
                        High-Quality Downloads: MP4, MP3 & More
                    </h2>
                    <p style="font-size: 0.95rem; color: #4B5563; line-height: 1.8; margin-bottom: 1.5rem;">
                        With Video Saver, you can download content in multiple formats and resolutions — from standard
                        480p
                        to
                        stunning 4K Ultra HD. Whether you need a crisp video file or just the audio track as MP3, our
                        downloader
                        gives you full control over your download quality.
                    </p>

                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #111827; margin-bottom: 0.8rem;">
                        Video Saver: Download for a Diverse Range of Platforms
                    </h2>
                    <p style="font-size: 0.95rem; color: #4B5563; line-height: 1.8; margin-bottom: 2rem;">
                        At Video Saver, we support content from a wide range of platforms. Simply paste the link, choose
                        your
                        format, and your download starts instantly — no sign-up required.
                    </p>
                @endif

            </div>

            {{-- Fade overlay when collapsed --}}
            <div id="seo-fade"
                style="position:relative; height:50px; margin-top:-50px; background:linear-gradient(to bottom, rgba(255,255,255,0), #fff); pointer-events:none;">
            </div>

            {{-- Read More / Read Less button --}}
            <button id="readMoreBtn" onclick="toggleReadMore()" class="hero-btn"
                style="display:inline-block; font-size:0.9rem; padding:12px 28px; border-radius:30px; border:none; cursor:pointer; margin-top:0.5rem;">
                Read More
            </button>

        </div>
    </section>

    <script>
        function toggleReadMore() {
            const wrap = document.getElementById('seo-content-wrap');
            const fade = document.getElementById('seo-fade');
            const btn = document.getElementById('readMoreBtn');
            const isCollapsed = wrap.style.maxHeight !== 'none';
            if (isCollapsed) {
                wrap.style.maxHeight = 'none';
                fade.style.display = 'none';
                btn.textContent = 'Read Less';
            } else {
                wrap.style.maxHeight = '380px';
                fade.style.display = 'block';
                btn.textContent = 'Read More';
            }
        }
    </script>



    <!-- Why Millions Choose Video Saver -->
    <section class="why-choose-section">
        <div class="hero-container why-choose-container">

            <div class="why-choose-header">
                <h2 class="why-choose-title">Why Millions Choose Video Saver</h2>
                <p class="why-choose-desc">
                    Video Saver makes it effortless to download videos, audio, reels, shorts, and photos in just a few
                    clicks. Built for speed, privacy, and a smooth experience, it works seamlessly across both mobile
                    and desktop browsers.
                </p>
            </div>

            <div class="why-choose-grid">

                <!-- Card 1 -->
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <img src="/images/icon-rocket.svg" alt="Instant">
                    </div>
                    <h3>Instant Link Analysis</h3>
                    <p>Paste a
                        link and get results in seconds — often faster than other downloaders.</p>
                </div>

                <!-- Card 2 -->
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <img src="/images/icon-globe.svg" alt="Multilingual">
                    </div>
                    <h3>Multilingual Experience</h3>
                    <p>Use HD
                        Video Downloader in multiple languages, including English, Spanish, Hindi, and more.</p>
                </div>

                <!-- Card 3 -->
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <img src="/images/icon-download.svg" alt="Quality">
                    </div>
                    <h3>Flexible Quality Choices</h3>
                    <p>Pick the
                        quality you want from 144p up to 1080p+ (4K) when available.</p>
                </div>

                <!-- Card 4 -->
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <img src="/images/icon-layers.svg" alt="Platform">
                    </div>
                    <h3>Wide Platform Support</h3>
                    <p>Supports
                        YouTube, TikTok, Instagram, Facebook, and more.</p>
                </div>

                <!-- Card 5 -->
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <img src="/images/icon-settings.svg" alt="Device">
                    </div>
                    <h3>Works on Any Device</h3>
                    <p>Download
                        seamlessly on mobile, tablet, or desktop — no extra apps needed.</p>
                </div>

                <!-- Card 6 -->
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <img src="/images/icon-shield.png" alt="Privacy">
                    </div>
                    <h3>Privacy-First by Design</h3>
                    <p>Your
                        privacy matters. Processing happens locally, with no data storage and reduced security risk.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    @if (isset($faqs) && count($faqs) > 0)
        <section style="padding: 3.5rem 0; background: #ffffff; border-top: 1px solid #F3F4F6;">
            <div class="hero-container" style="max-width: 850px;">

                <div style="text-align:center; margin-bottom: 2.5rem;">
                    <h2
                        style="font-size: 1.8rem; font-weight: 800; color: #0F0F0F; margin-bottom: 0; letter-spacing:-0.02em;">
                        Frequently Asked Questions
                    </h2>
                </div>

                <div id="faqAccordion" style="display:flex;flex-direction:column;gap:0.7rem;">
                    @foreach ($faqs as $faq)
                        <div class="faq-wrap"
                            style="border:1.5px solid #EBEBEB; border-radius:14px; overflow:hidden; background:#fff;">
                            <button onclick="toggleFaq(this)"
                                style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1.1rem 1.4rem;background:transparent;border:none;cursor:pointer;font-family:'Inter',sans-serif;text-align:left;">
                                <span
                                    style="font-size:0.95rem;font-weight:500;color:#111827;">{{ $faq->question }}</span>
                                <span class="faq-icon"
                                    style="font-size:1.3rem;color:#111827;font-weight:300;line-height:1;flex-shrink:0;margin-left:1rem;">+</span>
                            </button>
                            <div class="faq-body"
                                style="max-height:0;overflow:hidden;transition:max-height 0.3s ease;">
                                <p
                                    style="padding:0 1.4rem 1.1rem;font-size:0.9rem;color:#6B7280;line-height:1.7;text-align:justify;margin:0;">
                                    {{ $faq->answer }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

        <script>
            function toggleFaq(btn) {
                const wrap = btn.parentElement;
                const body = wrap.querySelector('.faq-body');
                const icon = btn.querySelector('.faq-icon');
                const isOpen = body.style.maxHeight && body.style.maxHeight !== '0px';

                // Close all
                document.querySelectorAll('.faq-wrap').forEach(w => {
                    w.querySelector('.faq-body').style.maxHeight = '0px';
                    w.querySelector('.faq-icon').textContent = '+';
                    w.style.borderColor = '#EBEBEB';
                });

                if (!isOpen) {
                    body.style.maxHeight = body.scrollHeight + 'px';
                    icon.textContent = '×';
                    wrap.style.borderColor = '#D1D5DB';
                }
            }
        </script>
    @endif

    <!-- Blog Section -->
    @if (isset($blogs) && count($blogs) > 0)
        <section class="blog-section">
            <div class="hero-container blog-section-inner">
                <h2 class="blog-section-title">Latest From Our Blog</h2>

                <div class="blog-grid">
                    <!-- Featured Blog (First one) -->
                    @php $featured = $blogs->first(); @endphp
                    <div class="blog-featured">
                        <a href="{{ $featured->slug }}" style="text-decoration:none;">
                            <div class="featured-img-wrap">
                                <img src="{{ $featured->featured_image ?: 'https://via.placeholder.com/800x450' }}"
                                    alt="{{ $featured->image_alt }}">
                            </div>
                        </a>
                        <div class="blog-meta-info">
                            <span>{{ $featured->author_name ?: 'Admin' }}</span>
                            <span>{{ $featured->created_at->format('M d, Y') }}</span>
                        </div>
                        <a href="{{ $featured->slug }}" style="text-decoration:none;">
                            <h3>{{ $featured->title }}</h3>
                        </a>
                        <p>{{ Str::limit($featured->description, 180) }}</p>
                    </div>

                    <!-- Sidebar Blogs (Next 3) -->
                    <div class="blog-sidebar">
                        @foreach ($blogs->skip(1) as $blog)
                            <div class="blog-item-sm">
                                <a href="{{ $blog->slug }}" class="sm-img-wrap">
                                    <img src="{{ $blog->featured_image ?: 'https://via.placeholder.com/200x200' }}"
                                        alt="{{ $blog->image_alt }}">
                                </a>
                                <div class="sm-info">
                                    <div class="blog-meta-info" style="margin-bottom: 0.3rem;">
                                        <span>{{ $blog->author_name ?: 'Admin' }}</span>
                                        <span>{{ $blog->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <a href="{{ $blog->slug }}" style="text-decoration:none;">
                                        <h4>{{ $blog->title }}</h4>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                        <a href="/blogs" class="btn-read-all">Read All</a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,ar,ur,hi,es,fr',
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>

    <script>
        const input = document.getElementById('videoUrl');
        const fetchBtn = document.getElementById('fetchBtn');
        const loader = document.getElementById('loader');
        const resultsBox = document.getElementById('results');
        const errorDiv = document.getElementById('error');
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        async function fetchVideo(url) {
            if (!url) return;
            loader.style.display = 'block';
            resultsBox.style.display = 'none';
            errorDiv.style.display = 'none';

            try {
                const res = await fetch('/extract', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        url
                    })
                });
                const data = await res.json();
                if (data.error) throw new Error(data.error);
                render(data);
            } catch (e) {
                errorDiv.innerHTML = `Error: ${e.message}`;
                errorDiv.style.display = 'block';
            } finally {
                loader.style.display = 'none';
            }
        }

        fetchBtn.addEventListener('click', () => fetchVideo(input.value.trim()));
        input.addEventListener('keydown', e => {
            if (e.key === 'Enter') fetchVideo(input.value.trim());
        });

        function render(data) {
            document.getElementById('title').textContent = data.title;
            document.getElementById('thumb').src = `/thumbnail-proxy?url=${encodeURIComponent(data.thumbnail)}`;
            document.getElementById('duration').textContent = data.duration || '00:00';

            const vList = document.getElementById('video-list');
            const aList = document.getElementById('audio-list');
            vList.innerHTML = aList.innerHTML = '';

            data.medias.forEach(m => {
                const dlUrl =
                    `/proxy-download?url=${encodeURIComponent(m.url)}&title=${encodeURIComponent(data.title)}&ext=${m.extension}`;
                const row = document.createElement('div');
                row.className = 'format-row';
                row.innerHTML = `
                    <div class="format-badge">${m.extension.toUpperCase()}</div>
                    <div style="font-weight:700; font-size: 0.9rem;">${m.quality}</div>
                    <div style="color:var(--text-gray); font-size:0.85rem; font-weight:600;">${m.size || ''}</div>
                    <a href="${dlUrl}" class="dl-btn">
                        <i class="fas fa-download"></i> Download
                    </a>`;
                (m.type === 'video' ? vList : aList).appendChild(row);
            });
            resultsBox.style.display = 'flex';
        }

        // --- Translation Scripts ---
        function toggleLangMenu() {
            const menu = document.getElementById('lang-menu');
            if (menu) menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
        }

        function changeLanguage(langCode) {
            const select = document.querySelector('.goog-te-combo');

            if (select) {
                select.value = langCode;
                select.dispatchEvent(new Event('change'));

                const langNames = {
                    'en': 'English',
                    'ar': 'Arabic',
                    'ur': 'Urdu',
                    'hi': 'Hindi',
                    'es': 'Spanish',
                    'fr': 'French'
                };
                document.getElementById('current-lang').innerText = langNames[langCode];
            } else {
                console.log("Retrying translation...");
                setTimeout(() => changeLanguage(langCode), 300);
            }

            const menu = document.getElementById('lang-menu');
            if (menu) menu.style.display = 'none';
        }

        window.onclick = function(event) {
            if (!event.target.closest('.lang-dropdown')) {
                const menu = document.getElementById('lang-menu');
                if (menu) menu.style.display = 'none';
            }
        }
        // Auto-Hide Google Translate Banner
        setInterval(function() {
            const banner = document.querySelector('.goog-te-banner-frame');
            if (banner) banner.remove();
            document.body.style.top = '0px';
        }, 500);
    </script>

    @include('partials.footer')


</body>

</html>
