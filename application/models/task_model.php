<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Task_model extends CI_Model
{
	public function insert_tasks($contactData)
	{
		$this->db->insert('tbl_tasks', $contactData);
		return $this->db->insert_id();
	}

	public function get_tasks()
	{
		return $this->db->order_by('id', 'DESC')->get('tbl_tasks')->result();
	}

	public function delete_tasks($id)
	{
		return $this->db->delete('tbl_tasks', array('id' => $id));
	}
}
