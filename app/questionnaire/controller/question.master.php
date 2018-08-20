<?php
/**
 * Created by PhpStorm.
 * User: baiencai
 * Date: 2018/8/20
 * Time: 16:05
 */

class action extends app
{
    public function display()
    {
        $this->questionnaire = $this->G->make('questionnaire','questionnaire');

        $action = $this->ev->url(3);
        if(!method_exists($this,$action))
            $action = "index";
        $this->$action();
        exit;
    }

    /**
     * 某门课程的评论列表
     */
    public function index()
    {
        $courseId = $this->ev->get('courseid');

        $questions = $this->questionnaire->getQuestionListByCourseId($courseId);
        $this->tpl->assign('questions', $questions);
        $this->tpl->display('index');
    }

}


?>
