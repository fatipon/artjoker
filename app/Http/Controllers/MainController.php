<?php

namespace app\Http\Controllers;

class MainController extends Controller {

    public function indexAction() {
		$vars = [
			'list' => $this->model->getRegions($this->route),
		];
		$this->view->render('Main page', $vars);
	}

	public function get_regionAction() {
	    $result = $this->model->getRegions($this->route);
	    echo json_encode($result);
	}

	public function get_cityAction() {
        if($_POST['region']) {
            $region = $_POST['region'];
            $result = $this->model->getCities($this->route, $region);
            echo json_encode($result);
        }
        else{
            echo 'error';
        }
	}

	public function get_districtAction() {
        if($_POST['city']) {
            $city = $_POST['city'];
            $result = $this->model->getDistricts($this->route, $city);
            echo json_encode($result);
        }
        else{
            echo 'error';
        }
	}

    public function createAction() {
        $data = array();
        $data['name'] = $_POST['name'];
        $data['email'] = $_POST['email'];
        $data['region'] = $_POST['selectRegion'];
        $data['city'] = $_POST['selectCity'];
        $data['district'] = $_POST['selectDistrict'];

        if(!($this->model->hasTable(USERS_TABLE))){
            $this->model->createTable(USERS_TABLE);
        }

        $user = $this->model->getUserEmail($data['email']);
        if(empty($user)){
            $this->model->addUser($data);
            $data['new_user'] = true;
        } else {
            $data['new_user'] = false;
            $data['user'] = $user;
        }

        $data['success'] = true;

        echo json_encode($data);
    }

}