<?php

namespace App\Models;

class Team
{
    private string $id;
    private string $name;
    private int $power;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Team
     */
    public function setId(string $id): Team
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Team
     */
    public function setName(string $name): Team
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getPower(): int
    {
        return $this->power;
    }

    /**
     * @param int $power
     * @return Team
     */
    public function setPower(int $power): Team
    {
        $this->power = $power;

        return $this;
    }

}
