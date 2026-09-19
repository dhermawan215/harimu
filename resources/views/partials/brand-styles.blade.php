<style>
    :root {
        --brand: #8a3b5e;
        --brand-dark: #5c2740;
        --brand-soft: #fbeef2;
        --gold: #c8a04d;
        --cream: #fffaf5;
        --ink: #2c2230;
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: var(--ink);
        background-color: var(--cream);
    }

    h1, h2, h3, h4, .font-serif {
        font-family: 'Playfair Display', serif;
    }

    .text-brand { color: var(--brand); }
    .bg-brand { background-color: var(--brand); }
    .bg-brand-soft { background-color: var(--brand-soft); }
    .bg-brand-dark { background-color: var(--brand-dark); }
    .text-gold { color: var(--gold); }

    .btn-brand {
        background-color: var(--brand);
        border-color: var(--brand);
        color: #fff;
    }
    .btn-brand:hover {
        background-color: var(--brand-dark);
        border-color: var(--brand-dark);
        color: #fff;
    }
    .btn-outline-brand {
        border-color: var(--brand);
        color: var(--brand);
    }
    .btn-outline-brand:hover {
        background-color: var(--brand);
        color: #fff;
    }

    .navbar-brand-name {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: var(--brand) !important;
        letter-spacing: .5px;
    }

    .section-eyebrow {
        letter-spacing: 2px;
        text-transform: uppercase;
        font-size: .75rem;
        font-weight: 600;
        color: var(--gold);
    }

    .icon-circle {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: var(--brand-soft);
        color: var(--brand);
        font-size: 1.5rem;
    }

    .feature-card, .price-card, .testimonial-card, .template-card {
        border: 1px solid rgba(140, 59, 94, .12);
        border-radius: 1rem;
        transition: transform .25s ease, box-shadow .25s ease;
        background: #fff;
    }
    .feature-card:hover, .price-card:hover, .template-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 1.5rem 3rem rgba(140, 59, 94, .12);
    }

    .price-card.popular {
        border: 2px solid var(--brand);
        transform: scale(1.03);
    }

    .step-number {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: var(--brand);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
    }

    .hero-section {
        background: linear-gradient(180deg, var(--brand-soft) 0%, var(--cream) 100%);
        overflow: hidden;
        position: relative;
    }

    .hero-decor {
        position: absolute;
        border-radius: 50%;
        opacity: .5;
    }

    .invite-mockup {
        background: linear-gradient(160deg, var(--brand) 0%, var(--brand-dark) 100%);
        border-radius: 1.75rem;
        padding: 2.5rem 1.75rem;
        color: #fff;
        box-shadow: 0 2rem 4rem rgba(92, 39, 64, .35);
        max-width: 320px;
        margin: 0 auto;
        position: relative;
    }
    .invite-mockup::before {
        content: '';
        position: absolute;
        inset: 14px;
        border: 1px solid rgba(255, 255, 255, .35);
        border-radius: 1.4rem;
        pointer-events: none;
    }
    .invite-mockup .ornament {
        font-size: 1.75rem;
        color: var(--gold);
    }

    .template-thumb {
        height: 190px;
        border-radius: .75rem .75rem 0 0;
    }

    .avatar-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: var(--brand);
        color: #fff;
        font-weight: 600;
    }

    .accordion-button:not(.collapsed) {
        background-color: var(--brand-soft);
        color: var(--brand-dark);
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(140, 59, 94, .25);
    }

    .cta-banner {
        background: radial-gradient(circle at top left, var(--brand-dark), var(--brand));
    }

    .footer-dark {
        background-color: var(--ink);
    }

    .auth-page {
        min-height: 100vh;
        background: linear-gradient(180deg, var(--brand-soft) 0%, var(--cream) 100%);
        display: flex;
        align-items: center;
    }
    .auth-card {
        border-radius: 1.5rem;
        border: 1px solid rgba(140, 59, 94, .12);
        box-shadow: 0 1.5rem 3rem rgba(140, 59, 94, .12);
    }
    .form-control:focus, .form-check-input:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 .2rem rgba(138, 59, 94, .15);
    }
    .form-check-input:checked {
        background-color: var(--brand);
        border-color: var(--brand);
    }
</style>
