<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* Heredamos de la clase CI_Controller */

class Crud extends CI_Controller {

    function __construct() {

        parent::__construct();

        /* Cargamos la base de datos */
        $this->load->database();

        /* Cargamos la libreria */
        $this->load->library('grocery_crud');

        /* Anadimos el helper al controlador */
        $this->load->helper('url');
    }

    function index() {
        //$this->load->view('welcome_message');
        echo 'CRUD';
    }

    function wp_posts_() {
        $output = $this->grocery_crud->render();
        //$this->_example_output($output);
        $this->load->view('crud/salida', $output);
    }

    function wp_users() {
        $output = $this->grocery_crud->render();
        $this->load->view('crud/salida', $output);
    }

    function wp_postmeta() {
        $output = $this->grocery_crud->render();
        $this->load->view('crud/salida', $output);
    }

    function wp_posts() {

        // Objeto Crud
        $crud = new grocery_CRUD();

        // Tabla a Usar
        $crud->set_table('wp_posts');


        $crud->set_relation_n_n('nn1', 'wp_term_relationships', 'wp_terms', 'object_id', 'term_taxonomy_id', 'name', 'term_order');
        //$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
        // Columnas a mostrar en tabla
        $crud->columns('post_author', 'post_date', 'post_modified', 'post_title', 'post_content', 'post_status', 'post_type');

        // Filas a mostrar cuando agregamos nuevo campo
        $crud->fields('nn1', 'post_author', 'post_date', 'post_modified', 'post_title', 'post_content', 'post_status', 'post_type');

        //$crud->set_theme('datatables');
        //$crud->unset_columns('post_excerpt');
        //$crud->unset_add();
        //$crud->unset_delete();
        // Seteo de Titulos
        //$crud->add_action('More', '', 'demo/action_more', 'ui-icon-plus');
        //$crud->add_action('Photos', '', '', 'ui-icon-image', array($this, 'just_a_test'));
        //$crud->add_action('Smileys', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', 'demo/action_smiley');
        //$crud->set_rules('buyPrice', 'buy Price', 'numeric');
        //$crud->set_rules('quantityInStock', 'Quantity In Stock', 'integer');
        //$crud->set_field_upload('post_content','assets/uploads/files');
        //$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
        //$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');


        $crud->display_as('post_author', 'Autor')
                ->display_as('post_date', 'Creación')
                ->display_as('post_modified', 'Modificación')
                ->display_as('post_title', 'Título')
                ->display_as('post_content', 'Contenido')
                ->display_as('post_status', 'Status')
                ->display_as('post_type', 'Tipo')
                ->display_as('nn1', 'Tipo de Post');


        // Campos requeridos
        $crud->required_fields('post_author', 'post_date', 'post_date_gmt', 'post_title', 'post_type', 'post_status');

        // Seteo de Nombre
        $crud->set_subject('"POST"');

        // Relaciones para campos con combos
        $crud->set_relation('post_author', 'wp_users', 'user_login');


        // CallBack al agregar nuevo campo
        $crud->callback_add_field('post_type', array($this, 'add_field_callback_1'));
        $crud->callback_add_field('post_status', array($this, 'add_field_callback_2'));

        // Render
        $output = $crud->render();

        // Vista
        $this->load->view('crud/salida', $output);
    }

    function just_a_test($primary_key, $row) {
        return site_url('demo/action/action_photos') . '?country=' . $row->post_title;
    }

    function add_field_callback_1() {
        //return '<input type="text" value="post" name="post_type">';
        return '<select name="post_type"><option value="post">Post</option></select>';
    }

    function add_field_callback_2() {
        //return '<input type="text" value="publish" name="post_status">';
        return '<select name="post_status"><option value="publish">Publicado</option></select>';
    }

}
