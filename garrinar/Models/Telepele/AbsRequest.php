<?php
namespace App\Models\Telepele;

use App\Models\Core\Files;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Class AbsRequest
 * @package App\Models\Telepele\Requests
 *
 * @property string $email
 * @property string $password
 * @property string $resultType
 * @property UploadedFile|Files $file
 */
abstract class AbsRequest
{
    protected
        $url = 'https://www.myfax.co.il/action/',
        $data = [],
        $errors = [],
        $action = '';


    public function __construct()
    {
        $this->email = 'bitulpolisa@gmail.com';
        $this->password = 'SHELAL321';
        $this->resultType = 'XML';
    }

    /**
     * @return bool
     */
    public function validate()
    {
        if (!$this->email) {
            $this->errors[] = 'email is required';
        }

        if (mb_strlen($this->email) > 200) {
            $this->errors[] = 'email max length is 200 chars';
        }
    }

    /**
     * @return array|bool
     */
    public function send()
    {
        $this->validate();

        if (!$this->hasErrors()) {
            $request = $this->toRequestString();
            if (env('API_FAX', true)) {
                //setting the curl parameters.
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->url . $this->action);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
                $arRequest = $this->toArray();
                if ($this->file && $this->file instanceof Files) {
                    $arRequest = array_merge($arRequest,
                        [
                            'theFile' => new \CURLFile(
                                $this->file->getFilePath(),
                                $this->file->old_name
                            )
                        ]
                    );
                }
                curl_setopt($ch, CURLOPT_POSTFIELDS, $arRequest);
                $data = curl_exec($ch);
                curl_close($ch);
            } else {
                $data = 'Fax API is turned off';
            }
            return [
                'request' => $request,
                'response' => trim($data)
            ];
        } else {
            return false;
        }
    }

    public function hasErrors()
    {
        return count($this->getErrors()) > 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function toRequestString()
    {
        $data = $this->toArray();
        $str = '';
        foreach ($data as $k => $v) {
            if ($k == 'file') {
                continue;
            }
            $str .= $k . '=' . $v . '&';
        }

        return rtrim($str, '&');
    }

    public function toArray()
    {
        return $this->data;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }
}