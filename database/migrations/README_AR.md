# ملفات Migration الخاصة بقاعدة بيانات realstate

تم توليد هذه الملفات تلقائياً من ملف SQL dump المرفوع (realstate.sql).

## عدد الملفات
- 78 ملف لإنشاء الجداول (Schema::create)
- ملف واحد أخير لإضافة كل العلاقات (Foreign Keys) بعد إنشاء جميع الجداول لتفادي مشاكل الترتيب

## طريقة الاستخدام
1. انسخ كل الملفات إلى مجلد `database/migrations` في مشروع Laravel الخاص بك.
2. تأكد أن اسم قاعدة البيانات والاتصال في `.env` صحيح.
3. شغّل الأمر:
   ```
   php artisan migrate
   ```

## ملاحظات مهمة
- الجداول التالية موجودة عادة بشكل افتراضي في أي مشروع Laravel جديد (تم توليدها هنا أيضاً لأنها كانت في الـ dump، لكن راجعها قبل التشغيل لتفادي التعارض مع ملفات migration الافتراضية لديك):
  `migrations`, `password_resets`, `personal_access_tokens`, `sessions`, `failed_jobs`,
  `permissions`, `roles`, `model_has_permissions`, `model_has_roles`, `role_has_permissions`
  إذا كانت هذه الملفات موجودة أصلاً في مشروعك (من Laravel Breeze/Sanctum/Spatie Permissions)، احذف نسخنا المكررة لهذه الجداول وأبقِ فقط ملفاتك الأصلية.
- هذا الملف يحتوي على جداول القطاع العقاري الإضافية: `properties`, `units`, `unit_images`, `owners`, `tenants`, `lease_contracts`, `property_images`, `property_media` — تمت معالجتها بنفس الطريقة.
- تم استخدام `$table->id()` تلقائياً لأي عمود `id` من نوع `bigint unsigned` يُستخدم كمفتاح أساسي مفرد.
- الفهارس (KEY) والمفاتيح الفريدة (UNIQUE KEY) الموجودة في الـ dump تمت إضافتها بأسمائها الأصلية.
- بيانات الجداول (INSERT INTO) لم يتم تضمينها — هذه ملفات هيكل (Schema) فقط، وليست Seeders.
- تم فحص كل الملفات آلياً للتأكد من توازن الأقواس وعدم وجود أنواع أعمدة غير مدعومة.
