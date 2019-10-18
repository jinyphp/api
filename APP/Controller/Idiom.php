<?php
namespace App\Controller;

class Idiom extends \Core\App\Controller
{
    private $dbo;
    const PATH = "..";
    public function __construct()
    {
        $dbconf = \Jiny\Database\db_conf("../dbconf.php");
        if ($this->dbo = \Jiny\Database\db_init($dbconf)) {
            
        }
    }
    
    /**
     * method get
     */
    public function index()
    {
        $listrows = $this->idiom_list();
        $file = "../Resource/View/Idiom/index.htm";
        if (file_exists($file)) {
            $body = file_get_contents($file);
            $body = str_replace("{{content}}", $listrows, $body);
            echo $body;
        }
    }

    private function idiom_list()
    {
        $content ="
        <table class=\"table table-hover\">
    <thead>
      <tr>
        <th>번호</th>
        <th>사자숙어</th>
        <th>설명</th>
      </tr>
    </thead>    
    ";

        // 목록 출력
        $builder = $this->dbo->table("idiom");
        $fields = ['id','idiom','descript'];
        $query = $builder->select($fields)->getQuery();
        // echo $query."\n";

        // 자동생성
        $builder->createAuto()->run();

        if ($rows = $builder->fetchAll()) {
            $content .= "<tbody>";
            foreach ($rows as $row) {
                $content .= 
                "<tr>
                <td>".$row['id']."</td>
                <td>"."<a href='/idiom/".$row['id']."'>"."".$row['idiom']."</a>". "</td>
                <td>". $row['descript']."</td>
                </tr>";
            }
            $content .= "</tbody>";
            $content .= "</table>";
        } else {
            $content .= "</table>";

            if (empty($rows)) {
                $content .= "등록된 데이터가 없습니다.<br>";
            } else {
                $content .= "데이터 조회 실폐.<br>";
            }
            
        }

        $content .= "<a href='/idiom/new' class='btn btn-primary' >추가</a>";

        return $content;
    }



    /**
     * 데이터를 추가합니다.
     */
    public function new()
    {

        $content = "<form action='/idiom/newup' method=post>";

        $content .= "
        <div class=\"form-group\">
            <label for=\"idiom\">사자성어</label>
            <input type=\"text\" name='idiom' class=\"form-control\" id=\"idiom\">
        </div>

        <div class=\"form-group\">
            <label for=\"descriptm\">설명</label>
            <textarea name='descript' class=\"form-control\" id=\"descript\"> </textarea>
        </div>

        <input type='submit' class=\"btn btn-primary\" value='추가'>";

        $content .= "</form>";

        $file = "../Resource/View/Idiom/index.htm";
        if (file_exists($file)) {
            $body = file_get_contents($file);
            $body = str_replace("{{content}}", $content, $body);
            echo $body;
        }

    }

    /**
     * DB 삽입 작업을 실행합니다.
     */
    public function newup()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST' || $_SERVER['REQUEST_METHOD']=='post') {
            echo "추가합니다...";

            $builder = $this->dbo->table("idiom");

            // 배열 데이터를 작성합니다.
            $data = [
                'idiom' => "idiom",
                'descript' => htmlspecialchars(strip_tags($_POST['descript']))
            ];

            // 테이터를 삽입합니다.
            $query = $builder->insert($data)->getQuery();
            echo $query;

            $builder->fieldAuto()->run($data);

            \ob_end_clean();
            $redirect = "/idiom";
            header('Location: '.$redirect);
        }
    }

    /**
     * 상세목록 출력
     * 정의되지 않는 메소드
     */
    public function __call($method, $params)
    {
        if (is_numeric($method)) {
            return $this->view($method);
        }
    }

    /**
     * 내용출력
     */
    private function view($id)
    {
        //echo $id."를 출력합니다.";
        // 쿼리빌더 테이블 선택
        $builder = $this->dbo->table("idiom");
        $fields = ['id','idiom','descript'];
        $query = $builder->select($fields)->getQuery();

        // 조건추가
       
        $where = ['id'=>$id];
        $query = $builder->where($where)->getQuery();
        //echo $query."\n";
        

        // 쿼리 실행
        if($row = $builder->run($where)->fetch()) {
            //print_r($row);
            $content = "<form action='/idiom/modify' method=post>
                <input type=hidden name=id value='".$row['id']."'>";

                $content .= "
                <div class=\"form-group\">
                    <label for=\"idiom\">사자숙어</label>
                    <input type=\"text\" name='idiom' value='".$row['idiom']."' class=\"form-control\" id=\"idiom\">
                </div>

                <div class=\"form-group\">
                    <label for=\"descript\">내용</label>
                    <textarea name='descript' class=\"form-control\" id=\"descript\"> ". stripslashes($row['descript'])."</textarea>
                </div>

                <input type='submit' class=\"btn btn-primary\" value='수정'>
                <button type=button onclick=\"location.href='/idiom/delete'\"  class=\"btn btn-danger\">삭제</button>";

                $content .= "</form>";

                $file = "../Resource/View/Idiom/index.htm";
            if (file_exists($file)) {
                $body = file_get_contents($file);
                $body = str_replace("{{content}}", $content, $body);
                echo $body;
            }

        } else {
            // 데이터가 없습니다.
        }
        
    }

    public function modify()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST' || $_SERVER['REQUEST_METHOD']=='post') {
            echo "수정합니다....";

            $data = [
                'id' => $_POST['id'],
                'idiom' => $_POST['idiom'],
                'descript' => addslashes($_POST['descript'])
            ];

            $this->dbo->update("UPDATE idiom SET idiom = :idiom, descript = :descript where id=:id",$data);

            \ob_end_clean();
            $redirect = "/idiom";
            header('Location: '.$redirect);

        }
        
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST' || $_SERVER['REQUEST_METHOD']=='post') {

            $this->dbo->table("idiom")->deleteId($_POST['id']);

            \ob_end_clean();
            $redirect = "/idiom";
            header('Location: '.$redirect);

        } else {

        }
    }
}
