<?php

namespace App\Libraries;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use CodeIgniter\CLI\CLI;
//user model and chat db
use App\Models\UserModel;
use App\Models\ChatModel;


class Chat implements MessageComponentInterface
{
    protected $clients;
    private $client_array = [];
    private $ConnectedUserId = [];

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->usermodel = new UserModel();
        $this->Chatdb = new ChatModel();
        helper('text');
    }

    public function onOpen(ConnectionInterface $conn)
    {

        //get parameter from url
        $url_parameter = $conn->httpRequest->getUri()->getQuery();
        parse_str($url_parameter, $payload);
        if (isset($payload['token'])) {
            $token = $payload['token'];
            $query = $this->usermodel->where('token', $token)->get();
            $userdata = $query->getrow();
            $num_rows = $query->getNumRows();
            if ($num_rows == 1) {
                // Store the new connection to send messages to later
                $this->clients->attach($conn);
                $this->client_array[$conn->resourceId] = $conn;
                $this->ConnectedUserId[$conn->resourceId] = $userdata->id;

                $msg = "New connection! ({$conn->resourceId})  \n";
                CLI::print($msg, 'green');
                CLI::print('Token : ' . $token . "\n", 'yellow');
                // store connection into database
                $this->usermodel->where('token', $token)->set(['conn_id' => $conn->resourceId])->update();
            }
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        $sender_id = $from->resourceId;
        $poi = sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );
        $thead = ['Connection id', 'Message'];
        $tbody = [
            [$from->resourceId, $msg],
        ];
        CLI::table($tbody, $thead);
        // CLI::print($poi);

        $url_parameter = $from->httpRequest->getUri()->getQuery();
        parse_str($url_parameter, $payload);
        if (isset($payload['token'])) {

            $token = $payload['token'];
            $msg_data = json_decode($msg, true);
            if ($this->check_msg_data($msg_data)) {

                $receiver_id = (int)$msg_data['receiver_id'];
                $message = $msg_data['msg'];
                $filtered_msg = htmlspecialchars($message);
                $request_type = $msg_data['type'];
                if ($request_type == 'msg') {

                    $this->StoreInDB($from->resourceId, $receiver_id, $filtered_msg);
                    if ($receiver_conn_id = $this->get_receiver_conn_id($receiver_id)) {
                        if (isset($this->client_array[$receiver_conn_id])) {
                            CLI::print("Reciever exist \n", 'green');
                            $sender_data = $this->get_sender_data($token);
                            if ($sender_data) {
                                $server_replay = [
                                    'msg' => ellipsize($filtered_msg, 50, .5),
                                    'orginal_msg' => $filtered_msg,
                                    'sender_name' => $sender_data->username,
                                    'sender_id' => $sender_data->id,
                                    'type' => $request_type
                                ];
                                $this->client_array[$receiver_conn_id]->send(json_encode($server_replay));
                                CLI::print("msg send to  $sender_data->username ", 'green');
                            }
                        }
                    }
                }
            }
        }
    }
    public function old_onMessage(ConnectionInterface $from, $msg)
    {
        //looping
        $numRecv = count($this->clients) - 1;
        $sender_id = $from->resourceId;
        $poi = sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );
        $thead = ['Connection id', 'Message'];
        $tbody = [
            [$from->resourceId, $msg],
        ];
        CLI::table($tbody, $thead);
        // CLI::print($poi);

        $url_parameter = $from->httpRequest->getUri()->getQuery();
        parse_str($url_parameter, $payload);
        if (isset($payload['token'])) {
            $token = $payload['token'];
            $msg_data = json_decode($msg, true);
            if ($this->check_msg_data($msg_data)) {
                $receiver_id = (int)$msg_data['receiver_id'];
                $message = $msg_data['msg'];
                $request_type = $msg_data['type'];
                if ($request_type == 'msg') {
                    if ($receiver_conn_id = $this->get_receiver_conn_id($receiver_id)) {
                        foreach ($this->clients as $client) {
                            if ($client->resourceId == $receiver_conn_id) {
                                CLI::print("Reciever exist \n", 'green');
                                $sender_data = $this->get_sender_data($token);
                                if ($sender_data) {
                                    $filtered_msg = htmlspecialchars($message);
                                    $server_replay = [
                                        'msg' => ellipsize($filtered_msg, 50, .5),
                                        'orginal_msg' => $filtered_msg,
                                        'sender_name' => $sender_data->username,
                                        'sender_id' => $sender_data->id,
                                        'type' => $request_type
                                    ];
                                    $client->send(json_encode($server_replay));
                                    CLI::print("msg send to  $sender_data->username ", 'green');
                                }
                            }
                        }
                    }
                }
            }
        }

        // foreach ($this->clients as $client) {
        //     if ($from !== $client) {
        //         // The sender is not the receiver, send to each client connected
        //         $client->send($msg);
        //     }
        //     // CLI::print($client->resourceId);
        // }
    }
    public function get_sender_data($token)
    {
        $row = $this->usermodel->where('token', $token)->get()->getRow();
        if (isset($row)) {
            return $row;
        }
        return false;
    }
    private function check_msg_data(array $msg)
    {
        if (isset($msg['msg'], $msg['receiver_id'], $msg['type'])) {
            return true;
        }
        return false;
    }
    private function get_receiver_conn_id(int $receiver_id)
    {

        $row = $this->usermodel->where('id', $receiver_id)->get()->getRow();
        if (isset($row)) {
            return $row->conn_id;
        }
        return false;
    }
    private function StoreInDB($FromResourceId, int $To, $Msg)
    {

        if (($IsExist = $this->get_receiver_conn_id($To)) !== false) {

            if (isset($this->ConnectedUserId[$FromResourceId])) {

                $From = $this->ConnectedUserId[$FromResourceId];
                $data = [
                    'sender' => $From,
                    'receiver' => $To,
                    'msg' => $Msg,
                    'status' => 0,
                ];
                if ($this->Chatdb->insert($data)) {
                    CLI::print("Stored On \n", 'green');
                    return true;
                }
            }
            CLI::print("Not stored On -> Db \n", 'red');
            return false;
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        //get parameter from url
        $url_parameter = $conn->httpRequest->getUri()->getQuery();
        parse_str($url_parameter, $payload);
        if (isset($payload['token'])) {
            $token = $payload['token'];
            $this->usermodel->where('token', $token)->set(['conn_id' => ''])->update();
        }
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        unset($this->client_array[$conn->resourceId]);
        unset($this->ConnectedUserId[$conn->resourceId]);

        CLI::print("Connection {$conn->resourceId} has disconnected\n", 'red');
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        CLI::print("An error has occurred: {$e->getMessage()}\n");

        $conn->close();
    }
}
