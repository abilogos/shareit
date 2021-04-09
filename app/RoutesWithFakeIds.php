<?php namespace App;

use Illuminate\Support\Facades\App;
use Exception;
use RuntimeException;

trait RoutesWithFakeIds
{
    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        $key = $this->getKey();
        if ($this->getKeyType() === 'int' && (ctype_digit($key) || is_int($key))) {
            return App::make('fakehashid')->encode($key);
        }

        throw new RuntimeException('Key should be of type int to encode into a fake id.');
    }

    /**
     * Retrieve model for route model binding
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        try {
            $value = App::make('fakehashid')->decode($value);
        } catch (Exception $e) {
            return null;
        }

        return $this->where($field ?? $this->getRouteKeyName(), $value)->first();
    }
}
