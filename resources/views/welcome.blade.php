<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @fonts

        <style>
            :root {
                --bg: #f6f7fb;
                --surface: rgba(255, 255, 255, 0.7);
                --surface-solid: #ffffff;
                --text: #14151a;
                --text-muted: #5b5d6b;
                --border: rgba(20, 21, 26, 0.08);
                --accent-a: #6d5efc;
                --accent-b: #ff5da2;
                --accent-c: #37d0ff;
                --shadow: 0 10px 30px rgba(20, 21, 26, 0.08);
            }

            @media (prefers-color-scheme: dark) {
                :root {
                    --bg: #0a0a0f;
                    --surface: rgba(255, 255, 255, 0.05);
                    --surface-solid: #15151d;
                    --text: #f2f2f7;
                    --text-muted: #9a9ba8;
                    --border: rgba(255, 255, 255, 0.08);
                    --shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
                }
            }

            * { box-sizing: border-box; }

            html { scroll-behavior: smooth; }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                background: var(--bg);
                color: var(--text);
                overflow-x: hidden;
                -webkit-font-smoothing: antialiased;
            }

            /* Animated gradient mesh background */
            .bg-blobs {
                position: fixed;
                inset: 0;
                z-index: 0;
                overflow: hidden;
                pointer-events: none;
            }

            .blob {
                position: absolute;
                border-radius: 50%;
                filter: blur(70px);
                opacity: 0.45;
                will-change: transform;
            }

            .blob-1 {
                width: 42vw; height: 42vw;
                top: -10%; left: -10%;
                background: radial-gradient(circle, var(--accent-a), transparent 70%);
                animation: float1 22s ease-in-out infinite;
            }
            .blob-2 {
                width: 38vw; height: 38vw;
                top: 30%; right: -12%;
                background: radial-gradient(circle, var(--accent-c), transparent 70%);
                animation: float2 26s ease-in-out infinite;
            }
            .blob-3 {
                width: 34vw; height: 34vw;
                bottom: -15%; left: 20%;
                background: radial-gradient(circle, var(--accent-b), transparent 70%);
                animation: float3 20s ease-in-out infinite;
            }

            @keyframes float1 {
                0%, 100% { transform: translate(0, 0) scale(1); }
                50% { transform: translate(8vw, 6vh) scale(1.15); }
            }
            @keyframes float2 {
                0%, 100% { transform: translate(0, 0) scale(1); }
                50% { transform: translate(-6vw, 8vh) scale(1.1); }
            }
            @keyframes float3 {
                0%, 100% { transform: translate(0, 0) scale(1); }
                50% { transform: translate(5vw, -7vh) scale(1.2); }
            }

            /* Cursor glow */
            .cursor-glow {
                position: fixed;
                width: 420px;
                height: 420px;
                border-radius: 50%;
                pointer-events: none;
                z-index: 1;
                background: radial-gradient(circle, rgba(109, 94, 252, 0.12), transparent 70%);
                transform: translate(-50%, -50%);
                transition: opacity 0.3s ease;
                opacity: 0;
            }

            @media (hover: hover) {
                .cursor-glow.active { opacity: 1; }
            }

            .wrap {
                position: relative;
                z-index: 2;
                max-width: 1100px;
                margin: 0 auto;
                padding: 1.5rem 1.5rem 4rem;
            }

            header.site-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1rem 0 3rem;
            }

            .brand {
                display: flex;
                align-items: center;
                gap: 0.6rem;
                font-weight: 600;
                font-size: 1.05rem;
                letter-spacing: -0.01em;
            }

            .brand-mark {
                width: 34px;
                height: 34px;
                border-radius: 10px;
                background: linear-gradient(135deg, var(--accent-a), var(--accent-b));
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-weight: 700;
                box-shadow: var(--shadow);
            }

            nav.actions {
                display: flex;
                align-items: center;
                gap: 0.6rem;
            }

            .btn {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                padding: 0.55rem 1.1rem;
                border-radius: 999px;
                font-size: 0.875rem;
                font-weight: 500;
                text-decoration: none;
                border: 1px solid var(--border);
                color: var(--text);
                background: var(--surface);
                backdrop-filter: blur(10px);
                transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: var(--shadow);
                border-color: transparent;
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--accent-a), var(--accent-b));
                color: #fff;
                border: none;
            }

            /* Hero */
            .hero {
                text-align: center;
                padding: 3rem 0 4rem;
                opacity: 0;
                transform: translateY(16px);
                animation: rise 0.9s ease forwards 0.1s;
            }

            @keyframes rise {
                to { opacity: 1; transform: translateY(0); }
            }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.35rem 0.9rem;
                border-radius: 999px;
                border: 1px solid var(--border);
                background: var(--surface);
                font-size: 0.8rem;
                color: var(--text-muted);
                margin-bottom: 1.5rem;
            }

            .eyebrow .dot {
                width: 7px; height: 7px; border-radius: 50%;
                background: #34d399;
                box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.25);
            }

            h1.headline {
                font-size: clamp(2.4rem, 6vw, 4.2rem);
                line-height: 1.05;
                margin: 0 0 1.1rem;
                letter-spacing: -0.03em;
                font-weight: 700;
            }

            .gradient-text {
                background: linear-gradient(120deg, var(--accent-a), var(--accent-b) 45%, var(--accent-c));
                background-size: 200% auto;
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
                animation: shine 6s linear infinite;
            }

            @keyframes shine {
                to { background-position: 200% center; }
            }

            #typed-line {
                min-height: 1.6em;
                font-size: clamp(1rem, 2.2vw, 1.25rem);
                color: var(--text-muted);
                max-width: 640px;
                margin: 0 auto 2.2rem;
            }

            #typed-line .cursor {
                display: inline-block;
                width: 2px;
                background: var(--accent-a);
                margin-left: 2px;
                animation: blink 0.9s step-end infinite;
            }

            @keyframes blink {
                50% { opacity: 0; }
            }

            .hero-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 0.75rem;
                justify-content: center;
            }

            /* Cards grid */
            .grid-section {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 1.1rem;
                margin-top: 1rem;
            }

            .card {
                position: relative;
                border-radius: 18px;
                border: 1px solid var(--border);
                background: var(--surface);
                backdrop-filter: blur(12px);
                padding: 1.6rem;
                text-decoration: none;
                color: var(--text);
                overflow: hidden;
                opacity: 0;
                transform: translateY(24px);
                transition: transform 0.35s cubic-bezier(.2,.8,.2,1), box-shadow 0.35s ease, border-color 0.35s ease;
            }

            .card.in-view {
                animation: rise 0.7s ease forwards;
            }

            .card:hover {
                box-shadow: var(--shadow);
                border-color: transparent;
            }

            .card .icon {
                width: 42px;
                height: 42px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
                background: linear-gradient(135deg, var(--accent-a), var(--accent-c));
                color: #fff;
                font-size: 1.1rem;
            }

            .card h3 {
                margin: 0 0 0.4rem;
                font-size: 1.05rem;
                letter-spacing: -0.01em;
            }

            .card p {
                margin: 0;
                font-size: 0.9rem;
                color: var(--text-muted);
                line-height: 1.5;
            }

            .card .arrow {
                position: absolute;
                top: 1.5rem;
                right: 1.5rem;
                opacity: 0;
                transform: translate(-4px, 4px);
                transition: all 0.25s ease;
                color: var(--text-muted);
            }

            .card:hover .arrow {
                opacity: 1;
                transform: translate(0, 0);
            }

            footer.site-footer {
                text-align: center;
                margin-top: 3.5rem;
                color: var(--text-muted);
                font-size: 0.85rem;
            }

            footer.site-footer a {
                color: inherit;
                font-weight: 500;
                text-decoration: underline;
                text-underline-offset: 3px;
                text-decoration-color: var(--border);
            }

            footer.site-footer a:hover {
                color: var(--accent-a);
            }

            @media (prefers-reduced-motion: reduce) {
                .blob, .hero, .card, .gradient-text, #typed-line .cursor {
                    animation: none !important;
                }
            }
        </style>
    </head>
    <body>
        <div class="bg-blobs" aria-hidden="true">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
        </div>
        <div class="cursor-glow" id="cursorGlow"></div>

        <div class="wrap">
            <header class="site-header">
                <div class="brand">
                    <span class="brand-mark">{{ strtoupper(substr(config('app.name', 'Laravel'), 0, 1)) }}</span>
                    <span>{{ config('app.name', 'Laravel') }}</span>
                </div>

                @if (Route::has('login'))
                    <nav class="actions">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <section class="hero">
                <span class="eyebrow"><span class="dot"></span> Laravel v{{ app()->version() }} &middot; up and running</span>
                <h1 class="headline">Let's build something<br><span class="gradient-text">beautiful</span> together.</h1>
                <p id="typed-line"></p>
                <div class="hero-actions">
                    <a href="https://laravel.com/docs" target="_blank" rel="noopener" class="btn btn-primary">Read the docs</a>
                    <a href="https://laracasts.com" target="_blank" rel="noopener" class="btn">Watch Laracasts</a>
                    <a href="https://cloud.laravel.com" target="_blank" rel="noopener" class="btn">Deploy now</a>
                </div>
            </section>

            <section class="grid-section" id="cards">
                <a href="https://laravel.com/docs" target="_blank" rel="noopener" class="card">
                    <span class="arrow">&#8599;</span>
                    <span class="icon">&#128218;</span>
                    <h3>Documentation</h3>
                    <p>Everything you need to know about routing, Eloquent, testing and deploying your app.</p>
                </a>
                <a href="https://laracasts.com" target="_blank" rel="noopener" class="card">
                    <span class="arrow">&#8599;</span>
                    <span class="icon">&#127909;</span>
                    <h3>Laracasts</h3>
                    <p>Hundreds of video tutorials covering Laravel, PHP and modern frontend tooling.</p>
                </a>
                <a href="https://cloud.laravel.com" target="_blank" rel="noopener" class="card">
                    <span class="arrow">&#8599;</span>
                    <span class="icon">&#9889;</span>
                    <h3>Deploy</h3>
                    <p>Ship your app to production in minutes with Laravel Cloud.</p>
                </a>
                <a href="https://github.com/laravel/framework/blob/13.x/CHANGELOG.md" target="_blank" rel="noopener" class="card">
                    <span class="arrow">&#8599;</span>
                    <span class="icon">&#128220;</span>
                    <h3>Changelog</h3>
                    <p>See what's new in Laravel v{{ app()->version() }} and every release before it.</p>
                </a>
            </section>

            <footer class="site-footer">
                Powered by Laravel v{{ app()->version() }} &mdash;
                <a href="https://github.com/laravel/framework/blob/13.x/CHANGELOG.md" target="_blank" rel="noopener">View changelog</a>
            </footer>
        </div>

        <script>
            // Typing effect for the hero subtitle
            (function () {
                var el = document.getElementById('typed-line');
                var messages = [
                    'A fresh Laravel app, ready for your next idea.',
                    'Fast, elegant, and built to scale.',
                    'Start coding — the rest is already set up.'
                ];
                var mIndex = 0, cIndex = 0, deleting = false;
                var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                if (reduceMotion) {
                    el.textContent = messages[0];
                } else {
                    var cursor = document.createElement('span');
                    cursor.className = 'cursor';
                    cursor.innerHTML = '&nbsp;';

                    function tick() {
                        var full = messages[mIndex];
                        cIndex += deleting ? -1 : 1;
                        el.textContent = full.slice(0, cIndex);
                        el.appendChild(cursor);

                        var delay = deleting ? 30 : 55;

                        if (!deleting && cIndex === full.length) {
                            deleting = true;
                            delay = 1400;
                        } else if (deleting && cIndex === 0) {
                            deleting = false;
                            mIndex = (mIndex + 1) % messages.length;
                            delay = 300;
                        }

                        setTimeout(tick, delay);
                    }
                    tick();
                }
            })();

            // Scroll reveal for cards
            (function () {
                var cards = document.querySelectorAll('#cards .card');
                if (!('IntersectionObserver' in window)) {
                    cards.forEach(function (c) { c.style.opacity = 1; c.style.transform = 'none'; });
                    return;
                }
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry, i) {
                        if (entry.isIntersecting) {
                            var idx = Array.prototype.indexOf.call(cards, entry.target);
                            entry.target.style.animationDelay = (idx * 90) + 'ms';
                            entry.target.classList.add('in-view');
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.15 });
                cards.forEach(function (c) { io.observe(c); });
            })();

            // Cursor glow that follows the pointer
            (function () {
                var glow = document.getElementById('cursorGlow');
                if (!window.matchMedia('(hover: hover)').matches) return;
                var raf = null;
                window.addEventListener('mousemove', function (e) {
                    glow.classList.add('active');
                    if (raf) cancelAnimationFrame(raf);
                    raf = requestAnimationFrame(function () {
                        glow.style.left = e.clientX + 'px';
                        glow.style.top = e.clientY + 'px';
                    });
                });
                window.addEventListener('mouseleave', function () {
                    glow.classList.remove('active');
                });
            })();

            // Subtle tilt on card hover
            (function () {
                if (!window.matchMedia('(hover: hover)').matches) return;
                document.querySelectorAll('#cards .card').forEach(function (card) {
                    card.addEventListener('mousemove', function (e) {
                        var r = card.getBoundingClientRect();
                        var x = (e.clientX - r.left) / r.width - 0.5;
                        var y = (e.clientY - r.top) / r.height - 0.5;
                        card.style.transform = 'perspective(600px) rotateX(' + (-y * 6) + 'deg) rotateY(' + (x * 6) + 'deg) translateY(-2px)';
                    });
                    card.addEventListener('mouseleave', function () {
                        card.style.transform = '';
                    });
                });
            })();
        </script>
    </body>
</html>
