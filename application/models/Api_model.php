<?php
class Api_model extends CI_Model
{
	function fetch_all()
	{
		$this->db->order_by('id', 'DESC');
		return $this->db->get('tbl_sample');
	}

	function insert_api($data)
	{
		$this->db->insert('tbl_sample', $data);
	}

	function fetch_single_user($usuario_id)
	{
		$this->db->where('id', $usuario_id);
		$query = $this->db->get('tbl_sample');
		return $query->result_array();
	}

	function update_api($usuario_id, $data)
	{
		$this->db->where('id', $usuario_id);
		$this->db->update('tbl_sample', $data);
	}

	function delete_single_user($usuario_id)
	{
		$this->db->where('id', $usuario_id);
		$this->db->delete('tbl_sample');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>