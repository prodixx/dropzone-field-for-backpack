# Dropzone Field for Backpack 4

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![The Whole Fruit Manifesto](https://img.shields.io/badge/writing%20standard-the%20whole%20fruit-brightgreen)](https://github.com/the-whole-fruit/manifesto)

This package provides a [Dropzone](https://www.dropzonejs.com/) field type for projects that use the [Backpack for Laravel](https://backpackforlaravel.com/) administration panel.

More exactly, the dropzone field type allows admins to upload multiple images to a crud entity. After uploading you can reorder the images simply by drag and drop.


## Screenshots

![Backpack Toggle Field Addon](https://user-images.githubusercontent.com/3352723/121692505-d1650900-cad0-11eb-8526-d8f18307785e.jpg)


## Installation

Via Composer

``` bash
composer require prodixx/dropzone-field-for-backpack
```

## Usage

For the moment you can use drozone field only on update operantions. So, to use it, inside your custom CrudController do:

```php
namespace App\Http\Controllers\Admin;

use Prodixx\DropzoneFieldForBackpack\Traits\DropzoneTrait;

class ProductCrudController extends CrudController
{
    use DropzoneTrait;

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        CRUD::addField(
            [
                'name'             => 'images',
                'label'            => 'Images',
                'type'             => 'dropzone',
                'disk'             => 'public',
                'destination_path' => 'products/',
                'image_width'      => 800,
                'image_height'     => 600,
                'mimes'            => 'image/*',
                'max_file_size'    => 5, // MB
                'webp'             => true, // (optional) also save webp version
                'view_namespace'   => 'prodixx.dropzone-field-for-backpack::fields',
                'thumb_prefix'     => '',
                // 'hint'          => 'Some info', // (optional) some text that is shown under the field
                // 'tab'           => 'Images', // (optional) if you want the field to be shown in tabs
            ],
        );
    }
}
```

Notice the ```view_namespace``` attribute - make sure that is exactly as above, to tell Backpack to load the field from this _addon package_, instead of assuming it's inside the _Backpack\CRUD package_.


## Overwriting

If you need to change the field in any way, you can easily publish the file to your app, and modify that file any way you want. But please keep in mind that you will not be getting any updates.

**Step 1.** Copy-paste the blade file to your directory:
```bash
# create the fields directory if it's not already there
mkdir -p resources/views/vendor/backpack/crud/fields

# copy the blade file inside the folder we created above
cp -i vendor/prodixx/dropzone-field-for-backpack/src/resources/views/fields/dropzone.blade.php resources/views/vendor/backpack/crud/fields/dropzone.blade.php
```

**Step 2.** Remove the vendor namespace wherever you've used the field:
```diff
    CRUD::addField(
        [
            'name'             => 'images',
            'label'            => 'Images',
            'type'             => 'dropzone',
            'disk'             => 'public',
            'destination_path' => 'products/',
            'image_width'      => 800,
            'image_height'     => 600,
            'mimes'            => 'image/*',
            'max_file_size'    => 5, // MB
            'webp'             => true,
-           'view_namespace' => 'prodixx.dropzone-field-for-backpack::fields'
            'thumb_prefix'     => '',
            // 'hint'          => 'Some info', // (optional) some text that is shown under the field
            // 'tab'           => 'Images', // (optional) if you want the field to be shown in tabs
        ],
    );
```

**Step 3.** Uninstall this package. Since it only provides one file, and you're no longer using that file, it makes no sense to have the package installed:
```bash
composer remove prodixx/dropzone-field-for-backpack
```

## Change log

Changes are documented here on Github. Please see the [Releases tab](https://github.com/prodixx/dropzone-field-for-backpack/releases).

## Contributing

Please see [contributing.md](contributing.md) for a todolist and howtos.

## Security

If you discover any security related issues, please email catalin.prodan@newpixel.ro instead of using the issue tracker.

## Credits

- [Catalin Prodan][link-author]
- [Cristian Tabacitu](https://github.com/tabacitu) - For being the creator of Backpack
- [All Contributors][link-contributors]

## License

This project was released under MIT, so you can install it on top of any Backpack & Laravel project. Please see the [license file](license.md) for more information.

However, please note that you do need Backpack installed, so you need to also abide by its [YUMMY License](https://github.com/Laravel-Backpack/CRUD/blob/master/LICENSE.md). That means in production you'll need a Backpack license code. You can get a free one for non-commercial use (or a paid one for commercial use) on [backpackforlaravel.com](https://backpackforlaravel.com).


[ico-version]: https://img.shields.io/packagist/v/prodixx/dropzone-field-for-backpack.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/prodixx/dropzone-field-for-backpack.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/prodixx/dropzone-field-for-backpack
[link-downloads]: https://packagist.org/packages/prodixx/dropzone-field-for-backpack
[link-author]: https://github.com/prodixx
[link-contributors]: ../../contributors
