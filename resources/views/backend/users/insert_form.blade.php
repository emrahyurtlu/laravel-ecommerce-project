@extends("backend.shared.backend_theme")
@section("title","Kullanıcı Modülü")
@section("subtitle","Yeni Kullanıcı Ekle")
@section("btn_url",url()->previous())
@section("btn_label","Geri Dön")
@section("btn_icon","arrow-left")
@section("content")
    <form action="{{url("/users")}}" method="POST" autocomplete="off" novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-2">
                    <x-input label="Ad Soyad" placeholder="Ad soyad giriniz" field="name" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mt-2">
                    <x-input label="Eposta giriniz" placeholder="Eposta giriniz" field="email" type="email" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-2">
                    <x-input label="Şifre Giriniz" placeholder="Şifre giriniz" field="password" type="password" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mt-2">
                    <x-input label="Şifre Tekrarı" placeholder="Şifrenizi tekrar giriniz" field="password_confirmation" type="password" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <x-checkbox field="is_admin" label="Yetkili Kullanıcı" />
            </div>
            <div class="col-lg-6">
                <x-checkbox field="is_active" label="Aktif Kullanıcı" />
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary mt-2"><span data-feather="save"></span> KAYDET
                </button>
            </div>
        </div>
    </form>
@endsection
