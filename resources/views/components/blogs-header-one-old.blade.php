<style>
/*/* Card-like TOC */
h2#toc_id {
  background: linear-gradient(135deg, #e6f7f7, #fdfdfd); 
  border: 1px solid #cce5e5;
  border-radius: 14px 14px 0 0;
  padding: 18px 20px;
  margin: 20px 0 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  font-size: 20px;
  font-weight: 700;
  color: #011f4b; 
  box-shadow: 0 4px 12px rgba(1,31,75,0.15);
}

h2#toc_id + ul {
  list-style: none;
  margin: 0;
  padding: 14px 16px 20px;
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-top: 0;
  border-radius: 0 0 14px 14px;
  box-shadow: 0 4px 10px rgba(0,128,128,0.08);
}

h2#toc_id + ul li {
  margin: 6px 0;
}

h2#toc_id + ul li a {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
  font-size: 15px;
  color: #011f4b; 
  padding: 8px 12px;
  border-radius: 10px;
  transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease;
  background: #f9fafb;
}

h2#toc_id + ul li a::before {
  content: "";
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #008080;
  flex-shrink: 0;
}

h2#toc_id + ul li a:hover {
  background: rgba(0,128,128,0.08); 
  color: #008080; /
  transform: translateX(6px);
}

h2#toc_id + ul li a.active {
  background: rgba(255,165,0,0.15); 
  color: #FFA500; 
  font-weight: 600;
}
h2#toc_id + ul li a.active::before {
  background: #FFA500; 
  box-shadow: 0 0 0 4px rgba(255,165,0,0.2);
}

h2#toc_id + ul li a:focus {
  outline: 3px solid rgba(0,128,128,0.3);
  outline-offset: 2px;
}

@media (max-width: 480px) {
  h2#toc_id { padding: 14px 16px; font-size: 18px; }
  h2#toc_id + ul { padding: 10px 10px 14px; }
  h2#toc_id + ul li a { font-size: 14px; padding: 8px 10px; }
}
*/*/
/* ── TABLE: responsive wrapper ── */
.dsd-table-wrap {
    display: block;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    width: 100%;
    max-width: 100%;
    margin: 24px 0;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,.07);
}

table {
    border-collapse: collapse;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    color: #111827;
    min-width: 480px;
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
}

/* Header */
table thead {
    background: linear-gradient(135deg, #011f4b, #008080);
}
table thead th {
    padding: 13px 16px;
    font-weight: 600;
    font-size: 13px;
    color: #ffffff !important;
    text-align: left;
    letter-spacing: .3px;
    white-space: nowrap;
    border: none;
}

/* Body rows */
table tbody tr {
    background: #ffffff;
    transition: background .18s;
}
table tbody tr:nth-child(even) {
    background: #f8fafc;
}
table tbody tr:hover {
    background: rgba(0, 128, 128, .07);
}

/* Cells */
table td,
table th {
    padding: 12px 16px !important;
    vertical-align: middle !important;
    text-align: left !important;
    border-bottom: 1px solid #e5e7eb;
}
table tbody tr:last-child td {
    border-bottom: none;
}
table td {
    color: #374151;
    font-size: 13.5px;
    line-height: 1.55;
}

/* Mobile label hint */
@media (max-width: 640px) {
    table {
        font-size: 13px;
        min-width: 420px;
    }
    table td, table th {
        padding: 10px 12px !important;
    }
}
</style>

<!--<div class="flex items-center gap-4 text-sm text-gray-500 p-4">
   <span class="flex items-center gap-1">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    12 min read
  </span>
  
  <span class="flex items-center gap-1">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
    </svg>
    Updated: {{ $blog->updated_at->format('M d, Y') }}
  </span>
</div> -->
 <script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqHeaders = document.querySelectorAll('#FAQs h3');
        faqHeaders.forEach(header => {
            header.addEventListener('click', function() {
                this.classList.toggle('active');
                const answer = this.nextElementSibling;
                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                } else {
                    answer.style.display = 'block';
                }
            });
        });
    });
    </script>
