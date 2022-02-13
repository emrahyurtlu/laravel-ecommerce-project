<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Üye Olun</title>

    <link rel="stylesheet" href="{{asset("css/app.css")}}">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-4 offset-4">
            <main class="mt-5">
                <form method="POST" action="{{url("/uye-ol")}}">
                    @csrf
                    <h1 class="h3 mb-3 fw-normal">Üye Olun</h1>

                    <div class="">
                        <x-input label="Ad Soyad" placeholder="Ad soyad giriniz" field="name" />
                    </div>

                    <div class="mt-2">
                        <x-input label="Eposta giriniz" placeholder="Eposta giriniz" field="email" type="email" />
                    </div>

                    <div class="mt-2">
                        <x-input label="Şifre Giriniz" placeholder="Şifre giriniz" field="password" type="password" />
                    </div>

                    <div class="mt-2">
                        <x-input label="Şifre Tekrarı" placeholder="Şifrenizi tekrar giriniz" field="password_confirmation" type="password" />
                    </div>

                   <div class="mt-2">
                       <button class="w-100 btn btn-lg btn-primary" type="submit">Kayıt Ol</button>
                   </div>
                </form>
            </main>
        </div>
    </div>
</div>
</body>
</html>
