@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink:        #1f2a24;
            --paper:      #fdfbf5;
            --emerald:    #0b3d2e;
            --emerald-2:  #0f4f3b;
            --gold:       #b08d4f;
            --gold-tint:  #f6efdf;
            --mist:       #eef3f0;
            --muted:      #7a8a80;
            --line:       #d8cead;
        }

        body { background: #e9e5da; }

        .contract-wrap {
            font-family: 'Tajawal', Arial, sans-serif;
            color: var(--ink);
        }

        /* -------- الإطار الخارجي (ورقة رسمية) -------- */
        .contract-sheet {
            position: relative;
            background: var(--paper);
            padding: 6px;
            border-radius: 4px;
            box-shadow: 0 4px 28px rgba(11, 61, 46, 0.12);
        }
        .contract-inner {
            position: relative;
            border: 1.5px solid var(--emerald);
            outline: 1px solid var(--gold);
            outline-offset: -6px;
            padding: 38px 42px 26px;
        }
        /* زخارف الزوايا */
        .corner { position: absolute; width: 22px; height: 22px; }
        .corner::before, .corner::after { content: ""; position: absolute; background: var(--gold); }
        .corner-tl { top: -6px; right: -6px; }
        .corner-tr { top: -6px; left: -6px; }
        .corner-bl { bottom: -6px; right: -6px; }
        .corner-br { bottom: -6px; left: -6px; }
        .corner::before { width: 100%; height: 2px; top: 6px; }
        .corner::after  { width: 2px; height: 100%; right: 6px; }
        .corner-tr::after, .corner-br::after { right: auto; left: 6px; }

        /* -------- شريط عنوان أعلى الورقة -------- */
        .doc-eyebrow {
            text-align: center;
            margin-bottom: 18px;
        }
        .doc-eyebrow span {
            display: inline-block;
            font-family: 'Amiri', serif;
            font-size: 13px;
            letter-spacing: 1.5px;
            color: var(--emerald);
            padding: 3px 22px;
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
        }

        /* -------- ترويسة الشركة -------- */
        .contract-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--emerald);
            position: relative;
        }
        .contract-header::after {
            content: "";
            position: absolute;
            bottom: -4px; right: 0; left: 0;
            height: 1px;
            background: var(--gold);
        }
        .co-block { width: 33%; font-size: 12.5px; line-height: 1.7; color: #45524a; }
        .co-block .co-name { font-family: 'Amiri', serif; font-size: 16px; font-weight: 700; color: var(--emerald); }
        .co-logo { width: 34%; text-align: center; }
        .co-logo img {
            width: 78px; height: 78px; object-fit: contain;
            padding: 6px;
            border: 1px solid var(--line);
            border-radius: 50%;
            background: #fff;
        }

        /* -------- شارة عنوان العقد -------- */
        .contract-title-wrap { text-align: center; margin: 22px 0 20px; }
        .contract-title {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: 'Amiri', serif;
            font-weight: 700;
            font-size: 19px;
            color: #fff;
            background: linear-gradient(135deg, var(--emerald), var(--emerald-2));
            padding: 9px 34px;
            border-radius: 3px;
            box-shadow: 0 2px 10px rgba(11,61,46,0.25);
        }
        .contract-title .diamond { color: var(--gold); font-size: 12px; }

        /* -------- فقرة تمهيدية -------- */
        .preamble {
            font-size: 13.5px;
            line-height: 2;
            background: var(--mist);
            border-right: 3px solid var(--emerald);
            padding: 12px 16px;
            border-radius: 0 4px 4px 0;
            margin-bottom: 20px;
        }
        .preamble strong { color: var(--emerald); }

        /* -------- جدول البيانات المالية -------- */
        .table-contract {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-bottom: 22px;
            border: 1px solid var(--line);
        }
        .table-contract td {
            padding: 9px 14px;
            border: 1px solid var(--line);
        }
        .table-contract td.label {
            width: 16%;
            font-weight: 700;
            color: var(--emerald);
            background: var(--gold-tint);
        }
        .table-contract tr:nth-child(even) td:not(.label) { background: #fbfaf6; }

        /* -------- قسم البنود -------- */
        .clauses-title {
            font-weight: 700;
            color: var(--emerald);
            font-size: 14px;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px dashed var(--line);
        }
        .clauses-list {
            list-style: none;
            counter-reset: clause;
            padding: 0;
            margin: 0;
            font-size: 12.5px;
            line-height: 1.9;
        }
        .clauses-list li {
            counter-increment: clause;
            position: relative;
            padding: 4px 42px 4px 6px;
            margin-bottom: 3px;
        }
        .clauses-list li::before {
            content: counter(clause);
            position: absolute;
            right: 0; top: 3px;
            width: 22px; height: 22px;
            border: 1px solid var(--emerald);
            color: var(--emerald);
            border-radius: 50%;
            font-size: 11px;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }

        /* -------- التواقيع -------- */
        .signatures {
            margin-top: 30px;
            padding-top: 18px;
            border-top: 2px solid var(--emerald);
        }
        .sig-box { text-align: center; font-size: 13px; }
        .sig-role {
            display: inline-block;
            font-weight: 700;
            color: var(--emerald);
            background: var(--gold-tint);
            padding: 3px 16px;
            border-radius: 3px;
            margin-bottom: 10px;
            font-size: 12.5px;
        }
        .sig-line {
            margin-top: 30px;
            border-top: 1px dashed #9aa89f;
            padding-top: 6px;
            color: var(--muted);
            font-size: 11.5px;
        }
        .qr-box {
            display: inline-block;
            padding: 6px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 6px;
        }

        /* -------- تذييل -------- */
        .doc-footer {
            text-align: center;
            margin-top: 22px;
            padding-top: 10px;
            border-top: 1px solid var(--gold);
            font-size: 10.5px;
            color: var(--muted);
            letter-spacing: .3px;
        }

        .no-print .btn { border-radius: 4px; }

        @media print {
            @page { size: A4; margin: 10mm; }
            body * { visibility: hidden; }
            .printable-contract, .printable-contract * { visibility: visible; }
            body { background: #fff; }
            .printable-contract {
                position: absolute;
                left: 0; top: 0; width: 100%;
                box-shadow: none;
            }
            .no-print { display: none; }
            .contract-inner { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
@endsection

@section('title')
    {{ __('realestate.contract_details') }}
@stop

@section('page-header')
    <div class="main-parent no-print">
        <div class="breadcrumb-header justify-content-between parent-heading">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto"><i class="fas fa-file-contract text-primary ml-2"></i> معاينة عقد الإيجار الرسمي رقم (#{{ $contract->id }})</h4>
                </div>
            </div>
            <div class="d-flex my-auto">
                <button onclick="window.print()" class="btn btn-success btn-sm ml-2">
                    <i class="fas fa-print ml-1"></i> طباعة العقد
                </button>
                <a href="{{ route('lease_contracts.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-right ml-1"></i> {{ __('realestate.back') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="contract-wrap">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">

                {{-- ورقة العقد الموثق --}}
                <div class="contract-sheet printable-contract mb-5">
                    <div class="contract-inner">
                        <span class="corner corner-tl"></span>
                        <span class="corner corner-tr"></span>
                        <span class="corner corner-bl"></span>
                        <span class="corner corner-br"></span>

                        <div class="doc-eyebrow"><span>وثيقة عقارية رسمية</span></div>

                        {{-- ترويسة العقد --}}
                        <div class="contract-header" dir="rtl">
                            <div class="co-block" style="text-align: right;">
                                <span class="co-name">{{ $setting->Namear ?? 'مؤسسة إبداء العقارية' }}</span><br>
                                <p class="mb-1">{{ $setting->describtionar ?? 'بيع شراء تماجر وسيط عقاري' }}</p>
                                <p class="mb-1">س.ت.: {{ $setting->STar ?? '1010584112' }}</p>
                                <p class="mb-0">الرقم الضريبي: {{ $setting->Taxar ?? '0' }}</p>
                            </div>

                            <div class="co-logo">
                                            <?php $logo = camplogo; ?>
                                <a href="https://ebdeasoft.com/">
                                    <img src="{{ asset('assets/img/brand').'/'.$logo }}" alt="logo">
                                </a>
                            </div>

                            <div class="co-block" style="text-align: left;" dir="ltr">
                                <span class="co-name">{{ $setting->Nameen ?? 'Ebdaat ebdeas Est' }}</span><br>
                                <p class="mb-1">{{ $setting->describtionen ?? 'Sales spare parts' }}</p>
                                <p class="mb-1">C.R.: {{ $setting->STen ?? '1010584112' }}</p>
                                <p class="mb-0">VAT Number: {{ $setting->Taxen ?? '0' }}</p>
                            </div>
                        </div>

                        {{-- عنوان العقد --}}
                        <div class="contract-title-wrap">
                            <span class="contract-title">
                                <span class="diamond">◆</span>
                                عقد إيجار رقم {{ $contract->id }}
                                <span class="diamond">◆</span>
                            </span>
                        </div>

                        {{-- أطراف العقد والتواريخ التمهيدية --}}
                        <div class="preamble">
                            انه في يوم : <strong>{{ $contract->contract_date ? \Carbon\Carbon::parse($contract->contract_date)->format('l') : '---' }}</strong>
                            الموافق : <strong>{{ $contract->contract_date ?? '---' }}</strong> هـ تم الاتفاق بين الموقعين أدناه وهما في كامل الأهلية المعتبرة شرعاً للتعاقد:
                            <br>
                            - <strong>الطرف الأول (المؤجر):</strong> {{ $contract->unit->property->owner_name ?? 'حسين' }} &nbsp;&nbsp;&nbsp;
                            - <strong>الطرف الثاني (المستأجر):</strong> {{ $contract->tenant->name ?? 'غير متوفر' }}
                            (هوية/سجل تجاري): {{ $contract->tenant->national_id ?? '2000225555' }} &nbsp;&nbsp;
                            - <strong>هاتفه:</strong> {{ $contract->tenant->phone ?? 'غير متوفر' }}
                        </div>

                        {{-- جدول البيانات المالية والمدفوعات --}}
                        <div class="table-responsive mb-3">
                            <table class="table-contract text-right">
                                <tr>
                                    <td class="label">الإيجار</td>
                                    <td>{{ number_format($contract->rent_amount, 2) }} ريال</td>
                                    <td class="label">التأمين</td>
                                    <td>{{ number_format($contract->insurance_amount ?? 0, 2) }} ريال</td>
                                </tr>
                                <tr>
                                    <td class="label">المدفوع</td>
                                    <td><span class="text-success font-weight-bold">{{ number_format($contract->paid_amount ?? 0, 2) }}</span> ريال</td>
                                    <td class="label">المياه</td>
                                    <td>{{ number_format($contract->water_bill ?? 0, 2) }} ريال</td>
                                </tr>
                                <tr>
                                    <td class="label">العمولة</td>
                                    <td>{{ number_format($contract->commission ?? 0, 2) }} ريال</td>
                                    <td class="label">العمولة السنوية</td>
                                    <td>{{ number_format($contract->annual_commission ?? 0, 2) }} ريال</td>
                                </tr>
                                <tr>
                                    <td class="label">طريقة السداد</td>
                                    <td>كل {{ $contract->payment_every ?? '6' }} أشهر</td>
                                    <td class="label">بداية العقد</td>
                                    <td>{{ $contract->start_date }}</td>
                                </tr>
                                <tr>
                                    <td class="label">مدة العقد</td>
                                    <td>
                                        @php
                                            $start = \Carbon\Carbon::parse($contract->start_date);
                                            $end = \Carbon\Carbon::parse($contract->end_date);
                                            $diffYears = $start->diffInYears($end);
                                        @endphp
                                        {{ $diffYears > 0 ? $diffYears . ' سنة' : 'أقل من سنة' }}
                                    </td>
                                    <td class="label">نهاية العقد</td>
                                    <td>{{ $contract->end_date }}</td>
                                </tr>
                                <tr>
                                    <td class="label">غرض الإيجار</td>
                                    <td colspan="3">{{ $contract->contract_type ?? 'لسكن / تجاري' }}</td>
                                </tr>
                                <tr>
                                    <td class="label">العين المؤجرة</td>
                                    <td colspan="3">
                                        وحدة رقم ({{ $contract->unit->unit_number ?? '' }}) -
                                        عقار: {{ $contract->unit->property->name ?? '' }} -
                                        مدينة {{ $contract->unit->property->city ?? 'الرياض' }} - حي {{ $contract->unit->property->district ?? '' }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        {{-- بنود العقد --}}
                        <div class="mb-2">
                            <div class="clauses-title">تم الاتفاق بين الطرفين أن يؤجر الطرف الأول للطرف الثاني العقار المشار اليه أعلاه وفقاً للشروط التالية:</div>
                            <ol class="clauses-list">
                                <li>أستلم الطرف الثاني العقار بعد الاطلاع عليه داخلياً وخارجياً وهو بحالة جيدة.</li>
                                <li>لا يحق للطرف الثاني أن يؤجر العقار بأكمله أو قسماً منه ولا تنازله عنه للغير دون موافقة الطرف الأول خطياً.</li>
                                <li>لا يحق للطرف الثاني عمل أي إضافات بالعقار أو تعديل إلا بموافقة الطرف الأول خطياً، وإذا حدث شيئاً منها لا يحق له إزالته ويعتبر ملكاً للطرف الأول.</li>
                                <li>على الطرف الثاني المحافظة على حقوق الجوار وعدم إزعاجهم وعدم إيذائهم والتقيد بالنظام العام.</li>
                                <li>يتجدد هذا العقد تلقائياً لمدة مماثلة ما لم يخطر أحد الطرفين كتابياً، وذلك قبل شهرين على الأقل من نهاية هذا العقد.</li>
                                <li>إذا رغب الطرف الثاني في إخلاء العقار لأي سبب قبل نهاية العقد لا يحق له المطالبة بقيمة الإيجار المتبقي.</li>
                                <li>يحق للطرف الأول فصل الكهرباء عن العقار إذا تأخر المستأجر في دفع الدفعات المستحقة أو خالف أحد بنود هذا العقد أو استعمل العقار المؤجر بغير الغرض المنصوص عليه في هذا العقد.</li>
                                <li>يتعهد الطرف الثاني بتسليم العقار في نهاية العقد بكامل محتوياته وهو في حالة سليمة كما استلمه.</li>
                                <li>يلتزم الطرف الثاني بإعادة رخصة المحل للمالك عند إخلائه العقار.</li>
                                <li>إذا تأخر الطرف الثاني عن دفع الإيجار مدة لا تزيد عن 15 يوماً يحق للطرف الأول التصرف بالعقار دون الرجوع للطرف الثاني ويتحمل الطرف الثاني كامل المسؤولية مع مطالبته استيفاء جميع ما عليه من مستحقات.</li>
                                <li>{{ $contract->notes ?? 'ينهي المكتب مسئوليته أمام الطرفين عقب توقيعهما على هذا العقد إلا إذا كان مشرفاً على العقار بموجب خطاب رسمي موجه من المالك وقد جرى تحرير هذا العقد والتوقيع عليه بعد معرفة كل من الطرفين بكامل نصوص وشروط العقد.' }}</li>
                            </ol>
                        </div>

                        {{-- التواقيع والأختام وباركود التحقق --}}
                        <div class="row signatures">
                            <div class="col-4 sig-box">
                                <span class="sig-role">الطرف الأول (المؤجر)</span>
                                <p class="mb-0">الاسم: {{ $contract->unit->property->owner->name ?? 'حسين' }}</p>
                                <div class="sig-line">التوقيع</div>
                            </div>

                            <div class="col-4 sig-box">
                                @php
                                    $publicContractUrl = \Illuminate\Support\Facades\URL::signedRoute(
                                        'contracts.public_show',
                                        ['contract' => $contract->id]
                                    );
                                @endphp
                                <div class="qr-box">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=90x90&data={{ urlencode($publicContractUrl) }}" alt="QR Code">
                                </div>
                                <p class="mt-1 mb-0" style="font-size: 10px; color: var(--muted);">امسح الكود لعرض العقد إلكترونياً</p>
                            </div>

                            <div class="col-4 sig-box">
                                <span class="sig-role">الطرف الثاني (المستأجر)</span>
                                <p class="mb-0">الاسم: {{ $contract->tenant->name ?? '---' }}</p>
                                <div class="sig-line">التوقيع</div>
                            </div>
                        </div>

                        {{-- تذييلة الورقة الرسمية --}}
                        <div class="doc-footer">
                            الرياض - المراسلات - خلف الدفاع المدني &nbsp;|&nbsp; ت: 0550380001 &nbsp;|&nbsp; ف: 012636777 &nbsp;|&nbsp; Email: sales@saudiakar.com
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection