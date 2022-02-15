<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-ticaret Projemiz</title>

    <link rel="stylesheet" href="{{asset("css/app.css")}}">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">PROJE</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/">Anasayfa</a>
                            </li>
                            @auth()
                                <li class="nav-item">
                                    <a class="nav-link" href="/sepetim">Sepetim</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/cikis">Çıkış</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="/giris">Giriş Yap</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/uye-ol">Üye ol</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 pt-4">
            <h5>Kategoriler</h5>
            <div class="list-group">
                <a href="/"
                   class="list-group-item list-group-item-action">Hepsi</a>
                @if(count($categories) > 0)
                    @foreach($categories as $category)
                        <a href="/kategori/{{$category->slug}}"
                           class="list-group-item list-group-item-action">{{$category->name}}</a>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-sm-9 pt-4">
            <h5>Ürünler</h5>
            @if(count($products) > 0)
                <div class="card-group">
                    @foreach($products as $product)
                        <div class="card" style="width: 18rem;">
                            <img src="{{asset("/storage/products/".$product->images[0]->image_url)}}"
                                 class="card-img-top" alt="{{$product->images[0]->alt}}">
                            <div class="card-body">
                                <h5 class="card-title">{{$product->name}}</h5>
                                <h6 class="card-title">Fiyat: {{$product->price}}TL</h6>
                                <p class="card-text">{{$product->lead}}</p>
                                <a href="/sepetim/ekle/{{$product->product_id}}" class="btn btn-primary">Sepete Ekle</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="{{asset("js/app.js")}}"></script>
</html>
