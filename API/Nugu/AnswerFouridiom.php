<?php
namespace API\Nugu;
/**
 * nugu AI backendProxy
 */
class AnswerFouridiom extends \Jiny\Nugu\Controller
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
            $idiom = $this->Proxy->params("idiom");

            // 쿼리빌더 테이블 선택
            $builder = $this->dbo->table("idiom");

            // 필드 선택
            $fields = ['idiom','descript'];
            $query = $builder->select($fields)->getQuery();           

            // 조건추가
            $where = ['id'=>1];
            $query = $builder->where($where)->getQuery();            

            if ($row = $builder->run($where)->fetch()) {
                $nuguRes->setOutput("res_idiom", $row['descript']);
            } else {
                $nuguRes->setOutput("res_idiom","죄송합니다. ".$idiom." 숙어을 잘 못들었습니다.");
            }

            return json_encode($nuguRes);
        }
        
    }
}
