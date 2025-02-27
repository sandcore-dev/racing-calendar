<?php

namespace App\Http\Controllers\Admin\Season;

use App\Http\Controllers\Controller;
use App\Models\Championship;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Intervention\Image\ImageManager;

class ImageController extends Controller
{
    public function index(Championship $championship, Season $season): Response
    {
        return Inertia::render(
            'Admin/Season/Image/Index',
            [
                'seasonId' => $season->id,

                'labels' => [
                    'name' => $championship->name,
                    'year' => $season->year,

                    'back' => Lang::get('Back to index'),

                    'iconImage' => Lang::get('Icon image'),
                    'headerImage' => Lang::get('Header image'),
                    'footerImage' => Lang::get('Footer image'),
                ],

                'backUrl' => URL::route('admin.season.index', ['championship' => $championship]),

                'iconUrl' => $season->icon_url,
                'headerUrl' => $season->header_url,
                'footerUrl' => $season->footer_url,
            ]
        );
    }

    public function update(Request $request, ImageManager $imageManager, Season $season): array
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

        $disk = Storage::disk('public');

        $name = $request->input('name');
        $field = "{$name}_image";
        $path = $name === 'icon'
            ? $disk->path($season->header_image)
            : $disk->path($season->{$field});

        $width = (int)$request->input('width');
        $height = (int)$request->input('height');

        $image = $imageManager->make($path);

        $image->crop(
            $width,
            $height,
            (int)$request->input('left'),
            (int)$request->input('top')
        );

        if ($name === 'icon') {
            $image->text(
                $season->year,
                $width * 0.5,
                $height * 0.95,
                function ($font) use ($width) {
                    if (!config('app.font.name')) {
                        return;
                    }

                    $font->file(
                        Storage::disk('fonts')
                            ->path(config('app.font.name'))
                    );

                    $font->size($width * config('app.font.ratio', 0.3));
                    $font->color('#ffffff');
                    $font->align('center');
                    $font->valign('bottom');
                }
            );
        }

        $newPath = 'images/' . Str::random(40) . '.png';
        $disk->put($newPath, $image->stream('png'));

        if ($season->{$field}) {
            $disk->delete($season->{$field});
        }

        $season->{$field} = $newPath;
        $season->save();

        return [
            'url' => $disk->url($season->{$field}),
        ];
    }
}
