<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;


class Dashboard extends ResourceController
{

    use ResponseTrait;
    public function __construct()
    {
        $this->db = db_connect();
        $this->session = session();
        $this->date = date("Y-m-d H:i:s");
        $config = new \Config\App();
        $this->TIMEZONE = $config->appTimezone;
    }
    public function ticket_chart()
    {
        #Timeconfig 

        $time = new \CodeIgniter\I18n\Time();
        $post_lable = $this->request->getPost('group');

        if ($post_lable == "year") {
            $GROUP = " YEAR(created_on)";
        } else if ($post_lable == "month") {
            $GROUP = " YEAR(created_on),MONTH(created_on)";
        } else if ($post_lable == "week") {
            $GROUP = " YEAR(created_on),MONTH(created_on),WEEK(created_on) ";
        } else if ($post_lable == "day") {
            $GROUP = " DATE(created_on)";
        } else {
            $GROUP = " YEAR(created_on),MONTH(created_on)";
        }


        if ($this->session->user_role == 2) {
            $where = "maintainer ='{$this->session->user_id}' ";
        } else {
            $where = "created_by ='{$this->session->user_id}' ";
        }
        $sql = "SELECT YEAR(created_on) as year ,MONTHNAME(created_on) as month,created_on,
                count(id) as total,
                count(CASE WHEN status=0 THEN 1 ELSE NULL END) as open,
                count(CASE WHEN status=1 THEN 1 ELSE NULL END) as close
                FROM `ticket` WHERE id !=0 AND {$where}  GROUP BY {$GROUP}";
        //return $this->respond($sql);
        $result = $this->db->query($sql)->getResult();
        $lables = $total = $open = $close = array();
        $lastdate = null;
        $set = ["lables" => &$lables, 'total' => &$total, 'open' => &$open, 'close' => &$close];
        foreach ($result as $row) {
            //checking for empty dates
            $this->MissingDates($lastdate, $row->created_on, $set, $post_lable);


            $parse = $time::parse($row->created_on, $this->TIMEZONE);
            // $lables[] = "{$row->month}, {$row->year}";
            if ($post_lable == "year") {
                $lables[] = $parse->toLocalizedString('yyyy');
            } else if ($post_lable == "month") {
                $lables[] = $parse->toLocalizedString('MMM yyyy');
            } else if ($post_lable == "week") {
                $lables[] = $parse->toLocalizedString('MMM W') . "W";
            } else if ($post_lable == "day") {
                $lables[] = $parse->toLocalizedString('MMM d, yyy');
            } else {
                $lables[] = $parse->toLocalizedString('MMM yyyy');
            }

            $total[] = $row->total;
            $open[] = $row->open;
            $close[] = $row->close;

            //recording lastdate
            $lastdate = $row->created_on;
        }


        $dataset = [
            'Lables' => $lables,
            'Total' => $total,
            'Open' => $open,
            'Close' => $close
        ];
        return $this->respond($dataset);
    }
    private function MissingDates($lastdate, $present, &$set, $post_lable)
    {
        if ($lastdate === null) {
            return;
        }
        $time = new \CodeIgniter\I18n\Time();
        $parselast = $time::parse(date('Y-m-d', strtotime($lastdate)), $this->TIMEZONE);
        $parsepresent = $time::parse(date('Y-m-d', strtotime($present)), $this->TIMEZONE);
        $diff = $parselast->difference($parsepresent);

        if ($post_lable == "day") {
            $totalday = $diff->getDays();
            if ($totalday > 1) {
                // echo "$lastdate    $present ----> {$totalday}";

                for ($i = 1; $i <= ($totalday - 1); $i++) {
                    $set['lables'][] = $parselast->addDays($i)->toLocalizedString('MMM d, yyy');
                    $set['total'][] = 0;
                    $set['open'][] = 0;
                    $set['close'][] = 0;
                }
                // print_r($lables);
            }
        } elseif ($post_lable == "week") {
             $totalweek = $parsepresent->getWeekOfYear() - $parselast->getWeekOfYear();
            if ($totalweek > 1) {
                for ($i = 1; $i <= ($totalweek - 1); $i++) {
                    $set['lables'][] = $parselast->addDays($i * 7)->toLocalizedString('MMM W') . "W";
                    $set['total'][] = 0;
                    $set['open'][] = 0;
                    $set['close'][] = 0;
                }
            }
            // echo $totalday = $diff->getWeeks();
            // die;
        }
        // die;
    }
    public function inventory_action()
    {
        #Timeconfig 
        $config = new \Config\App();
        $TIMEZONE = $config->appTimezone;
        $time = new \CodeIgniter\I18n\Time();
        $post_lable = $this->request->getPost('group');

        if ($post_lable == "year") {
            $GROUP = " YEAR(created_on)";
        } else if ($post_lable == "month") {
            $GROUP = " YEAR(created_on),MONTH(created_on)";
        } else if ($post_lable == "week") {
            $GROUP = " YEAR(created_on),MONTH(created_on),WEEK(created_on) ";
        } else if ($post_lable == "day") {
            $GROUP = " DATE(created_on)";
        } else {
            $GROUP = " YEAR(created_on),MONTH(created_on)";
        }
        $sql = "SELECT WEEK(created_on) AS Week,YEAR(created_on) as year,MONTHNAME(created_on) as month,created_on,
                COUNT(CASE WHEN status=1 AND action LIKE 'INSERT' THEN 1 ELSE NULL END) as assigned,
                COUNT(CASE WHEN status=2 THEN 1 ELSE NULL END) as damaged,
                COUNT(CASE WHEN status=3 THEN 1 ELSE NULL END) as m2_repaired,
                COUNT(CASE WHEN status=4 THEN 1 ELSE NULL END) as m2_upgrade,
                COUNT(CASE WHEN status=5 THEN 1 ELSE NULL END) as sold,
                COUNT(CASE WHEN status=6 THEN 1 ELSE NULL END) as comp_repaired,
                COUNT(CASE WHEN status=7 THEN 1 ELSE NULL END) as comp_upgrade,
                COUNT(CASE WHEN action !='Moved to usable' THEN 1 ELSE NULL END) as total_usab,
                COUNT(id) as total 
                FROM `timeline`
                WHERE action !='Assigned-SM' AND YEAR(created_on)=YEAR(NOW()) AND assert_id IN ((SELECT id FROM inventory WHERE maintainer={$this->session->user_id})) 
        GROUP BY {$GROUP} ";
        $result = $this->db->query($sql)->getResult();
        $lables = $total = $assigned = $m2_repaired = $m2_upgrade = $sold = $comp_repaired = $comp_upgrade = array();
        //unstructured json
        foreach ($result as $row) {
            $parse = $time::parse($row->created_on, $TIMEZONE);
            // $lables[] = "{$row->month}, {$row->year}";
            if ($post_lable == "year") {
                $lables[] = $parse->toLocalizedString('yyyy');
            } else if ($post_lable == "month") {
                $lables[] = $parse->toLocalizedString('MMM yyyy');
            } else if ($post_lable == "week") {
                $lables[] = $parse->toLocalizedString('MMM W') . "W";
            } else if ($post_lable == "day") {
                $lables[] = $parse->toLocalizedString('MMM d, yyy');
            } else {
                $lables[] = $parse->toLocalizedString('MMM yyyy');
            }

            $total[] = $row->total_usab;
            $assigned[] = $row->assigned;
            $damaged[] = $row->damaged;
            $m2_repaired[] = $row->m2_repaired;
            $m2_upgrade[] = $row->m2_upgrade;
            $sold[] = $row->sold;
            $comp_repaired[] = $row->comp_repaired;
            $comp_upgrade[] = $row->comp_upgrade;
        }
        $dataset = [
            'Lables' => $lables,
            'Total' => $total,
            'assigned' => $assigned,
            'damaged' => $damaged,
            'm2_repaired' => $m2_repaired,
            'm2_upgrade' => $m2_upgrade,
            'sold' => $sold,
            'comp_repaired' => $comp_repaired,
            'comp_upgrade' => $comp_upgrade,
        ];

        return $this->respond($dataset);
    }
}
