<?php
# _    _ _ _             ______         _   _                 
#| |  | | | |           |  ____|       | | (_)                
#| |  | | | |_ _ __ __ _| |__ __ _  ___| |_ _  ___  _ __  ___ 
#| |  | | | __| '__/ _` |  __/ _` |/ __| __| |/ _ \| '_ \/ __|
#| |__| | | |_| | | (_| | | | (_| | (__| |_| | (_) | | | \__ \
# \____/|_|\__|_|  \__,_|_|  \__,_|\___|\__|_|\___/|_| |_|___/
#
# Made by PocketEssential Copyright 2016 ©
#
# This is a public software, you cannot redistribute it a and/or modify any way
# unless otherwise given permission to do so.
#
# Author:The PocketEssential Team
# Link:https://github.com/PocketEssential
#
#|------------------------------------------------- UltraFaction -------------------------------------------------|
#| - If you want to suggest/contribute something, read our contributing guidelines on our Github Repo (Link Below)|
#| - If you find an issue, please report it at https://github.com/PocketEssential/UltraFaction/issues |
#|----------------------------------------------------------------------------------------------------------------|
namespace PocketEssential\UltraFaction;

use PocketEssential\UltraFaction\UltraFaction;
use pocketmine\event\Listener;
use pocektmine\event\player\PlayerChatEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\utils\TextFormat as TF;

class EventListener implements Listener {
 	public function __construct(UltraFaction $plugin) {
 		$this->plugin = $plugin;
 	}
 	public function onChat(PlayerChatEvent $event) {
 		$player = $event->getPlayer();
 		$message = $event->getMessage();
 		$faction = $this->plugin->getPlayerFaction($player);
 		$purechat = $this->plugin->getServer()->getPluginManager()->getPlugin("PureChat");
 		if($purechat) {
 			if($this->plugin->IsPlayerInFaction($player)) {
 				if($this->plugin->getFactionLeader($faction) == $player->getName()) {
 					$event->setFormat("**". $faction . $player->getName() ." > ". $message);
 				} else {
					$event->setFormat($faction . $player->getName() ." > ". $message);
 				}
 			} else {
				$event->setFormat($player->getName() ." > ". $message);
 			}
 		}
 	}
 	public function onDamage(EntityDamageEvent $event) {
 		if($event instanceof EntityDamageByEntityEvent) {
 			if($event->getEntity() instanceof Player && $event->getDamager() instanceof Player) {
 				$player = $event->getEntity();
 				$damager = $event->getDamager();
 				if($this->plugin->isSameFaction($player, $damager) && $this->plugin->getConfig()->get("Can_Attack") === false) {
 					$event->setCancelled(true);
 				}
 			}
 		}
 	}
}