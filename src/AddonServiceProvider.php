<?php

namespace Prodixx\DropzoneFieldForBackpack;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'prodixx';
    protected $packageName = 'dropzone-field-for-backpack';
    protected $commands = [];
}
