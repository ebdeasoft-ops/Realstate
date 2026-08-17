@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #1f2a24;
            --paper: #fdfbf5;
            --emerald: #0b3d2e;
            --emerald-2: #0f4f3b;
            --gold: #b08d4f;
            --gold-tint: #f6efdf;
            --mist: #eef3f0;
            --muted: #7a8a80;
            --line: #d8cead;
        }
        body { background: #e9e5da; }
        .payment-wrap {
            font-family: 'Tajawal', Arial, sans-serif;
            color: var(--ink);
        }
    </style>
@endsection

@section('title')
    إدارة الدفعات والتحصيلات
@stop

@section('page-header')
    <div class="main-parent no-print">
        <div class="breadcrumb-header justify-content-between parent-heading">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto"><i class="fas fa-money-bill-wave text-primary ml-2"></i> إدارة الدفعات والتحصيلات المالية</h4>
                </div>
            </div>
            <div class="d-flex my-auto">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPaymentModal">
                    <i class="fa-solid fa-plus ml-1"></i> دفعة جديدة
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="payment-wrap">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-right">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>العميل / المورد</th>
                                        <th>المبلغ</th>
                                        <th>طريقة الدفع</th>
                                        <th>التاريخ</th>
                                        <th>ملاحظات</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>شركة الأفق للتعمير</td>
                                        <td><span class="text-success font-weight-bold">5,000.00 ر.س</span></td>
                                        <td><span class="badge badge-info">تحويل بنكي</span></td>
                                        <td>2026-08-16</td>
                                        <td>دفعة مقدمة للوحدة العقارية</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" title="تعديل"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" title="حذف"><i class="fa-solid fa-trash"></i></button>
                                            <button class="btn btn-sm btn-outline-secondary" title="تحميل الإيصال"><i class="fa-solid fa-download"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal إضافة دفعة جديدة -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="addPaymentModalLabel"><i class="fa-solid fa-cash-register ml-2"></i> تسجيل دفعة جديدة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-right">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label">العميل / الجهة</label>
                                <select name="customer_id" class="form-control" required>
                                    <option value="">اختر العميل...</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="form-label">المبلغ</label>
                                <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="form-label">طريقة الدفع</label>
                                <select name="pay_method" class="form-control" required>
                                    <option value="cash">نقداً (صندوق)</option>
                                    <option value="bank">تحويل بنكي / شبكة</option>
                                    <option value="credit">أجل (حساب عميل)</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="form-label">التاريخ</label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-12 form-group">
                                <label class="form-label">ملاحظات</label>
                                <textarea name="note" class="form-control" rows="3" placeholder="أدخل أي تفاصيل إضافية هنا..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-check ml-1"></i> حفظ الدفعة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection