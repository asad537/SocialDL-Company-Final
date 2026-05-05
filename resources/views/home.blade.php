<!DOCTYPE html>
<html lang="en">

<head>
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
            background-color: #fdf2f2;
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
                padding: 0.8rem 0;
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
                padding: 7rem 0 250px 0;
                min-height: 500px;
            }

            .hero h1 {
                font-size: 1.5rem;
            }

            .hero-btn {
                font-size: 1rem;
                padding: 14px 28px;
            }
        }

        @media (max-width: 480px) {
            .logo img {
                height: 40px;
            }

            .hero {
                padding: 6rem 0 200px 0;
                min-height: 450px;
            }

            .hero h1 {
                font-size: 1.3rem;
            }

            .trust-row {
                gap: 1rem;
            }

            .trust-item {
                font-size: 0.85rem;
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
            max-width: 260px;
            height: auto;
            display: block;
        }

        .callout-top-right {
            position: absolute;
            right: 40px;
            top: 12%;
            max-width: 200px;
        }

        .callout-middle-left {
            position: absolute;
            left: 40px;
            top: 42%;
            max-width: 200px;
        }

        .callout-bottom-right {
            position: absolute;
            right: -20px;
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

        /* ── SEO Content Section ── */
        #seo-content-wrap, #seo-content-wrap * {
            font-family: 'Inter', sans-serif !important;
        }
        
        /* ── Blog Section ── */
        .blog-section {
            padding: 3rem 0;
            background: #fff;
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

        @media (max-width: 991px) {
            .blog-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── End Blog Section ── */

        /* ── End How It Works ── */
    </style>
</head>

<body>

    @include('partials.header')

    <section class="hero">
        <img class="hero-bg-img" src="/images/hero_section.jpeg" alt="">
        <div class="hero-container">
            <div class="hero-content">
                <h1>{!! $settings->hero_heading ?? 'HD Video & Music Downloader for<br>Seamless Downloads' !!}</h1>
                <a href="{{ $settings->hero_button_url ?? '#' }}" class="hero-btn">
                    {{ $settings->hero_button_text ?? 'Download Video Saver' }}
                </a>

                <!-- @if(!empty($settings->hero_description))
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
                        <img src="/images/security2.png" alt="Lookout"> Lookout
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="search-section" style="padding: 3rem 0;">
        <div class="hero-container">
            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.2rem;">Paste Your Link & Download Instantly
            </h2>
            <div class="search-box-wrap" style="max-width: 650px; margin: 0 auto;">
                <div class="search-container" id="searchBox"
                    style="border-radius: 12px; padding: 5px; border: 2px solid var(--primary);">
                    <i class="fas fa-globe" style="font-size: 1.1rem; margin-left: 0.8rem; color: #9CA3AF;"></i>
                    <input type="text" id="videoUrl" placeholder="Paste your link here" autocomplete="off"
                        spellcheck="false" style="font-size: 0.95rem; padding: 0.6rem 0.8rem;">
                    <button id="fetchBtn"
                        style="border-radius: 10px; padding: 8px 22px; font-size: 0.9rem; font-weight: 600;">
                        <i class="fas fa-arrow-down"
                            style="background: none; border: 1.5px solid #000; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.65rem;"></i>
                        Download
                    </button>
                </div>
            </div>
            <p style="margin-top: 0.8rem; text-align: center; font-size: 0.85rem;">
                <a href="#"
                    style="color: #007BFF; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                    <i class="fab fa-youtube" style="color: #FF0000; font-size: 1.1rem;"></i> How to download?
                </a>
                <span style="color: #6B7280; margin-left: 6px;">Watch the tutorial</span>
            </p>

            <!-- Moved Results, Loader, and Error inside the flow -->
            <div class="loader-box" id="loader" style="margin-top: 2rem;">
                <div class="spinner"></div>
                <p>Connecting to platform...</p>
            </div>

            <div class="skeleton-wrapper" id="skeleton" style="margin-top: 2rem;"></div>

            <div id="error" style="margin-top: 2rem;"></div>

            <div class="results-wrapper" id="results"
                style="margin-top: 2rem; background: #f9fafb; border-radius: 20px; padding: 20px;">
                <aside class="sidebar">
                    <div class="thumb-box"><img id="thumb" src="" alt="thumbnail"></div>
                    <h2 class="video-title" id="title">Video Title</h2>
                    <div class="duration-badge">
                        <i class="far fa-clock"></i> <span id="duration">00:00</span>
                    </div>
                </aside>

                <main class="main-content" style="background: transparent;">
                    <div class="section-header">
                        <i class="fas fa-film" style="color: var(--primary);"></i> Video
                    </div>
                    <div id="video-list"></div>
                    <div class="section-header" style="margin-top:20px;">
                        <i class="fas fa-music" style="color: var(--primary);"></i> Music
                    </div>
                    <div id="audio-list"></div>
                </main>
            </div>

            <!-- Features Area -->
            <div class="features-container" style="margin-top: 2.5rem; text-align: center;">
                <h2 style="font-size: 1.4rem; font-weight: 700; margin-bottom: 1.5rem;">More Than a Downloader Video
                    Saver Does It All</h2>

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
                <i class="fas fa-wifi hw-bg-icon" style="top: 10%; right: 4%; font-size: 4.5rem;"></i>
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
                <i class="fas fa-film hw-bg-icon" style="top: 5%; left: 3%; font-size: 6rem;"></i>
                <i class="fas fa-music hw-bg-icon" style="bottom: 10%; left: 8%; font-size: 4rem;"></i>
                <i class="fas fa-video hw-bg-icon" style="top: 15%; right: 5%; font-size: 5rem;"></i>
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



    <!-- SEO Content Section -->
    <section style="padding: 2rem 0; background: #fff; border-top: 1px solid #F3F4F6;">
        <div class="hero-container" style="max-width: 900px;">

            {{-- Collapsible content wrapper --}}
            <div id="seo-content-wrap"
                style="position:relative; overflow:hidden; max-height:380px; transition: max-height 0.5s ease; text-align:justify;">

                @if(!empty($settings->hero_description))
                    <div style="font-size: 0.95rem; color: #000000ff; line-height: 1.8;">
                        {!! App\Models\Blog::renderEditorJS($settings->hero_description) !!}
                    </div>
                @else
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #111827; margin-bottom: 0.8rem;">
                        By Platform: Download From Any Social Media
                    </h2>
                    <p style="font-size: 0.95rem; color: #000000ff; line-height: 1.8; margin-bottom: 1.5rem;">
                        If you're looking for a fast, reliable, and completely free video downloader that supports all major
                        platforms — you've found it. Video Saver lets you effortlessly save videos, reels, stories, and
                        audio
                        from YouTube, Instagram, TikTok, Facebook, Twitter, and many more.
                    </p>

                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #111827; margin-bottom: 0.8rem;">
                        High-Quality Downloads: MP4, MP3 & More
                    </h2>
                    <p style="font-size: 0.95rem; color: #4B5563; line-height: 1.8; margin-bottom: 1.5rem;">
                        With Video Saver, you can download content in multiple formats and resolutions — from standard 480p
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

            @if(count($platforms) > 0)
                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem 2.5rem;">
                    @foreach($platforms as $p)
                        <a href="{{ $p['url'] ?? '#' }}"
                            style="display:flex; flex-direction:column; align-items:center; gap:0.5rem; text-decoration:none; transition:transform 0.2s;"
                            onmouseover="this.style.transform='translateY(-5px)'"
                            onmouseout="this.style.transform='translateY(0)'">
                            <div
                                style="width:75px; height:75px; border-radius:50%; overflow:hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.15); border:2px solid #f0f0f0;">
                                @if(!empty($p['img']))
                                    <img src="{{ $p['img'] }}" alt="{{ $p['name'] }}"
                                        style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <div
                                        style="width:100%;height:100%;background:{{ $p['color'] ?? '#333' }};display:flex;align-items:center;justify-content:center;">
                                        <i class="{{ $p['icon'] ?? 'fas fa-globe' }}" style="font-size:1.8rem;color:#fff;"></i>
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

    <!-- Why Millions Choose Video Saver -->
    <section style="padding: 3rem 0; background: #ffffff;">
        <div class="hero-container" style="max-width: 1050px;">

            <div style="text-align:center; margin-bottom: 2.5rem;">
                <h2
                    style="font-size: 1.8rem; font-weight: 800; color: #0F0F0F; margin-bottom: 0.75rem; letter-spacing:-0.02em;">
                    Why Millions Choose Video Saver
                </h2>
                <p style="font-size: 0.93rem; color: #6B7280; max-width: 620px; margin: 0 auto; line-height: 1.75;">
                    Video Saver makes it effortless to download videos, audio, reels, shorts, and photos in just a few
                    clicks. Built for speed, privacy, and a smooth experience, it works seamlessly across both mobile
                    and desktop browsers.
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem;">

                <!-- Card 1 -->
                <div
                    style="background:#ffffff; border:1.5px solid #F0F1F3; border-radius:18px; padding:1.5rem 1.8rem; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
                    <div
                        style="width:60px;height:60px;background:#FEF3C7;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                        <img src="/images/icon-rocket.svg" alt="Instant"
                            style="width:35px;height:35px;object-fit:contain;">
                    </div>
                    <h3 style="font-size:1rem;font-weight:800;color:#0F172A;margin-bottom:0.45rem;">Instant Link
                        Analysis</h3>
                    <p style="font-size:0.875rem;color:#6B7280;line-height:1.65;margin:0;text-align:justify;">Paste a
                        link and get results in seconds — often faster than other downloaders.</p>
                </div>

                <!-- Card 2 -->
                <div
                    style="background:#ffffff; border:1.5px solid #F0F1F3; border-radius:18px; padding:1.5rem 1.8rem; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
                    <div
                        style="width:60px;height:60px;background:#FEF3C7;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                        <img src="/images/icon-globe.svg" alt="Multilingual"
                            style="width:35px;height:35px;object-fit:contain;">
                    </div>
                    <h3 style="font-size:1rem;font-weight:800;color:#0F172A;margin-bottom:0.45rem;">Multilingual
                        Experience</h3>
                    <p style="font-size:0.875rem;color:#6B7280;line-height:1.65;margin:0;text-align:justify;">Use HD
                        Video Downloader in multiple languages, including English, Spanish, Hindi, and more.</p>
                </div>

                <!-- Card 3 -->
                <div
                    style="background:#ffffff; border:1.5px solid #F0F1F3; border-radius:18px; padding:1.5rem 1.8rem; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
                    <div
                        style="width:60px;height:60px;background:#FEF3C7;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                        <img src="/images/icon-download.svg" alt="Quality"
                            style="width:35px;height:35px;object-fit:contain;">
                    </div>
                    <h3 style="font-size:1rem;font-weight:800;color:#0F172A;margin-bottom:0.45rem;">Flexible Quality
                        Choices</h3>
                    <p style="font-size:0.875rem;color:#6B7280;line-height:1.65;margin:0;text-align:justify;">Pick the
                        quality you want from 144p up to 1080p+ (4K) when available.</p>
                </div>

                <!-- Card 4 -->
                <div
                    style="background:#ffffff; border:1.5px solid #F0F1F3; border-radius:18px; padding:1.5rem 1.8rem; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
                    <div
                        style="width:60px;height:60px;background:#FEF3C7;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                        <img src="/images/icon-layers.svg" alt="Platform"
                            style="width:35px;height:35px;object-fit:contain;">
                    </div>
                    <h3 style="font-size:1rem;font-weight:800;color:#0F172A;margin-bottom:0.45rem;">Wide Platform
                        Support</h3>
                    <p style="font-size:0.875rem;color:#6B7280;line-height:1.65;margin:0;text-align:justify;">Supports
                        YouTube, TikTok, Instagram, Facebook, and more.</p>
                </div>

                <!-- Card 5 -->
                <div
                    style="background:#ffffff; border:1.5px solid #F0F1F3; border-radius:18px; padding:1.5rem 1.8rem; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
                    <div
                        style="width:60px;height:60px;background:#FEF3C7;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                        <img src="/images/icon-settings.svg" alt="Device"
                            style="width:35px;height:35px;object-fit:contain;">
                    </div>
                    <h3 style="font-size:1rem;font-weight:800;color:#0F172A;margin-bottom:0.45rem;">Works on Any Device
                    </h3>
                    <p style="font-size:0.875rem;color:#6B7280;line-height:1.65;margin:0;text-align:justify;">Download
                        seamlessly on mobile, tablet, or desktop — no extra apps needed.</p>
                </div>

                <!-- Card 6 -->
                <div
                    style="background:#ffffff; border:1.5px solid #F0F1F3; border-radius:18px; padding:1.5rem 1.8rem; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
                    <div
                        style="width:60px;height:60px;background:#FEF3C7;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                        <img src="/images/icon-shield.png" alt="Privacy"
                            style="width:35px;height:35px;object-fit:contain;">
                    </div>
                    <h3 style="font-size:1rem;font-weight:800;color:#0F172A;margin-bottom:0.45rem;">Privacy-First by
                        Design</h3>
                    <p style="font-size:0.875rem;color:#6B7280;line-height:1.65;margin:0;text-align:justify;">Your
                        privacy matters. Processing happens locally, with no data storage and reduced security risk.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    @if(isset($faqs) && count($faqs) > 0)
        <section style="padding: 3.5rem 0; background: #ffffff; border-top: 1px solid #F3F4F6;">
            <div class="hero-container" style="max-width: 850px;">

                <div style="text-align:center; margin-bottom: 2.5rem;">
                    <h2
                        style="font-size: 1.8rem; font-weight: 800; color: #0F0F0F; margin-bottom: 0; letter-spacing:-0.02em;">
                        Frequently Asked Questions
                    </h2>
                </div>

                <div id="faqAccordion" style="display:flex;flex-direction:column;gap:0.7rem;">
                    @foreach($faqs as $faq)
                        <div class="faq-wrap"
                            style="border:1.5px solid #EBEBEB; border-radius:14px; overflow:hidden; background:#fff;">
                            <button onclick="toggleFaq(this)"
                                style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1.1rem 1.4rem;background:transparent;border:none;cursor:pointer;font-family:'Inter',sans-serif;text-align:left;">
                                <span style="font-size:0.95rem;font-weight:500;color:#111827;">{{ $faq->question }}</span>
                                <span class="faq-icon"
                                    style="font-size:1.3rem;color:#111827;font-weight:300;line-height:1;flex-shrink:0;margin-left:1rem;">+</span>
                            </button>
                            <div class="faq-body" style="max-height:0;overflow:hidden;transition:max-height 0.3s ease;">
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
    @if(isset($blogs) && count($blogs) > 0)
        <section class="blog-section">
            <div class="hero-container" style="max-width: 1100px;">
                <h2
                    style="font-size: 1.8rem; font-weight: 800; color: #0F0F0F; margin-bottom: 2rem; letter-spacing:-0.02em;">
                    Latest From Our Blog
                </h2>

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
                        @foreach($blogs->skip(1) as $blog)
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
    <script type="text/javascript"
        src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
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

        window.onclick = function (event) {
            if (!event.target.closest('.lang-dropdown')) {
                const menu = document.getElementById('lang-menu');
                if (menu) menu.style.display = 'none';
            }
        }
        // Auto-Hide Google Translate Banner
        setInterval(function () {
            const banner = document.querySelector('.goog-te-banner-frame');
            if (banner) banner.remove();
            document.body.style.top = '0px';
        }, 500);
    </script>

    @include('partials.footer')


</body>

</html>