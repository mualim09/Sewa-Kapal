<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminOwner extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('adminowner/index', $data);
        $this->load->view('templates/footer');
    }

    public function perusahaan()
    {
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $cekPerusahaan = "SELECT * FROM pemilik_kapal WHERE pengguna=" . $user['id'];
        $cek = $this->db->query($cekPerusahaan)->row_array();
        if ($cek['perusahaan'] == 0) {
            $this->session->set_flashdata('msg', '<div class="alert alert-success" role="alert">Please Add Your Company First</div>');
            redirect('shipyard/tambah');
        }

        $data['title'] = 'Profil Perusahaan';
        $data['user'] = $user;
        $data['perusahaan'] = $this->db->get_where('perusahaan', ['id' => $user['id']])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('adminowner/perusahaan', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->form_validation->set_rules('NamaPerusahaan', 'Nama Perusahaan', 'required|trim');
        $this->form_validation->set_rules('AlamatPerusahaan', 'Alamat Perusahaan', 'required|trim');
        $this->form_validation->set_rules('EmailPerusahaan', 'Email Perusahaan', 'required|trim');
        $this->form_validation->set_rules('NoTelpPerusahaan', 'No Telp Perusahaan', 'required|trim');
        $this->form_validation->set_rules('NoFaxPerusahaan', 'No Fax Perusahaan', 'required|trim');
        $this->form_validation->set_rules('KodePosPerusahaan', 'Kode Pos Perusahaan', 'required|trim');



        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Perusahaan';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('adminowner/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'id' => htmlspecialchars($this->input->post('idPerusahaan', true)),
                'nama' => htmlspecialchars($this->input->post('NamaPerusahaan', true)),
                'email' => htmlspecialchars($this->input->post('EmailPerusahaan', true)),
                'alamat' => htmlspecialchars($this->input->post('AlamatPerusahaan', true)),
                'no_telp' => htmlspecialchars($this->input->post('NoTelpPerusahaan', true)),
                'no_fax' => htmlspecialchars($this->input->post('NoFaxPerusahaan', true)),
                'kode_pos' => htmlspecialchars($this->input->post('KodePosPerusahaan', true)),
            ];
            $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $query = "UPDATE pemilik_kapal SET perusahaan =" . $user['id'] . " WHERE pengguna=" . $user['id'];

            $this->db->insert('perusahaan', $data);
            $this->db->query($query);

            $this->session->set_flashdata('msg', '<div class="alert alert-success" role="alert">Congratulation! your company has been added</div>');
            redirect('owner/perusahaan');
        }
    }

    public function user()
    {
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Data Pengguna';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('adminowner/user', $data);
        $this->load->view('templates/footer');
    }

    public function tambahuser()
    {
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nama', 'Nama Pengguna', 'required');
        $this->form_validation->set_rules('email', 'Email Perusahaan', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered! '
        ]);
        $this->form_validation->set_rules('notelp', 'No Telp Perusahaan', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('role', 'Tipe Perusahaan', 'required|trim');

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password1]');

        if ($this->input->post('role') == 3) {
            $jabatan = 'Superintendent';
        } else if ($this->input->post('role') == 4) {
            $jabatan = 'Docking Monitoring';
        } else if ($this->input->post('role') == 5) {
            $jabatan = 'Ship Manager';
        }



        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah User';
            $data['user'] = $user;

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('adminowner/tambahuser', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'perusahaan' => $user['perusahaan'],
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'no_telp' => htmlspecialchars($this->input->post('notelp', true)),
                'alamat' => htmlspecialchars($this->input->post('alamat', true)),
                'jabatan' => $jabatan,
                'role_id' => htmlspecialchars($this->input->post('role', true)),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            ];
            $this->db->insert('user', $data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success" role="alert">Congratulation! your account has been created. Please Login</div>');
            redirect('AdminOwner/user');
        }
    }

    public function hapususer($id)
    {
        $where = array('id' => $id);
        $this->db->where($where);
        $this->db->delete('data_kapal');
        redirect('adminowner/user');
    }
}
