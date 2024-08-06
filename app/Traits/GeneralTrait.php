<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait GeneralTrait
{

    public function returnError($errNum, $msg)
    {
        return response()->json([
            'status' => false,
            'errNum' => $errNum,
            'message' => $msg
        ],$errNum);
    }


    public function returnSuccessMessage($msg = "", $errNum = 200)
    {
        return response()->json([
            'status' => true,
            'errNum' => $errNum,
            'message' => $msg
        ],$errNum);
    }

    public function returnData($value, $msg = "successfully")
    {
        return response()->json([
            'status' => true,
            'errNum' => 200,
            'message' => $msg,
            'data' => $value
        ],200);
    }


    public function returnValidationError($code = 422, $validator)
    {
        return $this->returnError($code, $validator->errors());
    }



    function saveImage($photo, $folder)
    {
        try {
            $file_extension = $photo->getClientOriginalExtension();
            $file_name = time() . rand() . '.' . $file_extension;
            $photo->move($folder, $file_name);
            return $folder . '/' . $file_name;
        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), "Error in image save ");
        }
    }


    public function deleteImage($photo)
    {

        try {
            if (\File::exists(public_path($photo))) {
                unlink($photo);
            }
        } catch (\Exception $ex) {
            throw new HttpResponseException($this->returnError($ex->getCode(), "This image Not found"));
        }
    }



}
