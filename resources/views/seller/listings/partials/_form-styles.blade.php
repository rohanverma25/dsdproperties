<style>
    [x-cloak] { display: none !important; }
    .req { color:#dc2626; }

    .sp-pill-group { display: flex; flex-wrap: wrap; gap: 8px; }
    .sp-pill input { display: none; }
    .sp-pill label {
        display: inline-block; padding: 7px 16px; border: 1.5px solid #e2e8f0; border-radius: 20px;
        font-size: 13px; cursor: pointer; color: #475569; transition: all .15s; user-select: none;
    }
    .sp-pill label:hover { border-color:#94a3b8; }
    .sp-pill input:checked + label { border-color: #008080; background: #008080; color: #fff; font-weight: 600; }

    /* Two-level property-type picker: category buttons, then subtypes */
    .sp-type-group { margin-bottom: 12px; }
    .sp-type-group-label {
        font-size: 11px; font-weight: 700; letter-spacing: .6px; text-transform: uppercase;
        color: #94a3b8; margin-bottom: 7px;
    }
    .sp-cat-group { gap: 10px; margin-bottom: 4px; }
    .sp-cat-btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 22px; border: 2px solid #e2e8f0; border-radius: 10px;
        background: #fff; color: #475569; font-family: inherit; font-size: 14px;
        font-weight: 600; cursor: pointer; transition: all .15s;
    }
    .sp-cat-btn:hover { border-color: #94a3b8; }
    .sp-cat-btn.active {
        border-color: #008080; background: #008080; color: #fff;
        box-shadow: 0 2px 8px rgba(0,128,128,.25);
    }
    .sp-cat-btn span { font-size: 17px; line-height: 1; }
    .sp-subtype-row {
        margin-top: 14px; padding: 14px 16px;
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;
    }
    /* A category with a single type needs no second choice to be made. */
    .sp-subtype-row .sp-single-type { display: none; }

    @media (max-width: 640px) {
        .sp-cat-group { flex-direction: column; }
        .sp-cat-btn { width: 100%; justify-content: flex-start; }
    }

    /* Price field with a fixed "Lakh" unit, matching the area unit selector */
    .sp-price-input { display: flex; }
    .sp-price-input .sp-input { flex: 1; border-top-right-radius: 0; border-bottom-right-radius: 0; }
    .sp-price-unit {
        display: inline-flex; align-items: center; padding: 0 14px;
        border: 1.5px solid #e2e8f0; border-left: none;
        border-top-right-radius: 8px; border-bottom-right-radius: 8px;
        background: #f8fafc; color: #475569; font-size: 13px; font-weight: 600; white-space: nowrap;
    }

    .sp-section-title { font-size: 15px; font-weight: 700; color: #011f4b; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 2px solid #e2e8f0; }

    /* Type-specific details block */
    .sp-subsection { background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:20px; }
    .sp-subsection-title { display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; color:#011f4b; margin-bottom:4px; }
    .sp-extras-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(210px,1fr)); gap:16px; }

    .sp-checkbox-item { display: flex; align-items: center; gap: 8px; }
    .sp-checkbox-item input[type=checkbox] { width: 16px; height: 16px; accent-color: #008080; cursor: pointer; flex:0 0 auto; }
    .sp-checkbox-item label { font-size: 13px; cursor: pointer; margin: 0; }
    .sp-amenities-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(190px,1fr)); gap:10px; margin-top:8px; }

    /* Inline step validation summary */
    .sp-step-errors {
        background:#fef2f2; border:1px solid #fecaca; border-left:4px solid #dc2626;
        border-radius:8px; padding:13px 16px; margin-bottom:18px;
    }
    .sp-step-errors strong { color:#991b1b; font-size:13.5px; }
    .sp-step-errors ul { margin:6px 0 0; padding-left:18px; }
    .sp-step-errors li { color:#b91c1c; font-size:13px; line-height:1.7; }

    .img-preview-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px; }
    .img-preview-item { position: relative; width: 100px; height: 78px; }
    .img-preview-item img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; border: 2px solid #e2e8f0; }
    .img-preview-item .del-btn {
        position: absolute; top: -7px; right: -7px; width: 22px; height: 22px;
        background: #dc2626; color: #fff; border-radius: 50%; font-size: 13px; line-height: 22px;
        text-align: center; cursor: pointer; border: none; font-weight: 700;
    }

    .progress-bar { height: 4px; background: #e2e8f0; border-radius: 4px; margin-bottom: 28px; }
    .progress-fill { height: 100%; background: #008080; border-radius: 4px; transition: width .3s ease; }

    /* Tag picker */
    .tag-chip { display:inline-flex;align-items:center;gap:5px;background:#008080;color:#fff;border-radius:20px;padding:5px 10px 5px 13px;font-size:13px;font-weight:600; }
    .tag-chip button { background:none;border:none;color:rgba(255,255,255,.75);cursor:pointer;font-size:17px;line-height:1;padding:0 2px;margin-left:2px; }
    .tag-chip button:hover { color:#fff; }
    .tag-dropdown { position:absolute;left:0;right:0;top:calc(100% + 4px);background:#fff;border:1.5px solid #cbd5e1;border-radius:8px;box-shadow:0 6px 16px rgba(0,0,0,.1);z-index:300;max-height:220px;overflow-y:auto; }
    .tag-option { padding:9px 14px;cursor:pointer;font-size:13px;color:#374151; }
    .tag-option:hover { background:#f1f5f9; }
    .tag-option-create { color:#008080;font-weight:600;border-top:1px solid #f1f5f9; }
    .tag-option-create:hover { background:#f0fdfd; }
    .tag-empty { padding:10px 14px;font-size:12.5px;color:#94a3b8;text-align:center; }

    /* Plot segments */
    .plot-seg-table { width:100%; border-collapse:collapse; margin-top:10px; }
    .plot-seg-table th { font-size:11.5px; font-weight:700; color:#64748b; text-align:left; padding:8px 10px; background:#f8fafc; border:1px solid #e2e8f0; text-transform:uppercase; letter-spacing:.3px; }
    .plot-seg-table td { padding:7px 8px; border:1px solid #e2e8f0; font-size:13px; vertical-align:middle; }
    .plot-seg-table td input, .plot-seg-table td select { width:100%; border:1px solid #e2e8f0; border-radius:6px; padding:6px 8px; font-size:13px; font-family:inherit; background:#fff; outline:none; box-sizing:border-box; }
    .plot-seg-table td input:focus, .plot-seg-table td select:focus { border-color:#008080; }
    .btn-add-seg { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:#f0fdfa; border:1.5px dashed #008080; border-radius:8px; color:#008080; font-size:13px; font-weight:600; cursor:pointer; margin-top:10px; transition:background .15s; }
    .btn-add-seg:hover { background:#ccfbf1; }
    .btn-del-seg { background:#fee2e2; border:none; color:#dc2626; border-radius:6px; width:28px; height:28px; cursor:pointer; font-size:16px; font-weight:700; line-height:1; display:inline-flex; align-items:center; justify-content:center; }
    .btn-del-seg:hover { background:#fca5a5; }

    /* Upload loader overlay */
    #upload-loader { display:none; position:fixed; inset:0; z-index:99999; background:rgba(1,31,75,.92); flex-direction:column; align-items:center; justify-content:center; gap:20px; }
    #upload-loader.active { display:flex; }
    .ul-spinner { width:54px; height:54px; border:4px solid rgba(255,255,255,.2); border-top-color:#fff; border-radius:50%; animation:ul-spin .75s linear infinite; }
    @keyframes ul-spin { to { transform:rotate(360deg); } }
    .ul-text { color:#fff; font-family:'Poppins',sans-serif; font-size:1.05rem; font-weight:700; text-align:center; }
    .ul-sub { color:rgba(255,255,255,.65); font-family:'Poppins',sans-serif; font-size:.8rem; text-align:center; line-height:1.7; max-width:300px; }

    /* Quill editor
       Quill turns #quill-editor into .ql-container, and its own stylesheet sets
       height:100%. Inside a `display:grid` form row that percentage resolves against the
       grid area rather than collapsing to content, so the editor overflowed its flow
       height and the hint below it landed on top of the amenities. Size it to content. */
    #quill-editor { background:#fff; font-family:'Poppins',sans-serif; font-size:14px; }
    .ql-toolbar.ql-snow { border-radius:8px 8px 0 0 !important; border-color:#e2e8f0 !important; background:#f8fafc; }
    .ql-container.ql-snow {
        border-radius:0 0 8px 8px !important; border-color:#e2e8f0 !important;
        height:auto !important;
    }
    .ql-editor { min-height:140px; font-family:'Poppins',sans-serif; font-size:14px; line-height:1.7; }
    .ql-editor.ql-blank::before { font-style:normal; color:#94a3b8; }

    /* Brochure upload */
    .brochure-zone { border:2px dashed #e2e8f0; border-radius:10px; padding:22px; text-align:center; cursor:pointer; background:#f8fafc; transition:border-color .2s,background .2s; }
    .brochure-zone:hover,.brochure-zone.drag { border-color:#008080; background:#f0fdfa; }
    .brochure-info { display:flex; align-items:center; gap:10px; margin-top:10px; padding:10px 14px; background:#f0fdfa; border:1px solid #a7f3d0; border-radius:8px; font-size:13px; color:#065f46; }

    @media (max-width: 768px) {
        /* On a phone the step labels are noise — the progress bar and heading carry it. */
        .sp-step-label { display: none; }
        .sp-steps { justify-content: space-between; margin-bottom: 18px; }

        /* Keep Back / Next reachable with a thumb instead of at the end of a long scroll. */
        .sp-wizard-nav {
            position: sticky; bottom: 0; z-index: 50;
            margin: 24px -20px calc(-1 * env(safe-area-inset-bottom));
            padding: 12px 20px calc(12px + env(safe-area-inset-bottom));
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(8px);
            border-top: 1px solid #e2e8f0;
        }
        .sp-wizard-nav .sp-btn { flex: 1; justify-content: center; text-align: center; }
    }

    @media (max-width: 640px) {
        .sp-extras-grid { grid-template-columns:1fr; }
        .sp-amenities-grid { grid-template-columns:1fr 1fr; }
        .plot-seg-table thead { display: none; }
        .plot-seg-table, .plot-seg-table tbody, .plot-seg-table tr, .plot-seg-table td { display: block; width: 100%; }
        .plot-seg-table tr { margin-bottom: 12px; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px; }
        .plot-seg-table td { border: none; padding: 5px 6px; }
        .img-preview-item { width: calc(33.333% - 7px); height: 72px; }
    }
</style>
