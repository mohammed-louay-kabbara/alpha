<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/alpha3.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <style>
        .gradient-custom-2 {
            /* fallback for old browsers */
            background: #fccb90;
            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
        }

        @media (min-width: 768px) {
            .gradient-form {
                height: 100vh !important;
            }
        }

        @media (min-width: 769px) {
            .gradient-custom-2 {
                border-top-right-radius: .3rem;
                border-bottom-right-radius: .3rem;
            }
        }
    </style>
    <title> تعديل الملف الشخصي</title>
</head>

<body>
    <div id="login-alert" class="alert d-none" role="alert"></div>
    <section class="vh-100 d-flex align-items-center justify-content-center" style="background-color: #eee;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/img/alpha3.png') }}" style="width: 100px;" alt="logo">
                                <h3 class="mt-3"> الملف الشخصي</h3>
                            </div>
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('editprofile_admin') }}">
                                @csrf
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="email">البريد الإلكتروني</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required />
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="password">كلمة المرور الجديدة</label>
                                    <input type="password" id="password" name="password" value="{{ $user->password }}" class="form-control"
                                        required />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="password">التحقق من كلمة السر</label>
                                    <input type="password" id="password" name="newpassword" value="{{ $user->newpassword }}"  class="form-control"
                                        required />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="password"> رقم الهاتف</label>
                                    <input type="password" id="password" name="phone" value="{{ $user->phone }}"  class="form-control"
                                        required />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="password"> الوصف</label>
                                    <textarea cols="30" rows="10" name="description" class="form-control">{{ $user->description }}</textarea>
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="password"> العنوان </label>
                                    <input type="text" id="address" name="address" value="{{ $user->address }}" class="form-control"
                                        required />
                                </div>
                                <div class="text-center mb-3">
                                    <button id="login-btn" class="btn w-100"
                                        style="background-color: #E92F22; color:white" type="submit">
                                        حفظ
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>

</html>
