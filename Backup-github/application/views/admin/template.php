<?php

if (isset($this->session->userdata['id'])) {      	
	
	redirect('appsumo/appsumo/dashboard');
    // $this->load->view($theme . '/includes/header');

    // $this->load->view($theme . '/includes/navbar');

    // $this->load->view($theme . '/includes/sidebar');

    // $this->load->view($theme . '/modules/' . $module . '/' . $page);

    // $this->load->view($theme . '/includes/footer');

} else {     

	if ($this->session->userdata('user_role') == 2) {
            redirect(base_url());
    }
 
    $this->load->view($theme . '/pages/login');

}

?>