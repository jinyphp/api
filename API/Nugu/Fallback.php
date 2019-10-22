<?php
namespace API\Nugu;


/**
 * nugu AI backendProxy
 */
class Fallback extends \Jiny\Nugu\Controller
{
    private $dbo;
    const PATH = "..";
    public function __construct()
    {
        $dbconf = \Jiny\Database\db_conf("../dbconf.php");
        if ($this->dbo = \Jiny\Database\db_init($dbconf)) {
            
        }
    }

    public function POST()
    {
        if($nuguRes = new \Jiny\Nugu\Response) {
            $idiom = $this->Proxy->params("ask_forthidiom");
            

            // 쿼리빌더 테이블 선택
            $builder = $this->dbo->table("idiom");

            // 필드 선택
            $fields = ['idiom','descript'];
            $query = $builder->select($fields)->getQuery();           

            // 조건추가
            $where = ['idiom'=>$idiom];
            $query = $builder->where($where)->getQuery();            

            if ($row = $builder->run($where)->fetch()) {
                $res_text = $row['idiom']."의 뜻은 ".$row['descript']." 입니다.";
                $nuguRes->setOutput("res_idiom",$res_text );
                $nuguRes->setOutput("ask_forthidiom","");
            } else {
                $nuguRes->setOutput("res_idiom","죄송합니다. ".$idiom." 숙어을 잘 못들었습니다.");
            }

            return json_encode($nuguRes);
        }
        
    }
}
