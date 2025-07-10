<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الملف الشخصي</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/alpha3.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .btn-primary-custom {
            background-color: #E92F22;
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #c8241a;
        }

        .form-label {
            font-weight: 600;
        }

        textarea {
            resize: none;
        }
    </style>
</head>

<body>
    <section class="" style="width: 100%">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow p-4">
                        <a href="{{ route('dashboard_admin.index') }}" class="btn btn"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-chevron-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                            </svg></a>
                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/img/alpha3.png') }}" style="width: 80px;" alt="logo">
                            <h4 class="mt-3">تعديل الملف الشخصي</h4>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger text-center">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('editprofile_admin') }}">
                            @csrf


                            <div class="mb-3">
                                <label for="name" class="form-label">الاسم</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $user->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $user->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">كلمة المرور الجديدة</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="اتركها فارغة إن لم ترد التغيير">
                            </div>

                            <div class="mb-3">
                                <label for="newpassword" class="form-label">تأكيد كلمة المرور</label>
                                <input type="password" name="newpassword" id="newpassword" class="form-control"
                                    placeholder="أعد كتابة كلمة المرور">
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">رقم الهاتف</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ $user->phone }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">الوصف</label>
                                <textarea name="description" id="description" rows="3" class="form-control">{{ $user->description }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="address" class="form-label">العنوان</label>
                                <input type="text" name="address" id="address" class="form-control"
                                    value="{{ $user->address }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100">حفظ التغييرات</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
