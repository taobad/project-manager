<?php
namespace Workice\PdfInvoice;

use Illuminate\Support\ServiceProvider;

class InvoicrServiceProvider extends ServiceProvider
{
    /**
     * Publishes configuration file.
     *
     * @return  void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/invoicr.php' => config_path('invoicr.php'),
        ], 'invoicr');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'invoicr');
    }
    /**
     * Make config publishment optional by merging the config from the package.
     *
     * @return  void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/invoicr.php',
            'invoicr'
        );
    }
}
