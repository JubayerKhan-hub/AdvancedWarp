<?php

namespace AdvancedWarp;

use pocketmine\player\Player;
use pocketmine\world\Position;

class WarpManager {

    private array $warps = [];

    public function addWarp(string $name, Position $position, ?string $description = null): bool {
        if (isset($this->warps[$name])) {
            return false; // Warp already exists
        }
        $this->warps[$name] = new Warp($name, $position, $description);
        return true;
    }

    public function removeWarp(string $name): bool {
        if (!isset($this->warps[$name])) {
            return false; // Warp does not exist
        }
        unset($this->warps[$name]);
        return true;
    }

    public function listWarps(): array {
        return array_keys($this->warps);
    }

    public function getWarp(string $name): ?Warp {
        return $this->warps[$name] ?? null;
    }

    public function teleportPlayerToWarp(Player $player, string $name): bool {
        $warp = $this->getWarp($name);
        if ($warp === null) {
            return false; // Warp does not exist
        }
        $player->teleport($warp->getPosition());
        return true;
    }
}
