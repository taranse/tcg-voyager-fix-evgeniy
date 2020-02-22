<?php

namespace TCG\Voyager\Http\Controllers\ContentTypes;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use FFMpeg\Format\Video\X264;
use Pbmedia\LaravelFFMpeg\FFMpegFacade as FFMpegg;

class File extends BaseType
{
    /**
     * @return string
     */
    public function handle()
    {
        if (!$this->request->hasFile($this->row->field)) {
            return;
        }

        $files = Arr::wrap($this->request->file($this->row->field));

        $filesPath = [];
        $path = $this->generatePath();

        foreach ($files as $file) {
            $filename = $this->generateFileName($file, $path);
            $file->storeAs(
                $path,
                $this->type == 'video' ? $file->getClientOriginalName() : $filename . '.' . $file->getClientOriginalExtension(),
                config('voyager.storage.disk', 'public')
            );

            $data = [
                'download_link' =>  $this->type == 'video' ? $path . $file->getClientOriginalName() : $path . $filename . '.' . $file->getClientOriginalExtension(),
                'original_name' => $file->getClientOriginalName(),
            ];

            if ($this->type == 'video') {
                $data['download_link_h264'] = $this->videoGenerate($path, $file->getClientOriginalExtension(), $file->getClientOriginalName());
            }

            array_push($filesPath, $data);
        }

        return json_encode($filesPath);
    }

    protected function videoGenerate($disk, $file, $name)
    {
        $video = FFMpegg::fromDisk('public')->open($disk . $name);

        $video->export()
            ->toDisk('public')
            ->inFormat((new X264('aac'))->setKiloBitrate(sqrt($video->getStreams()->first()->get('bit_rate') / 1000 / 1000) * 500))
            ->save($disk . str_replace('.' . $file, '', $name) . '.h264.' . $file);

        return $disk . str_replace('.' . $file, '', $name) . '.h264.' . $file;
    }

    /**
     * @return string
     */
    protected function generatePath()
    {
        return $this->slug . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    protected function generateFileName($file, $path)
    {
        if (isset($this->options->preserveFileUploadName) && $this->options->preserveFileUploadName) {
            $filename = basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension());
            $filename_counter = 1;

            // Make sure the filename does not exist, if it does make sure to add a number to the end 1, 2, 3, etc...
            while (Storage::disk(config('voyager.storage.disk'))->exists($path . $filename . '.' . $file->getClientOriginalExtension())) {
                $filename = basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension()) . (string) ($filename_counter++);
            }
        } else {
            $filename = Str::random(20);

            // Make sure the filename does not exist, if it does, just regenerate
            while (Storage::disk(config('voyager.storage.disk'))->exists($path . $filename . '.' . $file->getClientOriginalExtension())) {
                $filename = Str::random(20);
            }
        }

        return $filename;
    }
}
