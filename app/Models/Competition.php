<?php

namespace App\Models;

class Competition
{
    private string $id;
    private Team $homeTeam;
    private Team $awayTeam;
    private ?int $homeTeamGoal = null;
    private ?int $awayTeamGoal = null;
    private bool $played = false;

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
     * @return Team
     */
    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    /**
     * @param Team $homeTeam
     */
    public function setHomeTeam(Team $homeTeam): void
    {
        $this->homeTeam = $homeTeam;
    }

    /**
     * @return Team
     */
    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    /**
     * @param Team $awayTeam
     */
    public function setAwayTeam(Team $awayTeam): void
    {
        $this->awayTeam = $awayTeam;
    }

    /**
     * @return int|null
     */
    public function getHomeTeamGoal(): ?int
    {
        return $this->homeTeamGoal;
    }

    /**
     * @param int|null $homeTeamGoal
     */
    public function setHomeTeamGoal(?int $homeTeamGoal): void
    {
        $this->homeTeamGoal = $homeTeamGoal;
    }

    /**
     * @return int|null
     */
    public function getAwayTeamGoal(): ?int
    {
        return $this->awayTeamGoal;
    }

    /**
     * @param int|null $awayTeamGoal
     */
    public function setAwayTeamGoal(?int $awayTeamGoal): void
    {
        $this->awayTeamGoal = $awayTeamGoal;
    }

    /**
     * @return bool
     */
    public function isPlayed(): bool
    {
        return $this->played;
    }

    /**
     * @param bool $played
     */
    public function setPlayed(bool $played): void
    {
        $this->played = $played;
    }

}
