<?php

namespace App\Http\Controllers\Admin\Season;

use App\Http\Controllers\Controller;
use App\Models\Championship;
use App\Models\Season;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class ImageController extends Controller
{
    public function index(Championship $championship, Season $season): Renderable
    {
        return view('admin.season.image.index')
            ->with(
                [
                    'id' => $season->id,
                    'name' => $championship->name,
                    'year' => $season->year,

                    'back' => route('admin.season.index', ['championship' => $championship]),

                    'headerUrl' => $season->header_url,
                    'footerUrl' => $season->footer_url,
                ]
            );
    }

    public function update(Request $request, ImageManager $imageManager, Season $season)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'in:icon,header,footer'],
                'top' => ['required', 'numeric'],
                'left' => ['required', 'numeric'],
                'width' => ['required', 'numeric'],
                'height' => ['required', 'numeric'],
            ]
        );

        $name = $request->input('name');
        $field = "{$name}_image";
        $path = $name === 'icon'
            ? Storage::path($season->header_image)
            : Storage::path($season->{$field});

        $width = (int)$request->input('width');
        $height = (int)$request->input('height');

        $image = $imageManager->make($path);

        $image->crop(
            $width,
            $height,
            (int)$request->input('left'),
            (int)$request->input('top')
        );

        $image->text(
            $season->year,
            $width * 0.5,
            $height * 0.95,
            function ($font) use ($width) {
                if (!config('app.font')) {
                    return;
                }

                $font->file(
                    Storage::disk('fonts')
                        ->path(config('app.font'))
                );

                $font->size($width * 0.25);
                $font->color('#ffffff');
                $font->align('center');
                $font->valign('bottom');
            }
        );

        $newPath = 'public/images/' . Str::random(40) . '.png';
        Storage::put($newPath, $image->stream('png'));

        if ($season->{$field}) {
            Storage::delete($season->{$field});
        }

        $season->{$field} = $newPath;
        $season->save();

        return [
            $field => Storage::url($season->{$field}),
        ];
    }
}
