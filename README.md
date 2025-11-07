# Blade Feather Icons

<a href="https://packagist.org/packages/brunocfalcao/blade-feather-icons">
    <img src="https://poser.pugx.org/brunocfalcao/blade-feather-icons/v/stable.svg" alt="Latest Stable Version">
</a>
<a href="https://packagist.org/packages/brunocfalcao/blade-feather-icons">
    <img src="https://poser.pugx.org/brunocfalcao/blade-feather-icons/d/total.svg" alt="Total Downloads">
</a>
<a href="https://packagist.org/packages/brunocfalcao/blade-feather-icons">
    <img src="https://poser.pugx.org/brunocfalcao/blade-feather-icons/license.svg" alt="License">
</a>

A Laravel package to easily use [Feather Icons](https://github.com/feathericons/feather) in your Blade views as inline SVG components.

For a full list of available icons, see [the SVG directory](resources/svg) or preview them at [feathericons.com](https://feathericons.com/).

## ✨ Features

- 🎨 **287+ Beautiful Icons** - Simple, consistent, open-source icons
- 🚀 **Zero Dependencies** - No JavaScript required, pure inline SVG
- 💎 **Laravel Integration** - Native Blade component syntax
- 🎯 **Full Control** - Add classes, styles, and attributes easily
- ⚡ **Performance** - Cached and optimized SVG rendering
- 🔧 **Customizable** - Tailwind CSS and any CSS framework compatible
- 🔄 **NPM Sync Command** - Keep icons updated from official Feather Icons releases

## 📋 Requirements

- **PHP**: 8.1 or higher
- **Laravel**: 9.0 or higher
- **blade-ui-kit/blade-icons**: ^1.0

## 📦 Installation

Install the package via Composer:

```bash
composer require brunocfalcao/blade-feather-icons
```

The package will automatically register itself via Laravel's package auto-discovery.

## 🚀 Usage

### Basic Usage

Icons can be used as self-closing Blade components:

```blade
<x-feathericon-heart />
<x-feathericon-alert-triangle />
<x-feathericon-activity />
```

### Adding Classes

Perfect for Tailwind CSS or any CSS framework:

```blade
<x-feathericon-heart class="w-6 h-6 text-red-500" />
<x-feathericon-mail class="h-4 w-4 text-gray-600" />
```

### Adding Inline Styles

```blade
<x-feathericon-star style="color: #FFD700; width: 32px; height: 32px;" />
```

### Adding Multiple Attributes

```blade
<x-feathericon-check-circle
    class="w-5 h-5 text-green-500"
    aria-hidden="true"
    data-icon="success"
/>
```

### Using with Alpine.js

```blade
<button @click="liked = !liked">
    <x-feathericon-heart
        class="w-5 h-5"
        ::class="liked ? 'text-red-500 fill-current' : 'text-gray-400'"
    />
</button>
```

### Common Examples

```blade
{{-- Navigation --}}
<nav>
    <a href="/dashboard">
        <x-feathericon-home class="w-5 h-5" />
        Dashboard
    </a>
    <a href="/settings">
        <x-feathericon-settings class="w-5 h-5" />
        Settings
    </a>
</nav>

{{-- Buttons --}}
<button class="btn">
    <x-feathericon-download class="w-4 h-4 mr-2" />
    Download
</button>

{{-- Alerts --}}
<div class="alert alert-warning">
    <x-feathericon-alert-triangle class="w-5 h-5" />
    <span>Warning message here</span>
</div>

{{-- Loading States --}}
<x-feathericon-loader class="w-6 h-6 animate-spin text-blue-500" />
```

## 🎨 Available Icons

All 287 Feather icons are available. Common icons include:

**Interface**: `home`, `menu`, `x`, `check`, `chevron-down`, `chevron-up`, `arrow-right`, `arrow-left`, `more-vertical`, `more-horizontal`

**Media**: `play`, `pause`, `volume`, `volume-x`, `music`, `video`, `image`, `camera`, `film`

**Communication**: `mail`, `message-circle`, `phone`, `at-sign`, `bell`, `send`

**Files**: `file`, `folder`, `download`, `upload`, `save`, `trash`, `edit`, `copy`

**Social**: `heart`, `star`, `thumbs-up`, `share`, `bookmark`

**E-commerce**: `shopping-cart`, `credit-card`, `dollar-sign`, `tag`

**Status**: `check-circle`, `x-circle`, `alert-circle`, `alert-triangle`, `info`, `help-circle`

**System**: `settings`, `user`, `lock`, `unlock`, `eye`, `eye-off`, `search`, `filter`

[View all icons →](https://feathericons.com/)

## 🔧 Publishing Assets (Optional)

If you need the raw SVG files as static assets:

```bash
php artisan vendor:publish --tag=blade-feather-icons --force
```

This will publish the icons to `public/vendor/feather-icons/`.

Then use them in your views:

```blade
<img src="{{ asset('vendor/feather-icons/heart.svg') }}" width="24" height="24" alt="Heart" />
```

**Note:** This is rarely needed. Using Blade components (default) is recommended for better performance and control.

## 🔄 Syncing Icons from NPM

Want to keep your icons up-to-date with the latest Feather Icons releases? You can sync SVG files directly from the npm package.

### Prerequisites

First, install the official Feather Icons npm package in your project:

```bash
npm install feather-icons --save-dev
```

### Sync Command

Run the sync command to update your package's SVG files:

```bash
php artisan feathericons:sync
```

This will:
- ✅ Copy all icons from `node_modules/feather-icons/dist/icons` to the package
- ✅ Detect new, updated, and unchanged icons
- ✅ Display a detailed progress report

### Dry Run

Preview changes without actually copying files:

```bash
php artisan feathericons:sync --dry-run
```

Example output:
```
Syncing Feather Icons...
████████████████████████████ 100%

Total icons .......... 287
Would be added ....... 5
Would be updated ..... 12
Unchanged ............ 270

Run without --dry-run to apply these changes.
```

### Custom NPM Path

If your `node_modules` is in a non-standard location:

```bash
php artisan feathericons:sync --npm-path=/custom/path/to/project
```

### When to Sync

- 📦 After updating the `feather-icons` npm package
- 🆕 When new icons are released by Feather Icons
- 🔧 If you manually modified icons and want to revert to originals

**Note:** This is a unique feature not available in other Blade icon packages! It gives you full control over your icon versions.

## 🧪 Testing

The package includes comprehensive Pest tests:

```bash
composer test
```

Run tests with coverage:

```bash
composer test-coverage
```

## 📚 Advanced Usage

### Using the Helper Function

You can also use the `svg()` helper function:

```php
{!! svg('feathericon-heart', 'w-6 h-6 text-red-500') !!}
```

With multiple attributes:

```php
{!! svg('feathericon-star', ['class' => 'w-6 h-6', 'style' => 'color: gold']) !!}
```

### Custom Prefix

If you want to change the default `feathericon-` prefix, you can extend the service provider in your own application.

### Blade Icons Features

This package is built on top of [Blade Icons](https://github.com/blade-ui-kit/blade-icons). You can use all Blade Icons features:

- [Default classes](https://github.com/blade-ui-kit/blade-icons#default-classes)
- [Icon sets](https://github.com/blade-ui-kit/blade-icons#icon-sets)
- [Custom attributes](https://github.com/blade-ui-kit/blade-icons#attributes)

## 🐛 Troubleshooting

### Icons not showing?

1. Make sure you've installed the package: `composer require brunocfalcao/blade-feather-icons`
2. Clear Laravel's cache: `php artisan view:clear && php artisan cache:clear`
3. Check your icon name matches the filename in `resources/svg/`

### Wrong icon name?

Icon names use kebab-case. For example:
- `alert-triangle.svg` → `<x-feathericon-alert-triangle />`
- `arrow-up-right.svg` → `<x-feathericon-arrow-up-right />`

### Using with Livewire?

Blade Feather Icons works perfectly with Livewire. Just use the components as normal:

```blade
<div>
    @if($isActive)
        <x-feathericon-check-circle class="w-5 h-5 text-green-500" />
    @else
        <x-feathericon-x-circle class="w-5 h-5 text-red-500" />
    @endif
</div>
```

## 📝 Changelog

Please see [CHANGELOG](CHANGELOG.md) for recent changes.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 👨‍💻 Maintainers

**Blade Feather Icons** is developed and maintained by [Bruno Falcao](https://github.com/brunocfalcao).

**Blade Icons** is developed and maintained by [Dries Vints](https://driesvints.com).

**Feather Icons** is created by [Cole Bemis](https://github.com/colebemis).

## 📄 License

Blade Feather Icons is open-sourced software licensed under the [MIT license](LICENSE.md).

Feather Icons is also licensed under the [MIT license](https://github.com/feathericons/feather/blob/master/LICENSE).

## 🌟 Related Packages

- [Blade Icons](https://github.com/blade-ui-kit/blade-icons) - The foundation for this package
- [Blade Heroicons](https://github.com/blade-ui-kit/blade-heroicons) - Heroicons for Laravel
- [Blade Font Awesome](https://github.com/owenvoke/blade-fontawesome) - Font Awesome for Laravel

---

**Love this package?** Give it a ⭐️ on [GitHub](https://github.com/brunocfalcao/blade-feather-icons) and follow [@brunocfalcao](https://twitter.com/brunocfalcao) on Twitter!
