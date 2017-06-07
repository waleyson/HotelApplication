<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Booking (BookingController)
 * Booking Class to control all booking related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 29 Mar 2017
 */
class Booking extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model', "booking");
        $this->isLoggedIn();   
    }
    function bookListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $searchText = $this->input->post('searchText');
            $searchRoomSizeId = $this->input->post('searchRoomSizeId');
            $data['searchText'] = $searchText;
            $data['searchRoomSizeId'] = $searchRoomSizeId;            
            
            $this->load->library('pagination');
            
            $count = $this->booking->bookListingCount($searchText, $searchRoomSizeId);

			$returns = $this->paginationCompress ( "bookListing/", $count, 5 );
            
            $data['bookRecords'] = $this->booking->bookListing($searchText, $searchRoomSizeId, $returns["page"], $returns["segment"]);
            $this->load->model("rooms_model");
            $data['roomSizes'] = $this->rooms_model->getRoomSizes();
            
            $this->global['pageTitle'] = 'Fast Track Hotel : Book Listing';
            
            $this->loadViews("baseFare/bookIndex", $this->global, $data, NULL);
        }
    }
}