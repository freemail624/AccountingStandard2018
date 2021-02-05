<?php

class Sales_message_model extends CORE_Model {
    protected  $table="sales_messages";
    protected  $pk_id="sales_message_id";

    function __construct() {
        parent::__construct();
    }


    function get_message_list($sales_invoice_id=null,$sales_message_id=null){
        $sql="SELECT m.*,
		(
                            CASE
                                WHEN m.DaysPosted>0 THEN CONCAT(m.DaysPosted,' day ago')
                                WHEN m.DaysPosted=0 AND m.HoursPosted>0 THEN CONCAT(m.HoursPosted,' hour ago')
                                WHEN m.DaysPosted=0 AND m.HoursPosted=0 AND m.MinutePosted>0 THEN CONCAT(m.MinutePosted,' min ago')
                                WHEN m.DaysPosted=0 AND m.HoursPosted=0 AND m.MinutePosted=0 AND m.SecondPosted>0 THEN CONCAT(m.SecondPosted,' sec ago')
                                ELSE '1 sec ago'
                            END
                        )as time_description

            FROM

            (SELECT sim.*,

                CONCAT(DAYNAME(sim.date_posted),', ',DATE_FORMAT(sim.date_posted,'%M %d, %Y %r'))as full_date_description,
                TIME_FORMAT(sim.date_posted,'%r') as TimePosted,
                DATEDIFF(NOW(),sim.date_posted)as DaysPosted,
                HOUR(TIMEDIFF(sim.date_posted,NOW()))as HoursPosted,
                MINUTE(TIMEDIFF(sim.date_posted,NOW()))as MinutePosted,
                SECOND(TIMEDIFF(sim.date_posted,NOW()))as SecondPosted,
                CONCAT_WS(' ',ua.user_fname,ua.user_lname)as message_posted_by,
                ua.photo_path

            FROM
              sales_messages as sim
            LEFT JOIN
              user_accounts as ua
            ON
              sim.user_id=ua.user_id
            WHERE
              sim.is_deleted=FALSE

           ".($sales_invoice_id==null?'':' AND sim.sales_invoice_id='.$sales_invoice_id)."
           ".($sales_message_id==null?'':' AND sim.sales_message_id='.$sales_message_id)."

            )as m ORDER BY m.sales_message_id";
        return $this->db->query($sql)->result();
    }





}

?>