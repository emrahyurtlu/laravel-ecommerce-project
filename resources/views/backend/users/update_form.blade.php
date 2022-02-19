@extends("backend.shared.backend_theme")
@section("title","Kullanıcı Modülü")
@section("subtitle","Kullanıcı Güncelle")
@section("btn_url",url()->previous())
@section("btn_label","Geri Dön")
@section("btn_icon","arrow-left")
@section("content")
    <form action="{{url("/users/$user->user_id")}}" method="POST" autocomplete="off" novalidate>
        @csrf
        @method("PUT")
        <input type="hidden" name="user_id" value="{{$user->user_id}}">
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-2">
                    <x-input label="Ad Soyad" placeholder="Ad soyad giriniz" field="name" value="{{$user->name}}"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mt-2">
                    <x-input label="Eposta giriniz" placeholder="Eposta giriniz" field="email" type="email"
                             value="{{$user->email}}"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <x-checkbox field="is_admin" label="Yetkili Kullanıcı" checked="{{$user->is_admin == 1}}"/>
            </div>
            <div class="col-lg-6">
                <x-checkbox field="is_active" label="Aktif Kullanıcı" checked="{{$user->is_active == 1}}"/>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary mt-2"><span data-feather="save"></span> KAYDET</button>
            </div>
        </div>
    </form>
@endsection
