<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;


class General_api extends ResourceController
{

    use ResponseTrait;
    public function __construct()
    {
        $this->db = db_connect();
        $this->session = session();
        $this->date = date("Y-m-d H:i:s");
    }
    /**
     * ALL MASTER API - Inserts Tickets Titles
     * @param titles varchar input post
     * @return response success or fail
     */
    public function index()
    {

        $data = $this->db->table('product')->get()->getResultArray();
        return $this->respond($data);
    }
    public function Product_datatable()
    {

        $ordercol = array('name');
        $sql = "SELECT * FROM product as p WHERE p.id !=0 ";
        $search_value = $this->request->getPost('search[value]');
        $recordsTotal = $this->db->query($sql)->getNumRows();
        if (!empty($search_value)) {

            $sql .= "AND (p.name LIKE '%$search_value%' OR p.tags LIKE '%$search_value%'  OR FIND_IN_SET('$search_value', p.tags))  ";
        }

        if (isset($_POST["order"])) {
            $colorder = $this->request->getPost('order[0][column]');
            $coldir = $this->request->getPost('order[0][dir]');
            $columnname = isset($ordercol[$colorder]) ? $ordercol[$colorder] : 'id';

            $sql .= " ORDER BY $columnname $coldir";
        } else {
            //default
            $sql .= " ORDER BY id DESC";
        }
        $recordsFiltered = $this->db->query($sql)->getNumRows();
        if ($_POST["length"] != -1) {
            $sql .= " LIMIT " . $_POST["start"] . ", " . $_POST["length"];
        }

        $query = $this->db->query($sql);
        $data = [];

        $protype_array = $this->get_product_type();
        $procategory_array = $this->get_product_category();
        $pro_sub_category_array = $this->get_product_sub_category();
        foreach ($query->getResult() as $row) {
            $subarray = [];
            $subarray[] = $row->name;
            $subarray[] = $protype_array[$row->type];
            $subarray[] = $procategory_array[$row->category];
            $subarray[] = $pro_sub_category_array[$row->sub_category];
            $subarray[] = $row->default_price;
            $subarray[] = $row->status;
            $subarray[] = $row->status;
            $data[] = $subarray;
        }
        $output = [
            "draw"                 => $this->request->getPost('draw'),
            "recordsTotal"         => $recordsTotal,
            "recordsFiltered"    => $recordsFiltered,
            "data"                 => $data,
        ];
        return $this->respond($output);
    }
    private function get_product_type()
    {
        $protype_array = [];
        $type_model = model("App\Models\Product_type");
        $type_model_data = $type_model->select('id,type')->get()->getResult();
        foreach ($type_model_data as $row) {
            $protype_array[$row->id] = $row->type;
        }
        return  $protype_array;
    }
    private function get_product_category()
    {
        $procategory_array = [];
        $category_model = model("App\Models\Product_category");
        $category_model_data = $category_model->select('id,category')->get()->getResult();
        foreach ($category_model_data as $row) {
            $procategory_array[$row->id] = $row->category;
        }
        return  $procategory_array;
    }
    private function get_product_sub_category()
    {
        $pro_sub_category_array = [];
        $category_sub_model = model("App\Models\Product_sub_category");
        $category_sub_model_data = $category_sub_model->select('id,sub_category_name')->get()->getResult();
        foreach ($category_sub_model_data as $row) {
            $pro_sub_category_array[$row->id] = $row->sub_category_name;
        }
        return  $pro_sub_category_array;
    }
    public function Admin_inventory_datatable()
    {

        $ordercol = array('name');
        $sql = "SELECT 
        i.*, p.name, p.type, p.category, p.sub_category,p.default_price,p.status
        FROM inventory as i 
        INNER JOIN product as p ON p.id=i.product_id 
        WHERE i.id !=0 ";
        $search_value = $this->request->getPost('search[value]');
        $recordsTotal = $this->db->query($sql)->getNumRows();
        if (!empty($search_value)) {
            $search = "SELECT p.id FROM product as p WHERE i.id !=0 ";
            $sql .= "AND (p.name LIKE '%$search_value%' OR p.tags LIKE '%$search_value%'  OR FIND_IN_SET('$search_value', p.tags))  ";
        }


        $fromdate = $this->request->getPost('fromdate');
        $todate = $this->request->getPost('todate');
        $datetype = (int)$this->request->getPost('datetype');
        $type = (int)$this->request->getPost('type');
        $category = (int)$this->request->getPost('category');
        $sub_category = (int)$this->request->getPost('sub_category');
        $maintainer = (int) $this->request->getPost('maintainer');
        $status = (int) $this->request->getPost('status');

        if ($type) {
            $sql .= "AND p.type='$type' ";
        }
        if ($category) {
            $sql .= "AND p.category='$category' ";
        }
        if ($sub_category) {
            $sql .= "AND p.sub_category='$sub_category' ";
        }
        if ($maintainer) {
            $sql .= "AND i.maintainer='$maintainer' ";
        }
        if ($status) {
            $sql .= "AND i.status='$status' ";
        }
        if (!empty($fromdate) && !empty($todate)) {
            $fromdate = date('Y-m-d', strtotime($fromdate));
            $todate = date('Y-m-d', strtotime($todate));
            //1->Bought 2->entry 3-> sold on
            if ($datetype == 1) {
                $sql .= "AND date(i.bought_on) BETWEEN '$fromdate' AND '$todate' ";
            } elseif ($datetype == 2) {
                $sql .= "AND date(i.created_on) BETWEEN '$fromdate' AND '$todate' ";
            }
        }

        if (isset($_POST["order"])) {
            $colorder = $this->request->getPost('order[0][column]');
            $coldir = $this->request->getPost('order[0][dir]');
            $columnname = isset($ordercol[$colorder]) ? $ordercol[$colorder] : 'i.id';

            $sql .= " ORDER BY $columnname $coldir";
        } else {
            //default
            $sql .= " ORDER BY id DESC";
        }
        $recordsFiltered = $this->db->query($sql)->getNumRows();
        if ($_POST["length"] != -1) {
            $sql .= " LIMIT " . $_POST["start"] . ", " . $_POST["length"];
        }

        $query = $this->db->query($sql);
        $data = [];

        $protype_array = $this->get_product_type();
        $procategory_array = $this->get_product_category();
        $pro_sub_category_array = $this->get_product_sub_category();
        $user_data = $this->get_userdata();
        $inventory_status = $this->get_inventory_status();
        foreach ($query->getResult() as $row) {
            $subarray = [];
            $subarray[] = $this->maxwidth($row->name);
            $subarray[] = $this->maxwidth($protype_array[$row->type]);
            $subarray[] = $this->maxwidth($procategory_array[$row->category]);
            $subarray[] = $this->maxwidth($pro_sub_category_array[$row->sub_category]);

            $subarray[] = $this->maxwidth($row->actual_price);
            $subarray[] = $this->maxwidth($inventory_status[$row->status]);
            $subarray[] = $this->maxwidth($user_data[$row->maintainer]);
            $subarray[] = $user_data[$row->assigned_to];
            $subarray[] = $row->repaire_cost + $row->uprade_cost;
            $subarray[] = "<div class='max-content'>Entry : $row->created_on <br>Bought on : $row->bought_on</div>";
            $data[] = $subarray;
        }
        $output = [
            "draw"                 => $this->request->getPost('draw'),
            "recordsTotal"         => $recordsTotal,
            "recordsFiltered"    => $recordsFiltered,
            "data"                 => $data,
        ];
        return $this->respond($output);
    }
    private function get_userdata()
    {
        $user_data = [];
        $user_data[0] = NULL;
        $usermodel = new \App\Models\UserModel();
        $data = $usermodel->select('id,username')->get()->getResult();
        foreach ($data as $row) {
            $user_data[$row->id] = $row->username;
        }
        return $user_data;
    }
    private function get_inventory_status()
    {
        $status = [];
        $status[0] = "Data Invalid";
        $data = $this->db->table('inventory_status')->select('id,status_name')->get()->getResult();
        foreach ($data as $row) {
            $status[$row->id] = $row->status_name;
        }
        return $status;
    }
    private function maxwidth(string $string)
    {
        return "<div class='max-content'>" . $string . "</div>";
    }

    public function maintainer_inventory_datatable()
    {
        $maintainer_id = (int)$this->session->user_id;
        $ordercol = array('name');
        $sql = "SELECT 
        i.*,i.status as istatus, p.name, p.type, p.category, p.sub_category,p.default_price,p.status
        FROM inventory as i 
        INNER JOIN product as p ON p.id=i.product_id 
        WHERE i.id !=0 AND i.maintainer=$maintainer_id ";
        $search_value = $this->request->getPost('search[value]');
        $recordsTotal = $this->db->query($sql)->getNumRows();
        if (!empty($search_value)) {
            $search = "SELECT p.id FROM product as p WHERE i.id !=0 ";
            $sql .= "AND (p.name LIKE '%$search_value%' OR p.tags LIKE '%$search_value%'  OR FIND_IN_SET('$search_value', p.tags))  ";
        }


        $fromdate = $this->request->getPost('fromdate');
        $todate = $this->request->getPost('todate');
        $datetype = (int)$this->request->getPost('datetype');
        $type = (int)$this->request->getPost('type');
        $category = (int)$this->request->getPost('category');
        $sub_category = (int)$this->request->getPost('sub_category');
        $maintainer = (int) $this->request->getPost('maintainer');
        $assignedto = (int) $this->request->getPost('assign');
        $status = (int) $this->request->getPost('status');


        if ($type) {
            $sql .= "AND p.type='$type' ";
        }
        if ($category) {
            $sql .= "AND p.category='$category' ";
        }
        if ($sub_category) {
            $sql .= "AND p.sub_category='$sub_category' ";
        }
        //debug
        if ($maintainer) {
            $sql .= "AND i.maintainer='$maintainer' ";
        }
        if ($assignedto === -1) {
            $sql .= "AND i.assigned_to = '0' ";
        } elseif ($assignedto) {
            $sql .= "AND i.assigned_to = '$assignedto' ";
        }
        if ($status) {
            $sql .= "AND i.status='$status' ";
        }
        if (!empty($fromdate) && !empty($todate)) {
            $fromdate = date('Y-m-d', strtotime($fromdate));
            $todate = date('Y-m-d', strtotime($todate));
            //1->Bought 2->entry 3-> sold on
            if ($datetype == 1) {
                $sql .= "AND date(i.bought_on) BETWEEN '$fromdate' AND '$todate' ";
            } else if ($datetype == 2) {
                $sql .= "AND date(i.created_on) BETWEEN '$fromdate' AND '$todate' ";
            } else if ($datetype == 4  && $status == 2) {
                # Damaged
                $sql .= "AND date(i.damaged_on) BETWEEN '$fromdate' AND '$todate' ";
            } else if ($datetype == 5  && $status == 3) {
                # Repaired
                $sql .= "AND date(i.last_repaired_on) BETWEEN '$fromdate' AND '$todate' ";
            } else if ($datetype == 6 && $status == 4) {
                # Upgraded 
                $sql .= "AND date(i.last_upgraded_on) BETWEEN '$fromdate' AND '$todate' ";
            }
        }

        if (isset($_POST["order"])) {
            $colorder = $this->request->getPost('order[0][column]');
            $coldir = $this->request->getPost('order[0][dir]');
            $columnname = isset($ordercol[$colorder]) ? $ordercol[$colorder] : 'i.id';

            $sql .= " ORDER BY $columnname $coldir";
        } else {
            //default
            $sql .= " ORDER BY id DESC";
        }
        $recordsFiltered = $this->db->query($sql)->getNumRows();
        if ($_POST["length"] != -1) {
            $sql .= " LIMIT " . $_POST["start"] . ", " . $_POST["length"];
        }

        $query = $this->db->query($sql);
        $data = [];

        $protype_array = $this->get_product_type();
        $procategory_array = $this->get_product_category();
        $pro_sub_category_array = $this->get_product_sub_category();
        $user_data = $this->get_userdata();
        $inventory_status = $this->get_inventory_status();

        foreach ($query->getResult() as $row) {
            $subarray = [];
            $moveto = False;
            $dropdownlink = '';
            if ($row->istatus == 1) {
                $moveto = True;
                $dropdownlink .= "<a class='dropdown-item moveto' data-moveto='$moveto' data-instance-id='$row->id' href='#' role='button' data-product-name='$row->name' data-assigned-to='$row->assigned_to' data-toggle='modal' data-target='#moveto'><i class='ri-share-forward-2-line mr-2'></i>Move to</a>";
            } else if ($row->istatus == 3) {
                $dropdownlink .= "<a class='dropdown-item repaire_done' data-instance-id='$row->id' href='#' role='button' data-product-name='$row->name' data-assigned-to='$row->assigned_to' data-toggle='modal' data-target='#repairandupgrademodel'><i class='ri-share-forward-2-line mr-2'></i>Repair done</a>";
            } else if ($row->istatus == 4) {
                $dropdownlink .= "<a class='dropdown-item repaire_done' data-instance-id='$row->id' href='#' role='button' data-product-name='$row->name' data-assigned-to='$row->assigned_to' data-toggle='modal' data-target='#repairandupgrademodel'><i class='ri-share-forward-2-line mr-2'></i>Upgrade done</a>";
            }
            $dropdown = "<div class='dropdown'>
                            <span class='dropdown-toggle' id='dropdt$row->id' data-toggle='dropdown' role='button' aria-expanded='false'><i class='ri-more-fill'></i>
                            </span>
                            <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdt$row->id'>
                                <a class='dropdown-item assignbtn' data-instance-id='$row->id' href='#' role='button' data-product-name='$row->name' data-assigned-to='$row->assigned_to' data-toggle='modal' data-target='#assigner'><i class='ri-user-add-fill mr-2'></i>Assign</a>
                                $dropdownlink
                                <a class='dropdown-item timeline-btn' data-target='#PROTIMELINE' data-toggle='modal' href='#'><i class='ri-history-fill mr-2'></i>History</a>
                            </div>
                        </div>";
            $subarray[] = $dropdown;
            $subarray[] = $this->maxwidth($row->name);
            $subarray[] = $this->maxwidth($protype_array[$row->type]);
            $subarray[] = $this->maxwidth($procategory_array[$row->category]);
            $subarray[] = $this->maxwidth($pro_sub_category_array[$row->sub_category]);

            $subarray[] = $row->actual_price;
            $subarray[] = $inventory_status[$row->istatus];
            $subarray[] = $user_data[$row->maintainer];
            $subarray[] = $user_data[$row->assigned_to];

            $subarray[] = $row->repaire_cost + $row->uprade_cost;
            $subarray[] = "<div class='max-content'>Entry : $row->created_on <br>Bought on : $row->bought_on</div>";
            $subarray['code'] = $row->id;
            $subarray['maintainer'] = $row->maintainer;
            $subarray['maintainer-name'] = $user_data[$row->maintainer];
            $subarray['assigned-to'] = $user_data[$row->assigned_to];
            $subarray['assigned-to-id'] = $row->assigned_to;
            $data[] = $subarray;
        }
        $output = [
            "draw"                 => $this->request->getPost('draw'),
            "recordsTotal"         => $recordsTotal,
            "recordsFiltered"    => $recordsFiltered,
            "data"                 => $data,
        ];
        return $this->respond($output);
    }
    public function update_product_status()
    {
        $rules = [
            'instanceid'    => 'required|is_natural_no_zero',
            'movestatus' => 'required|in_list[2,3,4]',
            'Reason' => 'required|max_length[200]|htmlspecialchars',
            'allowmoveto' => 'required|matches[instanceid]',
        ];
        if ($this->validate($rules)) {
            $invent_id = (int) $this->request->getPost("instanceid");
            $Reason = $this->request->getPost("Reason");
            $status = (int) $this->request->getPost("movestatus");
            //2->damaged 3->repaired 4->upgrade
            $timedata = [
                'assert_id' => $invent_id,
                'status' => $status,
                'action' => '',
                'cost' => 0,
                'comment' => $Reason,
                'created_on' => $this->date,
                'created_by' => $this->session->user_id,
            ];
            $data = [
                'status' => $status,
            ];
            switch ($status) {
                case 2:
                    $data['damaged_on'] = $this->date;
                    $timedata['action'] = "Moved to damaged";
                    break;
                case 3:
                    $data['last_repaired_on'] = $this->date;
                    $timedata['action'] = "Moved to repaired";
                    break;
                case 4:
                    $data['last_upgraded_on'] = $this->date;
                    $timedata['action'] = "Moved to upgrade";
                    break;
                default:
                    $timedata['action'] = "Moved to Unknown";
                    break;
            }
            $where = [
                'id' => $invent_id,
                'maintainer' => $this->session->user_id,
                'status' => 1
            ];
            if ($this->db->table('inventory')->where($where)->update($data)) {
                # Timeline 
                $this->db->table('timeline')->insert($timedata);
                return $this->respond('success');
            }
        }
        //return $this->validator->listErrors('alert-info-list');
        return $this->respond('fail');
    }
    public function update_repair_upgrade()
    {
        $rules = [
            'instanceid'    => 'required|is_natural_no_zero',
            'ru_cost' => 'required|is_natural',
        ];
        if ($this->validate($rules)) {
            $invent_id = (int) $this->request->getPost("instanceid");
            $cost = (int) $this->request->getPost("ru_cost");
            $select_where = [
                'id' => $invent_id,
                'maintainer' => $this->session->user_id,
            ];
            $result = $this->db->table('inventory')->select("*")->where($select_where)->get()->getRow();
            if ($result) {
                $timedata = [
                    'assert_id' => $invent_id,
                    'status' => $result->status,
                    'action' => '',
                    'cost' => $cost,
                    'comment' => '',
                    'created_on' => $this->date,
                    'created_by' => $this->session->user_id,
                ];
                $inventory = $this->db->table('inventory');
                $inventory->set('status', '1');
                switch ($result->status) {
                    case 2:
                        # Damaged...
                        $timedata['action'] = "Completed Damaged";
                        break;
                    case 3:
                        # Repaired...
                        $timedata['action'] = "Completed Repair";
                        $timedata['status'] = 6;
                        $inventory->set('repaire_cost', "repaire_cost+$cost", false);
                        $inventory->set('last_repaired_on', $this->date);
                        break;
                    case 4:
                        # Upgrade...
                        $timedata['action'] = "Completed Upgrade";
                        $timedata['status'] = 7;
                        $inventory->set('uprade_cost', "uprade_cost+$cost", false);
                        $inventory->set('last_upgraded_on', $this->date);
                        break;
                    default:
                        $timedata['action'] = "Completed Unknown";
                        break;
                }
                $inventory->where($select_where);
                if ($inventory->update()) {
                    $this->db->table('timeline')->insert($timedata);
                    $timedata['cost'] = 0;
                    $timedata['status'] = 1;
                    $timedata['action'] = "Moved to usable";
                    $this->db->table('timeline')->insert($timedata);
                    return $this->respond('success');
                }
            }
        }
        return $this->respond('fail');
    }
    public function staff_inventory_datatable()
    {
        $staff_id = (int)$this->session->user_id;
        $ordercol = array('name');
        $sql = "SELECT 
        i.*,i.status as istatus, p.name, p.type, p.category, p.sub_category,p.default_price,p.status
        FROM inventory as i 
        INNER JOIN product as p ON p.id=i.product_id 
        WHERE i.id !=0 AND i.assigned_to=$staff_id ";
        $search_value = $this->request->getPost('search[value]');
        $recordsTotal = $this->db->query($sql)->getNumRows();
        if (!empty($search_value)) {
            $search = "SELECT p.id FROM product as p WHERE i.id !=0 ";
            $sql .= "AND (p.name LIKE '%$search_value%' OR p.tags LIKE '%$search_value%'  OR FIND_IN_SET('$search_value', p.tags))  ";
        }


        $fromdate = $this->request->getPost('fromdate');
        $todate = $this->request->getPost('todate');
        $datetype = (int)$this->request->getPost('datetype');
        $type = (int)$this->request->getPost('type');
        $category = (int)$this->request->getPost('category');
        $sub_category = (int)$this->request->getPost('sub_category');
        $maintainer = (int) $this->request->getPost('maintainer');
        $status = (int) $this->request->getPost('status');


        if ($type) {
            $sql .= "AND p.type='$type' ";
        }
        if ($category) {
            $sql .= "AND p.category='$category' ";
        }
        if ($sub_category) {
            $sql .= "AND p.sub_category='$sub_category' ";
        }
        //debug
        if ($maintainer) {
            $sql .= "AND i.maintainer='$maintainer' ";
        }

        if ($status) {
            $sql .= "AND i.status='$status' ";
        }
        if (!empty($fromdate) && !empty($todate)) {
            $fromdate = date('Y-m-d', strtotime($fromdate));
            $todate = date('Y-m-d', strtotime($todate));
            //1->Bought 2->entry 3-> sold on
            if ($datetype == 1) {
                $sql .= "AND date(i.bought_on) BETWEEN '$fromdate' AND '$todate' ";
            } else if ($datetype == 2) {
                #assigned on date
                $sql .= "AND date(i.assigned_on) BETWEEN '$fromdate' AND '$todate' ";
            } else if ($datetype == 4  && $status == 2) {
                # Damaged
                $sql .= "AND date(i.damaged_on) BETWEEN '$fromdate' AND '$todate' ";
            } else if ($datetype == 5  && $status == 3) {
                # Repaired
                $sql .= "AND date(i.last_repaired_on) BETWEEN '$fromdate' AND '$todate' ";
            } else if ($datetype == 6 && $status == 4) {
                # Upgraded 
                $sql .= "AND date(i.last_upgraded_on) BETWEEN '$fromdate' AND '$todate' ";
            }
        }

        if (isset($_POST["order"])) {
            $colorder = $this->request->getPost('order[0][column]');
            $coldir = $this->request->getPost('order[0][dir]');
            $columnname = isset($ordercol[$colorder]) ? $ordercol[$colorder] : 'i.id';

            $sql .= " ORDER BY $columnname $coldir";
        } else {
            //default
            $sql .= " ORDER BY id DESC";
        }
        $recordsFiltered = $this->db->query($sql)->getNumRows();
        if ($_POST["length"] != -1) {
            $sql .= " LIMIT " . $_POST["start"] . ", " . $_POST["length"];
        }

        $query = $this->db->query($sql);
        $data = [];

        $protype_array = $this->get_product_type();
        $procategory_array = $this->get_product_category();
        $pro_sub_category_array = $this->get_product_sub_category();
        $user_data = $this->get_userdata();
        $inventory_status = $this->get_inventory_status();

        foreach ($query->getResult() as $row) {
            $subarray = [];


            $dropdown = "<div class='dropdown'>
                            <span class='dropdown-toggle' id='dropdt$row->id' data-toggle='dropdown' role='button' aria-expanded='false'><i class='ri-more-fill'></i>
                            </span>
                            <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdt$row->id'>
                                <a class='dropdown-item ticket-riser' data-target='#ticketriser' data-toggle='modal'><i class='ri-trophy-line mr-2'></i>Raise a ticket</a>
                                <a class='dropdown-item timeline-btn' data-target='#PROTIMELINE' data-toggle='modal'><i class='ri-history-fill mr-2'></i>History</a>
                            </div>
                        </div>";
            $subarray[] = $dropdown;
            $subarray[] = $this->maxwidth($row->name);
            $subarray[] = $this->maxwidth($protype_array[$row->type]);
            $subarray[] = $this->maxwidth($procategory_array[$row->category]);
            $subarray[] = $this->maxwidth($pro_sub_category_array[$row->sub_category]);

            $subarray[] = $row->actual_price;
            $subarray[] = $inventory_status[$row->istatus];
            $subarray[] = $user_data[$row->maintainer];
            $subarray[] = $row->repaire_cost + $row->uprade_cost;
            $subarray[] = "<div class='max-content'>Entry : $row->created_on <br>Bought on : $row->bought_on</div>";
            $subarray['code'] = $row->id;
            $subarray['maintainer'] = $row->maintainer;
            $subarray['maintainer-name'] = $user_data[$row->maintainer];
            $subarray['assigned-to'] = $user_data[$row->assigned_to];
            $subarray['assigned-to-id'] = $row->assigned_to;
            $data[] = $subarray;
        }
        $output = [
            "draw"                 => $this->request->getPost('draw'),
            "recordsTotal"         => $recordsTotal,
            "recordsFiltered"    => $recordsFiltered,
            "data"                 => $data,
        ];
        return $this->respond($output);
    }
    /**
     * API - Fetching timeline from database
     * @param post $id assert-id
     * @return response HTML
     */
    public function get_assert_timeline()
    {
        $rules = [
            'id'    => 'required|is_natural_no_zero'
        ];
        $config = new \Config\App();
        $TIMEZONE = $config->appTimezone;
        $user_data = $this->get_userdata();
        if ($this->validate($rules)) {
            $time = new \CodeIgniter\I18n\Time();
            $id = (int)$this->request->getPost('id');
            $where = ['assert_id' => $id];
            $res = $this->db->table('timeline')->select("*")->where($where)->orderBy('id', 'ASC')->get()->getResult();
            $list = '';
            $i = 0;
            foreach ($res as $row) {
                $append = '';
                $parse = $time::parse($row->created_on, $TIMEZONE);

                if ($row->cost != 0) {
                    $append .= "<p class='text-monospace'><kbd> Cost : {$row->cost} </kbd></p>";
                }
                if ($row->comment) {
                    $append .= "<p class='text-muted'> Comment : {$row->comment} </p>";
                }
                $list .= "<li class='event' data-date='{$parse->toLocalizedString('MMM d, yyyy')}'><h3>{$row->action}</h3>
                            {$append}{$user_data[$row->created_by]} - {$parse->humanize()}</li>";
                $i++;
            }

            return $this->respond($list);
        } else {
            return $this->respond('fail to fetch!');
        }
    }
    /**
     * API - Ticket raised by staff
     * @param async post method
     * @return response success, fail
     */
    public function raise_ticket()
    {
        $rules = [
            'title'    => 'required|is_natural_no_zero|is_not_unique[ticket_title.id]',
            'description'    => 'required|trim|htmlspecialchars|max_length[2000]',
            'instance-id'    => 'required|is_natural_no_zero|is_not_unique[inventory.id]',
            'maintainer-id'    => 'required|is_natural_no_zero',
            'assert-code'    => 'required|alpha_dash|is_not_unique[inventory.code]',
        ];
        if ($this->validate($rules)) {
            $title = (int)$this->request->getPost('title');
            $description = htmlspecialchars($this->request->getPost('description'));
            $assert_id = (int)$this->request->getPost('instance-id');
            $assert_code = $this->request->getPost('assert-code');
            $main_id = (int)$this->request->getPost('maintainer-id');
            $where = [
                'id' => $assert_id,
                'code' => $assert_code,
                'assigned_to' => $this->session->user_id,
            ];
            $maintainer = $this->db->table('inventory')->select('maintainer,product_id')->where($where)->get()->getRow();
            if ($maintainer) {
                $data = [
                    'assert_id' => $assert_id,
                    'title_id' => $title,
                    'description' => $description,
                    'created_by' => $this->session->user_id,
                    'created_on' => $this->date,
                    'maintainer' => $maintainer->maintainer,
                    'product_id' => $maintainer->product_id,
                    'status' => '0',
                ];
                if ($this->db->table('ticket')->insert($data)) {
                    return $this->respond('success');
                }
            }
        }

        return $this->respond($this->validator->listErrors());
        return $this->respond('fail');
    }
    /**
     * @param start int  index to start
     * @param limit int  total number of tickets to output
     * @return HTML bootstarp cards
     */
    public function lazy_maintainer_tickets()
    {
        //maintainer response
        $rules = [
            'start' => 'required|is_natural',
            'limit' => 'required|is_natural',
            'status' => 'required|is_natural|in_list[0,1]',
            'datetype' => 'required|is_natural|in_list[0,1,2]',
        ];
        if ($this->validate($rules)) {
            $start = (int) $this->request->getPost('start');
            $limit = (int) $this->request->getPost('limit');
            $status = (int) $this->request->getPost('status');

            $where = array();
            $where = ['status' => $status];

            if ($this->session->user_role == 2) {
                $where['maintainer'] = $this->session->user_id;
            } else {
                $where['created_by'] = $this->session->user_id;
            }

            #Date filter
            $fromdate = $this->request->getPost('fromdate');
            $todate = $this->request->getPost('todate');
            $datetype = (int)$this->request->getPost('datetype');
            if (!empty($fromdate) && !empty($todate)) {
                $fromdate = date('Y-m-d', strtotime($fromdate));
                $todate = date('Y-m-d', strtotime($todate));
                //1->raised date 2->Resolved date 
                if ($datetype == 1) {
                    $where["DATE(created_on) >="] = $fromdate;
                    $where["DATE(created_on) <="] = $todate;
                } else if ($datetype == 2) {
                    $where["DATE(finished_on) >="] = $fromdate;
                    $where["DATE(finished_on) <="] = $todate;
                }
            }

            $result = $this->db->table('ticket')->select('*')->where($where)->limit($limit, $start)->orderBy('id', 'DESC')->get()->getResult();
            $title = $this->fetch_ticket_titles();
            $user_data = $this->get_userdata();
            #Timeconfig 
            $config = new \Config\App();
            $TIMEZONE = $config->appTimezone;
            $time = new \CodeIgniter\I18n\Time();

            $list = '';
            foreach ($result as $row) {
                $parse = $time::parse($row->created_on, $TIMEZONE);
                $foot_main = "<p></p><footer class='blockquote-footer'>
                                    <small class='text-muted text-break text-monospace text-wrap'>Maintainer : {$user_data[$row->maintainer]}</small>
                                 </footer>";
                if ($row->status) {
                    $resolved_on = $time::parse($row->finished_on, $TIMEZONE);
                    $button = "<footer class='blockquote-footer'>
                                        <small class='text-muted text-break text-monospace text-wrap'>Resolved on {$resolved_on->toLocalizedString('MMM d, yyyy')}</small>
                                </footer> {$foot_main}";
                    $button .= "<p></p><footer class='blockquote-footer'>
                                    <small class='text-muted text-break text-monospace text-wrap'>Comment : {$row->maintainer_comments}</small>
                                 </footer>";
                } else {
                    if ($this->session->user_role == 2) {
                        $button = "<a href='#' role='button' tabindex='-1' data-assert_id='{$row->assert_id}' data-id='{$row->code}' class='tick-completed btn btn-primary col-6'>Completed</a>";
                    } else {
                        $button = "<footer class='blockquote-footer'>
                                        <small class='text-muted text-break text-monospace text-wrap'>Status: Unresolved</small>
                                </footer>{$foot_main}";
                    }
                }
                $list .= "<div class='card' aria-hidden='true'>
                            <div class='card-body'>
                                <h5 class='card-title d-flex font-weight-bold'>
                                    <span class='col-auto text-break text-monospace text-wrap'>#{$row->code}</span>
                                    <span class='col-auto text-break text-monospace text-wrap'>{$title[$row->title_id]}</span>
                                    <small class='ml-auto text-break text-monospace text-wrap text-muted'>{$parse->humanize()}</small>
                                </h5>
                                <p class='card-text text-break text-monospace text-wrap'>
                                    <span class='col-6 text-break text-monospace text-wrap'> {$row->description} </span>
                                    <footer class='blockquote-footer'>
                                        <small class='text-muted text-break text-monospace text-wrap'>Assert-id INV-{$row->assert_id}</small><p></p>
                                    </footer>
                                    <footer class='blockquote-footer'>
                                        <small class='text-muted text-break text-monospace text-wrap'>Raised By {$user_data[$row->created_by]} on {$parse->toLocalizedString('MMM d, yyyy')}</small>
                                    </footer>
                                </p>{$button}
                            </div>
                        </div>";
            }
            return $this->respond($list);
        }
    }
    private function fetch_ticket_titles()
    {
        $title[0] = "Unknown";
        $data = $this->db->table('ticket_title')->select('*')->get()->getResult();
        foreach ($data as $row) {
            $titles[$row->id] = $row->title;
        }
        return $titles;
    }
    /**
     * Moving tickets to completed
     * @param ticket-id 
     * @param comment maintainer-comments
     * @param assert-id for verification
     */
    public function complete_ticket()
    {
        $rules = [
            'ticket_id'    => 'required|alpha_dash|is_not_unique[ticket.code]',
            'comments'    => 'required|trim|htmlspecialchars|max_length[1000]',
            'assert_id' => 'required|is_natural_no_zero|is_not_unique[inventory.id]|is_not_unique[ticket.assert_id]'
        ];
        if ($this->validate($rules)) {
            $ticket_id = $this->request->getPost('ticket_id');
            $comments = $this->request->getPost('comments');
            $assert_id = $this->request->getPost('assert_id');
            $where = [
                'code' => $ticket_id,
                'assert_id' => $assert_id,
                'maintainer' => $this->session->user_id,
                'status' => 0,
            ];
            if ($res = $this->db->table('ticket')->select('id')->where($where)->get()->getRow()) {
                $update = [
                    'status' => 1,
                    'finished_on' => $this->date,
                    'maintainer_comments' => $comments
                ];
                if ($this->db->table('ticket')->where($where)->update($update)) {
                    return $this->respond('success');
                }
                return $this->respond('fail');
            }
        }
        return $this->respond($this->validator->listErrors());
    }
    /**
     * Getting Chat Data 
     * @param receiver Id
     * @return json Response
     */
    public function get_chart_data()
    {
        //maintainer response
        $rulesfurther = [
            'start' => 'required|is_natural',
            'limit' => 'required|is_natural',
            'status' => 'required|is_natural|in_list[0,1]',
            'datetype' => 'required|is_natural|in_list[0,1,2]',
        ];
        $rules = [
            'id' => 'required|is_natural_no_zero|is_not_unique[users.id]'
        ];
        if ($this->validate($rules)) {
            $ReceiverId = $this->request->getPost('id');
            $current_user = $this->session->user_id;
            $IN=[$ReceiverId,$current_user];
            $data=$this->db->table('chat')->select('*')->wherein('sender',$IN)->wherein('receiver', $IN)->orderBy('id', 'DESC')->get()->getResult();
            return $this->respond($data);
        }
    }
}
