<?php


namespace App\Models;
use App\Core\Model;

class FavFilm extends Model
{
    /**
     * @var int
     */
    protected $id_user;
    /**
     * @var int
     */
    protected $id_film;

    public function __construct($id_user = 0, $id_film = 0)
    {
        $this->id_user = $id_user;
        $this->id_film = $id_film;
    }

    static public function setDbColumns()
    {
        return ['id_user', 'id_film'];
    }

    static public function setTableName()
    {
        return 'favorite_film';
    }

    /**
     * @return int
     */
    public function getIdFilm()
    {
        return $this->id_film;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->id_user;
    }


    static public function setPkColumn()
    {
        return 'id_film';
    }
}