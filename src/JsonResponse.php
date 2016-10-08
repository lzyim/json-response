<?php

namespace Soloslee\JsonResponse;

use Response;

class JsonResponse
{
    const ERROR = 'error';
    const SUCCESS = 'success';

    private function toString($data)
    {
        if (is_bool($data)) {
            return $data ? '1' : '0';
        } elseif (is_integer($data) || is_double($data)) {
            return $data . '';
        } elseif (is_string($data)) {
            return $data;
        } elseif (is_null($data)) {
            return null;
        } elseif (is_object($data)) {
            if (is_callable(array($data, 'toArray'))) {
                return $this->toString($data->toArray());
            } elseif (is_callable(array($data, 'getAttributes'))) {
                return $this->toString($data->getAttributes());
            } elseif (is_callable(array($data, '__toString'))) {
                return $data->__toString();
            } elseif (get_class($data) === 'stdClass' && $data === new \stdClass()) {
                return null;
            } else {
                return $this->toString((array) $data);
            }
        } elseif (is_array($data)) {
            $output = array();

            foreach ($data as $key => $value) {
                $output[$key] = $this->toString($value);
            }

            return $output;
        } else {
            return (string) $data;
        }
    }

    public function toArray($data, $status, $errorMessage = null, $errorCode = null)
    {
        $arr = array('status' => $status);

        if ($status === self::SUCCESS && $data) {
            $arr['data'] = $data;
        } elseif ($status === self::ERROR) {
            $arr['message'] = (string) $errorMessage;

            if ($errorCode) {
                $arr['code'] = $errorCode;
            }
        }

        return $arr;
    }

    public function success($data = null)
    {
        $output = $this->toString($data);
        $success = $this->toArray($output, self::SUCCESS);

        return Response::json($success, 200);
    }

    public function error($errorMessage = null, $errorCode = null)
    {
        $error = $this->toArray(null, self::ERROR, $errorMessage, $errorCode);

        return Response::json($error, 202);
    }
}
