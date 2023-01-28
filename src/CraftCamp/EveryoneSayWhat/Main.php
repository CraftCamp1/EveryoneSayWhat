<?php

namespace CraftCamp\EveryoneSayWhat;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class Main extends PluginBase {

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        switch ($command->getName()) {
            case "everyonesaywhat":
            case "esw":
                if(empty($args)){
                    $sender->sendMessage("Please provide a message to be broadcasted");
                    return true;
                }
                $players = $this->getServer()->getOnlinePlayers();
                if (empty($players)) {
                    $sender->sendMessage("No players to execute command on");
                    return true;
                }
                $message = implode(" ", $args);
                $count = 0;
                foreach ($players as $player) {
                    if ($player === $sender) continue;
                    if (!$player->hasPermission("everyonesaywhat.deny")) {
                        $player->chat($message);
                        $count++;
                    }
                }
                if ($count === 0) {
                    $sender->sendMessage("No players to execute command on");
                }else{
                    if($sender instanceof Player){
                        $this->getServer()->getLogger()->info("[".$sender->getName()."] said: ".$message);
                    }else{
                        $this->getServer()->getLogger()->info("[Console] said: ".$message);
                    }
                }
                return true;
                break;
        }
        return false;
    }
}
