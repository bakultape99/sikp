<?php 

/**
* 
*/
class M_pasien_identitas extends CI_Model
{
  
  function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
  }

  public function get_data($column = '*')
  {
    $this->db->select($column);
    $this->db->where('hapus', '0');
    $result = $this->db->get('pas_identitas');
    if ( ! $result) {
      $ret_val = array(
        'status' => 'error', 
        'data' => $this->db->error()
        );
    } else {
      $ret_val = array(
        'status' => 'success', 
        'data' => $result->result_array()
        );
    }
    return $ret_val;
  }

  /**
   * join with sys_provinsi, sys_kabupaten, sys_kecamatan, sys_kelurahan
   * @param  [type] $no_bpjs  [description]
   * @param  string $column [description]
   * @return [type]         [description]
   */
  public function get_data_identitas($no_bpjs, $column = '*')
  {
    $this->db->select($column);
    $this->db->from('pas_identitas a');
    $this->db->join('sys_provinsi d', 'a.id_provinsi = d.id_provinsi');
    $this->db->join('sys_kabupaten e', 'a.id_kabupaten = e.id_kabupaten');
    $this->db->join('sys_kecamatan f', 'a.id_kecamatan = f.id_kecamatan');
    $this->db->join('sys_kelurahan g', 'a.id_kelurahan = g.id_kelurahan');
    $this->db->where('a.no_bpjs', $no_bpjs);
    $this->db->where('a.hapus', '0');
    $result = $this->db->get();
    if (! $result) {
      $ret_val = array(
        'status' => 'error', 
        'data' => $this->db->error()
        );
    } else {
      $ret_val = array(
        'status' => 'success',
        'data' => $result->result_array()
        );
    }
    return $ret_val;
  }

  public function show($no_bpjs, $column = '*')
  {
    $this->db->select($column);
    $this->db->from('pas_identitas a');
    $this->db->join('sys_provinsi b', 'a.id_provinsi = b.id_provinsi');
    $this->db->join('sys_kabupaten c', 'a.id_kabupaten = c.id_kabupaten');
    $this->db->join('sys_kecamatan d', 'a.id_kecamatan = d.id_kecamatan');
    $this->db->join('sys_kelurahan e', 'a.id_kelurahan = e.id_kelurahan');
    $this->db->where('no_bpjs', $no_bpjs);
    $result = $this->db->get();
    if ( ! $result) {
      $ret_val = array(
        'status' => 'error',
        'data' => $this->db->error()
        );
    } else {
      $ret_val = array(
        'status' => 'success',
        'data' => $result->result_array()
        );
    }
    return $ret_val;
  }

  public function show_pasien_daerah($column = '*', $no_bpjs)
  {
    $this->db->select($column);
    $this->db->from('pas_identitas a');
    $this->db->join('sys_provinsi b', 'a.id_provinsi = b.id_provinsi');
    $this->db->join('sys_kabupaten c', 'a.id_kabupaten = c.id_kabupaten');
    $this->db->join('sys_kecamatan d', 'a.id_kecamatan = d.id_kecamatan');
    $this->db->join('sys_kelurahan e', 'a.id_kelurahan = e.id_kelurahan');
    $this->db->where('no_bpjs', $no_bpjs);
    $result = $this->db->get();
    if ( ! $result) {
      $ret_val = array(
        'status' => 'error',
        'data' => $this->db->error()
        );
    } else {
      $ret_val = array(
        'status' => 'success',
        'data' => $result->result_array()
        );
    }
    return $ret_val;
  }

  public function store($data = array())
  {
    $sql = $this->db->set($data)->get_compiled_insert('pas_identitas');
    $this->db->query($sql);
  }

  public function update($no_bpjs, $data = array())
  {
    $this->db->where('no_bpjs', $no_bpjs);
    $sql = $this->db->set($data)->get_compiled_update('pas_identitas');
    $this->db->query($sql);
  }
}