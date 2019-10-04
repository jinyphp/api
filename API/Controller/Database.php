<?php
namespace API\Controller;

class Database extends \Core\API\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        
    }

    public function post()
    {
        $body = $this->Request->getBody();
        $body = json_decode($body, true);
    
        $dbinfo = \Jiny\Database\db_conf("../dbconf.php");
        $db = \Jiny\Database\db_init($dbinfo);
        if ($db) {

            $builder = $db->table($body['Table']);
            $query = $builder->select($body['Fields'])->getQuery();

            $rows = $builder->run()->fetchAll();
            echo json_encode($rows);

        } else {
            // echo "db 접속 실패\n";
        }
    }

    public function put()
    {

    }

    public function delete()
    {
        
    }

}