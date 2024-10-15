<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Admin;
use Illuminate\Support\Facades\Storage;
class AdminCommonController extends Controller
{
    public function changeProfilePhoto(Request $request)
    {
        $admin = Admin::findOrFail(auth('admin')->id());
        $path = join_path(['public', 'uploads', 'admins']);
        $file = $request->file('adminProfilePhotoFile');
        $old_picture = $admin->getAttributes()['photo'];
        $file_name = 'ADMIN_IMG_' . uniqid() . '.jpg';
        $upload = $file->storeAs($path, $file_name);

     
        if ($upload) {
            if (Storage::exists($path . '/' . $old_picture)) {
                Storage::delete($path . '/' . $old_picture);
            }
            $admin->update(['photo' => $file_name]);
            return response()->json(['status' => 1, 'msg' => 'Your profile picture has been updated successfully']);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Somthing went wrong']);
        }
    }
}
