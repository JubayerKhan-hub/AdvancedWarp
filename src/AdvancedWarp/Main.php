<?php

namespace AdvancedWarp;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\world\Position;

class Main extends PluginBase {

    private WarpManager $warpManager;

    public function onEnable(): void {
        $this->warpManager = new WarpManager();
        $this->getLogger()->info("AdvancedWarp enabled!");
        $this->loadWarps(); // Load existing warps
    }

    public function onDisable(): void {
        $this->saveWarps(); // Save current warps
        $this->getLogger()->info("AdvancedWarp disabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "warp") {
            if (count($args) < 1) {
                $sender->sendMessage("Usage: /warp <set|delete|list|warp_name>");
                return true;
            }

            $subCommand = array_shift($args);

            if ($subCommand === "set") {
                if (!$sender->hasPermission("advancedwarp.admin")) {
                    $sender->sendMessage("You do not have permission to set warps.");
                    return true;
                }
                if (!$sender instanceof Player) {
                    $sender->sendMessage("This command can only be used by players.");
                    return true;
                }
                if (count($args) < 1) {
                    $sender->sendMessage("Usage: /warp set <name> [description]");
                    return true;
                }
                $name = array_shift($args);
                $description = count($args) > 0 ? implode(" ", $args) : null;
                if ($this->warpManager->addWarp($name, $sender->getPosition(), $description)) {
                    $sender->sendMessage("Warp '$name' set successfully.");
                } else {
                    $sender->sendMessage("A warp with that name already exists.");
                }
            } elseif ($subCommand === "delete") {
                if (!$sender->hasPermission("advancedwarp.admin")) {
                    $sender->sendMessage("§4You do not have permission to delete warps.");
                    return true;
                }
                if (count($args) < 1) {
                    $sender->sendMessage("§4Usage: /warp delete <name>");
                    return true;
                }
                $name = array_shift($args);
                if ($this->warpManager->removeWarp($name)) {
                    $sender->sendMessage("§aWarp '$name' deleted successfully.");
                } else {
                    $sender->sendMessage("Warp '$name' does not exist.");
                }
            } elseif ($subCommand === "list") {
                $warps = $this->warpManager->listWarps();
                if (empty($warps)) {
                    $sender->sendMessage("§4No warps set.");
                } else {
                    $sender->sendMessage("§aAvailable warps: " . implode(", ", $warps));
                }
            } else {
                if (!$sender->hasPermission("advancedwarp.use")) {
                    $sender->sendMessage("§4You do not have permission to use warps.");
                    return true;
                }
                if (!$sender instanceof Player) {
                    $sender->sendMessage("This command can only be used by players.");
                    return true;
                }
                if ($this->warpManager->teleportPlayerToWarp($sender, $subCommand)) {
                    $sender->sendMessage("§aTeleported to warp§b '$subCommand'.");
                } else {
                    $sender->sendMessage("§4Warp '$subCommand' does not exist.");
                }
            }

            return true;
        }

        return false;
    }

    private function loadWarps(): void {
        $path = $this->getDataFolder() . "warps.json";
        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);
            if (is_array($data)) {
                foreach ($data as $name => $warpData) {
                    $position = new Position(
                        $warpData['x'],
                        $warpData['y'],
                        $warpData['z'],
                        $this->getServer()->getWorldManager()->getWorldByName($warpData['world'])
                    );
                    $this->warpManager->addWarp($name, $position, $warpData['description'] ?? null);
                }
            }
        }
    }

    private function saveWarps(): void {
        $data = [];
        foreach ($this->warpManager->listWarps() as $name) {
            $warp = $this->warpManager->getWarp($name);
            if ($warp !== null) {
                $position = $warp->getPosition();
                $data[$name] = [
                    'x' => $position->getX(),
                    'y' => $position->getY(),
                    'z' => $position->getZ(),
                    'world' => $position->getWorld()->getFolderName(), // Updated to getFolderName
                    'description' => $warp->getDescription()
                ];
            }
        }
        file_put_contents($this->getDataFolder() . "warps.json", json_encode($data, JSON_PRETTY_PRINT));
    }
}
