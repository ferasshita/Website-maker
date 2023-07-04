<?php
        class Comman_model extends CI_Model {

                public $title;
                public $content;
                public $date;

                public function get_last_ten_entries()
                {
                        $query = $this->db->get('entries', 10);
                        return $query->result();
                }

                public function get_data_where($table,$where,$whereval)
                {
                        $this->db->where($where,$whereval);
                        $query=$this->db->get($table);
                        //$query = $this->db->get('entries', 10);
                        return $query->row_array();
                }

                public function get_dataCount_where($table,$where,$whereval)
                {
                        $this->db->where($where,$whereval);
                        $query=$this->db->get($table);
                        //$query = $this->db->get('entries', 10);
                        return $query->num_rows();
                }
                public function insert_entry($table,$array)
                {             
                        $this->db->insert($table, $array);
                        return $insert_id = $this->db->insert_id();

                }

                public function update_entry($table,$array,$where)
                {
                       
                        return    $this->db->update($table,$array,$where);
                }
                
                public function get_all_data_by_query($CustomQuery)
                {
                        $query = $this->db->query($CustomQuery);
                        return $query->result_array();
                }

                public function get_all_dataCounts_by_query($CustomQuery)
                {
                        $query = $this->db->query($CustomQuery);
                        return $query->num_rows();
                }

                public function run_query($query){
                        
                        return $this->db->query($query);
                }
        }
?>