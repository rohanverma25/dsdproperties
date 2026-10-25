{{-- Client-side image / video / brochure validation and previews. --}}
<script>
const ALLOWED_IMG_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
const MAX_IMG_BYTES     = 2 * 1024 * 1024;  // 2 MB
const ALLOWED_VID_TYPES = ['video/mp4', 'video/quicktime', 'video/webm', 'video/x-msvideo'];
const MAX_VID_BYTES     = 100 * 1024 * 1024; // 100 MB

function validateImage(file) {
    if (!ALLOWED_IMG_TYPES.includes(file.type))
        return `"${file.name}" is not allowed. Use JPG, PNG, or WEBP.`;
    if (file.size > MAX_IMG_BYTES)
        return `"${file.name}" is ${(file.size/1024/1024).toFixed(1)} MB — max allowed is 2 MB.`;
    return null;
}

function validateVideo(file) {
    if (!ALLOWED_VID_TYPES.includes(file.type))
        return 'Only MP4, MOV, WEBM, or AVI videos are allowed.';
    if (file.size > MAX_VID_BYTES)
        return `File is ${(file.size/1024/1024).toFixed(0)} MB — max allowed is 100 MB.`;
    return null;
}

function previewSingle(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const err  = validateImage(file);
    if (err) {
        preview.innerHTML = `<div style="color:#dc2626;font-size:12px;margin-top:4px;">${err}</div>`;
        input.value = '';
        return;
    }
    const img = document.createElement('img');
    img.style.cssText = 'width:100%;max-height:140px;object-fit:cover;border-radius:8px;border:2px solid #e2e8f0;';
    img.src = URL.createObjectURL(file);
    preview.appendChild(img);
}

let galleryFiles = [];

function previewMultiple(input) {
    const newFiles = Array.from(input.files);
    const errors   = [];
    const valid    = newFiles.filter(f => {
        const err = validateImage(f);
        if (err) { errors.push(err); return false; }
        return true;
    });
    const errDiv = document.getElementById('galleryError');
    if (errors.length) {
        errDiv.textContent = errors.join(' ');
        errDiv.style.display = '';
    } else {
        errDiv.style.display = 'none';
    }
    galleryFiles = [...galleryFiles, ...valid].slice(0, 10);
    renderGallery();
    input.value = '';
    syncGalleryInput();
}

function renderGallery() {
    const grid = document.getElementById('galleryPreview');
    grid.innerHTML = '';
    galleryFiles.forEach((file, i) => {
        const wrap = document.createElement('div');
        wrap.className = 'img-preview-item';
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        const del = document.createElement('button');
        del.type = 'button';
        del.className = 'del-btn';
        del.textContent = '×';
        del.onclick = () => { galleryFiles.splice(i, 1); renderGallery(); syncGalleryInput(); };
        wrap.appendChild(img);
        wrap.appendChild(del);
        grid.appendChild(wrap);
    });
}

function syncGalleryInput() {
    const dt = new DataTransfer();
    galleryFiles.forEach(f => dt.items.add(f));
    document.getElementById('galleryInput').files = dt.files;
}

function handleDrop(event, inputId, previewId) {
    const files = event.dataTransfer.files;
    const input = document.getElementById(inputId);
    if (!files[0]) return;
    const err = validateImage(files[0]);
    if (err) {
        document.getElementById(previewId).innerHTML = `<div style="color:#dc2626;font-size:12px;margin-top:4px;">${err}</div>`;
        return;
    }
    const dt = new DataTransfer();
    dt.items.add(files[0]);
    input.files = dt.files;
    previewSingle(input, previewId);
}

function handleGalleryDrop(event) {
    const files  = Array.from(event.dataTransfer.files);
    const errors = [];
    const valid  = files.filter(f => {
        const err = validateImage(f);
        if (err) { errors.push(err); return false; }
        return true;
    });
    const errDiv = document.getElementById('galleryError');
    if (errors.length) {
        errDiv.textContent = errors.join(' ');
        errDiv.style.display = '';
    } else {
        errDiv.style.display = 'none';
    }
    galleryFiles = [...galleryFiles, ...valid].slice(0, 10);
    renderGallery();
    syncGalleryInput();
}

function previewVideo(input) {
    const preview = document.getElementById('videoPreview');
    const text    = document.getElementById('videoUploadText');
    const errDiv  = document.getElementById('videoError');
    preview.innerHTML = '';
    errDiv.style.display = 'none';
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const err  = validateVideo(file);
    if (err) {
        errDiv.textContent = err;
        errDiv.style.display = '';
        input.value = '';
        return;
    }
    const video = document.createElement('video');
    video.controls = true;
    video.style.cssText = 'width:100%;max-height:220px;border-radius:8px;border:2px solid #e2e8f0;display:block;';
    video.src = URL.createObjectURL(file);
    preview.appendChild(video);
    text.innerHTML = '✅ <strong>' + file.name + '</strong> selected';
}

function handleVideoDrop(event) {
    const file = event.dataTransfer.files[0];
    if (!file) return;
    const input = document.getElementById('videoInput');
    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
    previewVideo(input);
}

function switchVideoTab(tab) {
    const uploadTab  = document.getElementById('videoUploadTab');
    const youtubeTab = document.getElementById('videoYoutubeTab');
    const btnUpload  = document.getElementById('tabUpload');
    const btnYoutube = document.getElementById('tabYoutube');
    if (tab === 'upload') {
        uploadTab.style.display  = '';
        youtubeTab.style.display = 'none';
        btnUpload.style.background  = '#011f4b'; btnUpload.style.color  = '#fff';
        btnYoutube.style.background = '#f4f7fb'; btnYoutube.style.color = '#475569';
        document.getElementById('youtubeUrlInput').value = '';
        document.getElementById('youtubePreview').innerHTML = '';
    } else {
        uploadTab.style.display  = 'none';
        youtubeTab.style.display = '';
        btnYoutube.style.background = '#011f4b'; btnYoutube.style.color = '#fff';
        btnUpload.style.background  = '#f4f7fb'; btnUpload.style.color  = '#475569';
        document.getElementById('videoInput').value = '';
        document.getElementById('videoPreview').innerHTML = '';
        document.getElementById('videoError').style.display = 'none';
        document.getElementById('videoUploadText').innerHTML = 'Click or drag to upload a<br><strong>property walkthrough video</strong><br><span style="font-size:11px;color:#94a3b8;">mp4 · mov · webm · avi &nbsp;·&nbsp; max 100 MB</span>';
    }
}

function previewYoutube(url) {
    const preview = document.getElementById('youtubePreview');
    if (!url.trim()) { preview.innerHTML = ''; return; }
    let videoId = null;
    const patterns = [
        /youtu\.be\/([a-zA-Z0-9_-]{11})/,
        /[?&]v=([a-zA-Z0-9_-]{11})/,
        /youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/,
    ];
    for (const p of patterns) {
        const m = url.match(p);
        if (m) { videoId = m[1]; break; }
    }
    if (videoId) {
        preview.innerHTML = `<iframe width="100%" height="220" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen style="border-radius:8px;border:2px solid #e2e8f0;display:block;"></iframe>`;
    } else {
        preview.innerHTML = '<div style="color:#dc2626;font-size:12px;margin-top:4px;">Please enter a valid YouTube URL.</div>';
    }
}

// ─── PDF / Brochure validation ───
const MAX_PDF_BYTES = 10 * 1024 * 1024;

function validatePdf(file) {
    if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf'))
        return 'Only PDF files are allowed.';
    if (file.size > MAX_PDF_BYTES)
        return `File is ${(file.size / 1024 / 1024).toFixed(1)} MB — max allowed is 10 MB.`;
    return null;
}

function handleBrochureSelect(input) {
    var errDiv  = document.getElementById('brochureError');
    var infoDiv = document.getElementById('brochureInfo');
    errDiv.style.display = 'none';
    infoDiv.style.display = 'none';
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];
    var err  = validatePdf(file);
    if (err) {
        errDiv.textContent   = err;
        errDiv.style.display = '';
        input.value = '';
        return;
    }
    infoDiv.innerHTML = '<div class="brochure-info">' +
        '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>' +
        '<span><strong>' + escHtml(file.name) + '</strong> &nbsp;·&nbsp; ' + (file.size / 1024 / 1024).toFixed(2) + ' MB</span>' +
        '<button type="button" onclick="clearBrochure()" style="margin-left:auto;background:none;border:none;color:#dc2626;cursor:pointer;font-size:12px;font-weight:600;">✕ Remove</button>' +
        '</div>';
    infoDiv.style.display = '';
}

function handleBrochureDrop(event) {
    var file = event.dataTransfer.files[0];
    if (!file) return;
    var input = document.getElementById('brochureInput');
    var dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
    handleBrochureSelect(input);
}

function clearBrochure() {
    document.getElementById('brochureInput').value = '';
    document.getElementById('brochureInfo').style.display = 'none';
    document.getElementById('brochureError').style.display = 'none';
}

</script>
