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

    public function setDatabase($value)
    {
        $this->params['database'] = $value;

        return $this;
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

    public function truncate()
    {
        $this->params['truncate'] = true;

        return $this;
    }

    public function setData($index, $value)
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
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;

        } catch (\Throwable $th) {

            return $th->getMessage();

        }
        
    }

}

