<?php
class Pagination {
    public $params = [
        'total' => 0,
        'limit' => 0,
        'controller' => '',
        'action' => '',
        'full_mode' => FALSE
    ];
    public function __construct($params){
        $this->params = $params;
    }
    public function getTotal(){
        $total = $this->params['total'] / $this->params['limit'];
        $total = ceil($total);
        return $total;
    }
    public function getCurrent(){
        $page = 1;
        if (isset($_GET['page']) && is_numeric($_GET['page'])){
            $page = $_GET['page'];
            $total_page = $this->getTotal();
            if ($page > $total_page){
                $page = $total_page;
            }
        }
        return $page;
    }
    public function getPrevPage(){
        $prev_page = '';
        $current_page = $this->getCurrent();
        if ($current_page >= 2){
            $controller = $this->params['controller'];
            $action = $this->params['action'];
            $page = $current_page - 1;
            $prev_url = "index.php?controller=$controller&action=$action&page=$page";
            $prev_page = "<li><a href='$prev_url'>Prev</a></li>";
        }
        return $prev_page;
    }
    public function getNextPage(){
        $next_page = '';
        $current_page = $this->getCurrent();
        $total_page = $this->getTotal();
        if ($current_page < $total_page){
            $controller = $this->params['controller'];
            $action = $this->params['action'];
            $page = $current_page + 1;
            $next_url = "index.php?controller=$controller&action=$action&page=$page";
            $next_page = "<li><a href='$next_url'>Next</a></li>";
        }
        return $next_page;
    }
    public function getPagination(){
        $data = '';
        $total_page = $this->getTotal();
        if ($total_page == 1){
            return '';
        }
        $data .= "<ul class='border-pagination'>";
        $prev = $this->getPrevPage();
        $data .= $prev;

        $controller = $this->params['controller'];
        $action = $this->params['action'];
        if ($this->params['full_mode'] == FALSE){
            for ($page=1; $page<=$total_page; $page++){
                $current_page = $this->getCurrent();
                $page_url = "index.php?controller=$controller&action=$action&page=$page";
                if ($page == 1 || $page == $total_page || $page == $current_page - 1 || $page == $current_page + 1){

                    $data .= "<li><a href='$page_url'>$page</a></li>";
                }
                else if ($page == $current_page){
                    $data .= "<li><a class='active' href='$page_url'>$page</a></li>";
                }
                else if (in_array($page, [$current_page - 2, $current_page + 2])){
                    $data .= "<li><a href='$page_url'>...</a></li>";
            }

            }
        }
        else {
            for ($page = 1; $page <= $total_page; $page++) {
                $current_page = $this->getCurrent();
                if ($current_page == $page) {
                    $data .= "<li class='active'><a href='#'>$page</a></li>";
                } else {
                    $page_url
                        = "index.php?controller=$controller&action=$action&page=$page";
                    $data .= "<li><a href='$page_url'>$page</a></li>";
                }
            }
        }
        $next = $this->getNextPage();
        $data .= $next;
        $data .= "</ul>";
        return $data;
    }
}
