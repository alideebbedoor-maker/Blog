
# Laravel Blog Project

مشروع Blog باستخدام Laravel Blade مع علاقات Many-to-Many بين Blogs و Categories.

---

## 1. المميزات

### لوحة الإدارة (Admin Panel)
- CRUD للمدونات.
- إدارة الفئات (Categories).
- إدارة البلوجات المحذوفة (Soft Delete / Trash).
- استعادة البلوجات أو حذفها نهائيًا.

### واجهة المستخدم (Frontend)
- عرض جميع البلوجات.
- تصفية البلوجات حسب الفئات.
- عرض تفاصيل كل بلوج.
- إضافة وإزالة البلوجات من المفضلة (Favorites).

---

## 2. المتطلبات

- PHP >= 8.x
- Laravel >= 10.x
- MySQL أو أي قاعدة بيانات مدعومة
- Composer
- Node.js + npm (لتجميع assets إذا استخدمت Laravel Mix)
- تشغيل Storage link للصور:

php artisan storage:link


---

3. طريقة التشغيل

1. استنساخ المشروع من GitHub:



git clone <repo-url>
cd <project-folder>

2. تنصيب الاعتمادات:



composer install
npm install
npm run dev

3. إعداد ملف .env:



cp .env.example .env
php artisan key:generate

عدلي بيانات قاعدة البيانات داخل .env:


DB_DATABASE=blog_db
DB_USERNAME=root
DB_PASSWORD=


4. تشغيل السيرفر المحلي:



php artisan serve

اذهبي إلى http://127.0.0.1:8000/blogs لعرض البلوجات.



---

5. روابط مفيدة

Admin Panel: /blogs (بعد تسجيل دخول المسؤول)

Frontend Blogs: /blogs

Favorites: /favorites



---

6. ملاحظات هامة

جميع الصور محفوظة في storage/app/public/blogs.

تم استخدام Blade Templates و Bootstrap للتصميم.

تم استخدام Form Requests للفاليديشن عند إضافة وتعديل البلوجات.

Middleware admin لحماية لوحة الادمن.

روابط الـ routes في web.php يجب أن تكون مطابقة للأسماء المستخدمة في الـ Blade views.



---

7. الهيكلية العامة للـ Project

app/
├── Http/
│   └── Controllers/BlogController.php
resources/
├── views/
│   ├── frontend/
│   │   ├── blogs/
│   │   │   ├── index.blade.php
│   │   │   └── show.blade.php
│   └── layouts/
│       └── app.blade.php
storage/
├── app/public/blogs/   ← جميع الصور هنا


---
