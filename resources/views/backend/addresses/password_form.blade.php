@extends("backend.shared.backend_theme")
@section("title","Kullanıcı Modülü")
@section("subtitle","Şifre Değiştir")
@section("btn_url",url()->previous())
@section("btn_label","Geri Dön")
@section("btn_icon","arrow-left")
@section("content")
    <form action="{{url("/users/$user->user_id/change-password")}}" method="POST" autocomplete="off" novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-2">
                    <label for="password" class="form-label">Şifre Giriniz</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Şifre giriniz" autocomplete="new-password">
                    @error("password")
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mt-2">
                    <label for="password_confirmation" class="form-label">Şifre Tekrarı</label>
                    <input type="password" class="form-control" id="password_confirmation"
                           name="password_confirmation" placeholder="Şifrenizi tekrar giriniz"
                           autocomplete="new-password">
                    @error("password")
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
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
