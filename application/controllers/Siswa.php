<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

    public function __construct() {
        parent::__construct();

        //load model
        $this->load->model('M_siswa');

        //load library form validasi
        $this->load->library('form_validation');
    }

   /**
    * Get All Data
    */
    public function index()
    {
        $siswa = $this->M_siswa->get_all();

        $response = array();

        foreach($siswa->result() as $hasil) {

            $response[] = array(
                'nama_siswa' => $hasil->nama_siswa,
                'alamat'     => $hasil->alamat         
            );

        }
        
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'success' => true,
                'message' => 'Get All Data Siswa',
                'data'    => $response  
            )
        );

    }



    /**
     * Simpan Data
     */
    public function simpan()
    {
        //set validasi
        $this->form_validation->set_rules('nama_siswa','Nama Siswa','required');
        $this->form_validation->set_rules('alamat','Alamat Siswa','required');

        if($this->form_validation->run() == TRUE){

            $data = array(
                'nama_siswa' => $this->input->post("nama_siswa"),
                'alamat'     => $this->input->post("alamat"),
            );

            $simpan = $this->M_siswa->simpan_siswa($data);

            if($simpan) {

                header('Content-Type: application/json');
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => 'Data Berhasil Disimpan!'
                    )
                );

            } else {

                header('Content-Type: application/json');
                echo json_encode(
                    array(
                        'success' => false,
                        'message' => 'Data Gagal Disimpan!'
                    )
                );
            }

        }else{

            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'success'    => false,
                    'message'    => validation_errors()
                )
            );

        }

    }
    /**
     * Detail Data Siswa
     */
    public function detail($id_siswa)
    {
        //get ID siswa from URL
        $id_siswa = $this->uri->segment(3);

        $siswa = $this->M_siswa->detail_siswa($id_siswa)->row();
     
        if($siswa) {

            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'success' => true,
                    'data'    => array(
                        'nama_siswa' => $siswa->nama_siswa,
                        'alamat'     => $siswa->alamat   
                    )  
                )
            );

        } else {

            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'success' => false,
                    'message' => 'Data Siswa Tidak Ditemukan!'
                )
            );

        }
        
    }

    /**
     * Update Data Siswa
     */    
    public function update()
    {
        //set validasi
        $this->form_validation->set_rules('id_siswa','ID Siswa','required');
        $this->form_validation->set_rules('nama_siswa','Nama Siswa','required');
        $this->form_validation->set_rules('alamat','Alamat Siswa','required');

        if($this->form_validation->run() == TRUE){

            $id['id_siswa'] = $this->input->post("id_siswa");
            $data = array(
                'nama_siswa' => $this->input->post("nama_siswa"),
                'alamat'     => $this->input->post("alamat"),
            );

            $update = $this->M_siswa->update_siswa($data, $id);

            if($update) {

                header('Content-Type: application/json');
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => 'Data Berhasil Diupdate!'
                    )
                );

            } else {

                header('Content-Type: application/json');
                echo json_encode(
                    array(
                        'success' => false,
                        'message' => 'Data Gagal Diupdate!'
                    )
                );
            }

        }else{

            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'success'    => false,
                    'message'    => validation_errors()
                )
            );

        }
    }

    /**
     * Delete Data Siswa
     */
    public function delete($id_siswa)
    {
        //get ID siswa from URL
        $id_siswa = $this->uri->segment(3);

        //delete data from model
        $delete = $this->M_siswa->delete_siswa($id_siswa);

        if($delete) {

            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'success' => true,
                    'message' => 'Data Berhasil Dihapus!'
                )
            );

        } else {

            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'success' => false,
                    'message' => 'Data Gagal Dihapus dan ini perubahan pada github!'
                )
            );
        }

    }

    
}
