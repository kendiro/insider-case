<?php

namespace App\Models;

class PointTable
{
    private Team $team;
    private int $win;
    private int $lose;
    private int $draw;
    private int $goalFor;
    private int $goalAgainst;
    private int $point;

    /**
     * @return Team
     */
    public function getTeam(): Team
    {
        return $this->team;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team): void
    {
        $this->team = $team;
    }

    /**
     * @return int
     */
    public function getWin(): int
    {
        return $this->win;
    }

    /**
     * @param int $win
     */
    public function setWin(int $win): void
    {
        $this->win = $win;
    }

    /**
     * @return int
     */
    public function getLose(): int
    {
        return $this->lose;
    }

    /**
     * @param int $lose
     */
    public function setLose(int $lose): void
    {
        $this->lose = $lose;
    }

    /**
     * @return int
     */
    public function getDraw(): int
    {
        return $this->draw;
    }

    /**
     * @param int $draw
     */
    public function setDraw(int $draw): void
    {
        $this->draw = $draw;
    }

    /**
     * @return int
     */
    public function getGoalFor(): int
    {
        return $this->goalFor;
    }

    /**
     * @param int $goalFor
     */
    public function setGoalFor(int $goalFor): void
    {
        $this->goalFor = $goalFor;
    }

    /**
     * @return int
     */
    public function getGoalAgainst(): int
    {
        return $this->goalAgainst;
    }

    /**
     * @param int $goalAgainst
     */
    public function setGoalAgainst(int $goalAgainst): void
    {
        $this->goalAgainst = $goalAgainst;
    }

    /**
     * @return int
     */
    public function getPoint(): int
    {
        return $this->point;
    }

    /**
     * @param int $point
     */
    public function setPoint(int $point): void
    {
        $this->point = $point;
    }

}
