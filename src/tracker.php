<?php 

namespace Bananovs\Tracker;


class Tracker 
{
    const VERSION = '1.0';

    private $endpoint;
    private $secret;
    private $access_token;

    private $params = [];

    public function __construct($endpoint, $secret, $access_token = NULL)
    {
        $this->endpoint = $endpoint;
        $this->secret = $secret;
        $this->access_token = $access_token;
    }


    public function setProgramId($id)
    {
        $this->params['p'] = $id;

        return $this;
    }

    public function setUser($id)
    {
        $this->params['user_id'] = (int) $id;

        return $this;
    }

    public function setCategory($value)
    {
        $this->params['category'] = $value;

        return $this;
    }

    public function setType($value)
    {
        $this->params['type'] = $value;

        return $this;
    }

    public function setAmount($value)
    {
        $this->params['amount'] = $value;

        return $this;
    }

    public function setEvent($value)
    {
        $this->params['event'] = $value;

        return $this;
    }

    public function setDimension($type, $value)
    {
        $this->params[$type] = $value;

        return $this;
    }


    public function setData1($value)
    {
        $this->setData(1, $value);

        return $this;
    }

    public function setData2($value)
    {
        $this->setData(2, $value);

        return $this;
    }

    public function setData3($value)
    {
        $this->setData(3, $value);

        return $this;
    }

    public function setData4($value)
    {
        $this->setData(4, $value);

        return $this;
    }

    public function setData5($value)
    {
        $this->setData(5, $value);

        return $this;
    }


    private function setData($index, $value)
    {
        $this->params["d$index"] = $value;
    }

    private function getQuery()
    {
        $query = '/?' . http_build_query($this->params);

        return $query . "&s=" . sha1($this->secret . $query). "&access_token=" . $this->access_token;
    }

    public function __toString()
    {
        return $this->getQuery();
    }

    public function send() 
    {
        try {
            
            $query = $this->getQuery();
            $url = $this->endpoint;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url . $query);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cache-Control: no-cache','Content-type: application/json'));
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;

        } catch (\Throwable $th) {

            return $th->getMessage();

        }
        
    }

}

