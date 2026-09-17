<style>
/* =====================================================================
   EBDEA SOFT — Executive Dark Navy + Orange Sidebar (Real Estate)
   ===================================================================== */
:root {
    --sb-width: 250px;
    --sb-bg: #05070c;
    --sb-surface: #1e293b;
    --sb-surface-hover: #293548;
    --sb-accent-orange: #f97316;
    --sb-accent-amber: #fb923c;
    --sb-border: rgba(255, 255, 255, 0.08);
    --sb-text-dark: #f8fafc;
    --sb-text-main: #f8fafc;
    --sb-text-muted: #cbd5e1;
    --sb-text-dim: #94a3b8;
    --sb-radius: 10px;
}

/* Base Sidebar Shell */
.app-sidebar,
.app-sidebar.sidebar-scroll,
html body .app-sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    width: var(--sb-width);
    height: 100vh !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    z-index: 1000;
    background: var(--sb-bg) !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35) !important;
    transition: transform 0.25s ease, width 0.25s ease;
}

/* Force container transparent so dark navy shows through */
.app-sidebar .main-sidemenu,
.app-sidebar .main-sidemenu > div {
    background: transparent !important;
}

/* Slim scrollbar */
.app-sidebar::-webkit-scrollbar { width: 5px; }
.app-sidebar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
.app-sidebar::-webkit-scrollbar-track { background: transparent; }

/* Keep expanded menus visible */
.app-sidebar .slide.is-expanded > .slide-menu { display: block !important; }

/* ---- Brand Header ---- */
.app-sidebar .main-sidebar-header {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 64px;
    border-bottom: 1px solid var(--sb-border) !important;
    background: var(--sb-bg) !important;
}
.app-sidebar .main-sidebar-header .main-logo { max-height: 38px; }
.app-sidebar .main-sidebar-header .logo-icon { max-height: 32px; }

/* ---- User Profile Card ---- */
.app-sidebar .app-sidebar__user {
    padding: 12px 14px;
    margin: 10px 10px 6px;
    background: var(--sb-surface) !important;
    border: 1px solid var(--sb-border) !important;
    border-radius: 10px !important;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25) !important;
}
.app-sidebar .app-sidebar__user .user-pro-body {
    display: flex;
    align-items: center;
    gap: 10px;
}
.app-sidebar .app-sidebar__user .avatar {
    width: 40px;
    height: 40px;
    border-radius: 50% !important;
    object-fit: cover !important;
    border: 2px solid #f97316;
    box-shadow: 0 0 10px rgba(249, 115, 22, 0.35);
    flex-shrink: 0;
}
.app-sidebar .app-sidebar__user .user-info {
    overflow: hidden;
    flex: 1;
}
.app-sidebar .app-sidebar__user .user-info h4 {
    color: var(--sb-text-main) !important;
    font-size: 13.5px;
    font-weight: 700;
    margin: 0;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.app-sidebar .app-sidebar__user .user-info span {
    color: var(--sb-text-muted) !important;
    font-size: 11px;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Language switcher pill inside user card */
.app-sidebar .sb-lang-switch {
    display: flex !important;
    width: 100% !important;
    margin-top: 10px !important;
    background: #030509 !important;
    border: 1px solid var(--sb-border) !important;
    border-radius: 20px !important;
    padding: 2px !important;
    gap: 3px !important;
}
.app-sidebar .sb-lang-switch a {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex: 1 1 0% !important;
    text-align: center !important;
    font-size: 11.5px !important;
    font-weight: 700 !important;
    padding: 4px 6px !important;
    border-radius: 16px !important;
    color: var(--sb-text-muted) !important;
    text-decoration: none !important;
    transition: all .15s ease !important;
}
.app-sidebar .sb-lang-switch a:hover {
    color: var(--sb-text-main) !important;
    background: rgba(255, 255, 255, 0.06) !important;
}
.app-sidebar .sb-lang-switch a.active {
    background: var(--sb-accent-orange) !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(249, 115, 22, 0.4) !important;
}

/* ---- Menu List ---- */
.app-sidebar .side-menu,
.app-sidebar ul.side-menu {
    list-style: none;
    margin: 0;
    padding: 4px 8px 30px;
    background: transparent !important;
}

/* Section Category Eyebrow */
.app-sidebar .side-menu__eyebrow {
    padding: 16px 10px 6px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #f8fafc !important;
    display: flex;
    align-items: center;
    gap: 7px;
    text-shadow: 0 1px 4px rgba(249, 115, 22, 0.25);
}
.app-sidebar .side-menu__eyebrow:first-child {
    padding-top: 2px;
}
.app-sidebar .side-menu__eyebrow::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #f97316;
    box-shadow: 0 0 8px rgba(249, 115, 22, 0.9);
    display: inline-block;
    flex-shrink: 0;
}
.app-sidebar .side-menu__eyebrow::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, rgba(249, 115, 22, 0.45) 0%, rgba(249, 115, 22, 0.1) 60%, transparent 100%);
}

/* Menu Items */
.app-sidebar .side-menu__item,
html body .app-sidebar .side-menu__item {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    padding: 9.5px 13px !important;
    margin: 4px 0 !important;
    border-radius: var(--sb-radius) !important;
    background: rgba(30, 41, 59, 0.55) !important;
    border: 1px solid rgba(249, 115, 22, 0.3) !important;
    border-inline-start: 3.5px solid rgba(249, 115, 22, 0.55) !important;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2) !important;
    text-decoration: none !important;
    cursor: pointer !important;
    transition: all .2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    white-space: nowrap !important;
}

/* Menu Text Label - ALWAYS High Contrast & Visible */
.app-sidebar .side-menu__label,
.app-sidebar .side-menu__item .side-menu__label,
html body .app-sidebar .side-menu__label {
    flex: 1 !important;
    color: #e2e8f0 !important;
    font-size: 13.5px !important;
    font-weight: 700 !important;
    opacity: 1 !important;
    visibility: visible !important;
    display: inline-block !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}

/* Menu Icons - Orange & Visible */
.app-sidebar .side-menu__icon,
.app-sidebar .side-menu__item i,
.app-sidebar .side-menu__item svg,
html body .app-sidebar .side-menu__icon {
    width: 18px !important;
    height: 18px !important;
    font-size: 16px !important;
    flex-shrink: 0 !important;
    color: #cbd5e1 !important;
    fill: #cbd5e1 !important;
    opacity: 1 !important;
    visibility: visible !important;
    transition: color .15s ease, fill .15s ease !important;
}

/* Chevron arrow */
.app-sidebar .angle,
.app-sidebar .side-menu__item .angle {
    font-size: 11px !important;
    color: #94a3b8 !important;
    transition: transform .2s ease !important;
    margin-inline-start: auto !important;
}
.app-sidebar .slide.is-expanded > .side-menu__item .angle {
    transform: rotate(180deg) !important;
    color: #fb923c !important;
}

/* Hover Menu Item */
.app-sidebar .side-menu__item:hover {
    background: rgba(249, 115, 22, 0.13) !important;
    border-color: rgba(249, 115, 22, 0.75) !important;
    border-inline-start-color: #f97316 !important;
    box-shadow: 0 4px 14px rgba(249, 115, 22, 0.24) !important;
}
.app-sidebar .side-menu__item:hover .side-menu__label {
    color: #ffffff !important;
}
.app-sidebar .side-menu__item:hover .side-menu__icon {
    color: #fb923c !important;
    fill: #fb923c !important;
}

/* Active Menu Item */
.app-sidebar .slide.active > .side-menu__item,
html body .app-sidebar .slide.active > .side-menu__item {
    background: linear-gradient(90deg, rgba(249, 115, 22, 0.25) 0%, rgba(249, 115, 22, 0.08) 100%) !important;
    border: 1px solid rgba(249, 115, 22, 0.8) !important;
    border-inline-start: 4px solid #f97316 !important;
    border-radius: var(--sb-radius) !important;
    box-shadow: 0 4px 18px rgba(249, 115, 22, 0.3) !important;
}
.app-sidebar .slide.active > .side-menu__item .side-menu__label,
html body .app-sidebar .slide.active > .side-menu__item .side-menu__label {
    color: #ffffff !important;
    font-weight: 800 !important;
}
.app-sidebar .slide.active > .side-menu__item .side-menu__icon,
.app-sidebar .slide.active > .side-menu__item i,
.app-sidebar .slide.active > .side-menu__item svg {
    color: #fb923c !important;
    fill: #fb923c !important;
}
.app-sidebar .slide.active > .side-menu__item .angle {
    color: #fb923c !important;
}

/* Pending-count badge inside menu items */
.app-sidebar .badge-warning {
    background: var(--sb-accent-orange) !important;
    color: #ffffff !important;
    border: none !important;
}

/* Submenu container */
.app-sidebar .slide-menu {
    list-style: none !important;
    margin: 3px 0 8px !important;
    padding: 6px !important;
    padding-inline-start: 12px !important;
    background: rgba(15, 23, 42, 0.5) !important;
    border-inline-start: 2px solid rgba(249, 115, 22, 0.35) !important;
    margin-inline-start: 20px !important;
    border-radius: var(--sb-radius) !important;
    box-shadow: none !important;
}

/* Submenu items */
.app-sidebar .slide-menu .slide-item {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    padding: 7px 11px !important;
    margin: 2px 0 !important;
    border-radius: 7px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #94a3b8 !important;
    text-decoration: none !important;
    transition: all .15s ease !important;
    white-space: nowrap !important;
    height: auto !important;
    line-height: 1.4 !important;
    position: relative;
}
.app-sidebar .slide-menu .slide-item:hover {
    background: rgba(249, 115, 22, 0.12) !important;
    color: #ffffff !important;
    padding-inline-start: 14px !important;
}
.app-sidebar .slide-menu .slide-item.active {
     background: rgba(249, 115, 22, 0.2) !important;
    color: #ffffff !important;
    font-weight: 800 !important;
}
.app-sidebar .slide-menu .slide-item i,
.app-sidebar .slide-menu .slide-item svg {
    font-size: 13px !important;
    width: 14px !important;
    color: #94a3b8 !important;
    flex-shrink: 0 !important;
}
.app-sidebar .slide-menu .slide-item:hover i,
.app-sidebar .slide-menu .slide-item.active i {
    color: #f97316 !important;
}

/* Level-2 Nested Submenu */
.app-sidebar .sub-side-menu__item {
    display: flex !important;
    align-items: center !important;
    padding: 7px 10px !important;
    font-size: 12.5px !important;
    font-weight: 700 !important;
    color: #cbd5e1 !important;
    text-decoration: none !important;
    cursor: pointer !important;
    border-radius: 6px !important;
    white-space: nowrap !important;
}
.app-sidebar .sub-side-menu__item:hover {
    background: rgba(249, 115, 22, 0.12) !important;
    color: #ffffff !important;
}
.app-sidebar .sub-side-menu__label {
    flex: 1 !important;
}

/* Logout Item */
.app-sidebar .side-menu__item.sb-logout {
    color: #fb7185 !important;
    margin-top: 10px;
    border: 1px solid rgba(244, 63, 94, 0.25) !important;
    background: rgba(244, 63, 94, 0.08) !important;
    border-inline-start: 3.5px solid rgba(244, 63, 94, 0.55) !important;
}
.app-sidebar .side-menu__item.sb-logout .side-menu__label {
    color: #fb7185 !important;
}
.app-sidebar .side-menu__item.sb-logout .side-menu__icon {
    color: #fb7185 !important;
}
.app-sidebar .side-menu__item.sb-logout:hover {
    background: rgba(244, 63, 94, 0.18) !important;
}
.app-sidebar .side-menu__item.sb-logout:hover .side-menu__label,
.app-sidebar .side-menu__item.sb-logout:hover .side-menu__icon {
    color: #ffffff !important;
}

/* Divider */
.app-sidebar .sb-divider {
    height: 1px !important;
    background: var(--sb-border) !important;
    margin: 8px 6px !important;
}

/* Mobile responsive drawer */
@media (max-width: 991px) {
    .app-sidebar.sidebar-open,
    .sidenav-toggled .app-sidebar {
        transform: translateX(0) !important;
    }
}

/* [إصلاح] فرض ظهور تسمية العنصر الرئيسي في كل الأحوال، حتى لو القالب حط أي كلاس
   على body بيخفيها بشكل افتراضي (زي أوضاع "أيقونات فقط" الشائعة في القوالب دي) -
   ده كان سبب اختفاء نص عناصر القائمة الرئيسية بينما نص القوائم الفرعية كان ظاهر عادي. */
body .app-sidebar .side-menu__item .side-menu__label,
html body .app-sidebar .side-menu__item .side-menu__label,
body.icontext-menu .app-sidebar .side-menu__item .side-menu__label,
body.closed-menu .app-sidebar .side-menu__item .side-menu__label,
body.sidenav-toggled .app-sidebar .side-menu__item .side-menu__label,
body.mini-sidebar .app-sidebar .side-menu__item .side-menu__label {
    display: inline-block !important;
    opacity: 1 !important;
    visibility: visible !important;
    width: auto !important;
    max-width: none !important;
    position: static !important;
    color: #e2e8f0 !important;
    background: transparent !important;
    font-size: 13.5px !important;
}

/* احتياط إضافي: لو فيه أي عنصر تاني (زي شريط تحميل placeholder) راكب فوق التسمية
   ومغطّيها، الكود ده بيخليه بايظ/شفاف بدل ما يغطي النص */
.app-sidebar .side-menu__item .side-menu__label::before,
.app-sidebar .side-menu__item .side-menu__label::after {
    content: none !important;
    background: none !important;
}

/* [تم الإصلاح] الشاشة دي ماكانتش متجاوبة (Responsive) مع شاشات الموبايل - العناصر كانت بتتزنق
   أو بتخرج بره حدود الشاشة. الكود ده بيظبط العرض على الشاشات الصغيرة (تابلت وموبايل). */
@media (max-width: 991px) {
    .breadcrumb-header, .main-parent > .breadcrumb-header {
        flex-wrap: wrap !important;
        row-gap: 10px;
    }
    .card-header form .row, .card-header .row {
        row-gap: 10px;
    }
    .row > [class*="col-"] {
        margin-bottom: 10px;
    }
}
@media (max-width: 767px) {
    .content-title { font-size: 16px !important; }
    .card-header { padding: 14px !important; }
    .btn, .button-eng {
        width: 100% !important;
        justify-content: center !important;
        margin-bottom: 8px;
    }
    .d-flex.justify-content-center, .d-flex.justify-content-end, .d-flex.justify-content-between {
        flex-wrap: wrap !important;
        row-gap: 10px;
        justify-content: center !important;
    }
    center > form, center {
        width: 100%;
    }
    button[style*="width"], a[style*="width"] {
        width: 100% !important;
        max-width: 100% !important;
        margin-bottom: 8px;
    }
    .modal-dialog, .modal-special {
        max-width: 94vw !important;
        width: 94vw !important;
        margin: 6vh auto !important;
    }
    table.our-table, table.table {
        font-size: 11.5px !important;
    }
    table.our-table thead th, table.table thead th {
        padding: 8px 6px !important;
        font-size: 11px !important;
    }
    table.our-table tbody td, table.table tbody td {
        padding: 6px !important;
    }
    .form-control, input, select.select2, textarea {
        font-size: 16px !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        font-size: 14px !important;
    }
}
</style>

{{-- =========================================================
     BULLETPROOF LOCALE-BASED DIRECTION & LAYOUT POSITIONING
     ========================================================= --}}
@if (App::getLocale() == 'ar')
<style>
.app-sidebar,
.app-sidebar.sidebar-scroll,
html body .app-sidebar {
    right: 0 !important;
    left: auto !important;
    border-left: 1px solid rgba(255, 255, 255, 0.08) !important;
    border-right: none !important;
}
@media (min-width: 768px) {
    .app-content,
    body .app-content,
    .main-content.app-content {
        margin-right: 245px !important;
        margin-left: 0 !important;
    }
}
@media (max-width: 991px) {
    .app-sidebar {
        transform: translateX(100%);
        transition: transform .25s ease;
    }
}
</style>
@else
<style>
.app-sidebar,
.app-sidebar.sidebar-scroll,
html body .app-sidebar {
    left: 0 !important;
    right: auto !important;
    border-right: 1px solid rgba(255, 255, 255, 0.08) !important;
    border-left: none !important;
}
@media (min-width: 768px) {
    .app-content,
    body .app-content,
    .main-content.app-content {
        margin-left: 245px !important;
        margin-right: 0 !important;
    }
}
@media (max-width: 991px) {
    .app-sidebar {
        transform: translateX(-100%);
        transition: transform .25s ease;
    }
}
</style>
@endif

<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">

    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="https://ebdeasoft.com/">
            <img src="{{ URL::asset('assets/img/brand/logo.png') }}" class="main-logo" alt="{{ config('app.name') }}">
        </a>
        <a class="desktop-logo logo-dark active" href="https://ebdeasoft.com/">
            <img src="{{ URL::asset('assets/img/brand/logo-white.png') }}" class="main-logo dark-theme" alt="{{ config('app.name') }}">
        </a>
        <a class="logo-icon mobile-logo icon-light active" href="https://ebdeasoft.com/">
            <img src="{{ URL::asset('assets/img/brand/favicon.png') }}" class="logo-icon" alt="{{ config('app.name') }}">
        </a>
        <a class="logo-icon mobile-logo icon-dark active" href="https://ebdeasoft.com/">
            <img src="{{ URL::asset('assets/img/brand/favicon-white.png') }}" class="logo-icon dark-theme" alt="{{ config('app.name') }}">
        </a>
    </div>

    <div class="main-sidemenu">

        {{-- ============== USER CARD + LANGUAGE SWITCH ============== --}}
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <img alt="user-img" class="avatar avatar-xl brround"
                    src="{{ Auth::user()->profile_photo_path ? URL::asset('storage/' . Auth::user()->profile_photo_path) : URL::asset('assets/img/faces/6.jpg') }}">
                <div class="user-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <span>{{ Auth::user()->email }}</span>
                </div>
            </div>

            {{-- Segmented Language Toggle Pill --}}
            <div class="sb-lang-switch">
                <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"
                   class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}">
                   العربية
                </a>
                <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}"
                   class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">
                   English
                </a>
            </div>
        </div>

        <ul class="side-menu">

            {{-- ============== HOME ============== --}}
            @can('Home')
            <li class="slide {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="side-menu__item" href="{{ url('/dashboard') }}">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <path d="M543.8 287.6c17 0 32-14 32-32.1c1-9-3-17-11-24L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1h32V448c0 35.3 28.7 64 64 64H480c35.3 0 64-28.7 64-64V287.6h-.2z"/>
                    </svg>
                    <span class="side-menu__label">{{ __('home.home') }}</span>
                </a>
            </li>
            @endcan

            {{-- ============== REAL ESTATE OPERATIONS ============== --}}
            <div class="side-menu__eyebrow">{{ __('realestate.property_management') }}</div>

            @can('Properties')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 576 512" fill="currentColor">
                        <path d="M575.8 255.5C575.8 273.5 561.8 287.5 543.8 287.5H511.8V448.5C511.8 483.6 483.4 512 448.4 512H96.38C61.31 512 32.38 483.6 32.38 448.5V287.5H.375C-17.62 287.5-31.62 273.5-31.62 255.5C-31.62 246.5-27.62 238.5-21.62 232.5L256.4 0L534.8 232.5C541.8 238.5 575.8 246.5 575.8 255.5zM288 88.5L96.38 248.5V448.5H160V352C160 334.3 174.3 320 192 320H384C401.7 320 416 334.3 416 352V448.5H481.6V248.5L288 88.5z"/>
                    </svg>
                    <span class="side-menu__label">{{ __('realestate.properties') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('Property Control')
                    <li><a class="slide-item" href="{{ route('properties.control.default') }}"><i class="bx bx-tachometer"></i>{{ __('realestate.property_control') }}</a></li>
                    @endcan
                    @can('Show properties')
                    <li><a class="slide-item" href="{{ route('properties.index') }}"><i class="bx bx-building-house"></i>{{ __('realestate.properties') }}</a></li>
                    @endcan
                    @can('Add new property')
                    <li><a class="slide-item" href="{{ route('properties.create') }}"><i class="bx bx-plus-circle"></i>{{ __('realestate.add_property') }}</a></li>
                    @endcan
                    @can('Show units')
                    <li><a class="slide-item" href="{{ route('units.index') }}"><i class="bx bx-grid-alt"></i>{{ __('realestate.units') }}</a></li>
                    @endcan
                    @can('Add new unit')
                    <li><a class="slide-item" href="{{ route('units.create') }}"><i class="bx bx-plus-circle"></i>{{ __('realestate.add_unit') }}</a></li>
                    @endcan
                    @can('Unit types')
                    <li><a class="slide-item" href="{{ route('unit-types.index') }}"><i class="bx bx-category"></i>{{ __('unit_types.title') }}</a></li>
                    @endcan
                    @can('Show owners')
                    <li><a class="slide-item" href="{{ route('owners.index') }}"><i class="bx bx-user"></i>{{ __('realestate.owners') }}</a></li>
                    @endcan
                    @can('Add new owner')
                    <li><a class="slide-item" href="{{ route('owners.create') }}"><i class="bx bx-plus-circle"></i>{{ __('realestate.add_owner') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('Tenants Management')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-users side-menu__icon"></i>
                    <span class="side-menu__label">{{ __('realestate.tenants_management') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('Show tenants')
                    <li><a class="slide-item" href="{{ route('tenants.index') }}"><i class="bx bx-list-ul"></i>{{ __('realestate.tenants') }}</a></li>
                    @endcan
                    @can('Add new tenant')
                    <li><a class="slide-item" href="{{ route('tenants.create') }}"><i class="bx bx-plus-circle"></i>{{ __('realestate.add_tenant') }}</a></li>
                    @endcan
                    @can('Payments management')
                    <li><a class="slide-item" href="{{ route('payments.index') }}"><i class="fa-solid fa-money-bill-wave"></i>{{ __('realestate.payments_management') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            @canany(['Properties', 'Show properties', 'Tenants Management'])
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-clipboard-list side-menu__icon"></i>
                    <span class="side-menu__label">{{ __('realestate.property_requests') }}</span>
                    @php
                        $pendingRequestsCount = \App\Models\PropertyRequest::where('status', 'pending')->count();
                    @endphp
                    @if($pendingRequestsCount > 0)
                        <span class="badge badge-warning ml-auto text-dark font-weight-bold" style="font-size: 11px;">{{ $pendingRequestsCount }}</span>
                    @endif
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li><a class="slide-item" href="{{ route('property-requests.index') }}"><i class="bx bx-list-ul"></i>{{ __('realestate.property_requests_list') }}</a></li>
                    <li><a class="slide-item" href="{{ route('property-requests.create') }}"><i class="bx bx-plus-circle"></i>{{ __('realestate.add_property_request') }}</a></li>
                </ul>
            </li>
            @endcanany

            @can('Lease Contracts')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-file-contract side-menu__icon"></i>
                    <span class="side-menu__label">{{ __('realestate.contract_management') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('Show lease contracts')
                    <li><a class="slide-item" href="{{ route('lease_contracts.index') }}"><i class="bx bx-list-ul"></i>{{ __('realestate.contracts') }}</a></li>
                    @endcan
                    @can('Create lease contract')
                    <li><a class="slide-item" href="{{ route('lease_contracts.create') }}"><i class="bx bx-plus-circle"></i>{{ __('realestate.create_contract') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('Property Expenses')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 512 512" fill="currentColor">
                        <path d="M501.1 395.7L384 278.6c-23.1-23.1-57.6-27.6-85.4-13.9L192 158.1V96L64 0 0 64l96 128h62.1l106.6 106.6c-13.6 27.8-9.2 62.3 13.9 85.4l117.1 117.1c14.6 14.6 38.2 14.6 52.7 0l52.7-52.7c14.6-14.6 14.6-38.2 0-52.7z"/>
                    </svg>
                    <span class="side-menu__label">{{ __('realestate.enter_maintenance_expenses') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('Enter maintenance expenses')
                    <li><a class="slide-item" href="{{ route('property_expenses.create') }}"><i class="bx bx-receipt"></i>{{ __('realestate.enter_maintenance_expenses') }}</a></li>
                    @endcan
                    @can('Property expense report')
                    <li><a class="slide-item" href="{{ route('property_expenses.report') }}"><i class="bx bx-file"></i>{{ __('realestate.expense_report') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            {{-- ============== SALES ============== --}}
            <div class="side-menu__eyebrow">{{ __('home.sales') }}</div>
            @can('Sales')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21,5c-1.11-0.35-2.33-0.5-3.5-0.5c-1.95,0-4.05,0.4-5.5,1.5c-1.45-1.1-3.55-1.5-5.5-1.5S2.45,4.9,1,6v14.65c0,0.25,0.25,0.5,0.5,0.5c0.1,0,0.15-0.05,0.25-0.05C3.1,20.45,5.05,20,6.5,20c1.95,0,4.05,0.4,5.5,1.5c1.35-0.85,3.8-1.5,5.5-1.5c1.65,0,3.35,0.3,4.75,1.05c0.1,0.05,0.15,0.05,0.25,0.05c0.25,0,0.5-0.25,0.5-0.5V6C22.4,5.55,21.75,5.25,21,5z"/>
                    </svg>
                    <span class="side-menu__label">{{ __('home.sales') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('Sales products')
                    <li><a class="slide-item" href="{{ url('/goToSale') }}">{{ __('home.sales') }}</a></li>
                    @endcan
                    @can('sales return')
                    <li><a class="slide-item" href="{{ url('/return_sale') }}">{{ __('home.salesـreturned') }}</a></li>
                    @endcan
                    @can('Previous sales invoices')
                    <li><a class="slide-item" href="{{ url('/previousSalesInvoices') }}">{{ __('home.previousSalesInvoices') }}</a></li>
                    @endcan
                    @can('Pending sales invoices')
                    <li><a class="slide-item" href="{{ url('/pending_invoice_previes') }}">{{ __('home.pending_invoice_previes') }}</a></li>
                    @endcan
                    @can('Sent sales invoices')
                    <li><a class="slide-item" href="{{ url('/previousSales_sended_Invoices') }}">{{ __('home.previousSales_sended_Invoices') }}</a></li>
                    @endcan
                    @can('Not sent sales invoices')
                    <li><a class="slide-item" href="{{ url('/previousSales_not_sended_Invoices') }}">{{ __('home.previousSales_not_sended_Invoices') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            {{-- ============== ACCOUNTING ============== --}}
            <div class="side-menu__eyebrow">{{ __('home.accounting') }}</div>
            @can('Accounts')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 384 512" fill="currentColor">
                        <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64zM96 64H288c17.7 0 32 14.3 32 32v32c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V96c0-17.7 14.3-32 32-32z"/>
                    </svg>
                    <span class="side-menu__label">{{ __('home.accounting') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('Account type')
                    <li><a class="slide-item" href="{{ url('/account_type') }}">{{ __('home.account_type') }}</a></li>
                    @endcan
                    @can('enpenses_reason')
                    <li><a class="slide-item" href="{{ url('/expenses_reason') }}">{{ __('report.enpenses_reason') }}</a></li>
                    @endcan
                    @can('Opening entry')
                    <li><a class="slide-item" href="{{ url('/Opening_entry') }}">{{ __('home.Opening_entry') }}</a></li>
                    @endcan
                    @can('Daily record')
                    <li><a class="slide-item" href="{{ url('/Daily_record') }}">{{ __('home.Daily_record') }}</a></li>
                    @endcan
                    @can('Voucher')
                    <li><a class="slide-item" href="{{ url('/voncher') }}">{{ __('home.voucher') }}</a></li>
                    @endcan
                    @can('Receipt document')
                    <li><a class="slide-item" href="{{ url('/reciept_decoument') }}">{{ __('home.Receipt document') }}</a></li>
                    @endcan
                    @can('Add new account')
                    <li><a class="slide-item" href="{{ url('/create_acount') }}">{{ __('home.add_new_account') }}</a></li>
                    @endcan
                    @can('Account tree')
                    <li><a class="slide-item" href="{{ url('/tree') }}">{{ __('home.tree') }}</a></li>
                    @endcan
                    @can('Transfer to main branch')
                    <li><a class="slide-item" href="{{ url('/Transfertomainbranch') }}">{{ __('home.transferMainBranch') }}</a></li>
                    @endcan
                    @can('Confirm transfer of master branch')
                    <li><a class="slide-item" href="{{ url('/confirmTransfertomainbranch') }}">{{ __('home.confirmtransferMainBranch') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            {{-- ============== REPORTS ============== --}}
            <div class="side-menu__eyebrow">{{ __('home.reports') }}</div>
            @can('Reports')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="javascript:void(0);">
                    <i class="fe fe-bar-chart-2 side-menu__icon"></i>
                    <span class="side-menu__label">{{ __('home.reports') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">

                    @can('Accounts Reports Section')
                    <li class="slide">
                        <a class="sub-side-menu__item" data-toggle="slide" href="javascript:void(0);">
                            <span class="sub-side-menu__label">{{ __('home.accounting') }}</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            @can('Daily transactions sheet')
                            <li><a class="slide-item" href="{{ url('budgetsheet') }}">{{ __('home.transction_day') }}</a></li>
                            @endcan
                            @can('Transfer cash next day')
                            <li><a class="slide-item" href="{{ url('TransFerCashTothenNextDay') }}">{{ __('home.Transfer cash to the next day') }}</a></li>
                            @endcan
                            @can('Credit collection report')
                            <li><a class="slide-item" href="{{ url('credit_collection') }}">{{ __('report.creditcollection') }}</a></li>
                            @endcan
                            @can('Supplier credit payment report')
                            <li><a class="slide-item" href="{{ url('Supplier_credit_payment') }}">{{ __('report.Supplier credit payment') }}</a></li>
                            @endcan
                            @can('Supplier debt restructuring')
                            <li><a class="slide-item" href="{{ url('Supplier_debt_restructuring') }}">{{ __('home.Supplier_debt_restructuring') }}</a></li>
                            @endcan
                            @can('Customer debt restructuring')
                            <li><a class="slide-item" href="{{ url('Customer_debt_restructuring') }}">{{ __('home.Customer_debt_restructuring') }}</a></li>
                            @endcan
                            @can('Cost center report')
                            <li><a class="slide-item" href="{{ url('cost_center') }}">{{ __('home.cost_center') }}</a></li>
                            @endcan
                            @can('Account statement report')
                            <li><a class="slide-item" href="{{ url('account_statement') }}">{{ __('home.account_statement') }}</a></li>
                            @endcan
                            @can('Daily record report')
                            <li><a class="slide-item" href="{{ url('Daily_record_report') }}">{{ __('home.Daily_record') }}</a></li>
                            @endcan
                            @can('Transactions to master branch report')
                            <li><a class="slide-item" href="{{ url('transactionsToMasterBranch') }}">{{ __('home.transactionsToMasterBranch') }}</a></li>
                            @endcan
                            @can('Expenses report')
                            <li><a class="slide-item" href="{{ url('Expensesreport') }}">{{ __('report.Expenses') }}</a></li>
                            @endcan
                            @can('List of customers')
                            <li><a class="slide-item" href="{{ url('/Customerlist') }}">{{ __('home.customer_supplier_account') }}</a></li>
                            @endcan
                            @can('VAT report')
                            <li><a class="slide-item" href="{{ url('VAT') }}">{{ __('report.VAT') }}</a></li>
                            @endcan
                            @can('Financial accounts')
                            <li><a class="slide-item" href="{{ url('/financial_accounts') }}">{{ __('home.Financial_accounts') }}</a></li>
                            @endcan
                            @can('Financial accounts')
                            <li><a class="slide-item" href="{{ url('/general_budget') }}">{{ __('home.general_budget') }}</a></li>
                            @endcan
                            @can('Financial accounts')
                            <li><a class="slide-item" href="{{ url('/Statement_of_Changes_in_Equity_Report') }}">{{ __('home.Statement_of_Changes_in_Equity_Report') }}</a></li>
                            @endcan
                            @can('Financial accounts')
                            <li><a class="slide-item" href="{{ url('/cashFlowStatement') }}">{{ __('home.cashFlowStatement') }}</a></li>
                            @endcan
                            @can('Profit and lost report')
                            <li><a class="slide-item" href="{{ url('profit_and_lost') }}">{{ __('home.profit_and_lost') }}</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                    @can('Properties Reports Section')
                    <li class="slide">
                        <a class="sub-side-menu__item" data-toggle="slide" href="javascript:void(0);">
                            <span class="sub-side-menu__label">{{ __('realestate.properties') }}</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('property_expenses.report') }}">{{ __('realestate.expense_report') }}</a></li>
                            <li><a class="slide-item" href="{{ route('properties.control.default') }}">{{ __('realestate.properties') }}</a></li>
                            <li><a class="slide-item" href="{{ route('reports.net_revenue') }}">{{ __('realestate.net_revenue_report') }}</a></li>
                            <li><a class="slide-item" href="{{ route('units.index') }}">{{ __('realestate.units') }}</a></li>
                            <li><a class="slide-item" href="{{ route('owners.index') }}">{{ __('realestate.owners') }}</a></li>
                            <li><a class="slide-item" href="{{ route('report.delayed_installments') }}">{{ __('report.delayed_installments_report') }}</a></li>
                            <li><a class="slide-item" href="{{ route('report.expiring_contracts') }}">{{ __('contracts.expiring_contracts_report') }}</a></li>
                            <li><a class="slide-item" href="{{ route('report.units_status') }}">{{ __('report.units_status_report') }}</a></li>
                        </ul>
                    </li>
                    @endcan

                    @can('Sales report')
                    <li class="slide">
                        <a class="sub-side-menu__item" data-toggle="slide" href="javascript:void(0);">
                            <span class="sub-side-menu__label">{{ __('home.sales') }}</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            @can('Sales product by date report')
                            <li><a class="slide-item" href="{{ url('sales_product_by_date') }}">{{ __('home.sales_product_by_date') }}</a></li>
                            @endcan
                            @can('Year sales report')
                            <li><a class="slide-item" href="{{ url('year_sales_report') }}">{{ __('home.year_sales_report') }}</a></li>
                            @endcan
                            @can('History of product sales report')
                            <li><a class="slide-item" href="{{ url('salesReport') }}">{{ __('home.Historyـofـproductـsales') }}</a></li>
                            @endcan
                            @can('Sales return report')
                            <li><a class="slide-item" href="{{ url('report_returns_sale') }}">{{ __('report.report_returns_sale') }}</a></li>
                            @endcan
                            @can('Customer purchases report')
                            <li><a class="slide-item" href="{{ url('customerـpurchases') }}">{{ __('report.customerـpurchases') }}</a></li>
                            @endcan
                            @can('Purchase product to customer report')
                            <li><a class="slide-item" href="{{ url('purchasproducttocustomer') }}">{{ __('report.purchasproducttocustomer') }}</a></li>
                            @endcan
                            @can('Product sales report')
                            <li><a class="slide-item" href="{{ url('product_sales') }}">{{ __('report.product_sales') }}</a></li>
                            @endcan
                            @can('Best selling product report')
                            <li><a class="slide-item" href="{{ url('Best_selling_products') }}">{{ __('report.Best selling products') }}</a></li>
                            @endcan
                            @can('Employee sales report')
                            <li><a class="slide-item" href="{{ url('employeeـsales') }}">{{ __('report.employeeـsales') }}</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcan

            {{-- ============== ZAKAT LINKAGE ============== --}}
            @can('Zakat Linkage Section')

            <div class="side-menu__eyebrow">{{ __('home.ZATCA_Platform') }}</div>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 576 512" fill="currentColor">
                        <path d="M248 0H208c-26.5 0-48 21.5-48 48V160c0 35.3 28.7 64 64 64H352c35.3 0 64-28.7 64-64V48c0-26.5-21.5-48-48-48H328V80c0 8.8-7.2 16-16 16H264c-8.8 0-16-7.2-16-16V0z"/>
                    </svg>
                    <span class="side-menu__label">{{ __('home.Linkage_with_zakat') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('Zakat Onboarding Privilege')
                    <li><a class="slide-item" href="{{ url('/onbourding') }}"><i class="bx bx-slider-alt"></i>{{ __('home.onbourding') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            {{-- ============== ADMINISTRATION ============== --}}
            @can('User and branches')

            <div class="side-menu__eyebrow">{{ __('home.users') }}</div>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 640 512" fill="currentColor">
                        <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0z"/>
                    </svg>
                    <span class="side-menu__label">{{ __('home.users') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('add branch')
                    <li><a class="slide-item" href="{{ url('/showallBranchs') }}">{{ __('report.allBranches') }}</a></li>
                    <li><a class="slide-item" href="{{ url('/wherehouse') }}">{{ __('home.wherehouse') }}</a></li>
                    @endcan
                    @can('List of users')
                    <li><a class="slide-item" href="{{ url('/users') }}">{{ __('users.usersList') }}</a></li>
                    @endcan
                    @can('Users permissions')
                    <li><a class="slide-item" href="{{ url('/roles') }}">{{ __('users.Userـpermissions') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('Human Resource')

            <div class="side-menu__eyebrow">{{ __('home.Human Resource Management') }}</div>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 640 512" fill="currentColor">
                        <path d="M335.5 4l288 160c15.4 8.6 21 28.1 12.4 43.5s-28.1 21-43.5 12.4L320 68.6 47.5 220c-15.4 8.6-34.9 3-43.5-12.4s-3-34.9 12.4-43.5L304.5 4c9.7-5.4 21.4-5.4 31.1 0z"/>
                    </svg>
                    <span class="side-menu__label">{{ __('home.Human Resource Management') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('Contracts')
                    <li><a class="slide-item" href="{{ route('contracts.index') }}">{{ __('hr.contracts_management') }}</a></li>
                    @endcan
                    <li><a class="slide-item" href="{{ route('hr-settings.index') }}">{{ __('hr.hr_settings') }}</a></li>
                    @can('Employee')
                    <li><a class="slide-item" href="{{ url('/allEmployees') }}">{{ __('hr.show_employees') }}</a></li>
                    @endcan
                    @can('Add new employee')
                    <li><a class="slide-item" href="{{ url('/createNewEmployee') }}">{{ __('hr.add_new_employee') }}</a></li>
                    @endcan
                    @can('create a department')
                    <li><a class="slide-item" href="{{ url('/addnewDepartment') }}">{{ __('hr.createdepartment') }}</a></li>
                    @endcan
                    @can('Increase or deduction')
                    <li><a class="slide-item" href="{{ url('/Increaseـor_deduction') }}">{{ __('hr.Increaseـor deductionـforـtheـemployee') }}</a></li>
                    @endcan
                    @can('Employee loans privilege')
                    <li><a class="slide-item" href="{{ url('/Loans') }}">{{ __('home.Loans') }}</a></li>
                    @endcan
                    @can('Salary document')
                    <li><a class="slide-item" href="{{ url('/salarydecoument') }}">{{ __('hr.salarydecoument') }}</a></li>
                    @endcan
                    @can('Attendances')
                    <li><a class="slide-item" href="{{ url('/attendances') }}">{{ __('hr.attendances_log') }}</a></li>
                    @endcan
                    @can('Leaves')
                    <li><a class="slide-item" href="{{ url('/leaves') }}">{{ __('hr.employee_leaves') }}</a></li>
                    <li><a class="slide-item" href="{{ route('leaves.balance_report') }}">{{ __('leaves.balance_report_title') }}</a></li>
                    @endcan
                    @can('End of Service')
                    <li><a class="slide-item" href="{{ route('eos.index') }}">{{ __('hr.eos_title') }}</a></li>
                    @endcan
                    @can('Custody and Assets')
                    <li><a class="slide-item" href="{{ route('custodies.index') }}">{{ __('hr.custody_and_assets') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('Settings Section')

            <div class="side-menu__eyebrow">{{ __('home.setting') }}</div>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 640 512" fill="currentColor">
                        <path d="M308.5 135.3c7.1-6.3 9.9-16.2 6.2-25c-2.3-5.3-4.8-10.5-7.6-15.5L304 89.4c-3-5-6.3-9.9-9.8-14.6c-5.7-7.6-15.7-10.1-24.7-7.1l-28.2 9.3c-10.7-8.8-23-16-36.2-20.9L199 27.1c-1.9-9.3-9.1-16.7-18.5-17.8C173.9 8.4 167.2 8 160.4 8h-.7c-6.8 0-13.5 .4-20.1 1.2z"/>
                    </svg>
                    <span class="side-menu__label">{{ __('home.setting') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li><a class="slide-item" href="{{ url('/profile') }}"><i class="bx bx-slider-alt"></i>{{ __('auth.setting') }}</a></li>
                    @can('AVT Control')
                    <li><a class="slide-item" href="{{ url('/avt') }}"><i class="bx bx-slider-alt"></i>{{ __('home.AVTSHOW') }}</a></li>
                    @endcan
                    @can('System setting')
                    <li><a class="slide-item" href="{{ url('/systemSetting') }}"><i class="bx bx-slider-alt"></i>{{ __('home.systemSetting') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcan

            {{-- ============== SUPPORT ============== --}}
            @can('Technical support')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 512 512" fill="currentColor">
                        <path d="M256 48C141.1 48 48 141.1 48 256v40c0 13.3-10.7 24-24 24s-24-10.7-24-24V256C0 114.6 114.6 0 256 0S512 114.6 512 256V400.1c0 48.6-39.4 88-88.1 88L313.6 488c-8.3 14.3-23.8 24-41.6 24H240c-26.5 0-48-21.5-48-48s21.5-48 48-48h32c17.8 0 33.3 9.7 41.6 24l110.4 .1c22.1 0 40-17.9 40-40V256c0-114.9-93.1-208-208-208z"/>
                    </svg>
                    <span class="side-menu__label">{{ __('home.For communication and technical support') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="https://ebdeasoft.com/" target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-globe"></i>{{ __('home.connectwithebdeasoft') }}
                        </a>
                    </li>
                    <li>
                        <a class="slide-item" target="_blank" rel="noopener noreferrer"
                           href="https://api.whatsapp.com/send/?phone=966534544615&text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85+%D8%B9%D9%84%D9%8A%D9%83%D9%85+...+%D8%A3%D8%B1%D8%BA%D8%A8+%D8%A8%D8%AE%D8%AF%D9%85%D8%A9+%D8%AA%D8%B3%D9%88%D9%8A%D9%82+%D8%A7%D9%84%D9%86%D8%B4%D8%A7%D8%B7+%D8%A7%D9%84%D8%AA%D8%AC%D8%A7%D8%B1%D9%8A">
                            <i class="fab fa-whatsapp" style="color:#25D366;"></i>{{ __('home.whatsappcontact') }}
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            <div class="sb-divider"></div>

            {{-- ============== LOGOUT ============== --}}
            <li class="slide">
                <a class="side-menu__item sb-logout" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bx bx-log-out side-menu__icon"></i>
                    <span class="side-menu__label">{{ __('home.logout') }}</span>
                </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </ul>
    </div>
</aside>
<!-- /main-sidebar -->