<?php


namespace App\Models;
use App\Core\Model;

class Score extends Model
{

    protected string $nickname;
    protected int $score;

    public function __construct($nickname = "", $score = 0)
    {

        $this->nickname = $nickname;
        $this->score = $score;
    }

    static public function setPkColumn()
    {
        return 'id';
    }

    static public function setDbColumns()
    {
        return ['id', 'nickname', 'score'];
    }

    static public function setTableName()
    {
        return 'score_table';
    }

    /**
     * @return mixed|string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return int|mixed
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param mixed|string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @param int|mixed $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }
}