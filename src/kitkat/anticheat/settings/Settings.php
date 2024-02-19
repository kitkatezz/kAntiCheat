<?php

declare(strict_types=1);

namespace kitkat\anticheat\settings;

use kitkat\anticheat\Loader;

final class Settings
{

    /** @var self */
    private static $instance = null;

    /** @return self */
    public static function get(): self
    {
        if (!self::$instance) self::$instance = new self;
        return self::$instance;
    }

    /** @var float */
    private $maxHitDistance;

    /** @var float */
    private $delayPerHit;

    public function init()
    {
        @mkdir(($plugin = Loader::get())->getDataFolder());
        $plugin->saveDefaultConfig();

        $config = $plugin->getConfig();

        $this->maxHitDistance = $config->get('max_hit_distance', 4);
        $this->delayPerHit = $config->get('delay_per_hit', 0.25);
    }

    /**
     * @return float
     */
    public function maxHitDistance(): float
    {
        return (float) $this->maxHitDistance;
    }

    /**
     * @return float
     */
    public function delayPerHit(): float
    {
        return (float) $this->delayPerHit;
    }
}
