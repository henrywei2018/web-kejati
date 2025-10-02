# Navigation Implementation Guide

## NavigationService - Pengelolaan Navigasi Header

Service class `App\Services\NavigationService` telah dibuat untuk mengelola navigasi header dengan fitur:

### Features:
1. **Main Menu Management** - Menu utama dengan active state
2. **Dynamic Profil Submenu** - Submenu profil yang diambil dari database
3. **Active State Detection** - Deteksi menu aktif dengan wildcard support
4. **Breadcrumbs Generation** - Generate breadcrumb otomatis

---

## Header Component Integration

Header component (`app/Livewire/Components/Header.php`) sudah diupdate dengan:

```php
public $mainMenu;      // Menu utama
public $breadcrumbs;   // Breadcrumbs
```

---

## Usage di View

### 1. Main Navigation Loop

```blade
<ul class="nav nav-pills" id="mainNav">
    @foreach($mainMenu as $item)
        @if(isset($item['children']) && count($item['children']) > 0)
            {{-- Menu dengan Dropdown --}}
            <li class="dropdown">
                <a href="{{ $item['url'] }}"
                   class="nav-link dropdown-toggle {{ $item['active'] ? 'active' : '' }}">
                    {{ $item['label'] }}
                </a>
                <ul class="dropdown-menu">
                    @foreach($item['children'] as $child)
                        <li>
                            <a href="{{ $child['url'] }}"
                               class="dropdown-item {{ $child['active'] ? 'active' : '' }}">
                                {{ $child['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            {{-- Menu Biasa --}}
            <li>
                <a href="{{ $item['url'] }}"
                   class="nav-link {{ $item['active'] ? 'active' : '' }}">
                    {{ $item['label'] }}
                </a>
            </li>
        @endif
    @endforeach
</ul>
```

### 2. Breadcrumbs Implementation

```blade
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($breadcrumbs as $index => $crumb)
            @if($loop->last)
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $crumb['label'] }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $crumb['url'] ?? '#' }}">{{ $crumb['label'] }}</a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
```

---

## Menu Structure

### Main Menu:
```php
[
    'label' => 'Beranda',
    'route' => 'home',
    'url' => route('home'),
    'active' => true/false,
]
```

### Menu dengan Children (Profil):
```php
[
    'label' => 'Profil',
    'route' => 'profil.*',
    'url' => '#',
    'active' => true/false,
    'children' => [
        [
            'label' => 'Visi & Misi',
            'route' => 'profil.show',
            'url' => '/profil/visi-misi',
            'active' => true/false,
        ],
        // ... more children
    ]
]
```

---

## Active State Classes

Gunakan class `active` untuk styling menu aktif:

```blade
{{-- Contoh dengan Bootstrap --}}
<a href="{{ $item['url'] }}"
   class="nav-link {{ $item['active'] ? 'active' : '' }}">
    {{ $item['label'] }}
</a>

{{-- Contoh dengan Tailwind --}}
<a href="{{ $item['url'] }}"
   class="{{ $item['active'] ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
    {{ $item['label'] }}
</a>
```

---

## Profil Menu - Auto Update

Menu Profil akan otomatis update ketika:
- Admin membuat halaman profil baru
- Mengubah urutan (order)
- Mengaktifkan/nonaktifkan halaman

Query: `Profil::active()->ordered()->get()`

---

## Example Implementation

### Full Header Navigation Example:

```blade
<nav class="header-nav-main">
    <ul class="nav nav-pills">
        @foreach($mainMenu as $item)
            @if(isset($item['children']) && count($item['children']) > 0)
                <li class="dropdown">
                    <a href="{{ $item['url'] }}"
                       class="nav-link dropdown-toggle {{ $item['active'] ? 'active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($item['children'] as $child)
                            <li>
                                <a href="{{ $child['url'] }}"
                                   class="dropdown-item {{ $child['active'] ? 'active' : '' }}">
                                    {{ $child['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li>
                    <a href="{{ $item['url'] }}"
                       class="nav-link {{ $item['active'] ? 'active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
```

---

## Customization

### Menambah Menu Baru:

Edit `app/Services/NavigationService.php`:

```php
public function getMainMenu(): array
{
    return [
        // ... existing menu
        [
            'label' => 'Menu Baru',
            'route' => 'menu.baru',
            'url' => route('menu.baru'),
            'active' => $this->isActiveRoute('menu.baru'),
        ],
    ];
}
```

### Menambah Breadcrumb Custom:

```php
public function getBreadcrumbs(): array
{
    // ... existing code

    if ($currentRoute === 'custom.page') {
        $breadcrumbs[] = ['label' => 'Custom Page'];
    }

    return $breadcrumbs;
}
```

---

## Notes:

1. **Active State** - Menggunakan wildcard `profil.*` untuk match semua route profil
2. **Dynamic Profil** - Menu profil otomatis dari database, no hardcode
3. **Breadcrumbs** - Auto-generate berdasarkan route
4. **Performance** - Menu di-cache di component, tidak query setiap render

---

## Testing:

1. Akses `/profil/tentang-kami` → Menu "Profil" dan submenu "Tentang Kami" aktif
2. Buat profil baru di admin → Otomatis muncul di menu
3. Ubah order profil → Menu sorting otomatis update
4. Nonaktifkan profil → Otomatis hilang dari menu
