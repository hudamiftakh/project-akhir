<?php
defined('BASEPATH') or exit('No direct script access allowed');

class broadcast extends CI_Controller
{

    public function __construct()
    {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->library('DatatablesServerside');
        $this->load->model('M_Datatables');
        $this->load->library('form_validation');
    }
    public function group_contact()
    {
        $this->checkSession();
        $data['halaman'] = 'broadcast/group_contact';
        $this->load->view('modul', $data);
    }
    public function broadcast()
    {
        $this->checkSession();
        $data['halaman'] = 'broadcast/broadcast';
        $this->load->view('modul', $data);
    }
    public function list_contact()
    {
        $this->checkSession();
        $data['halaman'] = 'broadcast/group_participant_contact';
        $this->load->view('modul', $data);
    }
    public function template_message()
    {
        $this->checkSession();
        $data['halaman'] = 'broadcast/template_message';
        $this->load->view('modul', $data);
    }
    public function create_broadcast()
    {
        $this->checkSession();
        $data['halaman'] = 'broadcast/create_broadcast';
        $this->load->view('modul', $data);
    }
    public function get_broadcast()
    {
        $this->checkSession();
        $Auth = $this->session->userdata['username'];
        $this->checkSession();
        $this->datatablesserverside
            ->where('a.email', $Auth['email'])
            ->select("*")
            ->from('broadcast_template as a');
        echo $this->datatablesserverside->generate();
    }
    function save_broadcast()
    {
        try {
            if ($this->input->post()) {
                if (empty($this->input->post('group_id'))) {
                    echo json_encode(array('status' => 'error', 'msg' => 'Pilih group contact terlebih dahulu'));
                    exit;
                }
                if (empty($this->input->post('template_id'))) {
                    echo json_encode(array('status' => 'error', 'msg' => 'Pilih template message terlebih dahulu'));
                    exit;
                }
                $Auth = $this->session->userdata['username'];
                $email = $Auth['email'];
                $user_id = $Auth['user_id'];
                $name = $this->input->post('name');
                $session = $this->input->post('session');
                $message = htmlspecialchars($this->input->post('message'));
                $delay = htmlspecialchars($this->input->post('delay'));
                $message_whatsap = htmlspecialchars($this->input->post('message_whatsap'));
                $template_id = $this->input->post('template');
                $groups = explode(",", $this->input->post('group_id'));
                $data = array(
                    'name' => $name,
                    'session' => $session,
                    'message' => $message,
                    'message_whatsapp' => $message_whatsap,
                    'template_id' => $template_id,
                    'delay' => $delay,
                    'user_id' => $user_id,
                    'email' => $email,
                    'create_at' => date('Y-m-d H:i:s')
                );
                $save_broadcast = $this->db->insert('broadcast', $data);
                if ($save_broadcast) {
                    foreach ($groups as $key) {
                        $broadcast_id = $this->db->insert_id();
                        $resultCaontact = $this->db->get_where('contact', array('group_id' => $key))->result_array();
                        $dataContact = array();
                        foreach ($resultCaontact as $key => $rest_contact) {
                            $dataContact[] = array(
                                'from' => $session,
                                'to' => $rest_contact['contact'],
                                'group_id' => $rest_contact['group_id'],
                                'broadcast_id' => $broadcast_id,
                                'status' => 'queue',
                                'email' => $email,
                                'create_at' => date('Y-m-d H:i:s')
                            );
                        }
                        $save_log = $this->db->insert_batch('broadcast_log', $dataContact);
                        if ($save_log) {
                            echo json_encode(array('status' => 'success', 'msg' => 'Success'));
                        } else {
                            echo json_encode(array('status' => 'error', 'msg' => 'Server error please try again'));
                        }
                    }
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'Server error please try again'));
                }
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'Method not allowed'));
            }
        } catch (\Throwable $th) {
            echo json_encode(array('status' => 'error', 'msg' => 'Error'));
        }
    }
    public function show_template_message()
    {
        $Auth = $this->session->userdata['username'];
        $this->checkSession();
        $this->datatablesserverside->where('email', $Auth['email'])->select("id, email, message, file, DATE_FORMAT(create_at, '%W, %d %M %Y %H:%i:%s') as create_at, name")->from('template');
        echo $this->datatablesserverside->generate();
    }
    public function create_template_message()
    {
        $this->checkSession();
        try {
            $Auth = $this->session->userdata['username'];
            $config['upload_path'] = './storage/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 8000;
            $config['max_width'] = 1000;
            $config['remove_space'] = 1000;
            $config['encrypt_name'] = 1000;
            $email = $Auth['email'];
            $name = $_POST['name'];
            $message = $_POST['message'];
            $message_whatsap = $_POST['message_whatsap'];
            $file_lama = $_POST['file_lama'];
            $this->load->library('upload', $config);
            if ($_FILES['file']['name'] != "") {
                if (!$this->upload->do_upload('file')) {
                    echo json_encode(array('status' => 'error', 'msg' => $this->upload->display_errors()));
                } else {
                    $upload_data = $this->upload->data();
                    $file = (empty($upload_data['file_name'])) ? "-" : $upload_data['file_name'];
                    unlink('./storage/' . $file_lama);
                }
            } else {
                $file = $_REQUEST['file_lama'];
            }
            $data = array(
                'message_wahtsapp' => $message_whatsap,
                'message' => $message,
                'email' => $email,
                'name' => $name,
                'file' => $file,
                'create_at' => date('Y-m-d H: i: s')
            );
            if (empty($_POST['id'])) {
                $result = $this->db->insert('template', $data);
            } else {
                $result = $this->db->where(array('id' => $_POST['id']))->update('template', $data);
            }
            if ($result) {
                echo json_encode(array('status' => 'success', 'msg' => 'Berhasil Disimpan'));
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'Gagal save'));
            }

        } catch (\Throwable $th) {
            echo json_encode(array('status' => 'error', 'msg' => 'Error'));
        }
    }
    public function get_list_contact()
    {
        $this->checkSession();
        $id = $this->uri->segment(3);
        $this->datatablesserverside->where('group_id', $id)->select("id, contact,  DATE_FORMAT(create_at, '%W, %d %M %Y %H:%i:%s') as create_at")->from('contact');
        echo $this->datatablesserverside->generate();
    }
    public function list_group()
    {
        $this->checkSession();
        $Auth = $this->session->userdata['username'];
        $this->datatablesserverside->where(array('email' => $Auth['email']))->select("a.id, (SELECT COUNT(*) FROM contact as b WHERE a.id = b.group_id) as participant, a.name,  DATE_FORMAT(a.create_at, '%W, %d %M %Y %H:%i:%s') as create_at");
        $this->datatablesserverside->from('group as a');
        echo $this->datatablesserverside->generate();
    }
    public function get_group()
    {
        try {
            $session = $_POST['session'];
            $data = $this->db->get_where('sessions', array('number' => $session))->row_array();
            $path = base_url() . "wasender/log/" . $data['number'] . ".json";
            $file = file_get_contents($path);
            $gropuData = json_decode($file, true);
            foreach ($gropuData as $group) {
                $id_group = $this->db->get_where('group', array('user_id' => $data['user_id'], 'name' => $group['subject']))->row_array();
                $delet_participant = $this->db->where(array('user_id' => $data['user_id'], 'group_id' => $id_group['id']))->delete('contact');
                if ($delet_participant) {
                    $delkGroup = $this->db->where(array('user_id' => $data['user_id'], 'name' => $group['subject']))->delete('group');
                }
                $insertGroup = $this->db->insert("group", array('email' => $data['email'], 'name' => $group['subject'], 'user_id' => $data['user_id'], 'participant' => count($group['participants']), 'create_at' => date('Y-m-d H:i:s')));
                $group_id = $this->db->insert_id();
                foreach ($group['participants'] as $key) {
                    $insertContact = $this->db->insert('contact', array('contact' => str_replace('@s.whatsapp.net', '', trim($key['id'])), 'email' => $data['email'], 'group_id' => $group_id, 'user_id' => $data['user_id'], 'create_at' => date('Y-m-d H:i:s')));
                }
            }
            echo json_encode(array('status' => 'success'));
        } catch (\Throwable $th) {
            echo json_encode(array('status' => 'error', 'msg' => 'server error'));
        }

    }
    public function create_group()
    {
        try {
            $this->checkSession();
            $name = $_POST['group'];
            $create_at = date('Y-m-d H: i: s');
            $Auth = $this->session->userdata['username'];
            if ($this->db->get_where('group', array('name' => $name, 'email' => $Auth['email']))->num_rows() >= 1) {
                echo json_encode(array('status' => 'error', 'msg' => 'Nama sudah digunakan'));
                exit;
            }
            $data = array(
                'name' => $name,
                'create_at' => $create_at,
                'user_id' => $Auth['id'],
                'email' => $Auth['email']
            );
            $result = $this->db->insert('group', $data);
            if ($result) {
                echo json_encode(array('status' => 'success', 'msg' => 'Berhasil Disimpan'));
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'Gagal save'));
            }
        } catch (\Throwable $th) {
            echo json_encode(array('status' => 'error', 'msg' => 'server error'));
        }

    }
    public function delete_group()
    {
        try {
            if ($_POST) {
                $id = $_POST['id'];
                $result = $this->db->where(array('id' => $id))->delete("group");
                if ($result) {
                    $this->db->where(array('group_id' => $id))->delete('contact');
                    echo json_encode(array('status' => 'success', 'msg' => 'Berhasil Dihapus'));
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'Gagal save'));
                }
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'Method not allowed'));
            }
        } catch (\Throwable $th) {
            echo json_encode(array('status' => 'error', 'msg' => 'server error'));
        }
    }
    public function delete_template_message()
    {
        try {
            if ($_POST) {
                $id = $_POST['id'];
                $result = $this->db->where(array('id' => $id))->delete("template");
                if ($result) {
                    echo json_encode(array('status' => 'success', 'msg' => 'Berhasil Dihapus'));
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'Gagal save'));
                }
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'Method not allowed'));
            }
        } catch (\Throwable $th) {
            echo json_encode(array('status' => 'error', 'msg' => 'server error'));
        }
    }
    public function create_contact()
    {
        try {
            if ($_POST) {
                $id = $this->uri->segment(3);
                $number = hp($_POST['number']);
                $Auth = $this->session->userdata['username'];
                if ($this->db->get_where('contact', array('contact' => $number, 'group_id' => $id, 'email' => $Auth['email']))->num_rows() >= 1) {
                    echo json_encode(array('status' => 'error', 'msg' => 'Number alredy exist'));
                    exit;
                }
                $result = $this->db->insert('contact', array('contact' => hp($number), 'group_id' => $id, 'email' => $Auth['email'], 'user_id' => $Auth['id'], 'create_at' => date('Y-m-d H:i:s')));
                if ($result) {
                    echo json_encode(array('status' => 'success', 'msg' => 'Berhasil disimpan'));
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'Gagal menyimpan'));
                }
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'server error, please check data again'));
            }
        } catch (\Throwable $th) {
            echo json_encode(array('status' => 'error', 'msg' => 'server error, please check data again'));
        }
    }
    public function delete_contact_checkbox()
    {
        try {
            if ($_POST) {
                $id = $_POST['id'];
                $Auth = $this->session->userdata['username'];
                foreach ($id as $key => $id_contact) {
                    $result = $this->db->where(array('id' => $id_contact, 'email' => $Auth['email']))->delete('contact');
                }
                if ($result) {
                    echo json_encode(array('status' => 'success', 'msg' => 'Berhasil disimpan'));
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'Gagal menyimpan'));
                }
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'server error'));
            }
        } catch (\Throwable $th) {
            echo json_encode(array('status' => 'error', 'msg' => 'server error, please check data again'));
        }
    }

    public function delete_group_checkbox()
    {
        try {
            if ($_POST) {
                $id = $_POST['id'];
                console . log($id);
                if (empty($id)) {
                    echo json_encode(array('status' => 'error', 'msg' => 'Pilih group terlebih dahulu'));
                    exit;
                }
                $Auth = $this->session->userdata['username'];
                foreach ($id as $key => $id_contact) {
                    $result = $this->db->where(array('id' => $id_contact, 'email' => $Auth['email']))->delete('group');
                    $this->db->where(array('group_id' => $id_contact, 'email' => $Auth['email']))->delete('contact');
                }
                if ($result) {
                    echo json_encode(array('status' => 'success', 'msg' => 'Berhasil disimpan'));
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'Gagal menyimpan'));
                }
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'server error'));
            }
        } catch (\Throwable $th) {
            echo json_encode(array('status' => 'error', 'msg' => 'server error, please check data again'));
        }
    }

    public function delete_contact()
    {
        try {
            if ($_POST) {
                $id = $_POST['id'];
                $Auth = $this->session->userdata['username'];
                $result = $this->db->where(array('id' => $id, 'email' => $Auth['email']))->delete('contact');
                if ($result) {
                    echo json_encode(array('status' => 'success', 'msg' => 'Berhasil disimpan'));
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'Gagal menyimpan'));
                }
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'server error, please check data again'));
            }
        } catch (\Throwable $th) {
            echo json_encode(array('status' => 'error', 'msg' => 'server error, please check data again'));
        }
    }
    public function send()
    {
        $this->checkSession();
        $from = $_POST['from'];
        $to = hp($_POST['to']);
        $message = urlencode($_POST['message']);
        $ch = curl_init();
        $url = url_wa() . "send-message?session = " . $from . "&to = " . $to . "&text = " . $message;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        $resdata = json_decode($result, true);
        if ($resdata) {
            $set_alert = '<div class="alert alert-success alert-dismissible" role="alert"><div class="alert-message"><strong>Perhatian !! Data berhasil dikirim</strong></div></div>';
            $this->session->set_flashdata('notify', $set_alert);
            redirect('./send');
        } else {
            $set_alert = '<div class="alert alert-danger alert-dismissible" role="alert"><div class="alert-message"><strong>Perhatian !! Data gagal dikirim</strong></div></div>';
            $this->session->set_flashdata('notify', $set_alert);
            redirect('./send');

        }
    }

    public function checkSession()
    {
        if (empty($this->session->userdata['username'])) {
            redirect('./');
        }
    }
}
?>