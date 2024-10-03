<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/userguide3/general/urls.html
     */
    public function index()
    {
        // $this->load->view('welcome_message');
        $this->loadViews("home");
        // echo base_url();
    }

    public function holaa()
    {
        echo base_url();
        $this->Site_model->updateProfesor();
    }

    public function login()
    {

        if ($_POST['username'] && $_POST['password']) {
            $login = $this->Site_model->loginUser($_POST);
            if ($login) {
                $array = array(
                    "id" => $login[0]->id,
                    "nombre" => $login[0]->nombre,
                    "apellidos" => $login[0]->apellidos,
                    "username" => $login[0]->username,
                    "curso" => $login[0]->curso
                );

                //Guardar TIPO usuario (profesor/alumno)
                if (isset($login[0]->is_profesor)) {
                    $array['tipo'] = "profesor";
                } else if (isset($login[0]->is_alumno)) {
                    $array['tipo'] = "alumno";
                }

                $this->session->set_userdata($array);
                //print_r($_SESSION);
            }
        }
        $this->loadViews('login');
    }


    public function gestionAlumnos()
    {



        if ($_SESSION['tipo'] == "profesor") {
            $data['alumnos'] = $this->Site_model->getAlumnos($_SESSION['curso']);
            $this->loadViews("gestionalumnos", $data);
        } else {
            redirect(base_url() . "Dashboard", "location");
        }
    }

    function eliminarAlumno()
    {
        if ($_POST['idalumno']) {
            $this->Site_model->deleteAlumno($_POST['idalumno']);
        }
    }

    function crearTareas()
    {

        if ($_POST) {

            if ($_FILES['archivo']) {
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                // $config['max_size']             = 100;
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;
                $config['file_name'] = uniqid() . $_FILES['archivo']['name'];
                $this->load->library('upload', $config);
                if (! $this->upload->do_upload('archivo')) {
                    echo "error";
                    // $error = array('error' => $this->upload->display_errors());
                    // $this->load->view('upload_form', $error);
                } else {
                    $this->Site_model->uploadTarea($_POST, $config['file_name']);
                    // $data = array('upload_data' => $this->upload->data());
                    // $this->load->view('upload_success', $data);


                }
            } else {
                $this->Site_model->uploadTarea($_POST);
            }
        }



        $this->loadViews("creartareas");
    }

    function misTareas()
    {

        if ($_SESSION['id']) {
            $data['tareas'] = $this->Site_model->getTareas($_SESSION['curso']);
            $this->loadViews("mistareas", $data);
        } else {
            redirect(base_url() . "Dashboard", "location");
        }
    }

    function mensajes()
    {

        if ($_SESSION['id']) {
            //print_r($_SESSION['tipo']);
            //INSERTAR MENSAJE
            if ($_POST) {

                $token = $this->Site_model->getToken($_SESSION['id'], $_SESSION['tipo']);
                $this->Site_model->insertMensaje($_POST, $token);
            }
            //OBTENER TODOS LOS USUARIOS
            $data['usuarios'] = $this->Site_model->getUsuarios($_SESSION['tipo'], $_SESSION['curso']);
            $token = $this->Site_model->getToken($_SESSION['id'], $_SESSION['tipo']);

            $data['mensajes'] = $this->Site_model->getMensajes($token);

            $this->loadViews("mensajes", $data);
        } else {
            redirect(base_url() . "Dashboard", "location");
        }
    }



    public function loadViews($view, $data = null)
    {
        //Si tenemos sesion creada
        if ($_SESSION['username']) {

            //Si la vista es login se redirige a la home
            if ($view == "login") {
                redirect(base_url() . "Dashboard", "location");
            }
            //si es una vista cualquiera se carga
            $this->load->view("includes/header");
            $this->load->view("includes/sidebar");
            $this->load->view($view, $data);
            $this->load->view("includes/footer");
            //SI NO TENEMOS LA SESION INICIADA
        } else {
            //si la vista es login se carga
            if ($view == "login") {
                $this->load->view($view);
                //si la vesta es otra cualquiera se redirige a login
            } else {
                redirect(base_url() . "Dashboard/login", "location");
            }
        }
    }


    function getMensaje()
    {
        $texto = $this->Site_model->getTextmensaje($_POST['idmensaje']);
        echo $texto[0]->texto;
    }
}
