<?php


namespace App\Models;
use App\Core\Model;

class Film extends Model
{
    /**
     * @var int
     */
    protected $id_film;
    /**
     * @var string
     */
    protected $img;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $about_film;
    /**
     * @var int
     */
    protected $film_type;

    public function __construct($img = "", $title = "", $about_film = "", $film_type = 0)
    {
        $this->img = $img;
        $this->title = $title;
        $this->about_film = $about_film;
        $this->film_type = $film_type;
    }

    static public function setDbColumns()
    {
        return ['id_film', 'img', 'title', 'about_film', 'film_type'];
    }

    static public function setTableName()
    {
        return 'film';
    }

    /**
     * @return int
     */
    public function getFilmType()
    {
        return $this->film_type;
    }

    /**
     * @param int $film_type
     */
    public function setFilmType($film_type)
    {
        $this->film_type = $film_type;
    }

    /**
     * @return string
     */
    public function getAboutFilm()
    {
        return $this->about_film;
    }

    /**
     * @param string $about_film
     */
    public function setAboutFilm($about_film)
    {
        $this->about_film = $about_film;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @return int
     */
    public function getIdFilm()
    {
        return $this->id_film;
    }

    static public function setPkColumn()
    {
        return 'id_film';
    }
}