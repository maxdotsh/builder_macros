<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class ChunkDynamicContentServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Builder::macro("chunkDynamicContent", function ($size, callable $callback) {
            $this->enforceOrderBy();

            $page = 1;
            $count = $this->get()->count();
            $iterator = intdiv($count, $size) + 1;

            for ($i = 1; $i <= $iterator; $i++) {
                $results = $this->forPage($page, $size)->get();

                if ($callback($results, $i) === false) {
                    return false;
                }

                unset($results);
            }

            return true;
        });
    }
}