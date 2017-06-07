<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Booking_model 
 * Booking model to handle database operations related to room booking.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 29 Mar 2017
 */
class Booking_model extends CI_Model
{
	function bookListingCount($searchText, $searchRoomSizeId)
    {
        $this->db->select('BaseTbl.bkId, BaseTbl.guestFName, BaseTbl.guestLame, BaseTbl.address, BaseTbl.mobileNo, BaseTbl.email, BaseTbl.sizeId, RS.sizeTitle, RS.sizeDescription');
        $this->db->from('ldg_room_booking AS BaseTbl');
        $this->db->join('ldg_room_sizes AS RS', 'RS.sizeId = BaseTbl.sizeId');
        $this->db->where('BaseTbl.isDeleted', 0);
        if(!empty($searchText)){
            $this->db->where('RS.sizeDescription LIKE "%'.$searchText.'%"');
        }        
        if(!empty($searchRoomSizeId)){
            $this->db->where('BaseTbl.sizeId', $searchRoomSizeId);
        }
        $this->db->order_by('BaseTbl.bkId', "DESC");
        $query = $this->db->get();
        
        return count($query->result());
    }
    function bookListing($searchText, $searchRoomSizeId, $page, $segment)
    {
        $this->db->select('BaseTbl.bkId, BaseTbl.guestFName, BaseTbl.guestLame, BaseTbl.address, BaseTbl.mobileNo, BaseTbl.email, BaseTbl.sizeId, RS.sizeTitle, RS.sizeDescription');
        $this->db->from('ldg_room_booking AS BaseTbl');
        $this->db->join('ldg_room_sizes AS RS', 'RS.sizeId = BaseTbl.sizeId');
        $this->db->where('BaseTbl.isDeleted', 0);
        if(!empty($searchText)){
            $this->db->where('RS.sizeDescription LIKE "%'.$searchText.'%"');
        }        
        if(!empty($searchRoomSizeId)){
            $this->db->where('BaseTbl.sizeId', $searchRoomSizeId);
        }
        $this->db->order_by('BaseTbl.bkId', "DESC");
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }
}
