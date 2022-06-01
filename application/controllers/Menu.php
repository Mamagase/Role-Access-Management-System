 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    
    public function index()
    {
        $data['sidebarT'] = 'Admin';
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');   
        }
        else
        {
            $this->db->insert('user_menu',['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');
                    redirect('menu');
        }
    }

    public function submenu()
    {
        $data['sidebarT'] = 'Admin';
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');

        $data['submenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu',$data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New submenu added!</div>');
                    redirect('menu/submenu');
        }
    }

    public function delete($menu_id)
    {
        $menu = $this->db->get_where('user_menu', ['id' => $menu_id])->row_array();

        if ($menu) 
        {
            $this->db->delete('user_menu', ['id' => $menu_id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu Deleted!</div>');  
            redirect('menu');
        }
        else
        {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Menu Already Deleted!</div>');  
            redirect('menu');
        }
    }

    public function deleteSubmenu($submenu_id)
    {
        $submenu = $this->db->get_where('user_sub_menu', ['id' => $submenu_id])->row_array();

        if ($submenu) 
        {
            $this->db->delete('user_sub_menu', ['id' => $submenu_id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu Deleted!</div>');  
            redirect('menu/submenu');

        }
        else
        {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Submenu Already Deleted!</div>');  
            redirect('menu/submenu');
        }
    }
}
