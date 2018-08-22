<?php

class questionnaire_questionnaire
{
    public $G;

    /**
     * questionnaire_questionnaire constructor.
     * @param $G
     */
    public function __construct(&$G)
    {
        $this->G = $G;
    }

    /**
     * 初始化本类
     */
    public function _init()
    {
        $this->categories = NULL;
        $this->tidycategories = NULL;
        $this->pdosql = $this->G->make('pdosql');
        $this->db = $this->G->make('pepdo');
        $this->pg = $this->G->make('pg');
        $this->ev = $this->G->make('ev');
    }

    /**
     * 获取问题评论
     * @param $args
     * @param $page
     * @param int $number
     * @param string $order
     * @return mixed
     */
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
     * @param $csId
     * @param $page
     * @param $number
     * @param $order
     * @return mixed
     */
    public function getQuestionListByCsId($csId, $page, $number = 20, $order = 'questionnaire.createtime DESC')
    {
        $data = array(
            'select' => 'questionnaire.*, user.username, coursesubject.cstitle, course.coursetitle',
            'table' => ['questionnaire', 'course', 'coursesubject', 'user'],
            'query' => [['AND', 'questionnaire.courseid = course.courseid'],
                ['AND', 'course.coursecsid = coursesubject.csid'],
                ['AND', 'questionnaire.userid = user.userid'],
                ['AND', 'coursesubject.csid = ' . $csId]],
            'orderby' => $order
        );
        $result = $this->db->listElements($page, $number, $data);
        return $result;
    }

    /**
     * 根据每节课ID获取评论
     * @param $courseId
     * @param $page
     * @param int $number
     * @param string $order
     * @return mixed
     */
    public function getQuestionListByCourseId($courseId, $page, $number = 20, $order = 'questionnaire.createtime DESC')
    {
        $data = array(
            'select' => 'questionnaire.*, user.username, coursesubject.cstitle, course.coursetitle',
            'table' => ['questionnaire', 'course', 'coursesubject', 'user'],
            'query' => [['AND', 'questionnaire.courseid = course.courseid'],
                ['AND', 'course.coursecsid = coursesubject.csid'],
                ['AND', 'course.courseuserid = user.userid'],
                ['AND', 'course.courseid = ' . $courseId]
            ],
            'orderby' => $order
        );
        $result = $this->db->listElements($page, $number, $data);
        return $result;
    }

    /**
     * 添加问题调查
     * @param $table
     * @param $query
     * @return mixed
     */
    public function addQuestion($table, $query)
    {
        $query['createtime'] = time();
        $result = $this->db->insertElement(['table' => $table, 'query' => $query]);

        return $result;
    }

}

?>
