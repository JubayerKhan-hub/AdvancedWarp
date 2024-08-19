<?php

namespace AdvancedWarp;

use pocketmine\world\Position;

class Warp {

    private string $name;
    private Position $position;
    private ?string $description;

    public function __construct(string $name, Position $position, ?string $description = null) {
        $this->name = $name;
        $this->position = $position;
        $this->description = $description;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPosition(): Position {
        return $this->position;
    }

    public function getDescription(): ?string {
        return $this->description;
    }
}
