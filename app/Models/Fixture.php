<?php

namespace App\Models;

class Fixture
{
    private string $id;
    private array $matches;
    private string $week;
    private bool $completed = false;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getMatches(): array
    {
        return $this->matches;
    }

    /**
     * @param array $matches
     */
    public function setMatches(array $matches): void
    {
        $this->matches = $matches;
    }

    /**
     * @return string
     */
    public function getWeek(): string
    {
        return $this->week;
    }

    /**
     * @param string $week
     */
    public function setWeek(string $week): void
    {
        $this->week = $week;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    /**
     * @param bool $completed
     */
    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }


}
