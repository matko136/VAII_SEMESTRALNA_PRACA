<?php


namespace App\Models;
use App\Core\Model;

class User extends Model
{
    protected $id_user;
    protected $log;
    protected $name;
    protected $surename;
    protected $email;
    protected $psswd;
    protected $user_type;


    /*protected function setPkColumn() {
        self::$pkColumn = "id_user";
    }*/

    public function __construct($log = "", $name = "", $surename = "", $email = "", $passwd = "", $user_type = 0)
    {
        self::$pkColumn = "id_user";
        /*$this->title = $title;
        $this->text = $text;*/

    }


    static public function setDbColumns()
    {
        return ['id_user', 'log', 'name', 'surename', 'email', 'passwd', 'user_type'];
    }

    static public function setTableName()
    {
        return "user";
    }


    /**
     * @return mixed
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param mixed $log
     */
    public function setLog($log)
    {
        $this->log = $log;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurename()
    {
        return $this->surename;
    }

    /**
     * @param mixed $surename
     */
    public function setSurename($surename)
    {
        $this->surename = $surename;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPsswd()
    {
        return $this->psswd;
    }

    /**
     * @param mixed $psswd
     */
    public function setPsswd($psswd)
    {
        $this->psswd = $psswd;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @param mixed $user_type
     */
    public function setUserType($user_type)
    {
        $this->user_type = $user_type;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }
}