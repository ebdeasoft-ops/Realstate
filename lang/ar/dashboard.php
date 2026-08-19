<?php

return [

    // العنوان الرئيسي
    'dashboard_title'    => 'لوحة تحكم إدارة العقارات والأملاك',
    'dashboard_subtitle' => 'نظرة شاملة على أداء المحفظة العقارية — محدثة بتاريخ :date',

    // بطاقات المؤشرات (KPIs)
    'kpi_total_properties'      => 'إجمالي العقارات (المباني)',
    'kpi_total_properties_desc' => 'يشمل كل المباني المسجلة بغض النظر عن الوحدات',
    'kpi_total_units'           => 'إجمالي الوحدات',
    'kpi_total_units_desc'      => 'مؤجرة: :rented | متاحة: :available',
    'kpi_active_contracts'      => 'العقود السارية',
    'kpi_active_contracts_desc' => 'منتهية / غير فعالة: :count',
    'kpi_tenants_owners'        => 'المستأجرون والملاك',
    'kpi_tenants_owners_desc'   => 'عدد الملاك: :count',
    'kpi_occupancy'             => 'نسبة الإشغال',
    'kpi_occupancy_desc'        => 'من إجمالي :total وحدة',

    // قسم البحث عن الوحدات
    'search_section_title' => 'البحث عن الوحدات المتاحة',
    'filter_listing_type'  => 'نوع العرض',
    'filter_all'           => 'الكل',
    'filter_for_rent'      => 'للإيجار',
    'filter_for_sale'      => 'للبيع',
    'filter_city'          => 'المدينة',
    'filter_all_cities'    => 'كل المدن',
    'filter_unit_type'     => 'نوع الوحدة',
    'filter_all_types'     => 'كل الأنواع',
    'filter_status'        => 'الحالة',
    'filter_available_only'=> 'متاح فقط',
    'search_button'        => 'بحث',

    // نتائج البحث
    'results_title' => 'نتائج البحث',
    'results_count' => ':count نتيجة',
    'results_empty' => 'لا توجد نتائج مطابقة لبحثك',

    // أعمدة جدول النتائج
    'table_name'            => 'الاسم',
    'table_type'            => 'النوع',
    'table_location'        => 'الموقع',
    'table_unit_category'   => 'تصنيف الوحدة',
    'table_price'           => 'السعر',
    'table_available_units' => 'الوحدات المتاحة',
    'table_status'          => 'الحالة',
    'status_available'      => 'متاح',
    'status_unavailable'    => 'غير متاح',
    'price_per_year'        => ':price ر.س / سنويًا',
    'price_total'           => ':price ر.س',
    'no_price'              => '—',
    'not_available'         => '—',
    'units_of_total'        => ':available من :total',

    // تحصيلات الشهر الحالي
    'collections_section_title' => 'تحصيلات الأقساط — الشهر الحالي',
    'collected'                 => 'تم تحصيلها',
    'collected_count'           => ':count قسط محصّل',
    'uncollected'                => 'لم تُحصّل بعد',
    'uncollected_count'          => ':count قسط مستحق/متأخر',
    'collection_rate'           => 'نسبة التحصيل الشهري',

    // تحليلات ورسوم بيانية
    'analytics_section_title' => 'تحليل المحفظة العقارية',
    'chart_rent_vs_sale'      => 'نسبة الوحدات: بيع مقابل إيجار',
    'chart_category'          => 'توزيع الوحدات حسب النوع',
    'chart_occupancy'         => 'حالة الإشغال',
    'chart_revenue_trend'     => 'اتجاه التحصيل خلال آخر 6 أشهر',
    'chart_address'           => 'توزيع العقارات حسب المدينة',
    'chart_legend_rented'     => 'مؤجرة',
    'chart_legend_available'  => 'متاحة',
    'chart_legend_rent'       => 'إيجار',
    'chart_legend_sale'       => 'بيع',
    'chart_legend_collected'  => 'المبلغ المحصّل (ر.س)',

    // أفضل الملاك
    'top_owners_title'   => 'أفضل 5 ملاك (حسب عدد العقارات)',
    'top_owners_empty'   => 'لا توجد بيانات كافية بعد',
    'properties_count'   => ':count عقار',

    // الأقساط القادمة
    'upcoming_installments_title' => 'أقرب الأقساط المستحقة',
    'upcoming_installments_empty' => 'لا توجد أقساط مستحقة قريبًا',
    'due_date'                    => 'تاريخ الاستحقاق',
    'amount'                      => 'القيمة',
    'paid_amount'                 => 'المدفوع',
    'due_status'                  => 'مستحق',

    // أحدث العقود
    'latest_contracts_title'  => 'أحدث العقود المضافة',
    'latest_contracts_empty'  => 'لا توجد عقود مضافة بعد',
    'contract_number'         => 'رقم العقد',
    'tenant'                  => 'المستأجر',
    'unit'                    => 'الوحدة',
    'start_date'              => 'تاريخ البدء',
    'end_date'                => 'تاريخ الانتهاء',
    'rent_value'              => 'قيمة الإيجار',
    'status_active_contract'  => 'ساري',
    'status_ended_contract'   => 'منتهي',

];