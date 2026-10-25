<style>
  .policy-wrap {
    background:
      radial-gradient(circle at top right, rgba(0, 128, 128, 0.08), transparent 28%),
      linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
  }

  .policy-hero {
    background: linear-gradient(135deg, #011f4b 0%, #01356f 55%, #008080 100%);
    color: #fff;
    padding: 72px 20px 56px;
  }

  .policy-hero-inner,
  .policy-content {
    max-width: 960px;
    margin: 0 auto;
  }

  .policy-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.18);
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
  }

  .policy-pill-dot {
    width: 8px;
    height: 8px;
    border-radius: 999px;
    background: #ffb380;
  }

  .policy-hero h1 {
    margin: 18px 0 14px;
    font-size: clamp(34px, 6vw, 56px);
    line-height: 1.08;
    font-weight: 700;
  }

  .policy-hero p {
    max-width: 700px;
    margin: 0;
    color: rgba(255, 255, 255, 0.82);
    font-size: 16px;
    line-height: 1.8;
  }

  .policy-meta {
    margin-top: 22px;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.74);
  }

  .policy-body {
    padding: 48px 20px 88px;
  }

  .policy-card {
    background: #fff;
    border: 1px solid rgba(1, 31, 75, 0.08);
    border-radius: 24px;
    padding: 32px 26px;
    box-shadow: 0 18px 50px rgba(1, 31, 75, 0.08);
  }

  .policy-lead {
    font-size: 16px;
    line-height: 1.8;
    color: #475569;
    margin: 0 0 20px;
  }

  .policy-note {
    margin: 0 0 28px;
    padding: 16px 18px;
    border-left: 4px solid #ff5c00;
    border-radius: 12px;
    background: #fff7ed;
    color: #7c2d12;
    font-size: 14px;
    line-height: 1.7;
  }

  .policy-section + .policy-section {
    margin-top: 28px;
    padding-top: 28px;
    border-top: 1px solid rgba(1, 31, 75, 0.08);
  }

  .policy-section h2 {
    margin: 0 0 12px;
    color: #011f4b;
    font-size: 24px;
    line-height: 1.3;
  }

  .policy-section p,
  .policy-section li {
    color: #475569;
    font-size: 15px;
    line-height: 1.8;
  }

  .policy-section ul {
    margin: 14px 0 0;
    padding-left: 22px;
  }

  .policy-section a {
    color: #008080;
    text-decoration: none;
    font-weight: 600;
  }

  .policy-section a:hover {
    text-decoration: underline;
  }

  .policy-cta {
    margin-top: 32px;
    padding: 22px;
    border-radius: 18px;
    background: linear-gradient(135deg, rgba(1, 31, 75, 0.06), rgba(0, 128, 128, 0.08));
    border: 1px solid rgba(1, 31, 75, 0.08);
  }

  .policy-cta h3 {
    margin: 0 0 8px;
    color: #011f4b;
    font-size: 20px;
  }

  .policy-cta p {
    margin: 0 0 14px;
    color: #475569;
    line-height: 1.7;
  }

  .policy-links {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
  }

  .policy-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 16px;
    border-radius: 999px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    color: #011f4b;
    background: #fff;
    border: 1px solid rgba(1, 31, 75, 0.1);
  }

  .policy-link:hover {
    border-color: rgba(0, 128, 128, 0.35);
    color: #008080;
    text-decoration: none;
  }

  @media (max-width: 640px) {
    .policy-card {
      padding: 26px 18px;
      border-radius: 18px;
    }
  }
</style>
