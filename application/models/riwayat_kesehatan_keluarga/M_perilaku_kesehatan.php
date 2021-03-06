<?php 

/**
* 
*/
class M_perilaku_kesehatan extends CI_Model
{
  
  function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
  }

  public function count_distinct_kasur_busa_by_kk($id_kk)
  {
    $this->db->where('kasur_busa', '1');
    $this->db->where('id_kk', $id_kk);
    $this->db->where('hapus', '0');
    $this->db->group_by('id_kk');
    $this->db->order_by('tgl_isi', 'desc');
    $this->db->limit(1);
    $result = $this->db->get('kk_perilaku_kes');
    return $result->num_rows();
  }

  /**
   * join with kk_perilaku_keselamatan
   * @param  [type] $id_kk  [description]
   * @param  string $column [description]
   * @return [type]         [description]
   */
  public function get_data_kes($id_kk, $column = '*')
  {
    $this->db->select($column);
    $this->db->from('kk_perilaku_kes a');
    $this->db->join('kk_perilaku_keselamatan b', 'a.id_kk = b.id_kk');
    $this->db->join('(select *  from kk_riwayat_kes_kel where hapus = \'0\' order by tgl_isi desc limit 1) c', 'a.id_kk = c.id_kk', 'left');
    $this->db->where('a.id_kk', $id_kk);
    $this->db->where('a.hapus', '0');
    $this->db->where('b.hapus', '0');
    $this->db->order_by('a.tgl_isi', 'desc');
    $this->db->limit(1);
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

  public function store($data = array())
  {
    $sql = $this->db->set($data)->get_compiled_insert('kk_perilaku_kes');
    $this->db->query($sql);
  }

  public function destroy($id_kk, $tgl_isi)
  {
    $this->db->where('id_kk', $id_kk);
    $this->db->where('tgl_isi', $tgl_isi);
    $sql = $this->db->set(array('hapus' => '1'))->get_compiled_update('kk_perilaku_kes');
    $this->db->query($sql);
  }
}