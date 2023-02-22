<?php

namespace Prodixx\DropzoneFieldForBackpack\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Prodixx\DropzoneFieldForBackpack\Http\Requests\DropzoneRequest;

trait DropzoneTrait
{
    protected function setupDropzoneRoutes($segment, $routeName, $controller)
    {
        Route::post($segment . '/dropzone-add', [
            'as'        => $routeName . '.dropzone-add',
            'uses'      => $controller . '@dropzoneUpload',
            'operation' => 'dropzoneUpload',
        ]);

        Route::post($segment . '/dropzone-remove', [
            'as'        => $routeName . '.dropzone-remove',
            'uses'      => $controller . '@dropzoneDelete',
            'operation' => 'dropzoneDelete',
        ]);
    }

    public function dropzoneUpload(DropzoneRequest $request)
    {
        $file = $request->file('file');

        try {
            $image = \Image::make($file);
            $filename = $request->slug . '-' . Str::random(4) . '.' . \File::extension($file->getClientOriginalName());
            $file_path =  $request->destination_path . '/' . $request->entry . '/' . $filename;

            $big_image = \Image::make($image)->fit($request->image_width, $request->image_height, function ($constraint) {
                $constraint->upsize();
            });

            \Storage::disk($request->disk)->put($file_path, (string) $big_image->stream());

            if ($request->webp) {
                $webp_file_path = $request->destination_path . '/' . $request->entry . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp';

                \Storage::disk($request->disk)->put($webp_file_path, (string) $big_image->encode('webp', 70)->stream());
            }

            return response()->json([
                'success' => true,
                'filename' => $file_path
            ]);
        } catch (\Exception $e) {
            if (empty($image)) {
                return response('Not a valid image type', 412);
            } else {
                return $e->getMessage();
            }
        }
    }

    public function dropzoneDelete(Request $request)
    {
        try {
            $this->crud->model->where('id', $request->entry)->update([
                $request->field_name => json_encode($request->images ?? NULL)
            ]);

            \Storage::disk($request->disk)->delete([
                $request->destination_path . '/' . $request->entry . '/' . $request->image_path,
                $request->destination_path . '/' . $request->entry . '/' . pathinfo($request->image_path, PATHINFO_FILENAME) . '.webp',
            ]);

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
