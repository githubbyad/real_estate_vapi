<?php

namespace App\Http\Controllers;

use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyImageController extends Controller
{
    /**
     * Delete a property image.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $image = PropertyImage::findOrFail($id);
        Storage::delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Reorder property images.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            PropertyImage::where('id', $item['id'])
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}