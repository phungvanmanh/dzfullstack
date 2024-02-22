<?php

namespace App\Jobs;

use App\Models\HocVien;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ShareVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $data;

    public function __construct($file, $data)
    {
        $this->file = $file;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //remove all share
        $service      = Storage::disk('google')->getAdapter()->getService();
        $parameters['fields'] = "permissions(*)";
        $permissions = $service->permissions->listPermissions($this->file, $parameters);

        foreach ($permissions->getPermissions() as $permission){
            if(isset($permission['emailAddress']) && $permission['emailAddress'] != env('root_mail')) {
                $service->permissions->delete($this->file,$permission['id']);
            }
        }

        // add new share
        foreach($this->data as $key => $value) {
            if($value['is_share']) {
                $hocVien = HocVien::find($value['id_hoc_vien']);
                $permission = new \Google_Service_Drive_Permission(array(
                    'type' => 'user',
                    'role' => 'reader',
                    'emailAddress' => $hocVien->email,
                ));
                $service->permissions->create(
                    $this->file, $permission
                );
            }
        }
    }
}
