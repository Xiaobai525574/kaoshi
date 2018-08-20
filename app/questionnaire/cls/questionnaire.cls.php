<?php

class questionnaire_questionnaire
{
    public $G;

    public function __construct(&$G)
    {
        $this->G = $G;
    }

    public function _init()
    {
        $this->categories = NULL;
        $this->tidycategories = NULL;
        $this->pdosql = $this->G->make('pdosql');
        $this->db = $this->G->make('pepdo');
        $this->pg = $this->G->make('pg');
        $this->ev = $this->G->make('ev');
    }

    public function getQuestionList($args, $page, $number = 20, $order = 'createtime DESC')
    {
        $data = array(
            'select' => false,
            'table' => 'questionnaire',
            'query' => $args,
            'orderby' => $order
        );
        $r = $this->db->listElements($page, $number, $data);
        return $r;
    }

    /**
     * 根据课程id获取评论
     * @param $courseId
     * @param $page
     * @param $number
     * @param $order
     * @return mixed
     */
    public function getQuestionListByCourseId($courseId, $page, $number = 20, $order = 'createtime DESC')
    {
        $r = $this->getQuestionList(['courseid' => $courseId], $page, $number, $order);
        return $r;
    }

}

?>
