<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ödeme Hatası</title>

    <link rel="stylesheet" href="{{asset("css/app.css")}}">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-4 offset-4">
            <main class="mt-5">
                <h1>Ödeme Hatası</h1>
                <p>Ödeme işlemi esnasında bir hata ile karşılaşıldı.</p>
                <p>Lütfen girdiğiniz bilgileri ve kart limitinizi kontrol ediniz.</p>
                <p><strong>Hata:</strong> <span class="text-black">{{$message}}</span></p>
            </main>
        </div>
    </div>
</div>
</body>
</html>
