<?php

declare(strict_types=1);

namespace kitkat\anticheat;

use kitkat\anticheat\settings\Settings;
use pocketmine\plugin\PluginBase;

/**
 * @author kitkat. <https://github.com/kitkatezz>
 * @copyright 2024 kitkat. - Todos os direitos reservados
 */

final class Loader extends PluginBase
{

    /** @var self */
    private static $instance = null;

    /** @return self */
    public static function get(): self
    {
        return self::$instance;
    }
    
    public function onLoad()
    {
        self::$instance = $this;
        Settings::get()->init();
    }

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener, $this);
    }
}
