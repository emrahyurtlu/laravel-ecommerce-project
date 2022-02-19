@extends("backend.shared.backend_theme")
@section("title","Ürün Modülü")
@section("subtitle","Yeni Ürün Ekle")
@section("btn_url",url()->previous())
@section("btn_label","Geri Dön")
@section("btn_icon","arrow-left")
@section("content")
    <form action="{{url("/products")}}" method="POST" autocomplete="off" novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-2">
                    <x-input label="Ürün Adı" placeholder="Ürün adı giriniz" field="name"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mt-2">
                    <label for="category_id" class="form-label">Kategori Seçiniz</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="-1">Seçiniz</option>
                        @foreach($categories as $category)
                            <option value="{{$category->category_id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    @error("category_id")
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-2">
                    <x-input label="Ürün Fiyatı" placeholder="Fiyat giriniz" field="price" type="number"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mt-2">
                    <x-input label="Eski Fiyat" placeholder="Eski fiyat giriniz" field="old_price" type="number"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="mt-2">
                    <x-input label="Kısa Açıklama" placeholder="Kısa açıklama giriniz" field="lead"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="mt-2">
                    <x-textarea label="Detaylı Açıklama" placeholder="Detaylı açıklama giriniz" field="description"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <x-checkbox field="is_active" label="Aktif Ürün"/>
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
