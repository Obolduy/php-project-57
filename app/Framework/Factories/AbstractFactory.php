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
        /** @var array<string, mixed> $data */
        $data = $request->all();
        return static::fromArray($data);
    }

    public static function fromRequestWithFiles(FormRequest $request): AbstractDTO
    {
        /** @var array<string, mixed> $data */
        $data = array_merge($request->all(), $request->allFiles());
        return static::fromArray($data);
    }

    public static function fromRequestValidated(FormRequest $request): AbstractDTO
    {
        /** @var array<string, mixed> $validated */
        $validated = $request->validated();
        return static::fromArray($validated);
    }

    public static function fromRequestValidatedWithFiles(FormRequest $request): AbstractDTO
    {
        /** @var array<string, mixed> $validated */
        $validated = $request->validated();
        /** @var array<string, mixed> $data */
        $data = array_merge($validated, $request->allFiles());
        return static::fromArray($data);
    }

    /**
     * @param array<string, mixed> $array
     */
    public static function fromArray(array $array): AbstractDTO
    {
        return static::reader(static::getDTO(), $array);
    }

    /**
     * @param Collection<int|string, mixed> $collection
     */
    public static function fromCollection(Collection $collection): AbstractDTO
    {
        return static::reader(static::getDTO(), $collection);
    }

    abstract public static function getDTO(): AbstractDTO;

    /**
     * @param iterable<int|string, mixed> $iterable
     */
    protected static function reader(AbstractDTO $class, iterable $iterable): AbstractDTO
    {
        foreach ($iterable as $key => $value) {
            $keyString = is_string($key) ? $key : strval($key);
            $keyString = Str::studly($keyString);
            $lcFirstKey = lcfirst($keyString);

            if (method_exists(static::class, 'set' . $keyString)) {
                $value = static::{'set' . $keyString}($value);
            }

            if (property_exists($class, $lcFirstKey)) {
                $class->{$lcFirstKey} = $value;
            }
        }

        return $class;
    }
}
