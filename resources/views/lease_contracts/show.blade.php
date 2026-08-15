@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .contract-sheet {
            background: #fff;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            font-family: 'Amiri', serif, Arial, sans-serif;
            color: #333;
        }
        .contract-header {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .table-contract td, .table-contract th {
            padding: 5px 10px;
            vertical-align: middle;
        }
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }
            body * {
                visibility: hidden;
            }
            .printable-contract, .printable-contract * {
                visibility: visible;
            }
            .printable-contract {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none;
                box-shadow: none;
                padding: 10px;
                font-size: 12px;
            }
            .no-print {
                display: none;
            }
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
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            
            {{-- ورقة العقد الموثق --}}
            <div class="contract-sheet printable-contract mb-5">
                
                {{-- ترويسة العقد (Header) الصحيحة --}}
                <div class="invoice-header contract-header" style="display: flex; justify-content: space-between; align-items: center; width: 100%;" dir="rtl">
                    <div style="width: 33%; text-align: right;">
                        <span style="font-size: 15px; font-weight: bold;">{{ $setting->Namear ?? 'مؤسسة إبداء العقارية' }}</span><br>
                        <p class="mb-1" style="font-size: 13px;">{{ $setting->describtionar ?? 'بيع شراء تماجر وسيط عقاري' }}</p>
                        <p class="mb-1" style="font-size: 13px;">س.ت.: {{ $setting->STar ?? '1010584112' }}</p>
                        <p class="mb-0" style="font-size: 13px;">الرقم الضريبي: {{ $setting->Taxar ?? '0' }}</p>
                    </div>

                    <div style="width: 34%; text-align: center;">
                        @php $logo =camplogo ?? 'default.png'; @endphp
                        <a href="https://ebdeasoft.com/">
                            <img src="{{ asset('assets/img/brand').'/'.$logo }}" class="logo-1" alt="logo" style="width: 90px; height: 90px; object-fit: contain;">
                        </a>
                    </div>

                    <div style="width: 33%; text-align: left;" dir="ltr">
                        <span style="font-size: 15px; font-weight: bold;">{{ $setting->Nameen ?? 'Ebdaat ebdeas Est' }}</span><br>
                        <p class="mb-1" style="font-size: 13px;">{{ $setting->describtionen ?? 'Sales spare parts' }}</p>
                        <p class="mb-1" style="font-size: 13px;">C.R.: {{ $setting->STen ?? '1010584112' }}</p>
                        <p class="mb-0" style="font-size: 13px;">VAT Number : {{ $setting->Taxen ?? '0' }}</p>
                    </div>
                </div>

                {{-- عنوان العقد --}}
                <div class="text-center mb-3">
                    <h4 class="font-weight-bold" style="background: #f8f9fa; display: inline-block; padding: 6px 25px; border-radius: 6px; border: 1px dashed #ccc; font-size: 16px;">
                        (( عقد إيجار رقم : {{ $contract->id }} ))
                    </h4>
                </div>

                {{-- أطراف العقد والتواريخ التمهيدية --}}
                <div class="mb-3" style="font-size: 13.5px; line-height: 1.8;">
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
                    <table class="table table-bordered table-contract text-right" style="border-color: #dee2e6; font-size: 13px;">
                        <tr>
                            <td style="width: 15%; background: #fdfdfd;" class="font-weight-bold">الإيجار</td>
                            <td style="width: 35%;">{{ number_format($contract->rent_amount, 2) }} ريال</td>
                            <td style="width: 15%; background: #fdfdfd;" class="font-weight-bold">التأمين</td>
                            <td style="width: 35%;">{{ number_format($contract->insurance_amount ?? 0, 2) }} ريال</td>
                        </tr>
                        <tr>
                            <td style="background: #fdfdfd;" class="font-weight-bold">المدفوع</td>
                            <td><span class="text-success font-weight-bold">{{ number_format($contract->paid_amount ?? 0, 2) }}</span> ريال</td>
                            <td style="background: #fdfdfd;" class="font-weight-bold">المياه</td>
                            <td>{{ number_format($contract->water_bill ?? 0, 2) }} ريال</td>
                        </tr>
                        <tr>
                            <td style="background: #fdfdfd;" class="font-weight-bold">العمولة</td>
                            <td>{{ number_format($contract->commission ?? 0, 2) }} ريال</td>
                            <td style="background: #fdfdfd;" class="font-weight-bold">العمولة السنوية</td>
                            <td>{{ number_format($contract->annual_commission ?? 0, 2) }} ريال</td>
                        </tr>
                        <tr>
                            <td style="background: #fdfdfd;" class="font-weight-bold">طريقة السداد</td>
                            <td>كل {{ $contract->payment_every ?? '6' }} أشهر</td>
                            <td style="background: #fdfdfd;" class="font-weight-bold">بداية العقد</td>
                            <td>{{ $contract->start_date }}</td>
                        </tr>
                        <tr>
                            <td style="background: #fdfdfd;" class="font-weight-bold">مدة العقد</td>
                            <td>
                                @php
                                    $start = \Carbon\Carbon::parse($contract->start_date);
                                    $end = \Carbon\Carbon::parse($contract->end_date);
                                    $diffYears = $start->diffInYears($end);
                                @endphp
                                {{ $diffYears > 0 ? $diffYears . ' سنة' : 'أقل من سنة' }}
                            </td>
                            <td style="background: #fdfdfd;" class="font-weight-bold">نهاية العقد</td>
                            <td>{{ $contract->end_date }}</td>
                        </tr>
                        <tr>
                            <td style="background: #fdfdfd;" class="font-weight-bold">غرض الإيجار</td>
                            <td colspan="3">{{ $contract->contract_type ?? 'لسكن / تجاري' }}</td>
                        </tr>
                        <tr>
                            <td style="background: #fdfdfd;" class="font-weight-bold">العين المؤجرة</td>
                            <td colspan="3">
                                وحدة رقم ({{ $contract->unit->unit_number ?? '' }}) - 
                                عقار: {{ $contract->unit->property->name ?? '' }} - 
                                مدينة {{ $contract->unit->property->city ?? 'الرياض' }} - حي {{ $contract->unit->property->district ?? '' }}
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- بنود العقد الـ 11 كاملة ومطابقة للفيديو --}}
                <div class="mb-3" style="font-size: 12.5px; line-height: 1.6;">
                    <strong>تم الاتفاق بين الطرفين أن يؤجر الطرف الأول للطرف الثاني العقار المشار اليه أعلاه وفقاً للشروط التالية:</strong>
                    <ol class="pl-3 mt-1 pr-4 mb-0" style="columns: 1;">
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

                {{-- التواقيع والأختام وباركود التحقق (QR) --}}
                <div class="row mt-4 pt-2 align-items-center" style="border-top: 1px solid #eee; font-size: 13px;">
                    <div class="col-4 text-center">
                        <p class="font-weight-bold mb-3">الطرف الأول (المؤجر)</p>
                        <p class="mb-1">الاسم: {{ $contract->unit->property->owner_name ?? 'حسين' }}</p>
                        <p class="text-muted mb-0">التوقيع: ........................</p>
                    </div>

                    <div class="col-4 text-center">
                        <div class="d-inline-block p-1 bg-white border">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=70x70&data=Contract-{{ $contract->id }}" alt="QR Code">
                        </div>
                        <p class="mt-1 text-muted mb-0" style="font-size: 10px;">رقم توثيق العقد الرقمي</p>
                    </div>

                    <div class="col-4 text-center">
                        <p class="font-weight-bold mb-3">الطرف الثاني (المستأجر)</p>
                        <p class="mb-1">الاسم: {{ $contract->tenant->name ?? '---' }}</p>
                        <p class="text-muted mb-0">التوقيع: ........................</p>
                    </div>
                </div>

                {{-- تذييلة الورقة الرسمية --}}
                <div class="text-center mt-3 pt-2 text-muted" style="font-size: 10.5px; border-top: 1px dashed #ddd;">
                    الرياض - المراسلات - خلف الدفاع المدني ت: 0550380001 - ف: 012636777 | Email: sales@saudiakar.com
                </div>

            </div>

        </div>
    </div>
@endsection