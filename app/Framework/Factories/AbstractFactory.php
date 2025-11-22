<?php

namespace App\Framework\Factories;

use App\Framework\DTO\AbstractDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class AbstractFactory
{
    public static function fromRequest(Request $request): AbstractDTO
    {
        return static::fromArray($request->all());
    }

    public static function fromRequestWithFiles(FormRequest $request): AbstractDTO
    {
        return static::fromArray(array_merge($request->all(), $request->allFiles()));
    }

    public static function fromRequestValidated(FormRequest $request): AbstractDTO
    {
        return static::fromArray($request->validated());
    }

    public static function fromRequestValidatedWithFiles(FormRequest $request): AbstractDTO
    {
        return static::fromArray(array_merge($request->validated(), $request->allFiles()));
    }

    public static function fromArray(array $array): AbstractDTO
    {
        return static::reader(static::getDTO(), $array);
    }

    public static function fromCollection(Collection $collection): AbstractDTO
    {
        return static::reader(static::getDTO(), $collection);
    }

    abstract public static function getDTO(): AbstractDTO;

    protected static function reader(AbstractDTO $class, iterable $iterable): AbstractDTO
    {
        foreach ($iterable as $key => $value) {
            $key = Str::studly($key);
            $lcFirstKey = lcfirst($key);

            if (method_exists(static::class, 'set' . $key)) {
                $value = static::{'set' . $key}($value);
            }

            if (property_exists($class, $lcFirstKey)) {
                $class->{$lcFirstKey} = $value;
            }
        }

        return $class;
    }
}

