@extends("backend.shared.backend_theme")
@section("title","Kullanıcı Modülü")
@section("subtitle","Kullanıcı Güncelle")
@section("btn_url",url()->previous())
@section("btn_label","Geri Dön")
@section("btn_icon","arrow-left")
@section("content")
    <form action="{{url("/users/$user->user_id/addresses/$addr->address_id")}}" method="POST" autocomplete="off"
          novalidate>
        @csrf
        @method("PUT")
        <input type="hidden" name="user_id" value="{{$user->user_id}}">
        <input type="hidden" name="address_id" value="{{$addr->address_id}}">
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-2">
                    <x-input label="Şehir" placeholder="Şehir giriniz" field="city" value="{{$addr->city}}"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mt-2">
                    <x-input label="İlçe" placeholder="İlçe giriniz" field="district" value="{{$addr->district}}"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-2">
                    <x-input label="Posta Kodu" placeholder="Posta kodu giriniz" field="zipcode"
                             value="{{$addr->zipcode}}"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="col-lg-6">
                    <x-checkbox field="is_default" label="Varsayılan" checked="{{$addr->is_default == 1}}"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="mt-4">
                    <x-textarea label="Açık Adres" placeholder="Açık adres giriniz" field="address"
                                value="{{$addr->address}}"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary mt-2"><span data-feather="save"></span> KAYDET</button>
            </div>
        </div>
    </form>
@endsection
