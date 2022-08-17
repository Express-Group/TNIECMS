<?php
class covidmaster extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		//$CI = &get_instance();
		//$this->db = $CI->load->database();
		//$this->live_db = $CI->load->database('live_db' , TRUE);
	}
	
	public function index(){
		$data['title'] = 'Covid Master';
		$data['template'] 	= 'covid_master';
		$data['states'] = $this->db->select('State_Id , StateName')->from('statemaster')->where('Country_id' ,101)->order_by('StateName' , 'ASC')->get()->result();
		$search = "";
		$suffix = "";
		if($this->input->get('states')!=''){
			$search .= " AND c.stateId='".$this->input->get('states')."'";
			$suffix .='&states='.$this->input->get('states');
			$data['cities'] = $this->db->select('City_id , CityName')->from('citymaster')->where('State_Id' ,$this->input->get('states'))->order_by('CityName' , 'ASC')->get()->result();
		}
		if($this->input->get('cities')!=''){
			$search .= " AND c.cityId='".$this->input->get('cities')."'";
			$suffix .='&cities='.$this->input->get('cities');
		}
		if($this->input->get('status')!=''){
			$search .= " AND c.status='".$this->input->get('status')."'";
			$suffix .='&status='.$this->input->get('status');
		}
		if($this->input->get('type')!=''){
			$search .= " AND cr.type='".$this->input->get('type')."'";
			$suffix .='&type='.$this->input->get('type');
		}
		if($this->input->get('search_text')!=''){
			$search .= " AND c.centre LIKE'%".$this->input->get('search_text')."%'";
			$suffix .='&search_text='.$this->input->get('search_text');
		}
		$totalRows = $this->db->query("SELECT c.cid FROM coronafightclub AS c INNER JOIN statemaster as s ON c.stateId = s.State_Id INNER JOIN citymaster AS ci ON c.cityId = ci.City_id INNER JOIN coronafightclub_requires as cr ON c.cid = cr.cid WHERE c.cid!='' ".$search." GROUP BY c.cid")->num_rows();
		$this->load->library('pagination');
		$config['base_url'] = base_url(folder_name.'/covidmaster');
		$config['total_rows'] = $totalRows;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		$config['suffix'] = $suffix; 
		$config['first_url'] = base_url(folder_name).'/covidmaster?per_page='.$suffix;
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['display_pages'] = FALSE;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$row = ($this->input->get('per_page')=='') ? 0 : $this->input->get('per_page');
		$data['data'] = $this->db->query("SELECT c.cid , c.centre , c.status , s.StateName , ci.CityName FROM coronafightclub AS c INNER JOIN statemaster as s ON c.stateId = s.State_Id INNER JOIN citymaster AS ci ON c.cityId = ci.City_id INNER JOIN coronafightclub_requires as cr ON c.cid = cr.cid WHERE c.cid!='' ".$search." GROUP BY c.cid ORDER BY c.cid DESC LIMIT ".$row." , ".$config['per_page']."")->result();
		$data['controller'] = $this;
		$this->load->view('admin_template',$data);
	}
	public function add(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('states', 'State', 'required|trim');
		$this->form_validation->set_rules('cities', 'City', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required|trim');
		$this->form_validation->set_rules('centre', 'Centre / Hospital Name', 'required|trim');
		$this->form_validation->set_rules('address', 'Address', 'required|trim');
		$this->form_validation->set_rules('contact_number', 'Contact Number', 'required|trim');
		$this->form_validation->set_rules('type[]', 'Requirement Type', 'required|trim');
		if($this->form_validation->run() == FALSE){
			$data['states'] = $this->db->select('State_Id , StateName')->from('statemaster')->where('Country_id' ,101)->order_by('StateName' , 'ASC')->get()->result();
			$data['title'] = 'Add Covid Master';
			$data['template'] 	= 'add_covidmaster';
			$this->load->view('admin_template',$data);
		}else{
			$data['stateId'] = $this->input->post('states');
			$data['cityId'] = $this->input->post('cities');
			$data['status'] = $this->input->post('status');
			$data['centre'] = $this->input->post('centre');
			$data['address'] = $this->input->post('address');
			$data['description'] = $this->input->post('description');
			$data['contact_number'] = $this->input->post('contact_number');
			$type = $this->input->post('type');
			$data['created_by'] = $data['modified_by'] = USERID;
			$data['modified_on'] = date('Y-m-d H:i:s');
			$result = $this->db->insert('coronafightclub' , $data);
			$cid = $this->db->insert_id();
			if($result==1){
				$types = [];
				for($i=0;$i<count($type);$i++){
					$types[] = ['cid' => $cid , 'type' => $type[$i]]; 
				}
				if(count($types) > 0){
					$finalresult = $this->db->insert_batch('coronafightclub_requires', $types);
				}
				if($finalresult==count($types)){
					$this->session->set_flashdata('type', '1');
				}else{
					$this->session->set_flashdata('type', '0');
				}
				redirect(folder_name.'/covidmaster');
			}else{
				$this->session->set_flashdata('type', '0');
				redirect(folder_name.'/covidmaster');
			}
		}
		
	}
	
	public function edit($cid){
		$details = $this->db->select('*')->from('coronafightclub')->where('cid' , $cid)->get()->row_array();
		if(count($details) == 0){
			redirect(folder_name.'/covidmaster');
			exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('states', 'State', 'required|trim');
		$this->form_validation->set_rules('cities', 'City', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required|trim');
		$this->form_validation->set_rules('centre', 'Centre / Hospital Name', 'required|trim');
		$this->form_validation->set_rules('address', 'Address', 'required|trim');
		$this->form_validation->set_rules('contact_number', 'Contact Number', 'required|trim');
		$this->form_validation->set_rules('type[]', 'Requirement Type', 'required|trim');
		if($this->form_validation->run() == FALSE){
			$data['states'] = $this->db->select('State_Id , StateName')->from('statemaster')->where('Country_id' ,101)->order_by('StateName' , 'ASC')->get()->result();
			$data['cities'] = $this->db->select('City_id , CityName')->from('citymaster')->where('State_Id' ,$details['stateId'])->order_by('CityName' , 'ASC')->get()->result();
			$types = $this->db->select('type')->from('coronafightclub_requires')->where('cid' , $cid)->get()->result();
			$data['title'] = 'Edit Covid Master';
			$data['template'] 	= 'edit_covidmaster';
			$data['data'] 	= $details;
			$data['types'] = [];
			foreach($types as $type){
				array_push($data['types'] , $type->type);
			}
			$this->load->view('admin_template',$data);
		}else{
			$data['stateId'] = $this->input->post('states');
			$data['cityId'] = $this->input->post('cities');
			$data['status'] = $this->input->post('status');
			$data['centre'] = $this->input->post('centre');
			$data['address'] = $this->input->post('address');
			$data['description'] = $this->input->post('description');
			$data['contact_number'] = $this->input->post('contact_number');
			$type = $this->input->post('type');
			$data['modified_by'] = USERID;
			$data['modified_on'] = date('Y-m-d H:i:s');
			$this->db->where('cid' , $cid);
			$result = $this->db->update('coronafightclub' , $data);
			if($result==1){
				$types = [];
				for($i=0;$i<count($type);$i++){
					$types[] = ['cid' => $cid , 'type' => $type[$i]]; 
				}
				if(count($types) > 0){
					$this->db->where('cid' , $cid);
					$this->db->delete('coronafightclub_requires');
					$finalresult = $this->db->insert_batch('coronafightclub_requires', $types);
				}
				if($finalresult==count($types)){
					$this->session->set_flashdata('type', '2');
				}else{
					$this->session->set_flashdata('type', '0');
				}
				redirect(folder_name.'/covidmaster');
			}else{
				$this->session->set_flashdata('type', '0');
				redirect(folder_name.'/covidmaster');
			}
		}
	}
	public function cities(){
		$id = trim($this->input->get('id'));
		$template ='<option value="">Please select any one</option>';
		if($id!=''){
			$cities = $this->db->select('City_id , CityName')->from('citymaster')->where('State_Id' ,$id)->order_by('CityName' , 'ASC')->get()->result();
			foreach($cities as $city):
				$template .= '<option value="'.$city->City_id.'">'.$city->CityName.'</option>';
			endforeach;
		}
		echo $template;
		exit;
	}
	public function get_types($cid){
		$types = $this->db->select('type')->from('coronafightclub_requires')->where('cid' ,$cid)->order_by('type' , 'ASC')->get()->result();
		$result = '';
		$list = [1=> 'Hospital (normal beds)' , 2=> 'Hospital bed (oxygen beds)' , 3=> 'Hospital bed (ICU beds)' , 4=>'Ventilator'];
		$class = [1=> 'default' , 2=> 'primary' , 3=> 'info' , 4=>'warning'];
		foreach($types as $type){
			$result .='<span class="label label-'.$class[$type->type].'" style="margin-right: 5px;">'.$list[$type->type].'</span>';
		}
		return $result;
	}
}
?> 