<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        EloquentBuilder::macro("hydrateWith", function(array $items, array $with = []) {
            $instance = EloquentBuilder::newModelInstance();

            return $instance->newCollection(array_map(function ($item) use ($instance, $with) {
                $model = $instance->newFromBuilder($item);
                if (count($with)) {
                    $results = [];
                    foreach ($with as $name) {
                        $keys = explode('.', $name);
                        $key = array_shift($keys);
                        if (! array_key_exists($key, $results)) {
                            $results[$key] = [];
                        }
                        if (count($keys)) {
                            $results[$key][] = implode('.', $keys);
                        }
                    }
                    foreach ($results as $key => $value) {
                        if (method_exists($model, $key) && array_key_exists($key, $model->getAttributes())) {
                            $result = $model->$key();
                            if ($result instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
                                if ($result instanceof \Illuminate\Database\Eloquent\Relations\HasOne
                                    || $result instanceof \Illuminate\Database\Eloquent\Relations\HasOneThrough
                                    || $result instanceof \Illuminate\Database\Eloquent\Relations\BelongsTo
                                    || $result instanceof \Illuminate\Database\Eloquent\Relations\MorphOne) {
                                    $relation = $result->getModel()::hydrateWith([$model->getAttributes()[$key]], $value)->first();
                                    $model->offsetUnset($key);
                                    $model->setRelation($key, $relation);
                                } elseif ($result instanceof \Illuminate\Database\Eloquent\Relations\HasMany
                                    || $result instanceof \Illuminate\Database\Eloquent\Relations\HasManyThrough
                                    || $result instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany
                                    || $result instanceof \Illuminate\Database\Eloquent\Relations\MorphMany) {
                                    $relation = $result->getModel()::hydrateWith($model->getAttributes()[$key], $value);
                                    $model->offsetUnset($key);
                                    $model->setRelation($key, $relation);
                                } else {
                                    throw new \RuntimeException('Relation '.get_class($result).' is not hydratable.');
                                }
                            } else {
                                throw new \RuntimeException($key.' is not a relation.');
                            }
                        }
                    }
                }

                return $model;
            }, $items));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
