<?php
add_action('admin_menu', 'qlhs_menu');
function qlhs_menu() {
    add_menu_page('Quản lý học sinh', 'QL Học Sinh', 'manage_options', 'ql-hoc-sinh', 'qlhs_trang', 'dashicons-welcome-learn-more');
}

add_action('admin_enqueue_scripts', 'qlhs_admin_styles');
function qlhs_admin_styles($hook) {
    if ($hook !== 'toplevel_page_ql-hoc-sinh') return;
    
    // Nạp jQuery gốc của WordPress
    wp_enqueue_script('jquery');
    
    // Nạp CSS của DataTables từ CDN
    wp_enqueue_style('qlhs-datatables-css', 'https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css');
    
    // Nạp thiết kế Premium riêng biệt cho hệ thống
    wp_add_inline_style('qlhs-datatables-css', qlhs_get_css());
}

function qlhs_get_css() {
    return '
        @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap");

        /* ── GLOBAL ── */
        .qlhs-wrap {
            max-width: 1280px;
            margin: 28px auto;
            padding: 0 16px;
            font-family: "Plus Jakarta Sans", -apple-system, sans-serif;
            color: #1e293b;
        }

        /* ── HEADER ── */
        .qlhs-header {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #1e293b 100%);
            padding: 34px 40px;
            border-radius: 24px;
            margin-bottom: 28px;
            box-shadow: 0 24px 56px rgba(15,23,42,0.22), inset 0 1px rgba(255,255,255,0.06);
        }
        .qlhs-header::before {
            content: "";
            position: absolute;
            width: 360px; height: 360px;
            background: radial-gradient(circle, rgba(139,92,246,0.28), transparent 70%);
            top: -160px; right: -100px;
        }
        .qlhs-header::after {
            content: "";
            position: absolute;
            width: 240px; height: 240px;
            background: radial-gradient(circle, rgba(96,165,250,0.18), transparent 70%);
            bottom: -120px; left: -80px;
        }
        .qlhs-header h1 {
            position: relative; z-index: 2;
            margin: 0;
            font-size: 28px; font-weight: 900;
            letter-spacing: -0.8px;
            color: #ffffff;
            display: flex; align-items: center; gap: 14px;
        }
        .qlhs-header h1::before {
            content: "🎓";
            font-size: 32px;
        }
        .qlhs-header-sub {
            position: relative; z-index: 2;
            margin: 8px 0 0 46px;
            font-size: 13px;
            color: rgba(255,255,255,0.45);
            font-weight: 500;
        }

        /* ── CARD ── */
        .qlhs-card {
            background: rgba(255,255,255,0.82);
            backdrop-filter: blur(20px);
            border-radius: 22px;
            padding: 32px;
            margin-bottom: 24px;
            border: 1px solid rgba(255,255,255,0.75);
            box-shadow: 0 8px 28px rgba(15,23,42,0.06), 0 2px 6px rgba(15,23,42,0.04), inset 0 1px rgba(255,255,255,0.9);
            transition: transform .3s ease, box-shadow .3s ease;
        }
        .qlhs-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 44px rgba(15,23,42,0.10);
        }
        .qlhs-card-title {
            font-size: 11px; font-weight: 800;
            text-transform: uppercase; letter-spacing: 2px;
            color: #94a3b8;
            margin: 0 0 26px 0;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(148,163,184,0.14);
            display: flex; align-items: center; gap: 10px;
        }

        /* ── STATS ── */
        .qlhs-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }
        .qlhs-stat-item {
            position: relative; overflow: hidden;
            background: linear-gradient(145deg, rgba(255,255,255,0.98), rgba(248,250,252,0.9));
            padding: 26px 28px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.8);
            box-shadow: 0 8px 24px rgba(15,23,42,0.06);
            transition: transform .3s ease, box-shadow .3s ease;
        }
        .qlhs-stat-item:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 16px 36px rgba(99,102,241,0.14);
        }
        .qlhs-stat-item::before {
            content: "";
            position: absolute;
            width: 180px; height: 180px;
            background: radial-gradient(circle, rgba(99,102,241,0.12), transparent 70%);
            top: -80px; right: -60px;
        }
        .qlhs-stat-item::after {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 3px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #a78bfa);
            border-radius: 20px 20px 0 0;
        }
        .qlhs-stat-number {
            position: relative; z-index: 2;
            font-size: 44px; font-weight: 900;
            letter-spacing: -2px; line-height: 1;
            background: linear-gradient(135deg, #0f172a 0%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .qlhs-stat-label {
            position: relative; z-index: 2;
            margin-top: 10px;
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1px;
            color: #94a3b8;
        }

        /* ── FORM ── */
        .qlhs-form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 20px; }
        .qlhs-form-group { display: flex; flex-direction: column; }
        .qlhs-form-group label {
            margin-bottom: 8px;
            font-size: 12px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.6px;
            color: #475569;
        }
        .qlhs-form-group input,
        .qlhs-form-group select {
            padding: 12px 16px;
            border: 1.5px solid rgba(148,163,184,0.2);
            border-radius: 14px;
            font-size: 14px;
            font-family: inherit;
            background: rgba(255,255,255,0.8);
            color: #0f172a;
            transition: all .22s ease;
        }
        .qlhs-form-group input:focus,
        .qlhs-form-group select:focus {
            outline: none;
            border-color: #818cf8;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(129,140,248,0.12), 0 6px 20px rgba(99,102,241,0.1);
            transform: translateY(-1px);
        }
        .qlhs-form-group.full-width { grid-column: 1 / -1; }
        .qlhs-score-group { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }

        /* ── BUTTONS ── */
        .qlhs-btn {
            position: relative; overflow: hidden;
            border: none; border-radius: 14px;
            padding: 13px 22px;
            font-size: 14px; font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
            text-decoration: none;
            transition: transform .22s ease, box-shadow .22s ease;
        }
        .qlhs-btn:hover { transform: translateY(-2px); }
        .qlhs-btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #ffffff;
            box-shadow: 0 10px 26px rgba(99,102,241,0.3);
        }
        .qlhs-btn-primary:hover {
            box-shadow: 0 16px 36px rgba(99,102,241,0.42);
            color: #ffffff;
        }
        .qlhs-btn-secondary {
            background: rgba(255,255,255,0.8);
            color: #334155;
            border: 1px solid rgba(148,163,184,0.2);
        }
        .qlhs-btn-secondary:hover { background: #f1f5f9; color: #1e293b; }

        /* ── DATATABLES ── */
        .dataTables_wrapper { font-size: 13px; padding-top: 6px; }
        .dataTables_wrapper .dataTables_length { margin-bottom: 18px; color: #64748b; font-weight: 600; }
        .dataTables_wrapper .dataTables_length select {
            padding: 7px 28px 7px 12px !important;
            border-radius: 10px;
            border: 1.5px solid rgba(148,163,184,0.2);
            background: rgba(255,255,255,0.8);
            font-family: inherit;
        }
        .dataTables_wrapper .dataTables_filter { margin-bottom: 20px; color: #64748b; font-weight: 600; }
        .dataTables_wrapper .dataTables_filter input {
            width: 280px;
            padding: 10px 16px;
            border-radius: 50px;
            border: 1.5px solid rgba(148,163,184,0.2);
            background: rgba(255,255,255,0.8);
            font-family: inherit;
            transition: all .22s ease;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #818cf8;
            box-shadow: 0 0 0 4px rgba(129,140,248,0.12);
        }

        /* ── TABLE ── */
        .qlhs-table {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(148,163,184,0.12) !important;
            background: rgba(255,255,255,0.8);
        }
        .qlhs-table thead th {
            background: linear-gradient(180deg, #f8fafc, #eef2ff) !important;
            color: #64748b !important;
            padding: 16px 14px !important;
            font-size: 11px; font-weight: 800;
            text-transform: uppercase; letter-spacing: 1.2px;
            border-bottom: 1px solid rgba(148,163,184,0.12) !important;
            border-top: none !important;
            text-align: center !important;
            white-space: nowrap;
        }
        .qlhs-table thead th:nth-child(2) { text-align: left !important; }
        .qlhs-table tbody tr { transition: background .18s ease, transform .18s ease; }
        .qlhs-table tbody tr:hover { background: rgba(99,102,241,0.04) !important; }
        .qlhs-table tbody td {
            padding: 16px 14px;
            border-bottom: 1px solid rgba(148,163,184,0.08);
            text-align: center !important;
            vertical-align: middle;
            color: #334155; font-size: 14px;
        }
        .qlhs-table tbody td:nth-child(2) {
            text-align: left !important;
            font-weight: 700; color: #0f172a;
        }
        .qlhs-table tbody tr:last-child td { border-bottom: none; }

        /* ── PAGINATION ── */
        .dataTables_wrapper .dataTables_paginate { margin-top: 22px; }
        .dataTables_wrapper .paginate_button {
            border-radius: 10px !important;
            padding: 7px 13px !important;
            margin: 0 2px;
            border: 1px solid rgba(148,163,184,0.16) !important;
            background: rgba(255,255,255,0.8) !important;
            color: #475569 !important;
            font-weight: 600;
            transition: all .2s ease;
        }
        .dataTables_wrapper .paginate_button:hover {
            background: rgba(99,102,241,0.08) !important;
            color: #1e293b !important;
            border-color: rgba(99,102,241,0.2) !important;
        }
        .dataTables_wrapper .paginate_button.current {
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
            color: #ffffff !important;
            border: none !important;
            box-shadow: 0 6px 16px rgba(99,102,241,0.3);
        }

        /* ── BADGES ── */
        .qlhs-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px; font-weight: 700;
            white-space: nowrap;
        }
        .qlhs-badge-male { background: linear-gradient(135deg, #dbeafe, #eff6ff); color: #1d4ed8; }
        .qlhs-badge-female { background: linear-gradient(135deg, #fce7f3, #fff1f2); color: #be185d; }

        /* ── SCORES ── */
        .qlhs-score {
            display: inline-block;
            min-width: 40px;
            padding: 5px 10px;
            border-radius: 10px;
            background: rgba(255,255,255,0.9);
            border: 1px solid rgba(148,163,184,0.14);
            font-weight: 700; color: #475569;
            font-size: 13px;
        }
        .qlhs-total {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #ffffff;
            padding: 6px 14px;
            border-radius: 12px;
            font-weight: 800; font-size: 13px;
            box-shadow: 0 8px 18px rgba(99,102,241,0.26);
        }

        /* ── XẾP LOẠI ── */
        .qlhs-rank {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px; font-weight: 700;
            white-space: nowrap;
        }
        .qlhs-rank-gioi { background: linear-gradient(135deg, #dcfce7, #f0fdf4); color: #166534; border: 1px solid #bbf7d0; }
        .qlhs-rank-kha  { background: linear-gradient(135deg, #dbeafe, #eff6ff); color: #1d4ed8; border: 1px solid #bfdbfe; }
        .qlhs-rank-tb   { background: linear-gradient(135deg, #fef9c3, #fefce8); color: #854d0e; border: 1px solid #fde68a; }
        .qlhs-rank-yeu  { background: linear-gradient(135deg, #fee2e2, #fff5f5); color: #991b1b; border: 1px solid #fecaca; }

        /* ── ACTIONS ── */
        .qlhs-actions { display: flex; justify-content: center; gap: 6px; }
        .qlhs-action-btn {
            padding: 7px 13px;
            border-radius: 10px;
            font-size: 12px; font-weight: 700;
            text-decoration: none;
            transition: all .18s ease;
        }
        .qlhs-action-edit { background: rgba(59,130,246,0.08); color: #2563eb; border: 1px solid rgba(59,130,246,0.14); }
        .qlhs-action-edit:hover { background: rgba(59,130,246,0.16); transform: translateY(-1px); color: #2563eb; }
        .qlhs-action-delete { background: rgba(239,68,68,0.08); color: #dc2626; border: 1px solid rgba(239,68,68,0.14); }
        .qlhs-action-delete:hover { background: rgba(239,68,68,0.16); transform: translateY(-1px); color: #dc2626; }

        /* ── ALERTS ── */
        .qlhs-alert {
            padding: 14px 20px;
            border-radius: 16px;
            margin-bottom: 22px;
            font-size: 14px; font-weight: 600;
            display: flex; align-items: center; gap: 10px;
        }
        .qlhs-alert-success { background: rgba(34,197,94,0.09); color: #166534; border: 1px solid rgba(34,197,94,0.16); }
        .qlhs-alert-error   { background: rgba(239,68,68,0.09); color: #991b1b; border: 1px solid rgba(239,68,68,0.16); }

        /* ── EMPTY ── */
        .qlhs-empty { text-align: center; padding: 60px 20px; color: #94a3b8; }
        .qlhs-empty-icon { font-size: 56px; margin-bottom: 16px; }
        .qlhs-empty p { font-size: 15px; font-weight: 600; }
    ';
}