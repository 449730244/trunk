<?php
namespace App\Models\Traits;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

trait clearFiles{

    public function clear(){
        $date = Carbon::now()->addMonth(-3)->toDateTimeString();

        foreach (File::where('updated_at', '>', $date)->cursor() as $file) {
            echo $file->url."\n";
            //Storage::disk('public')->delete($file->url);
            //$file->delete();
        }
    }
}