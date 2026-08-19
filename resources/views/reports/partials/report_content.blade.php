<div class="report-card">
    <div class="d-flex justify-content-between align-items-center report-title mb-4">
        <h4 class="text-primary font-weight-bold mb-0">
            {{ __('realestate.net_revenue') }}: {{ $reportData['property']->name }}
        </h4>
        <button onclick="window.print()" class="btn btn-success btn-sm">
            <i class="fas fa-print"></i> طباعة التقرير
        </button>
    </div>

    <!-- الملخص المالي الإجمالي -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="p-3 bg-light rounded border">
                <span class="text-muted d-block">إجمالي الإيرادات المحصلة</span>
                <h4 class="text-primary font-weight-bold mb-0">{{ number_format($reportData['total_revenue'], 2) }} ريال</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-light rounded border">
                <span class="text-muted d-block">إجمالي المصروفات</span>
                <h4 class="text-danger font-weight-bold mb-0">{{ number_format($reportData['total_expenses'], 2) }} ريال</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-light rounded border">
                <span class="text-muted d-block">عمولة التحصيل ({{ $reportData['commission_rate'] }}%)</span>
                <h4 class="text-warning font-weight-bold mb-0">{{ number_format($reportData['commission_amount'], 2) }} ريال</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-success text-white rounded">
                <span class="d-block">صافي الإيراد النهائي</span>
                <h4 class="font-weight-bold mb-0">{{ number_format($reportData['net_revenue'], 2) }} ريال</h4>
            </div>
        </div>
    </div>

    <!-- جدول تفاصيل الأقساط المحصلة -->
    <h5 class="font-weight-bold text-dark mt-4 mb-3"><i class="fas fa-file-invoice-dollar text-primary"></i> تفاصيل الأقساط المحصلة خلال الفترة</h5>
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-light">
                <tr>
                    <th>رقم القسط</th>
                    <th>الوحدة</th>
                    <th>المستأجر</th>
                    <th>مبلغ التحصيل</th>
                    <th>تاريخ الدفع</th>
                    <th>طريقة الدفع</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData['paid_installments'] as $installment)
                <tr>
                    <td>{{ $installment->installment_number }}</td>
                    <td>{{ optional($installment->UnitData)->unit_number ?? '---' }}</td>
                    <td>{{ optional($installment->tenantData)->name ?? '---' }}</td>
                    <td class="font-weight-bold text-primary">{{ number_format($installment->amount, 2) }}</td>
                    <td>{{ $installment->paid_date }}</td>
                    <td>{{ $installment->PaymentType ?? '---' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-muted">لا توجد أقساط محصلة في هذه الفترة</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- جدول تفاصيل المصروفات -->
    <h5 class="font-weight-bold text-dark mt-4 mb-3"><i class="fas fa-money-bill-wave text-danger"></i> تفاصيل المصروفات خلال الفترة</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-light">
                <tr>
                    <th>نوع المصروف</th>
                    <th>المبلغ</th>
                    <th>تاريخ المصروف</th>
                    <th>طريقة الدفع</th>
                    <th>الوصف / ملاحظات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData['expenses'] as $expense)
                <tr>
                    <td>
                        @if($expense->expense_type == 'water') مياه
                        @elseif($expense->expense_type == 'electricity') كهرباء
                        @elseif($expense->expense_type == 'maintenance') صيانة
                        @else أُخرى @endif
                    </td>
                    <td class="font-weight-bold text-danger">{{ number_format($expense->amount, 2) }}</td>
                    <td>{{ $expense->expense_date }}</td>
                    <td>{{ $expense->payment_method }}</td>
                    <td>{{ $expense->description ?? '---' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-muted">لا توجد مصروفات مسجلة في هذه الفترة</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>