<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\FileUpload\UploadComponents;

class DashboardComponentsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('uploadForm', function () {
            $component = UploadComponents::getUploadForm();
            $html = '<?php echo \'' . $component . '\'; ?>';

            return ('<?php echo "' . $component . '"; ?>');
        });
    }
}
