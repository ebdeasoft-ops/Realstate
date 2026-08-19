<style>
/* =====================================================================
   EBDEA SOFT — Sidebar Design Tokens (Corporate / Trust identity)
   Navy + Steel Blue + Slate, built for a Real Estate ERP
   ===================================================================== */
:root{
    --sb-navy-950:      #0B1B33;
    --sb-navy-900:      #102A4C;
    --sb-navy-800:      #16375F;
    --sb-blue-600:      #2F6FED;
    --sb-blue-500:      #4C8DFF;
    --sb-slate-300:     #B9C4D6;
    --sb-slate-400:     #8CA0BD;
    --sb-slate-500:     #6B7FA0;
    --sb-line:          rgba(255,255,255,.08);
    --sb-line-soft:     rgba(255,255,255,.05);
    --sb-white:         #F5F8FC;
    --sb-danger:        #EF5A6F;
    --sb-radius:        10px;
    --sb-width:         260px;
    --sb-font:          'IBM Plex Sans Arabic','Cairo','Segoe UI',system-ui,sans-serif;
}

/* ---- shell ---------------------------------------------------------- */
.app-sidebar,
.app-sidebar.sidebar-scroll,
html body .app-sidebar{
    position: fixed;
    top: 0; bottom: 0;
    inset-inline-end: 0;              /* RTL/LTR aware: right in RTL, left in LTR */
    width: var(--sb-width);
    height: 100vh !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    z-index: 1000;
    background: linear-gradient(180deg, var(--sb-navy-950) 0%, var(--sb-navy-900) 100%) !important;
    border-inline-start: 1px solid var(--sb-line);
    font-family: var(--sb-font);
    box-shadow: 0 0 40px rgba(0,0,0,.25);
}

/* the base theme wraps everything in .main-sidemenu — force it transparent
   so the gradient above always shows through, no matter what the theme's
   own stylesheet sets on it */
.app-sidebar .main-sidemenu,
.app-sidebar .main-sidemenu > div{
    background: transparent !important;
}

.app-sidebar::-webkit-scrollbar{ width: 5px; }
.app-sidebar::-webkit-scrollbar-thumb{ background: var(--sb-navy-800); border-radius: 10px; }
.app-sidebar::-webkit-scrollbar-track{ background: transparent; }

.app-sidebar .slide.is-expanded > .slide-menu{ display: block !important; }

/* ---- header / brand -------------------------------------------------- */
.app-sidebar .main-sidebar-header{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 68px;
    border-bottom: 1px solid var(--sb-line);
    background: var(--sb-navy-950) !important;
}
.app-sidebar .main-sidebar-header .main-logo{ max-height: 36px; }
.app-sidebar .main-sidebar-header .logo-icon{ max-height: 30px; }

/* ---- user card --------------------------------------------------------*/
.app-sidebar .app-sidebar__user{
    padding: 18px 20px;
    border-bottom: 1px solid var(--sb-line);
    background: transparent !important;
}
.app-sidebar .app-sidebar__user .dropdown,
.app-sidebar .app-sidebar__user .user-pro-body{
    background: transparent !important;
    display: flex;
    align-items: center;
    gap: 12px;
}
.app-sidebar .app-sidebar__user .avatar{
    width: 44px; height: 44px;
    border-radius: 50% !important;
    object-fit: cover !important;
    border: 2px solid var(--sb-blue-600);
}
.app-sidebar .app-sidebar__user .user-info{ background: transparent !important; }
.app-sidebar .app-sidebar__user .user-info h4{
    color: var(--sb-white) !important;
    font-size: 14px;
    font-weight: 600;
    margin: 0;
}
.app-sidebar .app-sidebar__user .user-info span{
    color: var(--sb-slate-400) !important;
    font-size: 12px;
}

/* language switch pill inside the user card */
.app-sidebar .sb-lang-switch{
    display: flex !important;
    width: 100% !important;
    margin-top: 12px !important;
    background: var(--sb-navy-800) !important;
    border-radius: 999px !important;
    padding: 3px !important;
    gap: 3px !important;
}
.app-sidebar .sb-lang-switch a{
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex: 1 1 0% !important;
    text-align: center !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    padding: 6px 4px !important;
    border-radius: 999px !important;
    color: var(--sb-slate-300) !important;
    text-decoration: none !important;
    transition: background .15s ease, color .15s ease;
}
.app-sidebar .sb-lang-switch a.active{
    background: var(--sb-blue-600) !important;
    color: #fff !important;
}

/* ---- menu ------------------------------------------------------------ */
.app-sidebar .side-menu,
.app-sidebar ul.side-menu{ list-style: none; margin: 0; padding: 10px 12px 24px; background: transparent !important; }

.app-sidebar .side-menu__item{
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 12px;
    margin: 2px 0;
    border-radius: var(--sb-radius);
    color: var(--sb-slate-300) !important;
    font-size: 13.5px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    background: transparent !important;
    transition: background .15s ease, color .15s ease;
}
.side-menu__item:hover{
    background: var(--sb-line-soft);
    color: var(--sb-white);
}
.side-menu__icon{
    width: 18px; height: 18px;
    flex-shrink: 0;
    color: var(--sb-slate-400);
    fill: currentColor;
    transition: color .15s ease;
}
.side-menu__item:hover .side-menu__icon{ color: var(--sb-blue-500); }

.side-menu__label{ flex: 1; }

.angle{
    font-size: 11px;
    color: var(--sb-slate-500);
    transition: transform .2s ease;
}
.slide.is-expanded > .side-menu__item .angle{ transform: rotate(180deg); }

/* active state (server should add .active on current route's <li class="slide">) */
.slide.active > .side-menu__item,
.slide-item.active{
    background: var(--sb-blue-600);
    color: var(--sb-white) !important;
}
.slide.active > .side-menu__item .side-menu__icon{ color: var(--sb-white); }

/* section eyebrow labels — encode grouping, not decoration */
.side-menu__eyebrow{
    padding: 16px 14px 6px;
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: var(--sb-slate-500);
}
.side-menu__eyebrow:first-child{ padding-top: 6px; }

/* sub menu */
.slide-menu{
    list-style: none;
    margin: 2px 0 6px;
    padding-inline-start: 14px;
    border-inline-start: 1px solid var(--sb-line);
    margin-inline-start: 24px;
}
.slide-menu .slide-item{
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    border-radius: 8px;
    font-size: 13px;
    color: var(--sb-slate-400);
    text-decoration: none;
    transition: background .15s ease, color .15s ease;
}
.slide-menu .slide-item:hover{
    background: var(--sb-line-soft);
    color: var(--sb-white);
}
.slide-menu .slide-item i,
.slide-menu .slide-item svg{
    width: 15px;
    font-size: 13px;
    color: var(--sb-slate-500);
}

/* nested (level-2) sub menu, e.g. reports groups */
.sub-side-menu__item{
    display: flex;
    align-items: center;
    padding: 9px 12px;
    font-size: 13px;
    font-weight: 600;
    color: var(--sb-slate-300);
    text-decoration: none;
    cursor: pointer;
}
.sub-side-menu__label{ flex: 1; }
.slide-menu .slide-menu{ margin-inline-start: 12px; }

/* logout — visually distinct, always at reach */
.side-menu__item.sb-logout{ color: var(--sb-danger); }
.side-menu__item.sb-logout .side-menu__icon{ color: var(--sb-danger); }
.side-menu__item.sb-logout:hover{ background: rgba(239,90,111,.12); }

/* divider */
.sb-divider{
    height: 1px;
    background: var(--sb-line);
    margin: 10px 14px;
}

@media (max-width: 991px){
    .app-sidebar{ transform: translateX(100%); transition: transform .25s ease; }
    [dir="ltr"] .app-sidebar{ transform: translateX(-100%); }
    .app-sidebar.sidebar-open{ transform: translateX(0); }
}
</style>

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

            {{-- Localization switch — swaps the /ar/ or /en/ prefix on the current URL,
                 matching the existing App\Http\Middleware\SetLocale prefix-based setup.
                 No extra named route needed. --}}
            @php
                $sbCurrentPath = request()->path();               // e.g. "ar/dashboard"
                $sbSegments    = explode('/', $sbCurrentPath);
                $sbRest        = implode('/', array_slice($sbSegments, 1)); // path without the locale segment
            @endphp
            <div class="sb-lang-switch">
                <a href="{{ url('ar/' . $sbRest) }}" class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}">العربية</a>
                <a href="{{ url('en/' . $sbRest) }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">English</a>
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