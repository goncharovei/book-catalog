<?php

namespace App\Common\Service;

final class SiteSide
{
    private static ?SiteSide $instance = null;

    /**
     * gets the instance via lazy initialization (created on first usage)
     */
    public static function getInstance(bool $isFront = false, bool $isApi = false): SiteSide
    {
        if (self::$instance === null) {
            self::$instance = new self($isFront, $isApi);
        }

        return self::$instance;
    }

    public static function flush(): void
    {
        self::$instance = null;
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
    private function __construct(
        private bool $isFront = false,
        private bool $isApi = false
    )
    {
        $this->setFlags();
    }

    private function setFlags(): void
    {
        $segments = $this->urlSegments();
        if (empty($segments))
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
            return null;
        }

        $segments = explode('/', rawurldecode($_SERVER['REQUEST_URI']));
        $segments = array_values(array_filter(array_map('trim', $segments), function ($value) {
            return !empty($value);
        }));

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

