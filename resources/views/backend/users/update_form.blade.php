<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yönetim Paneli</title>

    <link rel="stylesheet" href="{{asset("css/app.css")}}">

    <!-- Custom styles for this template -->
    <link href="{{asset("css/dashboard.css")}}" rel="stylesheet">
</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">Laravel Ecommerce</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="#">Çıkış</a>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">
                            <span data-feather="home"></span>
                            Yönetim Paneli
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Str::of(url()->current())->contains("/users") ? "active" : ""}}"
                           href="{{url("/users")}}">
                            <span data-feather="users"></span>
                            Kullanıcılar
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Kullanıcılar</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{url("/users")}}" class="btn btn-sm btn-outline-danger"> <span data-feather="arrow-left"></span> Geri Dön</a>
                    </div>
                </div>
            </div>
            <h2>Kullanıcı Düzenle</h2>
            <div class="table-responsive">
                <form action="{{url("/users/$user->user_id")}}" method="POST" autocomplete="off" novalidate>
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="user_id" value="{{$user->user_id}}">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mt-2">
                                <label for="name" class="form-label">Ad Soyad</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Ad soyad giriniz" value="{{old("name", $user->name)}}">
                                @error("name")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mt-2">
                                <label for="email" class="form-label">Eposta giriniz</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Eposta giriniz"  value="{{old("email", $user->email)}}">
                                @error("email")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="is_admin" name="is_admin" value="1" {{$user->is_admin == 1 ? "checked" : ""}}>
                                <label class="form-check-label" for="is_admin">
                                    Yetkili Kullanıcı
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"  {{$user->is_active == 1 ? "checked" : ""}}>
                                <label class="form-check-label" for="is_active">
                                    Aktif Kullanıcı
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary mt-2"><span data-feather="save"></span> KAYDET</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
<script type="text/javascript" src="{{asset("js/app.js")}}"></script>
</body>
</html>
