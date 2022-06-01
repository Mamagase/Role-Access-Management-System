 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{
    public function __construct()
    { 
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidebarT'] = 'Admin';
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->db->where('email != ', $this->session->userdata('email'));
        $data['users'] = $this->db->get('user')->result_array();

         $this->load->view('templates/header', $data);
         $this->load->view('templates/sidebar', $data);
         $this->load->view('templates/topbar', $data);
         $this->load->view('admin/index', $data);
         $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['sidebarT'] = 'Admin';
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();
        $this->form_validation->set_rules('role', 'Role', 'required');


        if($this->form_validation->run() == false)
        {        
         $this->load->view('templates/header', $data);
         $this->load->view('templates/sidebar', $data);
         $this->load->view('templates/topbar', $data);
         $this->load->view('admin/role', $data);
         $this->load->view('templates/footer');
        }
        else
        {
            $this->db->insert('user_role',['role' => $this->input->post('role')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New role added!</div>');
                    redirect('admin/role');
        }
    }


    public function roleAccess($role_id)
    {
        $data['sidebarT'] = 'Admin';
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        $this->db->where('id != ', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role-access', $data);
            $this->load->view('templates/footer');

    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);
        if ($result->num_rows() < 1) 
        {
            $this->db->insert('user_access_menu', $data);
        }
        else
        {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    public function delete($user_id)
    {
        $user = $this->db->get_where('user', ['id' => $user_id])->row_array();

        if ($user) 
        {
            $this->db->delete('user', ['id' => $user_id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User Deleted!</div>');  
            redirect('admin');         
        }
        else
        {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User Already Deleted!</div>');  
            redirect('admin');         
        }
       
    }

    public function deleteRole($role_id)
    {
        $role = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        if ($role) 
        {
            $this->db->delete('user_role', ['id' => $role_id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role Deleted!</div>');  
            redirect('admin/role');    
        }
        else
        {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Role Already Deleted!</div>');  
            redirect('admin/role');    
        }
    }

    public function edit($user_id) 
    {
        $data['sidebarT'] = 'User';
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['userById'] = $this->db->get_where('user', ['id' => $user_id])->row_array(); 

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email'); 
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('image', 'Image', 'required|trim');

        if ($this->form_validation->run() == false) 
        {
             $this->load->view('templates/header', $data);
             $this->load->view('templates/sidebar', $data);
             $this->load->view('templates/topbar', $data);
             $this->load->view('admin/edit', $data);
             $this->load->view('templates/footer');
        }
        else
        {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $upload_image = $_FILES['image'];
                        var_dump($upload_image);
                die();
            if ($upload_image) 
            {
    
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) 
                {
                    $old_image = $data['userById']['image'];
                    if ($old_image != 'default.jpg') 
                    {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                }
                else
                {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->set('email', $email);
            $this->db->where('id', $user_id);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profile has been updated!</div>');
            redirect('admin');
        }

    }

}  