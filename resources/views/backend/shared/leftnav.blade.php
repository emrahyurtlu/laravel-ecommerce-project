<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="#">
            <span data-feather="home"></span>
            Yönetim Paneli
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Str::of(url()->current())->contains("/users") ? "active" : ""}}"
           href="/users">
            <span data-feather="users"></span>
            Kullanıcılar
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Str::of(url()->current())->contains("/categories") ? "active" : ""}}"
           href="/categories">
            <span data-feather="grid"></span>
            Kategoriler
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Str::of(url()->current())->contains("/products") ? "active" : ""}}"
           href="/products">
            <span data-feather="grid"></span>
            Ürünler
        </a>
    </li>
</ul>
