<?php

namespace Soloslee\JsonResponse;

use Response;

class JsonResponse
{
    const ERR = 'error';
    const SUCC = 'success';

    private function toString($data)
    {
        switch (gettype($data)) {
            case 'boolean':
                return $data ? '1' : '0';
            case 'integer':
            case 'double':
                return $data . '';
            case 'string':
                return $data;
            case 'NULL':
                return null;
            case 'object':
                switch (true) {
                    case is_callable(array($data, 'toArray')):
                        return $this->toString($data->toArray());
                    case is_callable(array($data, 'getAttributes')):
                        return $this->toString($data->getAttributes());
                    case is_callable(array($data, '__toString')):
                        return $data->__toString();
                    case (get_class($data) === 'stdClass' && $data === new \stdClass()):
                        return null;
                    default:
                        return $this->toString((array) $data);
                }
            case 'array':
                $output = array();

                foreach ($data as $key => $value) {
                    $output[$key] = $this->toString($value);
                }

                return $output;
            default:
                return (string) $data;
        }
    }

    public function toArray($data, $status, $errMsg = null, $errCode = null)
    {
        $arr = array('status' => $status);

        if ($status === self::SUCC && $data) {
            $arr['data'] = $data;
        } elseif ($status === self::ERROR) {
            $arr['message'] = (string) $errMsg;

            if ($errCode) {
                $arr['code'] = $errCode;
            }
        }

        return $arr;
    }

    public function success($data = null)
    {
        $output = $this->toString($data);
        $succ = $this->toArray($output, self::SUCC);

        return Response::json($succ, 200);
    }

    public function error($errMsg = null, $errCode = null)
    {
        $err = $this->toArray(null, self::ERR, $errMsg, $errCode);

        return Response::json($err, 202);
    }
}
