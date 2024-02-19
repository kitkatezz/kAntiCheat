<?php

declare(strict_types=1);

namespace kitkat\anticheat;

use kitkat\anticheat\settings\Settings;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\Player;

final class EventListener implements Listener
{

    /** @var string<int> */
    private $data = [];

    /**
     * @priority HIGHEST
     * @ignoreCancelled
     */
    public function onEntityDamage(EntityDamageEvent $event)
    {
        if ($event instanceof EntityDamageByEntityEvent) {
            $entity = $event->getEntity();
            $damager = $event->getDamager();

            if ($entity instanceof Player && $damager instanceof Player) {
                $settings = Settings::get();

                if (!$damager->isCreative()) {
                    if ($damager->distance($entity) > $settings->maxHitDistance()) {
                        $event->setCancelled(true);
                        return;
                    }
                }

                $damagerName = $damager->getName();

                if (!isset($this->data[$damagerName])) {
                    $this->data[$damagerName] = microtime(true);
                    return;
                }

                $lastHitTime = microtime(true) - $this->data[$damagerName];
                if ($lastHitTime < $settings->delayPerHit()) {
                    $event->setCancelled(true);
                } else {
                    $this->data[$damagerName] = microtime(true);
                }
            }
        }
    }
}
