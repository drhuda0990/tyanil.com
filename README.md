# tyanil.com

متجر تيانيل الإلكتروني مبني بإطار Laravel، مخصص لمنتجات نسائية مع لوحة تحكم وإعدادات متجر وشحن وسلة وتهيئة SEO.

## Production Notes

- لا يتم رفع ملف `.env` إلى GitHub.
- صور المتجر العامة محفوظة ضمن `storage/app/public` ويجب إنشاء رابط التخزين بعد النشر:

```bash
php artisan storage:link
```

- بعد إعداد متغيرات البيئة وقاعدة البيانات:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
