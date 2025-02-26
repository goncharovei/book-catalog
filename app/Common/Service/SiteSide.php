<?php

namespace App\Common\Service;

use Illuminate\Http\Request;

final class SiteSide
{
    private static ?SiteSide $instance = null;
    private bool $isFront = false;
    private bool $isApi = false;

    /**
     * gets the instance via lazy initialization (created on first usage)
     */
    public static function getInstance(): SiteSide
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function isFront(): bool
    {
        return $this->isFront;
    }

    public function isApi(): bool
    {
        return $this->isApi;
    }

    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from SiteSide::getInstance() instead
     */
    private function __construct()
    {
        $this->setFlags();
    }

    private function setFlags(): void
    {
        $segments = $this->urlSegments();
        if ($segments === null)
        {
            return;
        }

        $this->isApi = !empty($segments[0]) && $segments[0] === 'api';
        $this->isFront = !$this->isApi;
    }

    private function urlSegments(): null|array
    {
        if (empty($_SERVER['REQUEST_URI']))
        {
            if (!class_exists(Request::class, autoload: false))
            {
                return null;
            }
            $segments = request()->segments();
        } else {
            $segments = explode('/', rawurldecode($_SERVER['REQUEST_URI']));
            $segments = array_values(array_filter($segments, function ($value) {
                return $value !== '';
            }));
        }

        return array_map('strtolower', $segments);
    }

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * prevent from being serialized (which would create a second instance of it)
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception('Cannot serialize singleton');
    }
}

